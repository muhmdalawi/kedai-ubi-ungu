@extends('layouts.admin')
@section('heading','Dashboard')
@section('content')
<div class="grid gap-5 sm:grid-cols-2 xl:grid-cols-5">@foreach($counts as $label=>$count)<article class="card p-5"><p class="text-xs font-bold uppercase tracking-wider text-stone-400">{{ $label }}</p><strong class="mt-2 block text-3xl font-black text-ube-800">{{ $count }}</strong></article>@endforeach</div>

<div class="mt-7 grid gap-7 xl:grid-cols-[1.5fr_1fr]">
    <section class="card p-6"><div class="flex items-center justify-between"><div><h2 class="text-xl font-black">Pesanan Bulanan</h2><p class="text-sm text-stone-400">12 bulan terakhir</p></div><a href="{{ route('admin.reports.orders') }}" class="text-sm font-bold text-ube-700">Unduh PDF</a></div>
        @php($max=max(1,$monthly->max('total')??1))
        <div class="mt-8 flex h-56 items-end gap-2">@forelse($monthly as $row)<div class="flex flex-1 flex-col items-center gap-2"><span class="text-xs font-bold">{{ $row->total }}</span><div class="w-full rounded-t-xl bg-ube-600" style="height:{{ max(8,($row->total/$max)*170) }}px"></div><small class="text-[10px] text-stone-400">{{ substr($row->month,5) }}</small></div>@empty<div class="grid h-full w-full place-items-center text-sm text-stone-400">Belum ada data pesanan.</div>@endforelse</div>
    </section>
    <section class="card p-6"><h2 class="text-xl font-black">Promo Aktif</h2><div class="mt-5 grid gap-3">@forelse($activePromos as $promo)<div class="rounded-2xl bg-ube-50 p-4"><strong class="text-ube-800">{{ $promo->title }}</strong><p class="mt-1 text-xs text-stone-500">Sampai {{ $promo->end_date->format('d M Y') }}</p></div>@empty<p class="text-sm text-stone-400">Tidak ada promo aktif.</p>@endforelse</div></section>
</div>

<div class="mt-7 grid gap-7 lg:grid-cols-3">
@foreach([['Produk Terlaris',$topProducts,'product_name'],['Topping Favorit',$topToppings,'topping_name'],['Variasi Favorit',$topVariants,'variant_name']] as [$title,$rows,$column])
<section class="card p-6"><h2 class="font-black">{{ $title }}</h2><div class="mt-4 grid gap-3">@forelse($rows as $row)<div class="flex justify-between border-b border-stone-100 pb-3 text-sm"><span>{{ $row->{$column} }}</span><strong class="text-ube-700">{{ $row->total }}</strong></div>@empty<p class="text-sm text-stone-400">Belum ada data.</p>@endforelse</div></section>
@endforeach
</div>

<section class="mt-7 card p-6"><div class="flex items-center justify-between"><h2 class="text-xl font-black">Pesanan Terbaru</h2><a class="text-sm font-bold text-ube-700" href="{{ route('admin.orders.index') }}">Lihat semua →</a></div><div class="mt-5 table-wrap"><table class="admin-table"><thead><tr><th>No. Pesanan</th><th>Pelanggan</th><th>Total</th><th>Status</th></tr></thead><tbody>@forelse($latestOrders as $order)<tr><td><a class="font-bold text-ube-700" href="{{ route('admin.orders.show',$order) }}">{{ $order->order_number }}</a></td><td>{{ $order->customer_name }}</td><td>Rp {{ number_format($order->total_price,0,',','.') }}</td><td>{{ \App\Models\Order::STATUSES[$order->status] }}</td></tr>@empty<tr><td colspan="4" class="text-center">Belum ada pesanan.</td></tr>@endforelse</tbody></table></div></section>
@endsection
