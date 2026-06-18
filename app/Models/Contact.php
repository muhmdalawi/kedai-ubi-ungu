<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $guarded = [];

    public function getWhatsappLinkAttribute(): string
    {
        return 'https://wa.me/'.preg_replace('/\D+/', '', $this->whatsapp);
    }
}
