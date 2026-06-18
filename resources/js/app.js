const CART_KEY = 'kedai_ubi_ungu_cart_v1';
const money = value => new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', maximumFractionDigits: 0 }).format(value);
const getCart = () => JSON.parse(localStorage.getItem(CART_KEY) || '[]');
const saveCart = cart => {
    localStorage.setItem(CART_KEY, JSON.stringify(cart));
    window.dispatchEvent(new CustomEvent('cart:updated', { detail: cart }));
};

window.KedaiCart = {
    all: getCart,
    clear: () => saveCart([]),
    remove: key => saveCart(getCart().filter(item => item.key !== key)),
    quantity: (key, quantity) => saveCart(getCart().map(item => item.key === key ? { ...item, quantity: Math.max(1, Number(quantity)) } : item)),
    add: item => {
        const cart = getCart();
        const key = [item.product_id, item.variant_id || 0, [...(item.topping_ids || [])].sort().join('-'), item.notes || ''].join(':');
        const existing = cart.find(row => row.key === key);
        if (existing) existing.quantity += Number(item.quantity || 1);
        else cart.push({ ...item, key, quantity: Number(item.quantity || 1) });
        saveCart(cart);
    },
    money,
};

function updateCartBadges() {
    const count = getCart().reduce((sum, item) => sum + Number(item.quantity), 0);
    document.querySelectorAll('[data-cart-count]').forEach(el => {
        el.textContent = count;
        el.classList.add('cart-bump');
        setTimeout(() => el.classList.remove('cart-bump'), 350);
    });
}

window.addEventListener('cart:updated', updateCartBadges);
document.addEventListener('DOMContentLoaded', () => {
    updateCartBadges();
    const adminShell = document.querySelector('[data-admin-shell]');
    const sidebarToggle = document.querySelector('[data-sidebar-toggle]');
    if (adminShell && sidebarToggle) {
        const applySidebarState = collapsed => {
            adminShell.classList.toggle('sidebar-collapsed', collapsed);
            sidebarToggle.setAttribute('aria-expanded', String(!collapsed));
            sidebarToggle.setAttribute('aria-label', collapsed ? 'Perbesar sidebar' : 'Minimalkan sidebar');
            sidebarToggle.setAttribute('title', collapsed ? 'Perbesar sidebar' : 'Minimalkan sidebar');
            sidebarToggle.querySelector('[data-sidebar-collapse-icon]')?.classList.toggle('hidden', collapsed);
            sidebarToggle.querySelector('[data-sidebar-expand-icon]')?.classList.toggle('hidden', !collapsed);
        };
        applySidebarState(localStorage.getItem('admin_sidebar_collapsed') === 'true');
        sidebarToggle.addEventListener('click', () => {
            const collapsed = !adminShell.classList.contains('sidebar-collapsed');
            localStorage.setItem('admin_sidebar_collapsed', String(collapsed));
            applySidebarState(collapsed);
        });
    }

    const mobileButton = document.querySelector('[data-mobile-menu]');
    mobileButton?.addEventListener('click', () => document.querySelector('[data-mobile-nav]')?.classList.toggle('nav-open'));

    document.querySelectorAll('[data-banner-carousel]').forEach(carousel => {
        const slides = [...carousel.querySelectorAll('[data-carousel-slide]')];
        const dots = [...carousel.querySelectorAll('[data-carousel-dot]')];
        const interval = Number(carousel.dataset.carouselInterval || 5000);
        const reducedMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
        let current = Math.max(0, slides.findIndex(slide => slide.classList.contains('is-active')));
        let timer;

        const show = index => {
            current = (index + slides.length) % slides.length;
            slides.forEach((slide, slideIndex) => {
                const active = slideIndex === current;
                slide.classList.toggle('is-active', active);
                slide.setAttribute('aria-hidden', String(!active));
            });
            dots.forEach((dot, dotIndex) => {
                const active = dotIndex === current;
                dot.classList.toggle('is-active', active);
                dot.setAttribute('aria-current', String(active));
            });
        };
        const stop = () => window.clearInterval(timer);
        const start = () => {
            stop();
            if (!reducedMotion && slides.length > 1) timer = window.setInterval(() => show(current + 1), interval);
        };

        carousel.querySelector('[data-carousel-prev]')?.addEventListener('click', () => { show(current - 1); start(); });
        carousel.querySelector('[data-carousel-next]')?.addEventListener('click', () => { show(current + 1); start(); });
        dots.forEach(dot => dot.addEventListener('click', () => { show(Number(dot.dataset.carouselDot)); start(); }));
        carousel.addEventListener('mouseenter', stop);
        carousel.addEventListener('mouseleave', start);
        carousel.addEventListener('focusin', stop);
        carousel.addEventListener('focusout', start);
        start();
    });

    document.querySelectorAll('[data-product-builder]').forEach(builder => {
        const price = Number(builder.dataset.price);
        const total = builder.querySelector('[data-live-price]');
        const recalculate = () => {
            const variant = Number(builder.querySelector('[name="variant_id"]:checked')?.dataset.price || 0);
            const toppings = [...builder.querySelectorAll('[name="topping_ids[]"]:checked')].reduce((sum, el) => sum + Number(el.dataset.price), 0);
            const quantity = Number(builder.querySelector('[name="quantity"]')?.value || 1);
            total.textContent = money((price + variant + toppings) * quantity);
        };
        builder.addEventListener('change', recalculate);
        builder.addEventListener('input', recalculate);
        builder.addEventListener('submit', event => {
            event.preventDefault();
            const selectedVariant = builder.querySelector('[name="variant_id"]:checked');
            const selectedToppings = [...builder.querySelectorAll('[name="topping_ids[]"]:checked')];
            window.KedaiCart.add({
                product_id: Number(builder.dataset.productId),
                product_name: builder.dataset.productName,
                product_image: builder.dataset.productImage,
                base_price: price,
                variant_id: selectedVariant?.value ? Number(selectedVariant.value) : null,
                variant_name: selectedVariant?.dataset.name || null,
                variant_price: Number(selectedVariant?.dataset.price || 0),
                topping_ids: selectedToppings.map(el => Number(el.value)),
                toppings: selectedToppings.map(el => ({ id: Number(el.value), name: el.dataset.name, price: Number(el.dataset.price) })),
                quantity: Number(builder.querySelector('[name="quantity"]').value),
                notes: builder.querySelector('[name="notes"]')?.value || '',
            });
            const message = builder.querySelector('[data-added-message]');
            if (message) {
                message.classList.remove('hidden');
                setTimeout(() => message.classList.add('hidden'), 2500);
            }
        });
        recalculate();
    });
});
