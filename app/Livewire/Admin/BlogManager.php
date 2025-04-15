<?php

namespace App\Livewire\Admin;

use App\Models\Blog;
use App\Traits\LivewireToast;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;

class BlogManager extends Component
{
    use LivewireToast;
    use WithFileUploads;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // List view properties
    public $search = '';

    public $sortField = 'created_at';

    public $sortDirection = 'desc';

    // Form properties
    public $blogId;

    public $title;

    public $slug;

    public $body;

    public $image;

    public $tempImage;

    public $existingImage;

    public $about;

    public $tags;

    public $is_active = true;

    public $metadata = [];

    // UI state
    public $view = 'list'; // 'list', 'create', 'edit'

    public $confirmingDelete = false;

    public $deleteId = null;

    protected $queryString = ['search', 'sortField', 'sortDirection'];

    protected $rules = [
        'title' => 'required|string|max:100',
        'slug' => 'nullable|string',
        'body' => 'required|string',
        'image' => 'nullable|image|max:2048',
        'about' => 'nullable|string|max:255',
        'tags' => 'nullable|string',
        'is_active' => 'boolean',
        'metadata' => 'nullable',
    ];

    public function mount($id = null)
    {
        $routeName = request()->route()->getName();

        if ($routeName === 'admin.blogs.create') {
            $this->view = 'create';
            $this->showCreateForm();
        } elseif ($routeName === 'admin.blogs.edit' && $id) {
            $this->showEditForm($id);
        } else {
            $this->view = 'list';
        }
    }

    public function updatedTitle()
    {
        $this->slug = Str::slug($this->title);
    }

    public function updatedImage()
    {
        $this->validate([
            'image' => 'image|max:2048',
        ]);
        $this->tempImage = true;
    }

    public function removeImage()
    {
        $this->image = null;
        $this->tempImage = false;
        $this->existingImage = null;
    }

    public function sortBy($field)
    {
        if ($this->sortField === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortField = $field;
            $this->sortDirection = 'asc';
        }
    }

    public function updatingSearch()
    {
        $this->resetPage();
    }

    public function showCreateForm()
    {
        $this->resetForm();
        $this->view = 'create';
    }

    public function showEditForm($id)
    {
        $this->resetForm();

        $blog = Blog::findOrFail($id);
        $this->blogId = $blog->id;
        $this->title = $blog->title;
        $this->slug = $blog->slug;
        $this->body = $blog->body;
        $this->existingImage = $blog->image;
        $this->about = $blog->about;
        $this->tags = $blog->tags;
        $this->is_active = $blog->is_active;
        $this->metadata = $blog->metadata ?? [];

        $this->view = 'edit';
    }

    public function backToList()
    {
        $this->view = 'list';
        $this->resetForm();
    }

    public function resetForm()
    {
        $this->reset([
            'blogId',
            'title',
            'slug',
            'body',
            'image',
            'tempImage',
            'existingImage',
            'about',
            'tags',
            'is_active',
            'metadata',
        ]);
        $this->resetErrorBag();
    }

    public function confirmDelete($id)
    {
        $this->deleteId = $id;
        $this->confirmingDelete = true;
    }

    public function cancelDelete()
    {
        $this->deleteId = null;
        $this->confirmingDelete = false;
    }

    public function deleteBlog()
    {
        $blog = Blog::findOrFail($this->deleteId);

        // Delete image file if exists
        if ($blog->image) {
            try {
                Storage::disk('uploads')->delete($blog->image);
            } catch (\Throwable $th) {
                // Continue if file doesn't exist
            }
        }

        $blog->delete();

        $this->confirmingDelete = false;
        $this->deleteId = null;

        $this->successAlert('Blog deleted successfully');
    }

    public function save()
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
        $this->rules['image'] = 'required|image|max:2048';
        $this->validate();

        $blog = new Blog;
        $blog->title = $this->title;
        $blog->slug = $this->generateUniqueSlug($this->title);
        $blog->body = $this->body;
        $blog->about = $this->about;
        $blog->tags = $this->tags;
        $blog->is_active = $this->is_active;
        // $blog->metadata = $this->metadata;

        if ($this->image) {
            $imagePath = Storage::disk('uploads')->putFile('blogs', $this->image);
            $blog->image = $imagePath;
        }

        $blog->save();

        $this->successAlert('Blog created successfully');
        $this->redirect(route('admin.blogs'), navigate: true);
        // $this->backToList();
    }

    protected function update()
    {
        // Make image optional when updating
        $this->rules['image'] = 'nullable|image|max:2048';
        $this->validate();

        $blog = Blog::findOrFail($this->blogId);
        $blog->title = $this->title;

        // Only update slug if title changed
        if ($blog->title !== $this->title) {
            $blog->slug = $this->generateUniqueSlug($this->title);
        }

        $blog->body = $this->body;
        $blog->about = $this->about;
        $blog->tags = $this->tags;
        $blog->is_active = $this->is_active;
        $blog->metadata = $this->metadata;

        if ($this->image) {
            // Remove old image
            if ($blog->image) {
                Storage::disk('uploads')->delete($blog->image);
            }
            // Save new image
            $imagePath = Storage::disk('uploads')->putFile('blogs', $this->image);
            $blog->image = $imagePath;
        }

        $blog->save();

        $this->redirect(route('admin.blogs'), navigate: true);
        $this->successAlert('Blog updated successfully');
    }

    protected function generateUniqueSlug($title)
    {
        $slug = Str::slug($title);
        $count = Blog::where('slug', $slug)
            ->when($this->blogId, function ($query): void {
                $query->where('id', '!=', $this->blogId);
            })
            ->count();

        return $count ? "{$slug}-{$count}" : $slug;
    }

    public function getImagePreviewUrl()
    {
        if ($this->tempImage && $this->image) {
            return $this->image->temporaryUrl();
        }

        if ($this->existingImage) {
            return my_asset($this->existingImage);
        }

        return null;
    }

    public function render()
    {
        $blogs = [];

        if ($this->view === 'list') {
            $blogs = Blog::when($this->search, function ($query): void {
                $query->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('tags', 'like', '%'.$this->search.'%')
                    ->orWhere('about', 'like', '%'.$this->search.'%');
            })
                ->orderBy($this->sortField, $this->sortDirection)
                ->paginate(10);
        }

        return view('livewire.admin.blog-manager', [
            'blogs' => $blogs,
            'imagePreviewUrl' => $this->getImagePreviewUrl(),
        ])->layout('admin.layouts.app');
    }
}
