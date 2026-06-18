@extends('layouts.public')
@section('title', 'Pesanan — Kedai Ubi Ungu')
@section('content')
<section class="bg-ube-950 py-14 text-white"><div class="container-site"><span class="eyebrow !bg-white/10 !text-ube-100">Delivery / Pesanan</span><h1 class="section-title !text-white">Satu langkah lagi menuju camilanmu.</h1><p class="mt-4 text-ube-200">Periksa keranjang, lengkapi data, lalu kirim pesanan ke WhatsApp kami.</p></div></section>
<section class="py-14"><div class="container-site grid gap-8 lg:grid-cols-[1.2fr_.8fr]">
    <div>
        <div class="mb-6 flex items-center justify-between"><h2 class="text-2xl font-black">Keranjang</h2><a href="{{ route('menu.index') }}" class="text-sm font-bold text-ube-700">+ Tambah menu</a></div>
        <div id="cart-empty" class="card hidden p-10 text-center"><div class="text-5xl">🛍</div><h3 class="mt-4 text-xl font-black">Keranjang masih kosong</h3><p class="mt-2 text-stone-500">Yuk, pilih menu dan racik topping favoritmu.</p><a href="{{ route('menu.index') }}" class="btn-primary mt-6">Lihat Menu</a></div>
        <div id="cart-items" class="space-y-4"></div>
    </div>
    <form id="checkout-form" class="card h-fit p-6 lg:sticky lg:top-28">
        <h2 class="text-2xl font-black">Data Pemesan</h2>
        <div id="checkout-errors" class="mt-4 hidden rounded-2xl bg-rose-50 p-4 text-sm text-rose-700"></div>
        <div class="mt-6 space-y-4">
            <div><label class="label">Nama lengkap</label><input class="field" name="customer_name" required maxlength="120"></div>
            <div><label class="label">Nomor WhatsApp</label><input class="field" name="whatsapp" required maxlength="30" placeholder="08xxxxxxxxxx"></div>
            <div><label class="label">Alamat lengkap</label><textarea class="field" name="address" rows="4" required maxlength="1000"></textarea></div>
            <div><label class="label">Catatan pesanan</label><textarea class="field" name="notes" rows="2" maxlength="1000" placeholder="Opsional"></textarea></div>
        </div>
        <div class="my-6 border-t border-stone-200"></div>
        <div class="flex items-center justify-between"><span class="font-bold">Total</span><strong id="cart-total" class="text-2xl font-black text-ube-800">Rp 0</strong></div>
        <button id="checkout-button" class="btn-primary mt-6 w-full" type="submit">Pesan via WhatsApp</button>
        <p class="mt-3 text-center text-xs leading-5 text-stone-400">Harga akan diverifikasi ulang oleh sistem sebelum pesanan disimpan.</p>
    </form>
</div></section>
@endsection

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const itemsEl = document.getElementById('cart-items');
    const emptyEl = document.getElementById('cart-empty');
    const totalEl = document.getElementById('cart-total');
    const form = document.getElementById('checkout-form');
    const button = document.getElementById('checkout-button');
    const errors = document.getElementById('checkout-errors');

    function itemUnitTotal(item) {
        return Number(item.base_price) + Number(item.variant_price || 0) + (item.toppings || []).reduce((sum, row) => sum + Number(row.price), 0);
    }

    function render() {
        const cart = window.KedaiCart.all();
        emptyEl.classList.toggle('hidden', cart.length > 0);
        form.classList.toggle('opacity-50', cart.length === 0);
        button.disabled = cart.length === 0;
        itemsEl.innerHTML = cart.map(item => `
            <article class="card flex gap-4 p-4">
                <img src="${item.product_image}" alt="" class="h-24 w-24 rounded-2xl object-cover">
                <div class="min-w-0 flex-1">
                    <div class="flex justify-between gap-3"><h3 class="font-black">${item.product_name}</h3><button type="button" data-remove="${item.key}" class="text-sm font-bold text-rose-500">Hapus</button></div>
                    <p class="mt-1 text-xs text-stone-500">${item.variant_name ? 'Variasi: '+item.variant_name : ''}</p>
                    <p class="mt-1 text-xs text-stone-500">${item.toppings?.length ? 'Topping: '+item.toppings.map(row => row.name).join(', ') : 'Tanpa topping'}</p>
                    ${item.notes ? `<p class="mt-1 text-xs italic text-stone-400">“${item.notes}”</p>` : ''}
                    <div class="mt-4 flex items-center justify-between">
                        <input data-quantity="${item.key}" type="number" min="1" max="99" value="${item.quantity}" class="field !w-20 !py-2">
                        <strong class="text-ube-800">${window.KedaiCart.money(itemUnitTotal(item) * item.quantity)}</strong>
                    </div>
                </div>
            </article>`).join('');
        const total = cart.reduce((sum, item) => sum + itemUnitTotal(item) * Number(item.quantity), 0);
        totalEl.textContent = window.KedaiCart.money(total);
        itemsEl.querySelectorAll('[data-remove]').forEach(el => el.onclick = () => window.KedaiCart.remove(el.dataset.remove));
        itemsEl.querySelectorAll('[data-quantity]').forEach(el => el.onchange = () => window.KedaiCart.quantity(el.dataset.quantity, el.value));
    }

    window.addEventListener('cart:updated', render);
    render();

    form.addEventListener('submit', async event => {
        event.preventDefault();
        errors.classList.add('hidden');
        button.disabled = true;
        button.textContent = 'Menyimpan pesanan...';
        const data = Object.fromEntries(new FormData(form));
        data.items = window.KedaiCart.all().map(item => ({
            product_id: item.product_id,
            variant_id: item.variant_id,
            topping_ids: item.topping_ids,
            quantity: item.quantity,
            notes: item.notes,
        }));
        try {
            const response = await fetch(@json(route('checkout.store')), {
                method: 'POST',
                headers: {'Content-Type':'application/json','Accept':'application/json','X-CSRF-TOKEN':document.querySelector('meta[name=csrf-token]').content},
                body: JSON.stringify(data),
            });
            const result = await response.json();
            if (!response.ok) throw result;
            window.KedaiCart.clear();
            window.location.href = result.whatsapp_url;
        } catch (error) {
            const messages = error.errors ? Object.values(error.errors).flat() : ['Pesanan belum dapat diproses. Silakan coba lagi.'];
            errors.innerHTML = messages.map(message => `<p>• ${message}</p>`).join('');
            errors.classList.remove('hidden');
        } finally {
            button.disabled = window.KedaiCart.all().length === 0;
            button.textContent = 'Pesan via WhatsApp';
        }
    });
});
</script>
@endpush
