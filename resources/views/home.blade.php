<x-layouts.app title="Beranda">
    <section class="hero">
        <div class="container hero__grid">
            <div>
                <h1>Sudah ngopi hari ini?</h1>
                <p class="hero__lead">Kopi lokal dengan konsep fresh to cup. Diracik dari bahan baku terbaik, lalu diantar sampai tempatmu.</p>
                <div class="hero__actions">
                    <a class="btn btn--primary" href="{{ route('menu.index') }}">Lihat menu</a>
                    <a class="btn btn--ghost" href="{{ route('about.us') }}">Tentang kami</a>
                </div>
            </div>
            <div class="hero__art">
                <img class="bowl" src="{{ asset('assets/home3.jpg') }}" alt="Segelas es kopi susu Tentang Kopi di atas talenan kayu" width="610" height="600" fetchpriority="high">
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="section__head">
                <h2>Pilih sesuai seleranya</h2>
            </div>
            <div class="pick-grid">
                @foreach ($cards as $card)
                    <a class="pick" href="{{ $card['url'] }}">
                        <img src="{{ $card['image'] }}" alt="" loading="lazy">
                        <div class="pick__label">
                            <span>{{ $card['label'] }}</span>
                            <x-icon name="arrow-right" />
                        </div>
                    </a>
                @endforeach
            </div>
        </div>
    </section>

    @if ($featured->isNotEmpty())
        <section class="section section--mist">
            <div class="container">
                <div class="section__head">
                    <h2>Menu andalan</h2>
                    <a class="link" href="{{ route('menu.index') }}">Lihat semua menu</a>
                </div>
                <div class="menu-grid">
                    @foreach ($featured as $menu)
                        <x-menu-card :menu="$menu" />
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    <section class="section">
        <div class="container band">
            <figure class="band__item">
                <img src="{{ asset('assets/home1.jpg') }}" alt="Barista menyiapkan kopi di depan mesin espresso" loading="lazy">
                <p>Brewed with Purpose</p>
            </figure>
            <figure class="band__item">
                <img src="{{ asset('assets/home2.jpg') }}" alt="Barista tersenyum di dekat mesin espresso yang mengepul" loading="lazy">
                <p>Grounded in Passion</p>
            </figure>
        </div>
    </section>

    <section class="section section--tight-top">
        <div class="container invite">
            <img src="{{ asset('assets/home6.jpg') }}" alt="Poster Sudah Ngopi? dengan empat gelas es kopi" loading="lazy">
            <div class="invite__text">
                <h2>Belum tahu mau pesan apa?</h2>
                <p>Mulai dari kopi susu yang ringan sampai toast yang mengenyangkan. Semua ada di satu halaman menu.</p>
                <a class="btn btn--primary" href="{{ route('menu.index') }}">Pesan sekarang</a>
            </div>
        </div>
    </section>
</x-layouts.app>
