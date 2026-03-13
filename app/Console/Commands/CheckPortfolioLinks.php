<?php

namespace App\Console\Commands;

use App\Http\Controllers\PortfolioController;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class CheckPortfolioLinks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'portfolio:check-links';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Check all portfolio image links and identify broken ones.';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Checking portfolio image links...');

        $controller = new PortfolioController;
        $collections = $controller->getCollectionsData();

        $brokenLinks = [];
        $totalImages = 0;

        foreach ($collections as $category => $data) {
            $this->comment("Checking category: {$category}");

            // Check featured image
            $featuredUrl = $data['featured'];
            $totalImages++;
            if (! $this->checkLink($featuredUrl)) {
                $brokenLinks[] = [
                    'category' => $category,
                    'title' => 'Featured Image',
                    'url' => $featuredUrl,
                ];
            }

            // Check individual images
            foreach ($data['images'] as $index => $img) {
                $totalImages++;
                if (! $this->checkLink($img['url'])) {
                    $brokenLinks[] = [
                        'category' => $category,
                        'title' => $img['title'] ?? "Image {$index}",
                        'url' => $img['url'],
                    ];
                }
            }
        }

        if (empty($brokenLinks)) {
            $this->info("Success! All {$totalImages} links are valid.");
        } else {
            $this->error('Found '.count($brokenLinks)." broken links out of {$totalImages}:");
            foreach ($brokenLinks as $broken) {
                $this->warn("- [{$broken['category']}] {$broken['title']}: {$broken['url']}");
            }
        }

        return empty($brokenLinks) ? 0 : 1;
    }

    /**
     * Check if a link is valid.
     */
    private function checkLink(string $url): bool
    {
        try {
            $response = Http::timeout(10)->head($url);

            return $response->successful();
        } catch (\Exception $e) {
            return false;
        }
    }
}
