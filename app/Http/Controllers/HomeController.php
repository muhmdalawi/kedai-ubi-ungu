<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Gallery;
use App\Models\Order;
use App\Models\Product;
use App\Models\Promo;
use App\Models\Testimonial;

class HomeController extends Controller
{
    public function __invoke()
    {
        return view('public.home', [
            'banners' => Banner::where('is_active', true)->orderBy('sort_order')->orderBy('id')->get(),
            'bestSellers' => Product::with('category')->where('is_best_seller', true)->take(4)->get(),
            'promos' => Promo::current()->latest()->take(3)->get(),
            'testimonials' => Testimonial::latest()->take(6)->get(),
            'gallery' => Gallery::latest()->take(4)->get(),
            'stats' => [
                'products' => Product::count(),
                'orders' => Order::count(),
                'customers' => Order::distinct('whatsapp')->count('whatsapp'),
            ],
        ]);
    }
}
