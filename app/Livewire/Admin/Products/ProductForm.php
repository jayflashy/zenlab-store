<?php

namespace App\Livewire\Admin\Products;

use App\Jobs\ProductUpdateNotificationJob;
use App\Models\Category;
use App\Models\Product;
use App\Traits\FileUploader;
use App\Traits\LivewireToast;
use Carbon\Carbon;
use Livewire\Attributes\Layout;
use Livewire\Component;
use Livewire\WithFileUploads;
use Purify;
use Str;

#[Layout('admin.layouts.app')]
class ProductForm extends Component
{
    use FileUploader;
    use LivewireToast;
    use WithFileUploads;

    public $product;

    public $pageTitle = 'Create Product';

    public $productId;

    public $name;

    public $slug;

    public $short_description;

    public $description;

    public $category_id;

    public $regular_price;

    public $extended_price;

    public $discount = 10;

    public $is_free = false;

    public $image;

    public $thumbnail;

    public $file_path;

    public $existing_image;

    public $existing_thumbnail;

    public $existing_file;

    public $download_link;

    public $download_type = 'file';

    public $demo_url;

    public $featured = false;

    public $tags = [];

    public $tag = '';

    public $version;

    public $customattributes = [];

    public $status = 'draft';

    public $publish_date;

    public $sales_count;

    public $sales_boost;

    // Screenshots array
    public $screenshots = [];

    public $existing_screenshots = [];

    // UI state
    public $activeTab = 'basic';

    public $formMode = 'create';

    // Attribute handling
    public $attributeKey = '';

    public $attributeValue = '';

    public $attributeType = 'text';

    protected $rules = [
        'name' => 'required|min:10|max:255',
        'slug' => 'required|max:255',
        'category_id' => 'nullable|exists:categories,id',
        'regular_price' => 'nullable|numeric|min:0',
        'extended_price' => 'nullable|numeric|min:0',
        'discount' => 'integer|min:0|max:100',
        'image' => 'nullable|image|max:5048',
        'thumbnail' => 'nullable|image|max:2024',
        'file_path' => 'nullable|file|max:51200', // 50MB max
        'demo_url' => 'nullable|url',
        'download_link' => 'nullable|url',
        'version' => 'nullable|max:20',
        'status' => 'required|in:draft,published,archived',
        'publish_date' => 'nullable|date',
        'short_description' => 'nullable|string',
        'description' => 'required|string|min:10',
        'sales_count' => 'nullable|integer|min:0',
        'sales_boost' => 'nullable|integer|min:0',
    ];

    public function mount($id = null)
    {
        $product = Product::find($id);
        if ($product && $product->exists) {
            $this->product = $product;
            $this->formMode = 'edit';
            $this->productId = $id;
            $this->loadProduct();
            $this->pageTitle = 'Edit Product';
        } else {
            $this->publish_date = now()->format('Y-m-d H:i:s');
        }
    }

    public function loadProduct()
    {
        $product = Product::findOrFail($this->productId);

        $this->name = $product->name;
        $this->slug = $product->slug;
        $this->short_description = $product->short_description;
        $this->description = $product->description;
        $this->category_id = $product->category_id;

        $this->regular_price = $product->regular_price;
        $this->extended_price = $product->extended_price;
        $this->discount = $product->discount;
        $this->is_free = $product->is_free;

        $this->existing_image = $product->image;
        $this->existing_thumbnail = $product->thumbnail;
        $this->existing_file = $product->file_path;
        $this->download_link = $product->download_link;
        $this->download_type = $product->download_type;
        $this->demo_url = $product->demo_url;
        $this->sales_count = $product->sales_count;
        $this->sales_boost = $product->sales_boost;

        $this->featured = $product->featured;
        $this->tags = $product->tags ?? [];
        $this->version = $product->version;
        $this->customattributes = $product->attributes ?? [];
        $this->status = $product->status;
        $this->publish_date = $product->publish_date ? Carbon::parse($product->publish_date)->format('Y-m-d') : null;

        $this->existing_screenshots = $product->screenshots ?? [];
    }

    public function updatedName()
    {
        $this->slug = Str::slug($this->name);
    }

    public function addTag()
    {
        $tag = trim((string) $this->tag);
        if (! empty($tag) && ! in_array($tag, $this->tags)) {
            $this->tags[] = $tag;
        }

        $this->tag = '';
    }

    public function removeTag($index)
    {
        unset($this->tags[$index]);
        $this->tags = array_values($this->tags);
    }

    public function addAttribute()
    {
        if (! empty($this->attributeKey)) {
            // Handle different attribute types
            $value = $this->attributeValue;

            switch ($this->attributeType) {
                case 'boolean':
                    $value = (bool) $value;
                    break;
                case 'array':
                    $value = explode(',', (string) $value);
                    break;
                case 'number':
                    $value = (float) $value;
                    break;
            }

            $this->customattributes[$this->attributeKey] = $value;
            $this->attributeKey = '';
            $this->attributeValue = '';
        }
    }

    public function removeAttribute($key)
    {
        unset($this->customattributes[$key]);
    }

    public function removeScreenshot($index)
    {
        if (isset($this->screenshots[$index])) {
            unset($this->screenshots[$index]);
            $this->screenshots = array_values($this->screenshots);
        }
    }

    public function removeExistingScreenshot($index)
    {
        if (isset($this->existing_screenshots[$index])) {
            unset($this->existing_screenshots[$index]);
            $this->existing_screenshots = array_values($this->existing_screenshots);
        }
    }

    public function loadAttributeTemplate($templateType)
    {
        switch ($templateType) {
            case 'theme':
                $this->customattributes = [
                    'compatible_with' => ['WordPress 6.0+', 'PHP 8.0+', 'MySQL 5.7+'],
                    'responsive' => true,
                    'file_types' => ['HTML', 'CSS', 'JS', 'PHP'],
                    'frameworks' => ['Bootstrap 5'],
                    'browsers' => ['Chrome', 'Firefox', 'Safari', 'Edge'],
                    'includes_documentation' => true,
                    'support_period' => '6 months',
                ];
                break;
            case 'plugin':
                $this->customattributes = [
                    'requirements' => [
                        'php' => '8.0+',
                        'wordpress' => '6.0+',
                    ],
                    'features' => [
                        'Easy installation',
                        'User-friendly interface',
                        'Regular updates',
                    ],
                    'license_type' => 'GPL-3.0',
                    'updates' => 'Lifetime',
                    'installation_method' => 'One-click install',
                ];
                break;
            case 'graphic':
                $this->customattributes = [
                    'file_formats' => ['PSD', 'AI', 'PNG', 'SVG'],
                    'dpi' => 300,
                    'color_mode' => 'CMYK',
                    'layered' => true,
                    'vector' => true,
                    'fonts' => [
                        'included' => true,
                    ],
                    'editable_text' => true,
                ];
                break;
        }
    }

    public function save()
    {
        $this->validate();

        $product = $this->formMode === 'edit' ? Product::findOrFail($this->productId) : new Product;

        $oldVersion = $product->version;
        // Basic info
        $product->name = $this->name;
        $product->slug = $this->slug;
        $product->short_description = $this->short_description;
        $product->description = Purify::clean($this->description) ?? $this->description;
        $product->category_id = $this->category_id;

        // Pricing
        $product->regular_price = $this->regular_price;
        $product->extended_price = $this->extended_price;
        $product->discount = $this->discount;
        $product->is_free = $this->is_free;
        $product->sales_boost = $this->sales_boost;
        $product->sales_count = $this->sales_count;

        // Media and files
        if ($this->image) {
            $imagePath = $this->handleImage(
                $this->image,
                'products/images',
                $this->existing_image,
                856,
                550
            );
            $product->image = $imagePath;
        }

        // handles thumbnail upload
        if ($this->thumbnail) {
            $thumbnailPath = $this->handleImage(
                $this->thumbnail,
                'products/thumbnails',
                $this->existing_thumbnail,
                290,
                160
            );
            $product->thumbnail = $thumbnailPath;
        }

        if ($this->file_path && $this->download_type === 'file') {
            $filePath = $this->handleFile(
                $this->file_path,
                'products/files',
                $this->existing_file
            );
            $product->file_path = $filePath;
        }

        $product->download_type = $this->download_type;
        $product->demo_url = $this->demo_url;
        $product->download_link = $this->download_link;

        // Screenshots
        $screenshotPaths = $this->existing_screenshots ?? [];

        if ($this->screenshots) {
            foreach ($this->screenshots as $screenshot) {
                $path = $screenshot->store('products/screenshots', 'uploads');
                $screenshotPaths[] = $path;
            }
        }

        $product->screenshots = $screenshotPaths;

        // Meta info
        $product->featured = $this->featured;
        $product->tags = $this->tags;
        $product->version = $this->version;
        $product->attributes = $this->customattributes;
        $product->status = $this->status;
        $product->publish_date = $this->publish_date;

        $product->save();

        if ($this->formMode === 'edit') {
            if ($product->version && $product->version !== $oldVersion) {
                ProductUpdateNotificationJob::dispatch($product);
                $this->infoAlert('Product update notifications are being sent to customers in the background.');
            }
        }

        $this->successAlert($this->formMode === 'edit' ? 'Product updated successfully!' : 'Product created successfully!');

        $this->redirect(route('admin.products.index'), navigate: true);
    }

    public function setActiveTab($tab)
    {
        $this->activeTab = $tab;
        $this->dispatch('activeTabChanged', $tab);
    }

    public function render()
    {
        $categories = Category::all();

        return view('livewire.admin.products.product-form', [
            'categories' => $categories,
            'pageTitle' => $this->pageTitle,
        ]);
    }
}
