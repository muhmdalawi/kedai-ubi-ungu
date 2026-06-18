<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    public const STATUSES = ['pending' => 'Menunggu Konfirmasi', 'processing' => 'Diproses', 'shipping' => 'Dalam Pengiriman', 'completed' => 'Selesai', 'cancelled' => 'Dibatalkan'];

    protected $guarded = [];

    protected function casts(): array
    {
        return ['total_price' => 'integer'];
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }
}
