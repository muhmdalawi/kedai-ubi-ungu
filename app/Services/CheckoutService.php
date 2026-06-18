<?php

namespace App\Services;

use App\Models\Contact;
use App\Models\Order;
use App\Models\Product;
use Illuminate\Support\Facades\DB;

class CheckoutService
{
    public function create(array $data): Order
    {
        return DB::transaction(function () use ($data) {
            $order = Order::create([
                'order_number' => 'KUU-'.now()->format('Ymd').'-'.str()->upper(str()->random(6)),
                'customer_name' => $data['customer_name'],
                'whatsapp' => $data['whatsapp'],
                'address' => $data['address'],
                'notes' => $data['notes'] ?? null,
                'total_price' => 0,
                'status' => 'pending',
            ]);

            $total = 0;
            foreach ($data['items'] as $index => $requested) {
                $product = Product::with(['variants', 'toppings'])->findOrFail($requested['product_id']);
                if ($product->stock_status !== 'available') {
                    throw new \DomainException("{$product->name} sedang habis.");
                }

                $variant = null;
                if (! empty($requested['variant_id'])) {
                    $variant = $product->variants->firstWhere('id', (int) $requested['variant_id']);
                    if (! $variant || ! $variant->is_active) {
                        throw new \DomainException('Variasi produk tidak lagi tersedia.');
                    }
                }

                $requestedToppingIds = collect($requested['topping_ids'] ?? [])->map(fn ($id) => (int) $id);
                $toppings = $product->toppings->whereIn('id', $requestedToppingIds)->where('is_active', true);
                if ($toppings->count() !== $requestedToppingIds->unique()->count()) {
                    throw new \DomainException('Salah satu topping tidak lagi tersedia.');
                }

                $quantity = (int) $requested['quantity'];
                $unitTotal = $product->price + ($variant?->additional_price ?? 0) + $toppings->sum('additional_price');
                $subtotal = $unitTotal * $quantity;
                $item = $order->items()->create([
                    'product_id' => $product->id,
                    'product_variant_id' => $variant?->id,
                    'product_name' => $product->name,
                    'variant_name' => $variant?->variant_name,
                    'quantity' => $quantity,
                    'price' => $product->price,
                    'variant_price' => $variant?->additional_price ?? 0,
                    'subtotal' => $subtotal,
                    'notes' => $requested['notes'] ?? null,
                ]);

                foreach ($toppings as $topping) {
                    $item->toppings()->create([
                        'topping_id' => $topping->id,
                        'topping_name' => $topping->name,
                        'topping_price' => $topping->additional_price,
                    ]);
                }
                $total += $subtotal;
            }

            $order->update(['total_price' => $total]);

            return $order->load('items.toppings');
        });
    }

    public function whatsappUrl(Order $order): string
    {
        $contact = Contact::first();
        $lines = [
            'Halo Kedai Ubi Ungu, saya ingin memesan:',
            '',
            "No. Pesanan: {$order->order_number}",
            "Nama: {$order->customer_name}",
            "Nomor WhatsApp: {$order->whatsapp}",
            "Alamat: {$order->address}",
            '',
        ];

        foreach ($order->items as $index => $item) {
            $lines[] = ($index + 1).". {$item->product_name} × {$item->quantity}";
            if ($item->variant_name) {
                $lines[] = "   Variasi: {$item->variant_name}";
            }
            if ($item->toppings->isNotEmpty()) {
                $lines[] = '   Topping: '.$item->toppings->pluck('topping_name')->join(', ');
            }
            if ($item->notes) {
                $lines[] = "   Catatan: {$item->notes}";
            }
            $lines[] = '   Subtotal: Rp '.number_format($item->subtotal, 0, ',', '.');
        }

        $lines[] = '';
        $lines[] = 'Total Pembayaran: Rp '.number_format($order->total_price, 0, ',', '.');
        if ($order->notes) {
            $lines[] = "Catatan pesanan: {$order->notes}";
        }

        return 'https://wa.me/'.preg_replace('/\D+/', '', $contact?->whatsapp ?? '').'?text='.rawurlencode(implode("\n", $lines));
    }
}
