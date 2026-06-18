@extends('layouts.public')
@section('title', 'Galeri — Kedai Ubi Ungu')
@section('content')
<section class="py-16"><div class="container-site"><div class="text-center"><span class="eyebrow">Galeri</span><h1 class="section-title">Dari dapur kami untuk harimu.</h1></div><div class="mt-10 columns-1 gap-5 sm:columns-2 lg:columns-3">@foreach($galleries as $item)<article class="card mb-5 break-inside-avoid overflow-hidden"><img src="{{ $item->image_url }}" alt="{{ $item->title }}" class="w-full object-cover"><div class="p-5"><span class="badge bg-ube-100 text-ube-700">{{ $item->category }}</span><h2 class="mt-3 font-black">{{ $item->title }}</h2><p class="mt-2 text-sm text-stone-500">{{ $item->description }}</p></div></article>@endforeach</div><div class="mt-10">{{ $galleries->links() }}</div></div></section>
@endsection
