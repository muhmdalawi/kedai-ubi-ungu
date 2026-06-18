<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Gallery;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\OrderItemTopping;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Topping;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function __invoke()
    {
        $monthly = Order::where('created_at', '>=', now()->subMonths(11))->get()
            ->groupBy(fn ($order) => $order->created_at->format('Y-m'))
            ->map(fn ($orders, $month) => (object) ['month' => $month, 'total' => $orders->count()])
            ->sortBy('month')->values();

        return view('admin.dashboard', [
            'counts' => ['Produk' => Product::count(), 'Kategori' => Category::count(), 'Topping' => Topping::count(), 'Pesanan' => Order::count(), 'Galeri' => Gallery::count()],
            'monthly' => $monthly,
            'topProducts' => OrderItem::select('product_name', DB::raw('SUM(quantity) as total'))->groupBy('product_name')->orderByDesc('total')->take(5)->get(),
            'topToppings' => OrderItemTopping::select('topping_name', DB::raw('COUNT(*) as total'))->groupBy('topping_name')->orderByDesc('total')->take(5)->get(),
            'topVariants' => OrderItem::select('variant_name', DB::raw('COUNT(*) as total'))->whereNotNull('variant_name')->groupBy('variant_name')->orderByDesc('total')->take(5)->get(),
            'latestOrders' => Order::latest()->take(8)->get(),
            'activePromos' => Promo::current()->get(),
        ]);
    }
}
