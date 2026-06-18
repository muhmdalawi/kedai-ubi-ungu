<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BusinessProfile;
use App\Models\Contact;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class OrderController extends Controller
{
    public function index(Request $request)
    {
        $orders = Order::when($request->filled('status'), fn ($q) => $q->where('status', $request->status))
            ->when($request->filled('q'), function ($query) use ($request) {
                $term = '%'.mb_strtolower($request->q).'%';
                $query->where(fn ($inner) => $inner->whereRaw('LOWER(order_number) LIKE ?', [$term])->orWhereRaw('LOWER(customer_name) LIKE ?', [$term]));
            })
            ->latest()->paginate(20)->withQueryString();

        return view('admin.orders.index', compact('orders'));
    }

    public function show(Order $order)
    {
        return view('admin.orders.show', ['order' => $order->load('items.toppings')]);
    }

    public function receipt(Order $order)
    {
        return view('admin.orders.receipt', [
            'order' => $order->load('items.toppings'),
            'profile' => BusinessProfile::first(),
            'contact' => Contact::first(),
        ]);
    }

    public function update(Request $request, Order $order)
    {
        $order->update($request->validate(['status' => ['required', Rule::in(array_keys(Order::STATUSES))]]));

        return back()->with('success', 'Status pesanan berhasil diperbarui.');
    }

    public function destroy(Order $order)
    {
        $order->delete();

        return redirect()->route('admin.orders.index')->with('success', 'Pesanan berhasil dihapus.');
    }
}
