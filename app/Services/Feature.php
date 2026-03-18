<?php

namespace App\Services;

use App\Models\Feature as FeatureModel;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;

class Feature
{
    protected const CACHE_KEY = 'app_features_all';

    /**
     * Check if a feature is enabled for the current user.
     */
    public function isEnabled(string $feature): bool
    {
        $features = $this->getAllFeatures();
        $config = $features[$feature] ?? null;

        if (! $config || ! ($config['enabled'] ?? false)) {
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

    /**
     * Get all enabled and visible features for a specific location.
     */
    public function getVisibleForLocation(string $location): array
    {
        $features = $this->getAllFeatures();
        $visible = [];

        foreach ($features as $key => $config) {
            if (($config['location'] ?? '') === $location &&
                ($config['show'] ?? false) &&
                $this->isEnabled($key)) {
                $visible[$key] = $config;
            }
        }

        return $visible;
    }

    /**
     * Get all features from cache or database.
     */
    protected function getAllFeatures(): array
    {
        return Cache::rememberForever(self::CACHE_KEY, function () {
            return FeatureModel::all()->keyBy('key')->toArray();
        });
    }

    /**
     * Clear the features cache.
     */
    public function clearCache(): void
    {
        Cache::forget(self::CACHE_KEY);
    }
}
