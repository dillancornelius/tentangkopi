<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Services\CartService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class OrderController extends Controller
{
    public function index(Request $request): View
    {
        $orders = $request->user()
            ->orders()
            ->with('items')
            ->latest()
            ->paginate(8);

        return view('orders.index', compact('orders'));
    }

    public function show(Order $order): View
    {
        $this->authorize('view', $order);

        $order->load('items');

        return view('orders.show', compact('order'));
    }

    /** Isi keranjang dengan item pesanan lama (harga mengikuti menu saat ini). */
    public function reorder(Order $order, CartService $cart): RedirectResponse
    {
        $this->authorize('view', $order);

        $cart->replace(
            $order->items()->whereNotNull('menu_id')->pluck('quantity', 'menu_id')->all()
        );

        return redirect()->route('checkout.show')->with('success', 'Item pesanan sebelumnya sudah masuk keranjang.');
    }
}
