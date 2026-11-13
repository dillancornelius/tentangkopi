<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Services\CartService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

/** Endpoint JSON untuk keranjang (dipanggil dari JavaScript). */
class CartController extends Controller
{
    public function __construct(private readonly CartService $cart) {}

    public function show(): JsonResponse
    {
        return response()->json($this->cart->payload());
    }

    public function add(Request $request): JsonResponse
    {
        $data = $request->validate([
            'menu_id' => ['required', 'integer', 'exists:menus,id'],
        ]);

        $this->cart->add($data['menu_id']);

        return response()->json($this->cart->payload());
    }

    public function update(Request $request, Menu $menu): JsonResponse
    {
        $data = $request->validate([
            'quantity' => ['required', 'integer', 'min:0', 'max:99'],
        ]);

        $this->cart->setQuantity($menu->id, $data['quantity']);

        return response()->json($this->cart->payload());
    }

    public function clear(): JsonResponse
    {
        $this->cart->clear();

        return response()->json($this->cart->payload());
    }
}
