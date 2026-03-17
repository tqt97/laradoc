<?php

namespace App\Services;

use App\Models\PrezetDocument;
use App\Support\PrezetCache;
use App\Support\PrezetHelper;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Prezet\Prezet\Data\DocumentData;

class SeriesService
{
    /**
     * Get all series with their index data and post count.
     */
    public function getAllSeries(?string $search = null): Collection
    {
        $version = PrezetCache::version();
        $cacheKey = "series_index_v2_{$version}_".md5($search ?? 'all');

        return Cache::remember($cacheKey, 86400, function () use ($search) {
            // First, find all unique series folders
            $query = PrezetDocument::active()->series();

            if ($search) {
                $query->search($search);
            }

            // Group by the first part of the filepath after content/series/
            $docs = $query->get();

            return $docs->groupBy(function (PrezetDocument $doc) {
                $relative = str_replace('content/series/', '', $doc->filepath);

                return explode('/', $relative)[0];
            })->map(function (Collection $groupDocs, $seriesSlug) {
                // Find the index doc or use the first one
                $indexDoc = $groupDocs->first(fn ($doc) => str_ends_with($doc->filepath, 'index.md')) ?? $groupDocs->first();

                $docData = app(DocumentData::class)::fromModel($indexDoc);
                $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

                return (object) [
                    'slug' => $seriesSlug,
                    'title' => $docData->frontmatter->title ?? Str::headline($seriesSlug),
                    'data' => $docData,
                    'postCount' => $groupDocs->count(),
                    'latestUpdate' => $groupDocs->max('updated_at'),
                ];
            })->sortByDesc('latestUpdate');
        });
    }

    /**
     * Get all posts within a specific series, sorted correctly.
     */
    public function getSeriesPosts(string $seriesSlug): Collection
    {
        return PrezetDocument::active()
            ->where('filepath', 'like', "content/series/{$seriesSlug}/%")
            ->get()
            ->map(function (PrezetDocument $doc) {
                $data = app(DocumentData::class)::fromModel($doc);
                $data->series_slug = str_replace('series/', '', $data->slug);
                $data->is_index = Str::endsWith($doc->filepath, 'index.md');

                // Optimized order extraction
                $fm = (array) $doc->frontmatter;
                $data->order = $fm['order'] ?? null;

                return $data;
            })
            ->sort(function ($a, $b) {
                if ($a->is_index && ! $b->is_index) {
                    return -1;
                }
                if (! $a->is_index && $b->is_index) {
                    return 1;
                }

                if ($a->order !== null && $b->order !== null) {
                    return (int) $a->order <=> (int) $b->order;
                }
                if ($a->order !== null) {
                    return -1;
                }
                if ($b->order !== null) {
                    return 1;
                }

                return strnatcasecmp($a->slug, $b->slug);
            })
            ->values();
    }
}
