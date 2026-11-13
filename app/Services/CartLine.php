<?php

namespace App\Services;

final readonly class CartLine
{
    public function __construct(
        public int $menuId,
        public string $name,
        public int $price,
        public int $quantity,
        public ?string $imageUrl,
    ) {}

    public function total(): int
    {
        return $this->price * $this->quantity;
    }

    /** @return array<string, int|string|null> */
    public function toArray(): array
    {
        return [
            'id' => $this->menuId,
            'name' => $this->name,
            'price' => $this->price,
            'quantity' => $this->quantity,
            'line_total' => $this->total(),
            'image' => $this->imageUrl,
        ];
    }
}
