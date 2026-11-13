<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Carbon\CarbonInterface;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'phone',
        'address',
        'note',
        'delivery_fee',
        'tax',
        'total',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'status' => OrderStatus::class,
            'delivery_fee' => 'integer',
            'tax' => 'integer',
            'total' => 'integer',
        ];
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function items(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    protected function subtotal(): Attribute
    {
        return Attribute::get(fn (): int => $this->total - $this->delivery_fee - $this->tax);
    }

    /** Waktu pesanan dalam zona waktu kafe (database tetap menyimpan UTC). */
    protected function placedAt(): Attribute
    {
        return Attribute::get(
            fn (): CarbonInterface => $this->created_at->copy()->timezone(config('cafe.timezone'))
        );
    }
}
