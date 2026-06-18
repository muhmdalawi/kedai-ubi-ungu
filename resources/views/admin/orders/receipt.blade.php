<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Struk {{ $order->order_number }}</title>
    <style>
        * { box-sizing: border-box; }
        body {
            margin: 0;
            background: #f5f5f4;
            color: #1c1917;
            font-family: "Courier New", monospace;
            font-size: 12px;
            line-height: 1.45;
        }
        .toolbar {
            display: flex;
            justify-content: center;
            gap: 10px;
            padding: 18px;
            font-family: Arial, sans-serif;
        }
        .toolbar a, .toolbar button {
            border: 0;
            border-radius: 999px;
            padding: 10px 18px;
            cursor: pointer;
            text-decoration: none;
            font-weight: 700;
        }
        .toolbar button { background: #64258f; color: white; }
        .toolbar a { background: white; color: #522274; border: 1px solid #d4b1ff; }
        .receipt {
            width: 80mm;
            margin: 0 auto 24px;
            padding: 7mm 5mm;
            background: white;
            box-shadow: 0 12px 30px rgba(0,0,0,.1);
        }
        .center { text-align: center; }
        .brand { font-size: 18px; font-weight: 800; }
        .muted { color: #57534e; }
        .divider { border-top: 1px dashed #57534e; margin: 10px 0; }
        .row { display: flex; justify-content: space-between; gap: 10px; }
        .item { margin: 10px 0; }
        .item-name { font-weight: 800; }
        .detail { padding-left: 8px; color: #57534e; font-size: 11px; }
        .total { font-size: 14px; font-weight: 800; }
        .wrap { overflow-wrap: anywhere; white-space: pre-line; }
        @page { size: 80mm auto; margin: 0; }
        @media print {
            body { background: white; }
            .toolbar { display: none; }
            .receipt { width: 80mm; margin: 0; box-shadow: none; }
        }
    </style>
</head>
<body>
    <div class="toolbar">
        <a href="{{ route('admin.orders.show', $order) }}">Kembali</a>
        <button type="button" onclick="window.print()">Print Struk</button>
    </div>

    <main class="receipt">
        <header class="center">
            <div class="brand">{{ $profile?->business_name ?? 'Kedai Ubi Ungu' }}</div>
            @if($profile?->address)
                <div class="muted wrap">{{ $profile->address }}</div>
            @endif
            @if($contact?->whatsapp)
                <div class="muted">WA: {{ $contact->whatsapp }}</div>
            @endif
        </header>

        <div class="divider"></div>

        <div class="row"><span>No.</span><strong>{{ $order->order_number }}</strong></div>
        <div class="row"><span>Tanggal</span><span>{{ $order->created_at->format('d/m/Y H:i') }}</span></div>
        <div class="row"><span>Pelanggan</span><span>{{ $order->customer_name }}</span></div>
        <div class="row"><span>Status</span><span>{{ \App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status) }}</span></div>

        <div class="divider"></div>

        @foreach($order->items as $item)
            <section class="item">
                <div class="row">
                    <span class="item-name">{{ $item->product_name }}</span>
                    <span>{{ $item->quantity }}x</span>
                </div>
                <div class="row detail">
                    <span>Harga</span>
                    <span>Rp {{ number_format($item->price, 0, ',', '.') }}</span>
                </div>
                @if($item->variant_name)
                    <div class="row detail">
                        <span>{{ $item->variant_name }}</span>
                        <span>+Rp {{ number_format($item->variant_price, 0, ',', '.') }}</span>
                    </div>
                @endif
                @foreach($item->toppings as $topping)
                    <div class="row detail">
                        <span>+ {{ $topping->topping_name }}</span>
                        <span>Rp {{ number_format($topping->topping_price, 0, ',', '.') }}</span>
                    </div>
                @endforeach
                @if($item->notes)
                    <div class="detail wrap">Catatan: {{ $item->notes }}</div>
                @endif
                <div class="row">
                    <strong>Subtotal</strong>
                    <strong>Rp {{ number_format($item->subtotal, 0, ',', '.') }}</strong>
                </div>
            </section>
        @endforeach

        <div class="divider"></div>
        <div class="row total">
            <span>TOTAL</span>
            <span>Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>

        @if($order->notes)
            <div class="divider"></div>
            <div class="wrap"><strong>Catatan:</strong> {{ $order->notes }}</div>
        @endif

        <div class="divider"></div>
        <footer class="center">
            <strong>Terima kasih!</strong>
            <div class="muted">Pesanan Anda sedang kami siapkan.</div>
        </footer>
    </main>
</body>
</html>
