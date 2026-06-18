<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class CatalogController extends Controller
{
    public function index(Request $request)
    {
        $products = Product::with(['category', 'variants' => fn ($q) => $q->where('is_active', true)->orderBy('additional_price'), 'toppings' => fn ($q) => $q->where('is_active', true)])
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.mb_strtolower($request->q).'%';
                $query->where(fn ($inner) => $inner->whereRaw('LOWER(name) LIKE ?', [$term])->orWhereRaw('LOWER(description) LIKE ?', [$term]));
            })
            ->when($request->filled('category'), fn ($q) => $q->whereHas('category', fn ($category) => $category->where('id', $request->integer('category'))))
            ->latest()->paginate(9)->withQueryString();

        return view('public.menu', ['products' => $products, 'categories' => Category::orderBy('name')->get()]);
    }

    public function show(Product $product)
    {
        $product->load(['category', 'variants' => fn ($q) => $q->where('is_active', true)->orderBy('additional_price'), 'toppings' => fn ($q) => $q->where('is_active', true)]);

        return view('public.product', compact('product'));
    }

    public function configuration(Product $product)
    {
        $product->load(['variants' => fn ($q) => $q->where('is_active', true)->orderBy('additional_price'), 'toppings' => fn ($q) => $q->where('is_active', true)]);

        return response()->json([
            'id' => $product->id,
            'name' => $product->name,
            'price' => $product->price,
            'stock_status' => $product->stock_status,
            'image_url' => $product->image_url,
            'variants' => $product->variants,
            'toppings' => $product->toppings->map(fn ($t) => $t->append('image_url')),
        ]);
    }
}
