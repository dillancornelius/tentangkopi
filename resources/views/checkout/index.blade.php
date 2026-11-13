<x-layouts.app title="Checkout">
    <div class="container section">
        <x-page-header title="Checkout" description="Isi data pengiriman, lalu kami proses pesananmu." />

        <div class="checkout">
            <form method="POST" action="{{ route('checkout.store') }}" class="panel">
                @csrf
                <h2>Data pengiriman</h2>

                <x-form.input name="name" label="Nama penerima" :value="auth()->user()->name" required autocomplete="name" />
                <x-form.input name="phone" label="Nomor telepon" type="tel" inputmode="tel" required autocomplete="tel" placeholder="08xxxxxxxxxx" />
                <x-form.textarea name="address" label="Alamat pengiriman" rows="3" required autocomplete="street-address" />
                <x-form.textarea name="note" label="Catatan (opsional)" rows="2" hint="Mis. less sugar atau tanpa es." />

                <div class="payment-note">
                    <x-icon name="info" />
                    <p><strong>Bayar di tempat (cash).</strong> Pembayaran dilakukan saat pesanan sampai.</p>
                </div>

                <button type="submit" class="btn btn--primary btn--block mt-4">Buat pesanan</button>
            </form>

            <aside class="panel checkout__summary" aria-labelledby="summary-title">
                <h2 id="summary-title">Ringkasan pesanan</h2>

                <ul role="list" class="list-reset">
                    @foreach ($summary['lines'] as $line)
                        <li class="cart-line">
                            <div class="cart-line__thumb">
                                @if ($line->imageUrl)
                                    <img src="{{ $line->imageUrl }}" alt="">
                                @else
                                    {{ mb_substr($line->name, 0, 1) }}
                                @endif
                            </div>
                            <div>
                                <p class="cart-line__name">{{ $line->name }}</p>
                                <p class="cart-line__price">@rupiah($line->price)</p>
                            </div>
                            <div class="stepper" role="group" aria-label="Jumlah {{ $line->name }}">
                                <button type="button" data-cart-step data-reload data-menu-id="{{ $line->menuId }}" data-quantity="{{ $line->quantity - 1 }}" aria-label="Kurangi"><x-icon name="minus" /></button>
                                <span>{{ $line->quantity }}</span>
                                <button type="button" data-cart-step data-reload data-menu-id="{{ $line->menuId }}" data-quantity="{{ $line->quantity + 1 }}" aria-label="Tambah"><x-icon name="plus" /></button>
                            </div>
                        </li>
                    @endforeach
                </ul>

                <div class="mt-4">
                    <div class="summary__row"><span>Subtotal</span><span>@rupiah($summary['subtotal'])</span></div>
                    <div class="summary__row"><span>Pajak ({{ (int) (config('cafe.tax_rate') * 100) }}%)</span><span>@rupiah($summary['tax'])</span></div>
                    <div class="summary__row"><span>Ongkir</span><span>@rupiah($summary['delivery_fee'])</span></div>
                    <div class="summary__total"><span>Total</span><span>@rupiah($summary['total'])</span></div>
                </div>

                <button type="button" class="btn btn--quiet btn--sm mt-4" data-cart-clear data-reload>
                    <x-icon name="trash" /> Kosongkan keranjang
                </button>
            </aside>
        </div>
    </div>
</x-layouts.app>
