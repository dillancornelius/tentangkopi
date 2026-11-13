<footer class="site-footer">
    <div class="container">
        <div class="site-footer__grid">
            <div>
                <img class="site-footer__logo" src="{{ asset('assets/logo.jpg') }}" alt="{{ config('cafe.name') }}" loading="lazy">
                <address>{{ config('cafe.address') }}</address>
                <p class="mt-4"><a href="tel:{{ preg_replace('/[^0-9+]/', '', config('cafe.phone')) }}">{{ config('cafe.phone') }}</a></p>
            </div>

            <div>
                <h2>Jelajahi</h2>
                <ul role="list">
                    <li><a href="{{ route('menu.index') }}">Menu</a></li>
                    <li><a href="{{ route('about.us') }}">Tentang kami</a></li>
                    <li><a href="{{ route('reviews.index') }}">Ulasan</a></li>
                </ul>
            </div>

            <div>
                <h2>Ikuti kami</h2>
                <div class="socials">
                    @foreach (config('cafe.socials') as $social)
                        <a href="{{ $social['url'] }}" target="_blank" rel="noopener noreferrer" aria-label="{{ $social['label'] }}">
                            <x-icon :name="$social['icon']" />
                        </a>
                    @endforeach
                </div>
            </div>
        </div>

        <p class="site-footer__legal">&copy; {{ date('Y') }} {{ config('cafe.name') }}</p>
    </div>
</footer>
