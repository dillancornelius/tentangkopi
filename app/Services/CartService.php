<?php

namespace App\Services;

use App\Models\Menu;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Collection;

/**
 * Keranjang disimpan di session sebagai [menu_id => jumlah].
 * Harga selalu dibaca dari database, jadi tidak pernah basi.
 */
class CartService
{
    private const SESSION_KEY = 'cart';

    private const MAX_QUANTITY = 99;

    public function __construct(private readonly Session $session) {}

    public function add(int $menuId, int $quantity = 1): void
    {
        $current = $this->quantities()[$menuId] ?? 0;

        $this->setQuantity($menuId, $current + $quantity);
    }

    /** Jumlah 0 (atau kurang) menghapus item. */
    public function setQuantity(int $menuId, int $quantity): void
    {
        $quantities = $this->quantities();

        if ($quantity <= 0) {
            unset($quantities[$menuId]);
        } else {
            $quantities[$menuId] = min($quantity, self::MAX_QUANTITY);
        }

        $this->session->put(self::SESSION_KEY, $quantities);
    }

    /** @param array<int, int> $quantities */
    public function replace(array $quantities): void
    {
        $this->session->put(self::SESSION_KEY, $quantities);
    }

    public function clear(): void
    {
        $this->session->forget(self::SESSION_KEY);
    }

    /** @return Collection<int, CartLine> */
    public function lines(): Collection
    {
        $quantities = $this->quantities();

        if ($quantities === []) {
            return collect();
        }

        $menus = Menu::whereIn('id', array_keys($quantities))->get()->keyBy('id');

        // Menu yang sudah dihapus admin dibuang dari keranjang.
        $lines = collect($quantities)
            ->filter(fn (int $quantity, int $menuId) => $menus->has($menuId))
            ->map(function (int $quantity, int $menuId) use ($menus): CartLine {
                $menu = $menus->get($menuId);

                return new CartLine($menu->id, $menu->name, $menu->price, $quantity, $menu->image_url);
            })
            ->values();

        if ($lines->count() !== count($quantities)) {
            $this->replace($lines->pluck('quantity', 'menuId')->all());
        }

        return $lines;
    }

    /**
     * @return array{lines: Collection<int, CartLine>, count: int, subtotal: int, tax: int, delivery_fee: int, total: int}
     */
    public function summary(): array
    {
        $lines = $this->lines();

        $subtotal = $lines->sum(fn (CartLine $line) => $line->total());
        $deliveryFee = $lines->isEmpty() ? 0 : (int) config('cafe.delivery_fee');
        $tax = (int) round($subtotal * (float) config('cafe.tax_rate'));

        return [
            'lines' => $lines,
            'count' => (int) $lines->sum('quantity'),
            'subtotal' => $subtotal,
            'tax' => $tax,
            'delivery_fee' => $deliveryFee,
            'total' => $subtotal + $tax + $deliveryFee,
        ];
    }

    /** Bentuk JSON untuk drawer keranjang di frontend. */
    public function payload(): array
    {
        $summary = $this->summary();
        $summary['lines'] = $summary['lines']
            ->map(fn (CartLine $line) => $line->toArray())
            ->all();

        return $summary;
    }

    /** @return array<int, int> */
    private function quantities(): array
    {
        return $this->session->get(self::SESSION_KEY, []);
    }
}
