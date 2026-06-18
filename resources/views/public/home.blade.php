@extends('layouts.public')
@section('content')
<section class="hero-grid overflow-hidden py-12 lg:py-20">
    <div class="container-site grid items-center gap-10 lg:grid-cols-[.9fr_1.1fr]">
        <div>
            <span class="eyebrow">Premium Purple Sweet Potato</span>
            <h1 class="text-5xl font-black leading-[1.05] tracking-tight text-stone-900 sm:text-6xl">Rasa hangat dari <span class="text-ube-700">ubi ungu</span>, dibuat lebih istimewa.</h1>
            <p class="mt-6 max-w-xl text-lg leading-8 text-stone-600">{{ $businessProfile?->description }}</p>
            <div class="mt-8 flex flex-wrap gap-3">
                <a href="{{ route('menu.index') }}" class="btn-primary">Lihat Menu</a>
                <a href="{{ $contact?->shopee_link }}" target="_blank" class="btn-secondary">Beli di Shopee ↗</a>
            </div>
            <div class="mt-10 flex gap-8">
                <div><strong class="text-2xl font-black text-ube-800">{{ $stats['products'] }}+</strong><p class="text-xs text-stone-500">Menu pilihan</p></div>
                <div><strong class="text-2xl font-black text-ube-800">{{ $stats['orders'] }}+</strong><p class="text-xs text-stone-500">Pesanan</p></div>
                <div><strong class="text-2xl font-black text-ube-800">{{ $stats['customers'] }}+</strong><p class="text-xs text-stone-500">Pelanggan</p></div>
            </div>
        </div>
        <div class="relative">
            <div class="absolute -inset-6 rotate-3 rounded-[3rem] bg-ube-200/60"></div>
            <img src="{{ asset('assets/banner/banner-1.png') }}" alt="Dapur Kedai Ubi Ungu" class="relative aspect-[16/11] w-full rounded-[3rem] object-cover shadow-2xl">
            <div class="absolute -bottom-5 -left-5 card max-w-xs p-4"><p class="text-sm font-extrabold text-ube-800">🌱 Dibuat segar dari bahan lokal pilihan</p></div>
        </div>
    </div>
</section>

<section class="py-24">
    <div class="container-site">
        <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end"><div><span class="eyebrow">Favorit Pelanggan</span><h2 class="section-title">Menu yang bikin balik lagi.</h2></div><a href="{{ route('menu.index') }}" class="font-bold text-ube-700">Lihat semua menu →</a></div>
        <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">@foreach($bestSellers as $product)<x-product-card :product="$product"/>@endforeach</div>
    </div>
</section>

@if($promos->isNotEmpty())
<section class="bg-ube-950 py-24 text-white">
    <div class="container-site"><span class="eyebrow !bg-white/10 !text-ube-100">Promo Terbaru</span><h2 class="section-title !text-white">Lebih nikmat, lebih hemat.</h2>
        <div class="mt-10 grid gap-6 lg:grid-cols-2">@foreach($promos as $promo)<article class="group relative overflow-hidden rounded-[2rem]"><img src="{{ $promo->image_url }}" alt="{{ $promo->title }}" class="aspect-[16/8] w-full object-cover transition duration-500 group-hover:scale-105"><div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div><div class="absolute inset-x-0 bottom-0 p-7"><p class="text-xs font-bold uppercase tracking-widest text-ube-200">{{ $promo->start_date->format('d M') }}—{{ $promo->end_date->format('d M Y') }}</p><h3 class="mt-2 text-2xl font-black">{{ $promo->title }}</h3><p class="mt-2 text-sm text-stone-200">{{ $promo->description }}</p></div></article>@endforeach</div>
    </div>
</section>
@endif

<section class="py-24"><div class="container-site"><div class="text-center"><span class="eyebrow">Kata Mereka</span><h2 class="section-title">Kecil kedainya, besar cintanya.</h2></div><div class="mt-10 grid gap-5 md:grid-cols-3">@foreach($testimonials as $item)<article class="card p-7"><div class="text-amber-400">{{ str_repeat('★', $item->rating) }}</div><p class="mt-4 leading-7 text-stone-600">“{{ $item->testimonial }}”</p><p class="mt-5 font-black text-ube-800">{{ $item->customer_name }}</p></article>@endforeach</div></div></section>

<section class="container-site"><div class="overflow-hidden rounded-[3rem] bg-amber-100 px-6 py-12 text-center sm:px-12"><h2 class="section-title">Sudah tahu mau pilih yang mana?</h2><p class="mx-auto mt-4 max-w-2xl text-stone-600">Racik menu favoritmu dengan variasi dan topping, lalu kirim pesanan langsung melalui WhatsApp.</p><a href="{{ route('menu.index') }}" class="btn-primary mt-7">Mulai Pesan</a></div></section>
@endsection
