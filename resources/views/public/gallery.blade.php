@extends('layouts.public')

@section('title', 'Galeri — Kedai Ubi Ungu')

@section('content')

<section class="py-16">
    <div class="container-site">


    <div class="mx-auto max-w-3xl text-center">
        <span class="eyebrow">Galeri</span>

        <h1 class="section-title mt-3">
            Dari Dapur Kami untuk Harimu
        </h1>

        <p class="mt-4 mb-4 text-stone-600">
            Dokumentasi berbagai kreasi menu, aktivitas, dan momen spesial
            Kedai Ubi Ungu yang dibuat dengan penuh cinta setiap harinya.
        </p>
    </div>

    <div class="mt-12 grid grid-cols-1 gap-8 sm:grid-cols-2 lg:grid-cols-3">

        @forelse($galleries as $item)
            <article
                class="overflow-hidden rounded-3xl border border-ube-100 bg-white shadow-sm transition-all duration-300 hover:-translate-y-1 hover:shadow-xl">

                <div class="aspect-[4/3] overflow-hidden">
                    <img
                        src="{{ $item->image_url }}"
                        alt="{{ $item->title }}"
                        class="h-full w-full object-cover transition duration-500 hover:scale-105">
                </div>

                <div class="p-5">

                    <span class="inline-flex rounded-full bg-ube-100 px-3 py-1 text-xs font-semibold text-ube-700">
                        {{ $item->category }}
                    </span>

                    <h2 class="mt-4 text-xl font-extrabold text-stone-900">
                        {{ $item->title }}
                    </h2>

                    @if($item->description)
                        <p class="mt-2 line-clamp-3 text-sm leading-relaxed text-stone-600">
                            {{ $item->description }}
                        </p>
                    @endif

                </div>
            </article>
        @empty
            <div class="col-span-full py-20 text-center">
                <h3 class="text-lg font-semibold text-stone-700">
                    Belum ada galeri
                </h3>

                <p class="mt-2 text-sm text-stone-500">
                    Foto galeri akan segera ditampilkan di sini.
                </p>
            </div>
        @endforelse

    </div>

    @if($galleries->hasPages())
        <div class="mt-12 flex justify-center">
            {{ $galleries->links() }}
        </div>
    @endif

</div>
```

</section>
@endsection
