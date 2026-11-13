<?php

namespace App\Actions;

use App\Enums\OrderStatus;
use App\Models\Order;
use App\Models\User;
use App\Services\CartLine;
use App\Services\CartService;
use Illuminate\Support\Facades\DB;

class PlaceOrder
{
    public function __construct(private readonly CartService $cart) {}

    /**
     * Membuat pesanan dari isi keranjang saat ini.
     * Nama dan harga item disalin ke order_items sebagai snapshot.
     *
     * @param  array{name: string, phone: string, address: string, note?: string|null}  $data
     */
    public function handle(User $user, array $data): Order
    {
        $summary = $this->cart->summary();

        $order = DB::transaction(function () use ($user, $data, $summary): Order {
            $order = Order::create([
                'user_id' => $user->id,
                'name' => $data['name'],
                'phone' => $data['phone'],
                'address' => $data['address'],
                'note' => $data['note'] ?? null,
                'delivery_fee' => $summary['delivery_fee'],
                'tax' => $summary['tax'],
                'total' => $summary['total'],
                'status' => OrderStatus::Pending,
            ]);

            $order->items()->createMany(
                $summary['lines']->map(fn (CartLine $line) => [
                    'menu_id' => $line->menuId,
                    'name' => $line->name,
                    'price' => $line->price,
                    'quantity' => $line->quantity,
                ])->all()
            );

            return $order;
        });

        $this->cart->clear();

        return $order;
    }
}
