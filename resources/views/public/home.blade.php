@extends('layouts.public')
@section('content')
    <section class="bg-ube-950">
        <div data-banner-carousel data-carousel-interval="5000"
            class="group relative isolate min-h-[560px] overflow-hidden sm:min-h-[620px]">
            @forelse($banners as $banner)
                <article data-carousel-slide class="banner-slide absolute inset-0 {{ $loop->first ? 'is-active' : '' }}"
                    aria-hidden="{{ $loop->first ? 'false' : 'true' }}">
                    <img src="{{ $banner->image_url }}" alt="{{ $banner->title }}"
                        class="absolute inset-0 h-full w-full object-cover"
                        @if ($loop->first) fetchpriority="high" @else loading="lazy" @endif>
                    <div class="absolute inset-0 bg-gradient-to-r from-ube-950/95 via-ube-950/75 to-ube-950/20"></div>
                    <div class="absolute inset-0 bg-gradient-to-t from-ube-950/70 via-transparent to-black/10"></div>
                    <div class="container-site relative flex min-h-[560px] items-center py-20 sm:min-h-[620px]">
                        <div class="max-w-3xl text-white">
                            <span
                                class="mb-5 inline-flex rounded-full border border-white/20 bg-white/10 px-4 py-2 text-xs font-extrabold uppercase tracking-[0.2em] text-ube-100 backdrop-blur">Premium
                                Purple Sweet Potato</span>
                            <h1
                                class="text-4xl font-black leading-[1.08] tracking-tight drop-shadow-lg sm:text-6xl lg:text-7xl">
                                {{ $banner->title }}</h1>
                            @if ($banner->subtitle)
                                <p
                                    class="mt-6 max-w-2xl text-base font-medium leading-8 text-white/90 drop-shadow sm:text-lg">
                                    {{ $banner->subtitle }}</p>
                            @endif
                            <div class="mt-8 flex flex-wrap gap-3">
                                @if ($banner->button_text && $banner->button_url)
                                    <a href="{{ $banner->button_url }}"
                                        class="btn-primary !bg-white !text-ube-950 hover:!bg-ube-100">{{ $banner->button_text }}</a>
                                @endif
                                <a href="{{ $contact?->shopee_link }}" target="_blank"
                                    class="inline-flex items-center justify-center rounded-full border border-white/40 bg-white/10 px-6 py-3 text-sm font-extrabold text-white backdrop-blur hover:bg-white hover:text-ube-950">Beli
                                    di Shopee</a>
                            </div>
                        </div>
                    </div>
                </article>
            @empty
                <article class="absolute inset-0">
                    <img src="{{ asset('assets/banner/banner-1.png') }}" alt="Kedai Ubi Ungu"
                        class="absolute inset-0 h-full w-full object-cover">
                    <div class="absolute inset-0 bg-ube-950/75"></div>
                    <div class="container-site relative flex min-h-[560px] items-center py-20 text-white sm:min-h-[620px]">
                        <div>
                            <h1 class="text-5xl font-black">Kedai Ubi Ungu</h1>
                            <p class="mt-5 max-w-xl text-lg">{{ $businessProfile?->description }}</p>
                        </div>
                    </div>
                </article>
            @endforelse

            @if ($banners->count() > 1)
                <!-- <button data-carousel-prev type="button" class="absolute left-4 top-1/2 z-10 grid h-12 w-12 -translate-y-1/2 place-items-center rounded-full border border-white/25 bg-ube-950/45 text-2xl font-bold text-white backdrop-blur hover:bg-white hover:text-ube-950 sm:left-7" aria-label="Banner sebelumnya">‹</button>
            <button data-carousel-next type="button" class="absolute right-4 top-1/2 z-10 grid h-12 w-12 -translate-y-1/2 place-items-center rounded-full border border-white/25 bg-ube-950/45 text-2xl font-bold text-white backdrop-blur hover:bg-white hover:text-ube-950 sm:right-7" aria-label="Banner berikutnya">›</button> -->
                <div class="absolute inset-x-0 bottom-8 z-10 flex justify-center gap-2" aria-label="Navigasi banner">
                    @foreach ($banners as $banner)
                        <button data-carousel-dot="{{ $loop->index }}" type="button"
                            class="banner-dot h-2.5 w-2.5 rounded-full bg-white/45 transition-all {{ $loop->first ? 'is-active' : '' }}"
                            aria-label="Tampilkan banner {{ $loop->iteration }}"
                            aria-current="{{ $loop->first ? 'true' : 'false' }}"></button>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    <section class="relative z-10 -mt-5">
        <div class="container-site">
            <div class="card grid gap-4 rounded-2xl p-5 sm:grid-cols-3 sm:gap-0 sm:p-0">
                <div class="px-6 py-3 text-center sm:py-6"><strong
                        class="text-3xl font-black text-ube-800">{{ $stats['products'] }}+</strong>
                    <p class="mt-1 text-xs font-bold uppercase tracking-wider text-stone-500">Menu pilihan</p>
                </div>
                <div class="border-ube-100 px-6 py-3 text-center sm:border-x sm:py-6"><strong
                        class="text-3xl font-black text-ube-800">{{ $stats['orders'] }}+</strong>
                    <p class="mt-1 text-xs font-bold uppercase tracking-wider text-stone-500">Pesanan</p>
                </div>
                <div class="px-6 py-3 text-center sm:py-6"><strong
                        class="text-3xl font-black text-ube-800">{{ $stats['customers'] }}+</strong>
                    <p class="mt-1 text-xs font-bold uppercase tracking-wider text-stone-500">Pelanggan</p>
                </div>
            </div>
        </div>
    </section>

    <section class="py-24">
        <div class="container-site">
            <div class="flex flex-col justify-between gap-5 sm:flex-row sm:items-end">
                <div><span class="eyebrow">Favorit Pelanggan</span>
                    <h2 class="section-title">Menu yang bikin balik lagi.</h2>
                </div><a href="{{ route('menu.index') }}" class="font-bold text-ube-700">Lihat semua menu →</a>
            </div>
            <div class="mt-10 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($bestSellers as $product)
                    <x-product-card :product="$product" />
                @endforeach
            </div>
        </div>
    </section>

    @if ($promos->isNotEmpty())
        <section class="bg-ube-950 py-24 text-white">
            <div class="container-site"><span class="eyebrow !bg-white/10 !text-ube-100">Promo Terbaru</span>
                <h2 class="section-title !text-white">Lebih nikmat, lebih hemat.</h2>
                <div class="mt-10 grid gap-6 lg:grid-cols-2">
                    @foreach ($promos as $promo)
                        <article class="group relative overflow-hidden rounded-[2rem]"><img src="{{ $promo->image_url }}"
                                alt="{{ $promo->title }}"
                                class="aspect-[16/8] w-full object-cover transition duration-500 group-hover:scale-105">
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/20 to-transparent"></div>
                            <div class="absolute inset-x-0 bottom-0 p-7">
                                <p class="text-xs font-bold uppercase tracking-widest text-ube-200">
                                    {{ $promo->start_date->format('d M') }}—{{ $promo->end_date->format('d M Y') }}</p>
                                <h3 class="mt-2 text-2xl font-black">{{ $promo->title }}</h3>
                                <p class="mt-2 text-sm text-stone-200">{{ $promo->description }}</p>
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="py-24">
        <div class="container-site">
            <div class="text-center"><span class="eyebrow">Kata Mereka</span>
                <h2 class="section-title">Kecil kedainya, besar cintanya.</h2>
            </div>
            <div class="mt-10 grid gap-5 md:grid-cols-3">
                @foreach ($testimonials as $item)
                    <article class="card p-7">
                        <div class="text-amber-400">{{ str_repeat('★', $item->rating) }}</div>
                        <p class="mt-4 leading-7 text-stone-600">“{{ $item->testimonial }}”</p>
                        <p class="mt-5 font-black text-ube-800">{{ $item->customer_name }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="container-site">
        <div class="overflow-hidden rounded-[3rem] bg-amber-100 px-6 py-12 text-center sm:px-12">
            <h2 class="section-title">Sudah tahu mau pilih yang mana?</h2>
            <p class="mx-auto mt-4 max-w-2xl text-stone-600">Racik menu favoritmu dengan variasi dan topping, lalu kirim
                pesanan langsung melalui WhatsApp.</p><a href="{{ route('menu.index') }}" class="btn-primary mt-7">Mulai
                Pesan</a>
        </div>
    </section>
@endsection
