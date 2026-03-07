<?php

namespace App\Support;

use Illuminate\Support\Facades\Cache;

class PrezetCache
{
    /**
     * Increment the cache version to instantly invalidate all Prezet-related caches.
     */
    public static function invalidate(): void
    {
        Cache::increment('prezet_cache_version');
    }

    /**
     * Get the current cache version.
     */
    public static function version(): int
    {
        return (int) Cache::get('prezet_cache_version', 1);
    }
}
