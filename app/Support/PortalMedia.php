<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;

class PortalMedia
{
    public static function url(?string $path): ?string
    {
        if (blank($path)) {
            return null;
        }

        if (str_starts_with($path, 'http')) {
            return $path;
        }

        $relative = ltrim($path, '/');
        $prefix = trim((string) config('portal.local_path_prefix', 'portal-media'), '/');
        $localPath = $prefix.'/'.$relative;
        $disk = config('portal.local_disk', 'public');

        if (Storage::disk($disk)->exists($localPath)) {
            return asset('storage/'.$localPath);
        }

        $base = rtrim((string) config('portal.media_base_url'), '/');

        if ($base === '') {
            return null;
        }

        return $base.'/'.trim($relative, '/');
    }
}
