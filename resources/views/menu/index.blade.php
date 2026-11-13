@php
    $base = array_filter([
        'search' => $filters['search'] ?? null,
        'sort' => $filters['sort'] ?? null,
    ]);
    $activeSub = $filters['subcategory'] ?? null;
    $sorts = [
        '' => 'Urutan awal',
        'price_asc' => 'Harga terendah',
        'price_desc' => 'Harga tertinggi',
        'name_asc' => 'Nama A-Z',
    ];
@endphp

<x-layouts.app title="Menu">
    <div class="container section">
        <x-page-header title="Menu" :description="$menus->count().' menu'" />

        <form method="GET" action="{{ route('menu.index') }}" class="toolbar" role="search">
            @if ($activeSub)
                <input type="hidden" name="subcategory" value="{{ $activeSub }}">
            @endif

            <div class="search">
                <x-icon name="search" />
                <label class="visually-hidden" for="search">Cari menu</label>
                <input id="search" type="search" name="search" value="{{ $filters['search'] ?? '' }}" placeholder="Cari menu, mis. latte">
            </div>

            <label class="visually-hidden" for="sort">Urutkan</label>
            <select id="sort" name="sort" data-autosubmit>
                @foreach ($sorts as $value => $label)
                    <option value="{{ $value }}" @selected(($filters['sort'] ?? '') === $value)>{{ $label }}</option>
                @endforeach
            </select>

            <button type="submit" class="btn btn--dark">Cari</button>
        </form>

        <nav class="chips" aria-label="Kategori menu">
            <a class="chip {{ $activeSub ? '' : 'is-active' }}" href="{{ route('menu.index', $base) }}">Semua</a>
            @foreach ($categories as $category)
                <span class="chips__label">{{ $category->name }}</span>
                @foreach ($category->subcategories as $subcategory)
                    <a class="chip {{ (int) $activeSub === $subcategory->id ? 'is-active' : '' }}"
                       href="{{ route('menu.index', $base + ['subcategory' => $subcategory->id]) }}">{{ $subcategory->name }}</a>
                @endforeach
            @endforeach
        </nav>

        @if ($menus->isEmpty())
            <div class="empty">
                <h2>Menu tidak ditemukan</h2>
                <p>Coba kata kunci lain, atau tampilkan semua menu.</p>
                <a class="btn btn--ghost" href="{{ route('menu.index') }}">Tampilkan semua menu</a>
            </div>
        @else
            <div class="menu-grid">
                @foreach ($menus as $menu)
                    <x-menu-card :menu="$menu" />
                @endforeach
            </div>
        @endif
    </div>
</x-layouts.app>
