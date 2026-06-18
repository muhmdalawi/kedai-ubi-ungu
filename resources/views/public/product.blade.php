@extends('layouts.public')
@section('title', $product->name.' — Kedai Ubi Ungu')
@section('description', $product->description)
@section('content')
<section class="py-12 lg:py-20"><div class="container-site grid gap-10 lg:grid-cols-2">
    <div><img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="sticky top-28 aspect-square w-full rounded-[3rem] object-cover shadow-xl"></div>
    <div>
        <a href="{{ route('menu.index') }}" class="text-sm font-bold text-ube-700">← Kembali ke menu</a>
        <div class="mt-5 flex gap-2"><span class="badge bg-ube-100 text-ube-700">{{ $product->category->name }}</span>@if($product->is_best_seller)<span class="badge bg-amber-100 text-amber-700">Best Seller</span>@endif</div>
        <h1 class="mt-4 text-4xl font-black text-stone-900 sm:text-5xl">{{ $product->name }}</h1>
        <p class="mt-5 leading-8 text-stone-600">{{ $product->description }}</p>
        @if($product->stock_status !== 'available')<div class="mt-8 rounded-2xl bg-stone-100 p-5 font-bold text-stone-500">Maaf, menu ini sedang habis.</div>@else
        <form data-product-builder data-product-id="{{ $product->id }}" data-product-name="{{ $product->name }}" data-product-image="{{ $product->image_url }}" data-price="{{ $product->price }}" class="mt-8 space-y-7">
            @if($product->variants->isNotEmpty())<fieldset><legend class="mb-3 text-sm font-black">Pilih variasi</legend><div class="grid gap-3 sm:grid-cols-2">@foreach($product->variants as $variant)<label class="cursor-pointer rounded-2xl border border-stone-200 p-4 has-[:checked]:border-ube-600 has-[:checked]:bg-ube-50"><input type="radio" name="variant_id" value="{{ $variant->id }}" data-name="{{ $variant->variant_name }}" data-price="{{ $variant->additional_price }}" class="mr-2 accent-ube-700" @checked($loop->first)><strong>{{ $variant->variant_name }}</strong><span class="float-right text-sm text-ube-700">+Rp {{ number_format($variant->additional_price,0,',','.') }}</span></label>@endforeach</div></fieldset>@endif
            @if($product->toppings->isNotEmpty())<fieldset><legend class="mb-3 text-sm font-black">Tambah topping <span class="font-normal text-stone-400">(boleh lebih dari satu)</span></legend><div class="grid grid-cols-2 gap-3 sm:grid-cols-3">@foreach($product->toppings as $topping)<label class="cursor-pointer overflow-hidden rounded-2xl border border-stone-200 has-[:checked]:border-ube-600 has-[:checked]:ring-2 has-[:checked]:ring-ube-100"><img src="{{ $topping->image_url }}" class="aspect-square w-full object-cover" alt="{{ $topping->name }}"><span class="block p-3"><input type="checkbox" name="topping_ids[]" value="{{ $topping->id }}" data-name="{{ $topping->name }}" data-price="{{ $topping->additional_price }}" class="mr-1 accent-ube-700"><span class="text-xs font-bold">{{ $topping->name }}</span><small class="mt-1 block text-ube-700">+Rp {{ number_format($topping->additional_price,0,',','.') }}</small></span></label>@endforeach</div></fieldset>@endif
            <div class="grid gap-4 sm:grid-cols-[120px_1fr]"><div><label class="label">Jumlah</label><input class="field" type="number" name="quantity" min="1" max="99" value="1"></div><div><label class="label">Catatan item</label><input class="field" name="notes" maxlength="500" placeholder="Contoh: saus dipisah"></div></div>
            <div class="card flex flex-col gap-4 p-5 sm:flex-row sm:items-center sm:justify-between"><div><p class="text-xs text-stone-400">Total item</p><strong data-live-price class="text-2xl font-black text-ube-800"></strong></div><button class="btn-primary" type="submit">+ Tambah ke Keranjang</button></div>
            <p data-added-message class="hidden rounded-xl bg-emerald-100 p-3 text-center text-sm font-bold text-emerald-700">Berhasil ditambahkan ke keranjang.</p>
        </form>@endif
    </div>
</div></section>
@endsection
