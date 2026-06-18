<?php

namespace App\Models;

use App\Models\Concerns\HasImageUrl;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasImageUrl;

    protected $guarded = [];

    protected function casts(): array
    {
        return ['is_best_seller' => 'boolean', 'is_promo' => 'boolean', 'price' => 'integer'];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function toppings()
    {
        return $this->belongsToMany(Topping::class, 'product_toppings')->withTimestamps();
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
