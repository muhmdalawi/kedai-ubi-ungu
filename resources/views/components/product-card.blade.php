<article class="product-card card group overflow-hidden">
    <a href="{{ route('menu.show', $product) }}" class="block overflow-hidden">
        <img src="{{ $product->image_url }}" alt="{{ $product->name }}" class="aspect-[4/3] w-full object-cover transition duration-500">
    </a>
    <div class="p-5">
        <div class="mb-3 flex flex-wrap gap-2">
            <span class="badge bg-ube-100 text-ube-700">{{ $product->category->name }}</span>
            @if($product->is_best_seller)<span class="badge bg-amber-100 text-amber-700">Best Seller</span>@endif
            @if($product->is_promo)<span class="badge bg-rose-100 text-rose-700">Promo</span>@endif
        </div>
        <h3 class="text-xl font-black text-stone-900">{{ $product->name }}</h3>
        <p class="mt-2 line-clamp-2 text-sm leading-6 text-stone-500">{{ $product->description }}</p>
        <div class="mt-5 flex items-center justify-between">
            <div><span class="text-xs text-stone-400">Mulai dari</span><p class="font-black text-ube-800">Rp {{ number_format($product->price, 0, ',', '.') }}</p></div>
            @if($product->stock_status === 'available')
                <a href="{{ route('menu.show', $product) }}" class="rounded-full bg-ube-700 px-4 py-2 text-sm font-bold text-white hover:bg-ube-800">Pilih</a>
            @else
                <span class="badge bg-stone-100 text-stone-500">Habis</span>
            @endif
        </div>
    </div>
</article>
