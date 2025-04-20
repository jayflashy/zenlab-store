<?php

namespace App\Livewire\Admin;

use App\Models\Page;
use App\Traits\LivewireToast;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Log;
use Throwable;

class PageManager extends Component
{
    use LivewireToast;
    use WithFileUploads;
    use WithPagination;

    public $search;

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    public $view = 'list';

    // Form properties
    public $pageId;

    public $title;

    public $slug;

    public $content;

    public $image;

    public $existingImage;

    public $type = 'custom'; // Set default type

    public $isUploading = false;

    public $confirmingDelete = false;

    public $deleteId;

    protected $queryString = ['search', 'sortField', 'sortDirection'];

    protected $rules = [
        'title' => 'required|string|max:100',
        'slug' => 'nullable|string',
        'content' => 'required|string',
        'image' => 'nullable|image|max:2048',
    ];

    protected $listeners = [
        'editorContentChanged' => 'updateContent',
    ];

    public function mount($id = null): void
    {
        $routeName = request()->route()->getName();

        if ($routeName === 'admin.pages.create') {
            $this->view = 'create';
            $this->showCreateForm();
        } elseif ($routeName === 'admin.pages.edit' && $id) {
            $this->view = 'edit';
            $this->showEditForm($id);
        } else {
            $this->view = 'list';
        }
    }

    public function updateContent($content): void
    {
        $this->content = $content;
    }

    public function getImagePreviewUrl()
    {
        if ($this->image && method_exists($this->image, 'temporaryUrl')) {
            return $this->image->temporaryUrl();
        }

        if ($this->existingImage) {
            return my_asset($this->existingImage);
        }

        return null;
    }

    public function updatedTitle(): void
    {
        $this->slug = Str::slug($this->title);
    }

    public function updatedImage(): void
    {
        $this->validate([
            'image' => 'image|max:2048',
        ]);

        $this->isUploading = false;
    }

    public function removeImage(): void
    {
        $this->image = null;
        $this->existingImage = null;
    }

    public function sortBy($field): void
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch(): void
    {
        $this->resetPage();
    }

    public function showCreateForm(): void
    {
        $this->resetForm();
        $this->view = 'create';
    }

    public function showEditForm($id): void
    {
        $this->resetForm();

        $page = Page::findOrFail($id);
        $this->pageId = $page->id;
        $this->title = $page->title;
        $this->slug = $page->slug;
        $this->content = $page->content;
        $this->existingImage = $page->image;
        $this->type = $page->type ?: 'custom';

        $this->view = 'edit';
    }

    public function backToList(): void
    {
        $this->view = 'list';
        $this->resetForm();
    }

    public function applySearch(): void
    {
        $this->resetPage();
    }

    public function resetForm(): void
    {
        $this->reset([
            'pageId',
            'title',
            'slug',
            'content',
            'image',
            'existingImage',
            'type',
            'isUploading',
        ]);
        $this->resetErrorBag();
    }

    public function confirmDelete($id): void
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function cancelDelete(): void
    {
        $this->deleteId = null;
        $this->confirmingDelete = false;
    }

    public function deletePage(): void
    {
        $page = Page::findOrFail($this->deleteId);

        // if page is not custom, don't delete
        if ($page->type !== 'custom') {
            $this->cancelDelete();
            $this->errorAlert('You cannot delete default pages');

            return;
        }

        // Delete image file if exists
        if ($page->image) {
            try {
                Storage::disk('uploads')->delete($page->image);
            } catch (Throwable $e) {
                // Log the error but continue with deletion
                Log::error('Failed to delete image file: '.$e->getMessage());
            }
        }

        $page->delete();

        $this->confirmingDelete = false;
        $this->deleteId = null;

        $this->successAlert('Page deleted successfully');
    }

    public function save(): void
    {
        if ($this->view === 'edit') {
            $this->update();
        } else {
            $this->store();
        }
    }

    protected function store()
    {
        // Make image required when creating
        $this->rules['image'] = 'nullable|image|max:2048';
        $this->validate();

        $page = new Page;
        $page->title = $this->title;
        $page->slug = $this->generateUniqueSlug($this->title);
        $page->content = $this->content;
        $page->type = $this->type ?: 'custom';

        if ($this->image) {
            try {
                $imagePath = $this->image->store('pages', 'uploads');
                $page->image = $imagePath;
            } catch (Throwable $e) {
                Log::error('Failed to store image: '.$e->getMessage());
                $this->errorAlert('Failed to upload image: '.$e->getMessage());

                return;
            }
        }

        $page->save();

        $this->successAlert('Page created successfully');
        $this->redirect(route('admin.pages'), navigate: true);
    }

    protected function update()
    {
        // Make image optional when updating
        $this->rules['image'] = 'nullable|image|max:2048';
        $this->validate();

        $page = Page::findOrFail($this->pageId);
        $page->title = $this->title;

        // Only update slug if title changed
        if ($page->title !== $this->title) {
            $page->slug = $this->generateUniqueSlug($this->title);
        }

        $page->content = $this->content;
        $page->type = $this->type ?: 'custom';

        if ($this->image) {
            try {
                // Remove old image
                if ($page->image) {
                    Storage::disk('uploads')->delete($page->image);
                }

                // Save new image
                $imagePath = $this->image->store('pages', 'uploads');
                $page->image = $imagePath;
            } catch (Throwable $e) {
                Log::error('Failed to update image: '.$e->getMessage());
                $this->errorAlert('Failed to upload image: '.$e->getMessage());

                return;
            }
        }

        $page->save();

        $this->successAlert('Page updated successfully');
        $this->redirect(route('admin.pages'), navigate: true);
    }

    protected function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = Page::where('slug', $slug)
            ->when($this->pageId, function ($query): void {
                $query->where('id', '!=', $this->pageId);
            })
            ->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function render()
    {
        $pages = [];

        if ($this->view === 'list') {
            $pages = Page::when($this->search, function ($query): void {
                $query->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('type', 'like', '%'.$this->search.'%')
                    ->orWhere('content', 'like', '%'.$this->search.'%');
            })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10);
        }

        return view('livewire.admin.page-manager', [
            'pages' => $pages,
            'imagePreviewUrl' => $this->getImagePreviewUrl(),
        ])->layout('admin.layouts.app');
    }
}
