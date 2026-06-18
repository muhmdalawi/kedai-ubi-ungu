<?php

namespace App\Models;

use App\Models\Concerns\HasImageUrl;
use Illuminate\Database\Eloquent\Model;

class Topping extends Model
{
    use HasImageUrl;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_active' => 'boolean', 'additional_price' => 'integer'];
    }

    public function products()
    {
        return $this->belongsToMany(Product::class, 'product_toppings')->withTimestamps();
    }
}
