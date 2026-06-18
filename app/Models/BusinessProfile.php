<?php

namespace App\Models;

use App\Models\Concerns\HasImageUrl;
use Illuminate\Database\Eloquent\Model;

class BusinessProfile extends Model
{
    use HasImageUrl;

    protected $guarded = [];

    public function getImageAttribute(): ?string
    {
        return $this->logo;
    }

    public function getLogoUrlAttribute(): string
    {
        return $this->imageUrl($this->logo);
    }
}
