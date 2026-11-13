@php
    $links = [
        ['route' => 'home', 'match' => 'home', 'label' => 'Beranda', 'auth' => false],
        ['route' => 'menu.index', 'match' => 'menu.*', 'label' => 'Menu', 'auth' => false],
        ['route' => 'about.us', 'match' => 'about.us', 'label' => 'Tentang kami', 'auth' => false],
        ['route' => 'reviews.index', 'match' => 'reviews.*', 'label' => 'Ulasan', 'auth' => false],
        ['route' => 'orders.index', 'match' => 'orders.*', 'label' => 'Pesanan saya', 'auth' => true],
    ];
@endphp

<header class="site-header">
    <div class="container site-header__bar">
        <a class="brand" href="{{ route('home') }}" aria-label="{{ config('cafe.name') }}, ke beranda">
            <img src="{{ asset('assets/logo.jpg') }}" alt="" width="56" height="56">
        </a>

        <nav class="site-nav" id="site-nav" data-nav aria-label="Utama">
            @foreach ($links as $link)
                @continue($link['auth'] && ! auth()->check())
                <a href="{{ route($link['route']) }}" @class(['is-active' => request()->routeIs($link['match'])]) @if (request()->routeIs($link['match'])) aria-current="page" @endif>{{ $link['label'] }}</a>
            @endforeach
        </nav>

        <div class="site-header__actions">
            <button type="button" class="icon-btn cart-btn" data-cart-open aria-label="Buka keranjang">
                <x-icon name="cart" />
                <span class="cart-btn__count" data-cart-count hidden>0</span>
            </button>

            @auth
                <details class="user-menu" data-user-menu>
                    <summary>
                        <span class="avatar" aria-hidden="true">{{ mb_strtoupper(mb_substr(auth()->user()->name, 0, 1)) }}</span>
                        <span class="user-menu__name">{{ auth()->user()->name }}</span>
                        <span class="visually-hidden">Menu akun</span>
                    </summary>
                    <div class="user-menu__panel">
                        <a href="{{ route('profile.edit') }}">Profil</a>
                        <a href="{{ route('orders.index') }}">Pesanan saya</a>
                        <form method="POST" action="{{ route('logout') }}">
                            @csrf
                            <button type="submit">Keluar</button>
                        </form>
                    </div>
                </details>
            @else
                <a class="btn btn--dark btn--sm" href="{{ route('login') }}">Masuk</a>
            @endauth

            <button type="button" class="icon-btn nav-toggle" data-nav-toggle aria-controls="site-nav" aria-expanded="false" aria-label="Buka menu navigasi">
                <x-icon name="menu" />
            </button>
        </div>
    </div>
</header>
