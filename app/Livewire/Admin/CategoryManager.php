<?php

namespace App\Livewire\Admin;

use App\Models\Category;
use App\Traits\LivewireToast;
use Livewire\Component;
use Livewire\WithFileUploads;
use Livewire\WithPagination;
use Str;

class CategoryManager extends Component

{
    use LivewireToast, WithPagination, WithFileUploads;

    public $name = '';
    public $slug = '';
    public $description = '';
    public $image;
    public $icon = '';
    public $isActive = true;
    public $parentId = null;
    public $sortOrder = 0;
    public $metaTitle = '';
    public $metaDescription = '';

    public $editingCategoryId = null;
    public $isCreating = false;
    public $confirmingCategoryDeletion = false;
    public $categoryIdToDelete = null;

    public $searchTerm = '';
    public $showInactive = false;
    public $perPage = 1;

    protected $rules = [
        'name' => 'required|min:2|max:100',
        'slug' => 'nullable|max:100',
        'description' => 'nullable',
        'image' => 'nullable|image|max:2048',
        'icon' => 'nullable|max:50',
        'isActive' => 'boolean',
        'parentId' => 'nullable|exists:categories,id',
        'sortOrder' => 'integer',
        'metaTitle' => 'nullable|max:100',
        'metaDescription' => 'nullable|max:255',
    ];

    public function updatedName()
    {
        $this->slug = \Str::slug($this->name);
    }

    public function create()
    {
        $this->reset([
            'name',
            'slug',
            'description',
            'image',
            'icon',
            'isActive',
            'parentId',
            'sortOrder',
            'metaTitle',
            'metaDescription',
            'editingCategoryId'
        ]);
        $this->isActive = true;
        $this->sortOrder = 0;
        $this->isCreating = true;
    }

    public function save()
    {
        $this->validate();

        $metaData = [
            'title' => $this->metaTitle,
            'description' => $this->metaDescription,
        ];

        $categoryData = [
            'name' => $this->name,
            'slug' => $this->slug ?: Str::slug($this->name),
            'description' => $this->description,
            'icon' => $this->icon,
            'is_active' => $this->isActive,
            'parent_id' => $this->parentId,
            'order' => $this->sortOrder,
            'metadata' => $metaData,
        ];

        if ($this->image) {
            $imagePath = $this->image->store('categories', 'uploads');
            $categoryData['image'] = $imagePath;
        }

        if ($this->editingCategoryId) {
            $category = Category::find($this->editingCategoryId);
            if ($category->image) {
                \Storage::disk('uploads')->delete($category->image);
            }
            $category->update($categoryData);
            $this->successAlert('Category updated successfully!');
        } else {
            Category::create($categoryData);
            $this->successAlert('Category updated successfully!');
        }

        $this->reset([
            'name',
            'slug',
            'description',
            'image',
            'icon',
            'isActive',
            'parentId',
            'sortOrder',
            'metaTitle',
            'metaDescription',
            'editingCategoryId',
            'isCreating'
        ]);
    }

    public function edit(Category $category)
    {
        $this->editingCategoryId = $category->id;
        $this->name = $category->name;
        $this->slug = $category->slug;
        $this->description = $category->description;
        $this->icon = $category->icon;
        $this->isActive = $category->is_active;
        $this->parentId = $category->parent_id;
        $this->sortOrder = $category->order;

        if ($category->metadata) {
            $this->metaTitle = $category->metadata['title'] ?? '';
            $this->metaDescription = $category->metadata['description'] ?? '';
        }

        $this->isCreating = true;
    }

    public function confirmDelete($categoryId)
    {
        $this->confirmingCategoryDeletion = true;
        $this->categoryIdToDelete = $categoryId;
    }

    public function deleteCategory()
    {
        $category = Category::find($this->categoryIdToDelete);

        if ($category) {
            // Check if has children
            if ($category->hasChildren()) {
                $this->errorAlert('Cannot delete a category with subcategories!');
            } else {
                if ($category->image) {
                    \Storage::disk('uploads')->delete($category->image);
                }
                $category->delete();
                $this->successAlert('Category deleted successfully!');
            }
        }

        $this->confirmingCategoryDeletion = false;
        $this->categoryIdToDelete = null;
    }

    public function cancelDelete()
    {
        $this->confirmingCategoryDeletion = false;
        $this->categoryIdToDelete = null;
    }

    public function cancelEdit()
    {
        $this->reset([
            'name',
            'slug',
            'description',
            'image',
            'icon',
            'isActive',
            'parentId',
            'sortOrder',
            'metaTitle',
            'metaDescription',
            'editingCategoryId',
            'isCreating'
        ]);
    }

    public function render()
    {
        $categories = Category::query()
            ->when($this->searchTerm, function ($q) {
                return $q->where('name', 'like', '%' . $this->searchTerm . '%')
                    ->orWhere('slug', 'like', '%' . $this->searchTerm . '%');
            })
            ->when(!$this->showInactive, function ($q) {
                return $q->where('is_active', true);
            })
            ->with('parent')
            ->withCount('children')
            ->orderBy('order')
            ->paginate($this->perPage);

        $parentCategories = Category::whereNull('parent_id')
            ->where('is_active', true)
            ->orderBy('name')
            ->get();

        return view('livewire.admin.category-manager', [
            'categories' => $categories,
            'parentCategories' => $parentCategories,
        ])->layout('admin.layouts.app');
    }
}
