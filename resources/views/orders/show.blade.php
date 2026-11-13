<x-layouts.app :title="'Pesanan #'.$order->id">
    <div class="narrow section" @if ($order->status->isActive()) data-autorefresh="30" @endif>
        <x-page-header :title="'Pesanan #'.$order->id" :description="$order->placed_at->translatedFormat('d M Y, H:i')">
            <x-slot:actions>
                <x-status-badge :status="$order->status" />
            </x-slot:actions>
        </x-page-header>

        <div class="panel">
            <h2>Item pesanan</h2>
            <ul class="order-lines">
                @foreach ($order->items as $item)
                    <li><span>{{ $item->quantity }}&times; {{ $item->name }}</span><span>@rupiah($item->line_total)</span></li>
                @endforeach
            </ul>

            <div class="summary__row"><span>Subtotal</span><span>@rupiah($order->subtotal)</span></div>
            <div class="summary__row"><span>Pajak</span><span>@rupiah($order->tax)</span></div>
            <div class="summary__row"><span>Ongkir</span><span>@rupiah($order->delivery_fee)</span></div>
            <div class="summary__total"><span>Total</span><span>@rupiah($order->total)</span></div>
        </div>

        <div class="panel">
            <h2>Pengiriman</h2>
            <p><strong>{{ $order->name }}</strong>, {{ $order->phone }}</p>
            <p class="muted">{{ $order->address }}</p>
            @if ($order->note)
                <p class="mt-4"><strong>Catatan:</strong> {{ $order->note }}</p>
            @endif
            <p class="mt-4 muted">Pembayaran: bayar di tempat (cash).</p>
        </div>

        <div class="page-head__actions mt-4">
            <a class="btn btn--ghost" href="{{ route('orders.index') }}">Semua pesanan</a>
            <form method="POST" action="{{ route('orders.reorder', $order) }}">
                @csrf
                <button type="submit" class="btn btn--dark">Pesan lagi</button>
            </form>
        </div>
    </div>
</x-layouts.app>
