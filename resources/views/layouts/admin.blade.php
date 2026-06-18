<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Kedai Ubi Ungu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-[#f7f4f9] text-stone-900">
@php
    $resourceIcons = [
        'banners' => 'banner', 'categories' => 'category', 'products' => 'product',
        'toppings' => 'topping', 'variants' => 'variant', 'promos' => 'promo',
        'galleries' => 'gallery', 'testimonials' => 'testimonial',
    ];
@endphp
<div data-admin-shell class="admin-shell min-h-screen lg:grid">
    <aside class="admin-sidebar flex max-h-[70vh] flex-col bg-ube-950 p-4 text-white shadow-2xl shadow-ube-950/20 lg:sticky lg:top-0 lg:h-screen lg:max-h-screen">
        <a href="{{ route('admin.dashboard') }}" class="admin-brand mb-4 flex shrink-0 items-center gap-3 rounded-2xl border border-white/10 bg-white/5 p-3" title="Kedai Ubi Ungu">
            <img src="{{ asset('assets/logo/logo-4.png') }}" class="h-11 w-11 shrink-0 rounded-2xl bg-white object-cover">
            <div class="admin-label min-w-0"><strong class="block truncate text-white">Kedai Ubi Ungu</strong><span class="text-xs font-semibold text-ube-200">Administration</span></div>
        </a>
        <nav class="admin-sidebar-nav grid min-h-0 flex-1 content-start gap-1 overflow-y-auto pr-1">
            <a class="admin-link {{ request()->routeIs('admin.dashboard')?'active':'' }}" href="{{ route('admin.dashboard') }}" title="Dashboard"><span class="admin-icon"><x-icon name="dashboard"/></span><span class="admin-label">Dashboard</span></a>
            @foreach(config('admin_resources') as $key=>$definition)
                <a class="admin-link {{ request('resource')===$key?'active':'' }}" href="{{ route('admin.resources.index',$key) }}" title="{{ $definition['label'] }}"><span class="admin-icon"><x-icon :name="$resourceIcons[$key] ?? 'category'"/></span><span class="admin-label">{{ $definition['label'] }}</span></a>
            @endforeach
            <a class="admin-link {{ request()->routeIs('admin.orders.*')?'active':'' }}" href="{{ route('admin.orders.index') }}" title="Pesanan"><span class="admin-icon"><x-icon name="order"/></span><span class="admin-label">Pesanan</span></a>
            <a class="admin-link {{ request()->routeIs('admin.settings.*')?'active':'' }}" href="{{ route('admin.settings.edit') }}" title="Profil & Kontak"><span class="admin-icon"><x-icon name="settings"/></span><span class="admin-label">Profil & Kontak</span></a>
        </nav>
        <form method="POST" action="{{ route('admin.logout') }}" class="mt-3 shrink-0 border-t border-white/15 pt-3">@csrf<button class="admin-link w-full text-left" title="Keluar"><span class="admin-icon"><x-icon name="logout"/></span><span class="admin-label">Keluar</span></button></form>
    </aside>
    <div class="min-w-0">
        <header class="flex items-center justify-between gap-4 border-b border-ube-100 bg-white px-5 py-4 shadow-sm sm:px-8">
            <div class="flex min-w-0 items-center gap-3">
                <button data-sidebar-toggle type="button" class="hidden h-10 w-10 shrink-0 place-items-center rounded-xl border border-ube-200 bg-ube-50 text-ube-800 hover:bg-ube-100 lg:grid" aria-label="Minimalkan sidebar" aria-expanded="true" title="Minimalkan sidebar">
                    <span data-sidebar-collapse-icon><x-icon name="collapse"/></span>
                    <span data-sidebar-expand-icon class="hidden"><x-icon name="expand"/></span>
                </button>
                <div class="min-w-0"><p class="text-xs font-extrabold uppercase tracking-widest text-ube-700">Admin Panel</p><h1 class="truncate text-xl font-black text-stone-950">@yield('heading','Dashboard')</h1></div>
            </div>
            <div class="text-right text-sm"><strong class="text-stone-900">{{ auth()->user()->name }}</strong><p class="hidden text-xs font-medium text-stone-500 sm:block">{{ auth()->user()->email }}</p></div>
        </header>
        <main class="p-5 sm:p-8">
            @if(session('success'))<div class="mb-6 rounded-2xl bg-emerald-100 p-4 text-sm font-bold text-emerald-700">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="mb-6 rounded-2xl bg-rose-100 p-4 text-sm font-bold text-rose-700">{{ session('error') }}</div>@endif
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
