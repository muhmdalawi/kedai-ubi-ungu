<!DOCTYPE html>
<html lang="id">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Kedai Ubi Ungu — Kreasi Ubi Ungu Premium')</title>
    <meta name="description" content="@yield('description', 'Kedai Ubi Ungu menghadirkan makanan dan minuman premium berbahan ubi ungu.')">
    <meta property="og:title" content="@yield('title', 'Kedai Ubi Ungu')">
    <meta property="og:description" content="@yield('description', 'Kreasi ubi ungu premium, dibuat segar setiap hari.')">
    <meta property="og:image" content="{{ asset('assets/banner/banner-1.png') }}">
    <link rel="icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}?v=2">
    <link rel="shortcut icon" type="image/x-icon" href="{{ asset('assets/favicon.ico') }}?v=2">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @stack('head')
</head>

<body>
    <header
        data-public-header
        @if(request()->routeIs('home')) data-home-header @endif
        class="site-header top-0 z-50 w-full {{ request()->routeIs('home') ? 'site-header-home fixed' : 'sticky border-b border-ube-100/80 bg-cream/90 backdrop-blur-xl' }}"
        >
        <div class="container-site flex h-20 items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <img src="{{ $businessProfile?->logo_url ?? asset('assets/logo/logo-1.png') }}" alt="Logo Kedai Ubi Ungu" class="h-12 w-12 rounded-2xl object-cover">
                <span class="hidden font-black text-ube-900 sm:block">Kedai Ubi Ungu</span>
            </a>
            <nav class="hidden items-center gap-2 lg:flex">
                <a href="{{ route('home') }}" class="public-nav-link {{ request()->routeIs('home') ? 'active' : '' }}" @if(request()->routeIs('home')) aria-current="page" @endif>Home</a>
                <a href="{{ route('menu.index') }}" class="public-nav-link {{ request()->routeIs('menu.*') ? 'active' : '' }}" @if(request()->routeIs('menu.*')) aria-current="page" @endif>Menu</a>
                <a href="{{ route('gallery') }}" class="public-nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}" @if(request()->routeIs('gallery')) aria-current="page" @endif>Galeri</a>
                <a href="{{ route('promos') }}" class="public-nav-link {{ request()->routeIs('promos') ? 'active' : '' }}" @if(request()->routeIs('promos')) aria-current="page" @endif>Promo</a>
                <a href="{{ route('contact') }}" class="public-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}" @if(request()->routeIs('contact')) aria-current="page" @endif>Kontak</a>
            </nav>
            <div class="flex items-center gap-2">
                <a href="{{ route('checkout.index') }}" class="relative rounded-full bg-white p-3 text-ube-800 shadow-sm" aria-label="Keranjang">
                    <span class="text-xl">🛍</span>
                    <span data-cart-count class="absolute -right-1 -top-1 grid h-5 min-w-5 place-items-center rounded-full bg-amber-400 px-1 text-[10px] font-black text-stone-900">0</span>
                </a>
                <button data-mobile-menu class="rounded-full bg-ube-700 p-3 text-white lg:hidden" aria-label="Buka menu">☰</button>
                <a href="{{ route('checkout.index') }}" class="btn-primary hidden sm:inline-flex">Pesan Sekarang</a>
            </div>
        </div>
        <nav data-mobile-nav class="container-site hidden flex-col gap-1 border-t border-ube-100 py-4 text-sm font-bold lg:hidden">
            <a href="{{ route('home') }}" class="mobile-nav-link {{ request()->routeIs('home') ? 'active' : '' }}">Home</a>
            <a href="{{ route('menu.index') }}" class="mobile-nav-link {{ request()->routeIs('menu.*') ? 'active' : '' }}">Menu</a>
            <a href="{{ route('gallery') }}" class="mobile-nav-link {{ request()->routeIs('gallery') ? 'active' : '' }}">Galeri</a>
            <a href="{{ route('promos') }}" class="mobile-nav-link {{ request()->routeIs('promos') ? 'active' : '' }}">Promo</a>
            <a href="{{ route('contact') }}" class="mobile-nav-link {{ request()->routeIs('contact') ? 'active' : '' }}">Kontak</a>
        </nav>
    </header>
    <main>@yield('content')</main>
    <footer class="mt-24 bg-ube-950 text-ube-100">
        <div class="container-site grid gap-10 py-14 md:grid-cols-3">
            <div>
                <h3 class="text-xl font-black text-white">{{ $businessProfile?->business_name ?? 'Kedai Ubi Ungu' }}</h3>
                <p class="mt-3 max-w-sm text-sm leading-7 text-ube-200">{{ $businessProfile?->description }}</p>
            </div>
            <div>
                <h3 class="font-black text-white">Jelajahi</h3>
                <div class="mt-4 grid gap-2 text-sm"><a href="{{ route('menu.index') }}">Katalog Menu</a><a href="{{ route('checkout.index') }}">Pesan Online</a><a href="{{ route('promos') }}">Promo Terbaru</a><a href="{{ route('admin.login') }}">Admin</a></div>
            </div>
            <div>
                <h3 class="font-black text-white">Kunjungi Kami</h3>
                <p class="mt-4 text-sm leading-7">{{ $businessProfile?->address }}<br>{{ $businessProfile?->operational_hours }}<br>{{ $contact?->email }}</p>
            </div>
        </div>
        <div class="border-t border-white/10 py-5 text-center text-xs text-ube-300">© {{ date('Y') }} Kedai Ubi Ungu. Dibuat dengan hangat dan ubi pilihan.</div>
    </footer>
    @stack('scripts')
</body>

</html>
