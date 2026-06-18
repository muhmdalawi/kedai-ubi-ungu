<?php

namespace App\Services;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Intervention\Image\Drivers\Gd\Driver;
use Intervention\Image\ImageManager;
use Throwable;

class ImageUploadService
{
    public function store(UploadedFile $file, string $directory): string
    {
        $name = Str::uuid().'.webp';
        $path = trim($directory, '/').'/'.$name;

        try {
            $manager = new ImageManager(new Driver);
            $encoded = $manager->read($file->getRealPath())->scaleDown(width: 1600, height: 1600)->toWebp(82);
            Storage::disk('public')->put($path, (string) $encoded);

            return $path;
        } catch (Throwable) {
            return $file->store($directory, 'public');
        }
    }

    public function delete(?string $path): void
    {
        if ($path && ! str_starts_with($path, 'assets/') && ! str_starts_with($path, 'http')) {
            Storage::disk('public')->delete($path);
        }
    }
}
