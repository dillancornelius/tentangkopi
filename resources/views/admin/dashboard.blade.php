<x-layouts.admin title="Dashboard">
    <x-page-header title="Dashboard" description="Ringkasan hari ini." />

    <div class="stats">
        <div class="stat">
            <p class="stat__label">Pesanan hari ini</p>
            <p class="stat__value">{{ $stats['orders_today'] }}</p>
        </div>
        <div class="stat">
            <p class="stat__label">Pendapatan hari ini</p>
            <p class="stat__value">@rupiah($stats['revenue_today'])</p>
        </div>
        <div @class(['stat', 'stat--alert' => $stats['pending'] > 0])>
            <p class="stat__label">Menunggu konfirmasi</p>
            <p class="stat__value">{{ $stats['pending'] }}</p>
        </div>
        <div class="stat">
            <p class="stat__label">Menu aktif</p>
            <p class="stat__value">{{ $stats['menus'] }}</p>
        </div>
        <div class="stat">
            <p class="stat__label">Pelanggan</p>
            <p class="stat__value">{{ $stats['customers'] }}</p>
        </div>
    </div>

    <div class="page-head">
        <h2>Pesanan terbaru</h2>
        <a class="btn btn--ghost btn--sm" href="{{ route('admin.orders.index') }}">Semua pesanan</a>
    </div>

    <div class="panel panel--flush">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr><th>Pesanan</th><th>Pelanggan</th><th class="num">Total</th><th>Status</th></tr>
                </thead>
                <tbody>
                    @forelse ($recentOrders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong><br><span class="muted">{{ $order->placed_at->translatedFormat('d M, H:i') }}</span></td>
                            <td>{{ $order->name }}</td>
                            <td class="num">@rupiah($order->total)</td>
                            <td><x-status-badge :status="$order->status" /></td>
                        </tr>
                    @empty
                        <tr><td colspan="4" class="muted">Belum ada pesanan.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</x-layouts.admin>
