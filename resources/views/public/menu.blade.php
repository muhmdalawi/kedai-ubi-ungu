@extends('layouts.public')
@section('title', 'Menu — Kedai Ubi Ungu')
@section('content')
<section class="bg-ube-950 py-16 text-center text-white"><div class="container-site"><span class="eyebrow !bg-white/10 !text-ube-100">Katalog</span><h1 class="section-title !text-white">Pilih kreasi ubi favoritmu.</h1><p class="mx-auto mt-4 max-w-2xl text-ube-200">Setiap menu dibuat segar dan bisa diracik dengan variasi serta topping pilihan.</p></div></section>
<section class="py-14"><div class="container-site">
    <form class="card mb-10 grid gap-3 p-4 sm:grid-cols-[1fr_240px_auto]">
        <input name="q" value="{{ request('q') }}" class="field" placeholder="Cari menu...">
        <select name="category" class="field"><option value="">Semua kategori</option>@foreach($categories as $category)<option value="{{ $category->id }}" @selected(request('category') == $category->id)>{{ $category->name }}</option>@endforeach</select>
        <button class="btn-primary">Cari Menu</button>
    </form>
    <div class="grid gap-6 sm:grid-cols-2 lg:grid-cols-3">@forelse($products as $product)<x-product-card :product="$product"/>@empty<div class="card col-span-full p-12 text-center"><p class="text-lg font-bold">Menu tidak ditemukan.</p><a href="{{ route('menu.index') }}" class="mt-3 inline-block text-ube-700">Reset pencarian</a></div>@endforelse</div>
    <div class="mt-10">{{ $products->links() }}</div>
</div></section>
@endsection
