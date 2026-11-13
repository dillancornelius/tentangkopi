@props(['menu'])

<article class="menu-card">
    <div class="menu-card__media">
        @if ($menu->image_url)
            <img src="{{ $menu->image_url }}" alt="{{ $menu->name }}" loading="lazy">
        @else
            <span class="menu-card__ph" aria-hidden="true">{{ mb_substr($menu->name, 0, 1) }}</span>
        @endif
    </div>
    <div class="menu-card__body">
        <p class="menu-card__cat">{{ $menu->subcategory?->name }}</p>
        <h3>{{ $menu->name }}</h3>
        <div class="menu-card__foot">
            <p class="price">@rupiah($menu->price)</p>
            <button type="button" class="btn btn--primary btn--sm" data-cart-add data-menu-id="{{ $menu->id }}" data-menu-name="{{ $menu->name }}" aria-label="Tambah {{ $menu->name }} ke keranjang">
                <x-icon name="plus" /> Tambah
            </button>
        </div>
    </div>
</article>
