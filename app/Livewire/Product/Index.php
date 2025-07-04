<?php

namespace App\Livewire\Product;

use App\Models\Category;
use App\Models\Product;
use App\Traits\LivewireToast;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;
use Livewire\WithPagination;

class Index extends Component
{
    use LivewireToast;
    use WithPagination;

    protected $paginationTheme = 'bootstrap';

    // Filter properties
    public $search = '';

    public $categoryId = '';

    public $minPrice = '';

    public $maxPrice = '';

    public $ratingFilter = '';

    public $dateFilter = '';

    public $sortBy = 'latest';

    public $view = 'grid'; // grid or list view

    // For filter sidebar mobile toggle
    public $sidebarOpen = false;

    public $isFilterOpen = false;

    protected $queryString = [
        'search' => ['except' => ''],
        'categoryId' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'ratingFilter' => ['except' => ''],
        'dateFilter' => ['except' => ''],
        'sortBy' => ['except' => 'latest'],
        'view' => ['except' => 'grid'],
        'sidebarOpen' => ['except' => false],
    ];

    public function mount(): void {}

    public function openFilter(): void
    {
        $this->isFilterOpen = ! $this->isFilterOpen;
    }

    public function toggleView(string $viewType): void
    {
        $this->view = $viewType;
    }

    public function toggleSidebar(): void
    {
        $this->sidebarOpen = ! $this->sidebarOpen;
    }

    public function toggleWishlist($productId): void
    {
        if (! Auth::check()) {
            $this->warningAlert('Please login to add products to wishlist', 'warning');

            return;
        }
        $user = Auth::user();

        $wishlistItem = $user->wishlists()->where('product_id', $productId)->first();

        if ($wishlistItem) {
            $wishlistItem->delete();
            $this->successAlert('Product removed from wishlist!', 'success');
        } else {
            $user->wishlists()->create([
                'product_id' => $productId,
            ]);
            $this->successAlert('Product added to wishlist!', 'success');
        }

        $this->dispatch('wishlistUpdated', $productId);
    }

    public function clearFilters(): void
    {
        $this->reset([
            'search',
            'categoryId',
            'minPrice',
            'maxPrice',
            'ratingFilter',
            'dateFilter',
        ]);
    }

    public function updated($name, $value)
    {
        // List of filters that should reset and close the sidebar
        $filterProperties = [
            'search',
            'categoryId',
            'minPrice',
            'maxPrice',
            'ratingFilter',
            'dateFilter',
            'sortBy',
        ];

        if (in_array($name, $filterProperties)) {

            $this->resetPage();
            $this->dispatch('closeSidebar');
        }
    }

    public function getTotalProductsCount()
    {
        return Product::where('status', 'published')->count();
    }

    public function getCategories()
    {
        return Category::active()
            ->parents()
            ->withCount(['products' => function ($query) {
                $query->where('status', 'published');
            }])
            ->having('products_count', '>', 0)
            ->orderBy('order')
            ->get();
    }

    public function getProducts()
    {
        $query = Product::query()->where('status', 'published')->with(['category', 'wishlists', 'ratings']);

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('name', 'like', '%' . $this->search . '%')
                    ->orWhere('short_description', 'like', '%' . $this->search . '%')
                    ->orWhere('tags', 'like', '%' . $this->search . '%');
            });
        }

        // Apply category filter
        if ($this->categoryId) {
            $query->where('category_id', $this->categoryId);
        }

        // Apply price filter
        if ($this->minPrice !== '' && is_numeric($this->minPrice)) {
            $query->whereRaw('COALESCE(sale_price, regular_price) >= ?', [$this->minPrice]);
        }

        if ($this->maxPrice !== '' && is_numeric($this->maxPrice)) {
            $query->whereRaw('COALESCE(sale_price, regular_price) <= ?', [$this->maxPrice]);
        }
        // Apply rating filter - Note: This is a simplified approach
        if ($this->ratingFilter) {
            $minRating = (int) $this->ratingFilter;
            // This subquery approach requires testing with your specific database
            $query->whereHas('ratings', function ($q) use ($minRating) {
                $q->select('product_id')
                    ->groupBy('product_id')
                    ->havingRaw('AVG(stars) >= ?', [$minRating]);
            });
        }

        // Apply date filter
        if ($this->dateFilter) {
            $date = match ($this->dateFilter) {
                'day' => now()->subDay(),
                'week' => now()->subWeek(),
                'month' => now()->subMonth(),
                'year' => now()->subYear(),
                default => null,
            };

            if ($date) {
                $query->where('publish_date', '>=', $date);
            }
        }

        // Apply sorting
        $query = match ($this->sortBy) {
            'price_low' => $query->orderBy('regular_price', 'asc'),
            'price_high' => $query->orderBy('regular_price', 'desc'),
            'popular' => $query->orderBy('sales_count', 'desc'),
            'rating' => $query->withAvg('ratings', 'stars')->orderByDesc('ratings_avg_stars'),
            'latest' => $query->orderBy('publish_date', 'desc'),
            'oldest' => $query->orderBy('publish_date', 'asc'),
            default => $query->orderBy('publish_date', 'desc'),
        };

        return $query->paginate(12);
    }

    public function render(): View
    {
        return view('livewire.product.index', [
            'products' => $this->getProducts(),
            'categories' => $this->getCategories(),
        ]);
    }
}
