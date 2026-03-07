<?php

namespace App\Support;

use Illuminate\Support\Facades\Storage;
use Prezet\Prezet\Prezet;

class PrezetHelper
{
    /**
     * Get common data required by most views.
     */
    public static function getCommonData(): array
    {
        return [
            'nav' => Prezet::getSummary(),
        ];
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
        $defaultDescription = 'Chia sẻ kiến thức lập trình, kỹ thuật xây dựng hệ thống và những bài học trong quá trình phát triển ứng dụng web';
        $defaultText = 'Chia sẻ kiến thức, kinh nghiệm phát triển ứng dụng web';

        return [
            'title' => $title.' | '.$defaultText,
            'description' => $description ?? $defaultDescription,
            'url' => $url ?? request()->fullUrl(),
        ];
    }
}
