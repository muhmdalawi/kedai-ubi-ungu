@extends('layouts.admin')

@section('heading', 'Detail '.$order->order_number)

@section('content')
<div class="mb-6 flex flex-wrap items-center justify-between gap-3">
    <a href="{{ route('admin.orders.index') }}" class="btn-secondary">← Kembali</a>
    <a href="{{ route('admin.orders.receipt', $order) }}" target="_blank" class="btn-primary">
        <x-icon name="print" class="mr-2 h-5 w-5"/>
        Print Struk
    </a>
</div>

<div class="grid gap-7 xl:grid-cols-[1.2fr_.8fr]">
    <section class="card p-6">
        <div class="flex flex-wrap items-center justify-between gap-3">
            <div>
                <h2 class="text-xl font-black">Item Pesanan</h2>
                <p class="mt-1 text-sm font-medium text-stone-500">
                    {{ $order->created_at->translatedFormat('d F Y, H:i') }}
                </p>
            </div>
            <span class="badge bg-ube-100 text-ube-800">
                {{ \App\Models\Order::STATUSES[$order->status] ?? ucfirst($order->status) }}
            </span>
        </div>

        <div class="mt-5 grid gap-4">
            @forelse($order->items as $item)
                <article class="rounded-2xl border border-stone-200 p-4">
                    <div class="flex items-start justify-between gap-4">
                        <div>
                            <strong>{{ $item->product_name }} × {{ $item->quantity }}</strong>
                            <p class="mt-1 text-xs font-medium text-stone-500">
                                Harga dasar: Rp {{ number_format($item->price, 0, ',', '.') }}
                            </p>
                        </div>
                        <strong class="shrink-0 text-ube-700">
                            Rp {{ number_format($item->subtotal, 0, ',', '.') }}
                        </strong>
                    </div>

                    @if($item->variant_name)
                        <p class="mt-3 text-sm text-stone-600">
                            Variasi: {{ $item->variant_name }}
                            @if($item->variant_price > 0)
                                (+Rp {{ number_format($item->variant_price, 0, ',', '.') }})
                            @endif
                        </p>
                    @endif

                    @if($item->toppings->isNotEmpty())
                        <div class="mt-3 rounded-xl bg-ube-50 p-3">
                            <p class="text-xs font-extrabold uppercase tracking-wider text-ube-800">Topping</p>
                            @foreach($item->toppings as $topping)
                                <div class="mt-1 flex justify-between gap-3 text-sm text-stone-600">
                                    <span>{{ $topping->topping_name }}</span>
                                    <span>+Rp {{ number_format($topping->topping_price, 0, ',', '.') }}</span>
                                </div>
                            @endforeach
                        </div>
                    @endif

                    @if($item->notes)
                        <p class="mt-3 text-sm italic text-stone-500">Catatan: {{ $item->notes }}</p>
                    @endif
                </article>
            @empty
                <div class="rounded-2xl bg-stone-50 p-6 text-center text-sm text-stone-500">
                    Detail item pesanan tidak tersedia.
                </div>
            @endforelse
        </div>

        <div class="mt-6 flex justify-between border-t border-stone-200 pt-5 text-xl font-black">
            <span>Total</span>
            <span class="text-ube-800">Rp {{ number_format($order->total_price, 0, ',', '.') }}</span>
        </div>
    </section>

    <aside class="space-y-6">
        <section class="card p-6">
            <h2 class="font-black">Data Pelanggan</h2>
            <dl class="mt-4 grid gap-4 text-sm">
                <div>
                    <dt class="font-bold text-stone-500">Nama</dt>
                    <dd class="mt-1 font-bold text-stone-900">{{ $order->customer_name }}</dd>
                </div>
                <div>
                    <dt class="font-bold text-stone-500">WhatsApp</dt>
                    <dd class="mt-1">{{ $order->whatsapp }}</dd>
                </div>
                <div>
                    <dt class="font-bold text-stone-500">Alamat</dt>
                    <dd class="mt-1 whitespace-pre-line">{{ $order->address }}</dd>
                </div>
                <div>
                    <dt class="font-bold text-stone-500">Catatan</dt>
                    <dd class="mt-1 whitespace-pre-line">{{ $order->notes ?: '—' }}</dd>
                </div>
            </dl>
        </section>

        <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="card p-6">
            @csrf
            @method('PATCH')
            <label class="label" for="status">Status pesanan</label>
            <select id="status" name="status" class="field">
                @foreach(\App\Models\Order::STATUSES as $value => $label)
                    <option value="{{ $value }}" @selected($order->status === $value)>{{ $label }}</option>
                @endforeach
            </select>
            <button class="btn-primary mt-4 w-full">Perbarui Status</button>
        </form>

        <form method="POST" action="{{ route('admin.orders.destroy', $order) }}" onsubmit="return confirm('Hapus pesanan ini?')">
            @csrf
            @method('DELETE')
            <button class="w-full rounded-full bg-rose-100 px-5 py-3 font-bold text-rose-700 hover:bg-rose-200">
                Hapus Pesanan
            </button>
        </form>
    </aside>
</div>
@endsection
