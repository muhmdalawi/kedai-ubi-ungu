<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8"><meta name="viewport" content="width=device-width,initial-scale=1"><meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — Kedai Ubi Ungu</title>
    <link rel="preconnect" href="https://fonts.googleapis.com"><link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    @vite(['resources/css/app.css','resources/js/app.js'])
</head>
<body class="bg-stone-100">
<div class="min-h-screen lg:grid lg:grid-cols-[270px_1fr]">
    <aside class="bg-ube-950 p-5 text-white lg:sticky lg:top-0 lg:h-screen">
        <a href="{{ route('admin.dashboard') }}" class="mb-8 flex items-center gap-3"><img src="{{ asset('assets/logo/logo-4.png') }}" class="h-12 w-12 rounded-2xl object-cover"><div><strong class="block">Kedai Ubi Ungu</strong><span class="text-xs text-ube-300">Administration</span></div></a>
        <nav class="grid gap-1">
            <a class="admin-link {{ request()->routeIs('admin.dashboard')?'active':'' }}" href="{{ route('admin.dashboard') }}">⌂ Dashboard</a>
            @foreach(config('admin_resources') as $key=>$definition)<a class="admin-link {{ request('resource')===$key?'active':'' }}" href="{{ route('admin.resources.index',$key) }}">• {{ $definition['label'] }}</a>@endforeach
            <a class="admin-link {{ request()->routeIs('admin.orders.*')?'active':'' }}" href="{{ route('admin.orders.index') }}">▤ Pesanan</a>
            <a class="admin-link {{ request()->routeIs('admin.settings.*')?'active':'' }}" href="{{ route('admin.settings.edit') }}">⚙ Profil & Kontak</a>
        </nav>
        <form method="POST" action="{{ route('admin.logout') }}" class="mt-8 border-t border-white/10 pt-5">@csrf<button class="admin-link w-full text-left">↪ Keluar</button></form>
    </aside>
    <div class="min-w-0">
        <header class="flex items-center justify-between border-b border-stone-200 bg-white px-5 py-4 sm:px-8"><div><p class="text-xs font-bold uppercase tracking-widest text-ube-600">Admin Panel</p><h1 class="text-xl font-black">@yield('heading','Dashboard')</h1></div><div class="text-right text-sm"><strong>{{ auth()->user()->name }}</strong><p class="text-xs text-stone-400">{{ auth()->user()->email }}</p></div></header>
        <main class="p-5 sm:p-8">
            @if(session('success'))<div class="mb-6 rounded-2xl bg-emerald-100 p-4 text-sm font-bold text-emerald-700">{{ session('success') }}</div>@endif
            @if(session('error'))<div class="mb-6 rounded-2xl bg-rose-100 p-4 text-sm font-bold text-rose-700">{{ session('error') }}</div>@endif
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
