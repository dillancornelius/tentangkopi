<?php

namespace App\Enums;

enum OrderStatus: string
{
    case Pending = 'pending';
    case Confirmed = 'confirmed';
    case Completed = 'completed';
    case Cancelled = 'cancelled';

    public function label(): string
    {
        return match ($this) {
            self::Pending => 'Menunggu',
            self::Confirmed => 'Dikonfirmasi',
            self::Completed => 'Selesai',
            self::Cancelled => 'Dibatalkan',
        };
    }

    /** Nama varian warna di CSS (badge--warn, badge--info, dst). */
    public function tone(): string
    {
        return match ($this) {
            self::Pending => 'warn',
            self::Confirmed => 'info',
            self::Completed => 'ok',
            self::Cancelled => 'bad',
        };
    }

    /** Pesanan yang masih berjalan. */
    public function isActive(): bool
    {
        return $this === self::Pending || $this === self::Confirmed;
    }
}
