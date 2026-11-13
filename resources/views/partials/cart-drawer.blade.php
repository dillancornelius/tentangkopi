<div class="drawer-backdrop" data-cart-backdrop hidden></div>

<aside
    class="drawer"
    id="cart-drawer"
    role="dialog"
    aria-modal="true"
    aria-labelledby="cart-title"
    data-show-url="{{ route('cart.show') }}"
    data-add-url="{{ route('cart.add') }}"
    data-update-url="{{ route('cart.update', ['menu' => '__ID__']) }}"
    data-clear-url="{{ route('cart.clear') }}"
>
    <div class="drawer__head">
        <h2 id="cart-title">Keranjang</h2>
        <button type="button" class="icon-btn" data-cart-close aria-label="Tutup keranjang"><x-icon name="close" /></button>
    </div>

    <div class="drawer__body">
        <ul role="list" class="list-reset" data-cart-lines></ul>

        <div class="drawer__empty" data-cart-empty>
            <strong>Keranjang masih kosong</strong>
            <p>Pilih menu favoritmu, lalu tambahkan ke sini.</p>
            <a class="btn btn--ghost btn--sm mt-4" href="{{ route('menu.index') }}">Lihat menu</a>
        </div>
    </div>

    <div class="drawer__foot" data-cart-foot hidden>
        <div class="summary__total"><span>Subtotal</span><span data-cart-subtotal>Rp 0</span></div>
        <p class="field__hint">Pajak dan ongkir dihitung di halaman checkout.</p>
        <a class="btn btn--primary btn--block" href="{{ route('checkout.show') }}">Lanjut ke checkout</a>
    </div>
</aside>
