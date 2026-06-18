<?php

namespace App\Models\Concerns;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HasImageUrl
{
    public function imageUrl(?string $value = null): string
    {
        $path = $value ?? $this->image ?? null;
        if (! $path) {
            return asset('assets/logo/logo-4.png');
        }
        if (Str::startsWith($path, ['http://', 'https://', '/'])) {
            return $path;
        }
        if (Str::startsWith($path, 'assets/')) {
            return asset($path);
        }

        return Storage::disk(config('filesystems.upload_disk', 'public'))->url($path);
    }

    public function getImageUrlAttribute(): string
    {
        return $this->imageUrl();
    }
}
