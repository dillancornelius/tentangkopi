<x-layouts.admin title="Pesanan">
    <x-page-header title="Pesanan" description="Pantau dan ubah status pesanan pelanggan." />

    <nav class="tabs" aria-label="Filter status">
        <a href="{{ route('admin.orders.index') }}" @class(['tab', 'is-active' => ! $status])>Semua <small>{{ $counts->sum() }}</small></a>
        @foreach (\App\Enums\OrderStatus::cases() as $case)
            <a href="{{ route('admin.orders.index', ['status' => $case->value]) }}" @class(['tab', 'is-active' => $status === $case])>
                {{ $case->label() }} <small>{{ $counts[$case->value] ?? 0 }}</small>
            </a>
        @endforeach
    </nav>

    <div class="panel panel--flush">
        <div class="table-wrap">
            <table class="table">
                <thead>
                    <tr><th>Pesanan</th><th>Pelanggan</th><th>Item</th><th class="num">Total</th><th>Status</th><th>Ubah status</th></tr>
                </thead>
                <tbody>
                    @forelse ($orders as $order)
                        <tr>
                            <td><strong>#{{ $order->id }}</strong><br><span class="muted">{{ $order->placed_at->translatedFormat('d M Y, H:i') }}</span></td>
                            <td>
                                <strong>{{ $order->name }}</strong><br>
                                <span class="muted">{{ $order->phone }}</span><br>
                                <span class="muted">{{ $order->address }}</span>
                                @if ($order->note)
                                    <br><em>Catatan: {{ $order->note }}</em>
                                @endif
                            </td>
                            <td>
                                <details class="items-detail">
                                    <summary>{{ $order->items->sum('quantity') }} item</summary>
                                    <ul>
                                        @foreach ($order->items as $item)
                                            <li>{{ $item->quantity }}&times; {{ $item->name }}</li>
                                        @endforeach
                                    </ul>
                                </details>
                            </td>
                            <td class="num">@rupiah($order->total)</td>
                            <td><x-status-badge :status="$order->status" /></td>
                            <td>
                                <form method="POST" action="{{ route('admin.orders.update', $order) }}" class="inline-form">
                                    @csrf
                                    @method('PATCH')
                                    <select name="status" aria-label="Status pesanan #{{ $order->id }}">
                                        @foreach (\App\Enums\OrderStatus::cases() as $case)
                                            <option value="{{ $case->value }}" @selected($order->status === $case)>{{ $case->label() }}</option>
                                        @endforeach
                                    </select>
                                    <button type="submit" class="btn btn--dark btn--sm">Simpan</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="6" class="muted">Tidak ada pesanan untuk filter ini.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    {{ $orders->links() }}
</x-layouts.admin>
