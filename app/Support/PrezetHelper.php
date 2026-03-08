<?php

namespace App\Support;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Prezet\Prezet\Prezet;

class PrezetHelper
{
    /**
     * Get common data required by most views.
     */
    public static function getCommonData(): array
    {
        $version = PrezetCache::version();
        $cacheKey = "prezet_common_data_v{$version}";

        return \Illuminate\Support\Facades\Cache::remember($cacheKey, 86400, function () {
            return [
                'nav' => Prezet::getSummary(),
            ];
        });
    }

    /**
     * Check if an image exists on the prezet disk.
     */
    public static function checkImageExists(?string $image): ?string
    {
        if (empty($image)) {
            return null;
        }

        if (str_starts_with($image, 'http')) {
            return $image;
        }

        // Remove the /prezet/img/ prefix if it exists
        $imagePath = str_replace('/prezet/img/', '', $image);
        $imagePath = 'images/'.ltrim($imagePath, '/');

        if (! Storage::disk('prezet')->exists($imagePath)) {
            return null;
        }

        return $image;
    }

    /**
     * Calculate estimated reading time for a piece of content.
     */
    public static function calculateReadingTime(string $content): int
    {
        $wordCount = str_word_count(strip_tags($content));

        return (int) max(1, ceil($wordCount / 200));
    }

    /**
     * Generate base SEO data for sub pages.
     */
    public static function getSeoData(string $title, ?string $description = null, ?string $url = null): array
    {
        $defaultDescription = config('prezet.seo.default_description');
        $defaultText = config('prezet.seo.default_title_suffix');

        return [
            'title' => $title.' | '.$defaultText,
            'description' => $description ?? $defaultDescription,
            'url' => $url ?? request()->fullUrl(),
        ];
    }

    /**
     * Extract metadata (title and OG image) from a URL.
     */
    public static function extractMetadata(string $url, ?string $providedTitle): array
    {
        $title = $providedTitle;
        $ogImage = null;

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0',
                'Accept' => 'text/html,application/xhtml+xml',
            ])
                ->timeout(10)
                ->connectTimeout(5)
                ->retry(2, 200)
                ->get($url);

            if (! $response->successful()) {
                return [
                    'title' => $title ?: $url,
                    'og_image' => null,
                ];
            }

            $contentType = $response->header('Content-Type');

            if (str_contains($contentType, 'image/')) {
                return [
                    'title' => $title ?: basename(parse_url($url, PHP_URL_PATH)),
                    'og_image' => $url,
                ];
            }

            $html = $response->body();
            libxml_use_internal_errors(true);
            $dom = new \DOMDocument('1.0', 'UTF-8');
            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');
            $dom->loadHTML($html);
            $xpath = new \DOMXPath($dom);

            if (! $title) {
                $node = $xpath->query('//meta[@property="og:title"]')->item(0);
                if ($node instanceof \DOMElement) {
                    $title = $node->getAttribute('content');
                }
                if (! $title) {
                    $node = $xpath->query('//title')->item(0);
                    if ($node instanceof \DOMElement) {
                        $title = trim($node->textContent);
                    }
                }
            }

            $imageNode = $xpath->query('//meta[@property="og:image"]')->item(0);
            if (! $imageNode) {
                $imageNode = $xpath->query('//meta[@name="twitter:image"]')->item(0);
            }
            if ($imageNode instanceof \DOMElement) {
                $ogImage = $imageNode->getAttribute('content');
            }

            if ($ogImage && ! str_starts_with($ogImage, 'http')) {
                $ogImage = self::resolveAbsoluteUrl($url, $ogImage);
            }
        } catch (\Throwable $e) {
            Log::warning('Metadata extraction failed', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
        }

        return [
            'title' => html_entity_decode($title ?: $url),
            'og_image' => $ogImage,
        ];
    }

    /**
     * Resolve a relative URL into an absolute one.
     */
    public static function resolveAbsoluteUrl(string $baseUrl, string $relativeUrl): string
    {
        $parsed = parse_url($baseUrl);
        $scheme = $parsed['scheme'] ?? 'https';
        $host = $parsed['host'] ?? '';
        $domain = $scheme.'://'.$host;

        if (str_starts_with($relativeUrl, '//')) {
            return $scheme.':'.$relativeUrl;
        }
        if (str_starts_with($relativeUrl, '/')) {
            return $domain.$relativeUrl;
        }

        return $domain.'/'.ltrim($relativeUrl, '/');
    }
}
