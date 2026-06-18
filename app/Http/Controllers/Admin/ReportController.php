<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promo;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    public function products()
    {
        return Pdf::loadView('admin.reports.products', ['products' => Product::with('category')->orderBy('name')->get()])->download('laporan-menu.pdf');
    }

    public function promos()
    {
        return Pdf::loadView('admin.reports.promos', ['promos' => Promo::orderByDesc('start_date')->get()])->download('laporan-promo.pdf');
    }

    public function orders(Request $request)
    {
        $orders = Order::with('items.toppings')->when($request->filled('status'), fn ($q) => $q->where('status', $request->status))->when($request->filled('from'), fn ($q) => $q->whereDate('created_at', '>=', $request->from))->when($request->filled('to'), fn ($q) => $q->whereDate('created_at', '<=', $request->to))->latest()->get();

        return Pdf::loadView('admin.reports.orders', compact('orders'))->setPaper('a4', 'landscape')->download('laporan-pesanan.pdf');
    }
}
