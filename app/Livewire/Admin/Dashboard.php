<?php

namespace App\Livewire\Admin;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use App\Traits\LivewireToast;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('admin.layouts.app')]
class Dashboard extends Component
{
    use LivewireToast;

    public $totalRevenue = 0;
    public $totalOrders = 0;
    public $totalUsers = 0;
    public $totalProducts = 0;

    public $salesChartData = [];

    public $recentOrders = [];
    public $recentUsers = [];
    public $topSellingProducts = [];

    public function mount()
    {
        $this->loadStats();
    }

    public function loadStats()
    {
        $this->totalRevenue = Order::where('payment_status', 'completed')->sum('total');
        $this->totalOrders = Order::count();
        $this->totalUsers = User::count();
        $this->totalProducts = Product::count();
        $this->recentOrders = Order::with('user')->latest()->take(5)->get();
        $this->recentUsers = User::latest()->take(5)->get();

        $topSellingData = OrderItem::query()
            ->select('product_id', DB::raw('SUM(quantity) as total_sales'))
            ->whereHas('order', fn($q) => $q->where('payment_status', 'completed'))
            ->groupBy('product_id')
            ->orderByDesc('total_sales')
            ->take(5)
            ->get();
        $productIds = $topSellingData->pluck('product_id');

        if ($productIds->isNotEmpty()) {
            $products = Product::with('category')->whereIn('id', $productIds)->get()->keyBy('id');

            $this->topSellingProducts = $topSellingData->map(function ($item) use ($products) {
                $product = $products->get($item->product_id);
                if ($product) {
                    $product->total_sales = $item->total_sales;
                    return $product;
                }
                return null;
            })->filter()->sortByDesc('total_sales');
        } else {
            $this->topSellingProducts = collect();
        }

        $this->prepareSalesChartData();
        $this->dispatch('statsRefreshed', salesChartData: $this->salesChartData);
    }

    private function prepareSalesChartData()
    {
        $days = 30;
        $startDate = Carbon::today()->subDays($days - 1);
        $endDate = Carbon::today();

        $sales = Order::where('payment_status', 'completed')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->groupBy('date')
            ->orderBy('date', 'ASC')
            ->get([
                DB::raw('DATE(created_at) as date'),
                DB::raw('SUM(total) as total'),
            ])->pluck('total', 'date');

        $dates = collect(Carbon::parse($startDate)->toPeriod($endDate))->map(fn($date) => $date->format('Y-m-d'));

        $this->salesChartData['labels'] = $dates->map(fn($date) => Carbon::parse($date)->format('M d'))->toArray();
        $this->salesChartData['data'] = $dates->map(fn($date) => $sales->get($date, 0))->toArray();
    }

    public function render()
    {
        return view('livewire.admin.dashboard');
    }
}
