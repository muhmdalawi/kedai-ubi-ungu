@props(['name', 'class' => 'h-5 w-5'])

@php
    $paths = [
        'dashboard' => '<path d="M3 3h7v7H3V3Zm11 0h7v4h-7V3ZM3 14h7v7H3v-7Zm11-3h7v10h-7V11Z"/>',
        'banner' => '<path d="M3 5h18v14H3V5Zm3 11 4-4 3 3 2-2 3 3H6Zm10-7.5a1.5 1.5 0 1 0 0-3 1.5 1.5 0 0 0 0 3Z"/>',
        'category' => '<path d="M4 4h6v6H4V4Zm10 0h6v6h-6V4ZM4 14h6v6H4v-6Zm10 0h6v6h-6v-6Z"/>',
        'product' => '<path d="m12 3 9 5-9 5-9-5 9-5Zm-9 9 9 5 9-5M3 16l9 5 9-5"/>',
        'topping' => '<path d="M5 11a7 7 0 0 1 14 0v1H5v-1Zm-1 1h16l-2 8H6l-2-8ZM9 7V4m6 3V4"/>',
        'variant' => '<path d="M4 7h10m0 0-3-3m3 3-3 3m9 7H10m0 0 3-3m-3 3 3 3"/>',
        'promo' => '<path d="m12 3 2.2 2.2 3.1-.4.9 3 2.8 1.4-1.4 2.8.4 3.1-3 .9-1.4 2.8-2.8-1.4-2.8 1.4-1.4-2.8-3-.9.4-3.1L3 9.2l2.8-1.4.9-3 3.1.4L12 3Zm-3 12 6-6m-5.5.5h.01m4.99 5h.01"/>',
        'gallery' => '<path d="M3 5h18v14H3V5Zm3 11 4-4 3 3 2-2 3 3H6Zm10-7.5h.01"/>',
        'testimonial' => '<path d="M4 5h16v11H8l-4 4V5Zm4 4h8M8 12h5"/>',
        'order' => '<path d="M6 3h12v18H6V3Zm3 5h6m-6 4h6m-6 4h4"/>',
        'settings' => '<path d="M12 15.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7Zm8-3.5 2-1-2-3-2.2.4a8 8 0 0 0-1.2-.7L16 4h-4l-.6 2.7a8 8 0 0 0-1.2.7L8 7 6 10l2 1a8 8 0 0 0 0 2l-2 1 2 3 2.2-.4c.4.3.8.5 1.2.7L12 20h4l.6-2.7c.4-.2.8-.4 1.2-.7L20 17l2-3-2-1a8 8 0 0 0 0-2Z"/>',
        'logout' => '<path d="M10 5H5v14h5m4-3 4-4-4-4m4 4H9"/>',
        'collapse' => '<path d="M15 6 9 12l6 6"/>',
        'expand' => '<path d="m9 6 6 6-6 6"/>',
        'print' => '<path d="M7 8V3h10v5M7 17H5a2 2 0 0 1-2-2v-4a2 2 0 0 1 2-2h14a2 2 0 0 1 2 2v4a2 2 0 0 1-2 2h-2M7 14h10v7H7v-7Z"/>',
    ];
@endphp

<svg {{ $attributes->merge(['class' => $class, 'viewBox' => '0 0 24 24', 'fill' => 'none', 'stroke' => 'currentColor', 'stroke-width' => '1.8', 'stroke-linecap' => 'round', 'stroke-linejoin' => 'round', 'aria-hidden' => 'true']) }}>
    {!! $paths[$name] ?? $paths['category'] !!}
</svg>
