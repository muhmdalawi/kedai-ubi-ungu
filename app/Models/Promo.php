<?php

namespace App\Models;

use App\Models\Concerns\HasImageUrl;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;

class Promo extends Model
{
    use HasImageUrl;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'start_date' => 'date', 'end_date' => 'date'];
    }

    public function getImageUrlAttribute(): string
    {
        return $this->imageUrl($this->banner);
    }

    public function scopeCurrent(Builder $query): Builder
    {
        return $query->where('is_active', true)->whereDate('start_date', '<=', now())->whereDate('end_date', '>=', now());
    }
}
