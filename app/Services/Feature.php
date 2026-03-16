<?php

namespace App\Services;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;

class Feature
{
    /**
     * Check if a feature is enabled for the current user.
     */
    public function isEnabled(string $feature): bool
    {
        $config = Config::get("features.{$feature}");

        if (! $config || ! $config['enabled']) {
            return false;
        }

        if (empty($config['roles'])) {
            return true;
        }

        $user = Auth::user();

        if (! $user) {
            return false;
        }

        return $user->hasAnyRole($config['roles']);
    }
}
