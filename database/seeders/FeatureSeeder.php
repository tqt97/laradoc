<?php

namespace Database\Seeders;

use App\Models\Feature;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Config;

class FeatureSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $features = Config::get('features', []);

        foreach ($features as $key => $config) {
            Feature::updateOrCreate(
                ['key' => $key],
                [
                    'enabled' => $config['enabled'] ?? true,
                    'roles' => $config['roles'] ?? [],
                    'show' => $config['show'] ?? false,
                    'location' => $config['location'] ?? null,
                    'description' => $config['description'] ?? null,
                    'ui' => $config['ui'] ?? null,
                ]
            );
        }
    }
}
