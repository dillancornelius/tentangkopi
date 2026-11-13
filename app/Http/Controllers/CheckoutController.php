<?php

namespace App\Http\Controllers;

use App\Actions\PlaceOrder;
use App\Http\Requests\CheckoutRequest;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class CheckoutController extends Controller
{
    public function show(CartService $cart): View|RedirectResponse
    {
        $summary = $cart->summary();

        if ($summary['lines']->isEmpty()) {
            return $this->emptyCartRedirect();
        }

        return view('checkout.index', compact('summary'));
    }

    public function store(CheckoutRequest $request, CartService $cart, PlaceOrder $placeOrder): RedirectResponse
    {
        if ($cart->summary()['lines']->isEmpty()) {
            return $this->emptyCartRedirect();
        }

        $order = $placeOrder->handle($request->user(), $request->validated());

        return redirect()
            ->route('orders.show', $order)
            ->with('success', 'Pesanan berhasil dibuat. Kami segera memprosesnya.');
    }

    private function emptyCartRedirect(): RedirectResponse
    {
        return redirect()->route('menu.index')->with('error', 'Keranjangmu masih kosong. Pilih menu dulu, ya.');
    }
}
