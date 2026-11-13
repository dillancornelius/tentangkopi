<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Menu extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price',
        'description',
        'image',
        'subcategory_id',
    ];

    protected function casts(): array
    {
        return ['price' => 'integer'];
    }

    public function subcategory(): BelongsTo
    {
        return $this->belongsTo(Subcategory::class);
    }

    public function orderItems(): HasMany
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * URL gambar: file unggahan admin, atau gambar bawaan di public/assets/menu/{nama}.png.
     * Null jika keduanya tidak ada (view menampilkan placeholder).
     */
    protected function imageUrl(): Attribute
    {
        return Attribute::get(function (): ?string {
            if ($this->image) {
                return asset('storage/'.$this->image);
            }

            $fallback = 'assets/menu/'.$this->name.'.png';

            return file_exists(public_path($fallback))
                ? asset('assets/menu/'.rawurlencode($this->name).'.png')
                : null;
        });
    }

    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        $term = trim((string) $term);

        // ILIKE: khusus PostgreSQL (sesuai database proyek ini).
        return $term === ''
            ? $query
            : $query->where('name', 'ilike', '%'.addcslashes($term, '%_\\').'%');
    }

    public function scopeSortBy(Builder $query, ?string $sort): Builder
    {
        return match ($sort) {
            'price_asc' => $query->orderBy('price')->orderBy('name'),
            'price_desc' => $query->orderByDesc('price')->orderBy('name'),
            'name_asc' => $query->orderBy('name'),
            default => $query->orderBy('id'),
        };
    }
}
