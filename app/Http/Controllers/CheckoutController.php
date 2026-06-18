<?php

namespace App\Http\Controllers;

use App\Http\Requests\CheckoutRequest;
use App\Models\Product;
use App\Services\CheckoutService;

class CheckoutController extends Controller
{
    public function index()
    {
        return view('public.checkout', ['products' => Product::where('stock_status', 'available')->orderBy('name')->get()]);
    }

    public function store(CheckoutRequest $request, CheckoutService $service)
    {
        try {
            $order = $service->create($request->validated());
        } catch (\DomainException $exception) {
            return response()->json(['message' => $exception->getMessage(), 'errors' => ['items' => [$exception->getMessage()]]], 422);
        }

        return response()->json(['order_number' => $order->order_number, 'total' => $order->total_price, 'whatsapp_url' => $service->whatsappUrl($order)], 201);
    }
}
