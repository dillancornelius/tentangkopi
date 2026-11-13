<x-layouts.app title="Pesanan saya">
    <div class="narrow section" @if ($orders->contains(fn ($order) => $order->status->isActive())) data-autorefresh="30" @endif>
        <x-page-header title="Pesanan saya" description="Status pesanan yang masih berjalan diperbarui otomatis." />

        @forelse ($orders as $order)
            <article class="order-card">
                <div class="order-card__head">
                    <div>
                        <h2 class="order-card__title">Pesanan #{{ $order->id }}</h2>
                        <p class="order-card__date">{{ $order->placed_at->translatedFormat('d M Y, H:i') }}</p>
                    </div>
                    <x-status-badge :status="$order->status" />
                </div>

                <ul class="order-lines">
                    @foreach ($order->items as $item)
                        <li><span>{{ $item->quantity }}&times; {{ $item->name }}</span><span>@rupiah($item->line_total)</span></li>
                    @endforeach
                </ul>

                <div class="order-card__foot">
                    <p class="order-card__total">@rupiah($order->total)</p>
                    <div class="page-head__actions">
                        <a class="btn btn--quiet btn--sm" href="{{ route('orders.show', $order) }}">Detail</a>
                        <form method="POST" action="{{ route('orders.reorder', $order) }}">
                            @csrf
                            <button type="submit" class="btn btn--dark btn--sm">Pesan lagi</button>
                        </form>
                    </div>
                </div>
            </article>
        @empty
            <div class="empty">
                <h2>Belum ada pesanan</h2>
                <p>Pesanan yang kamu buat akan muncul di sini.</p>
                <a class="btn btn--primary" href="{{ route('menu.index') }}">Lihat menu</a>
            </div>
        @endforelse

        {{ $orders->links() }}
    </div>
</x-layouts.app>
