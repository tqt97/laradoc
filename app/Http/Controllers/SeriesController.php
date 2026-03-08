<?php

namespace App\Http\Controllers;

use App\Support\PrezetCache;
use App\Support\PrezetHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Str;
use Illuminate\View\View;
use Prezet\Prezet\Data\DocumentData;
use Prezet\Prezet\Models\Document;
use Prezet\Prezet\Prezet;

class SeriesController extends Controller
{
    /**
     * Display a listing of all series.
     */
    public function index(Request $request): View
    {
        $q = $request->query('q');
        $version = PrezetCache::version();
        $cacheKey = "prezet_v{$version}_series_index_".md5($q ?? '');

        $data = Cache::remember($cacheKey, 86400, function () use ($q) {
            // A series is a sub-folder in content/series
            $query = app(Document::class)::query()
                ->where('filepath', 'like', 'content/series/%')
                ->where('draft', false);

            if ($q) {
                $query->where(function ($query) use ($q) {
                    $query->where('frontmatter->title', 'like', "%{$q}%")
                        ->orWhere('content', 'like', "%{$q}%");
                });
            }

            $docs = $query->get();

            $series = $docs->groupBy(function (Document $doc) {
                // Get the folder name after content/series/
                $parts = explode('/', str_replace('content/series/', '', $doc->filepath));

                return $parts[0];
            })->map(function ($docs, $seriesSlug) {
                // Get info for the series (from index.md or first post)
                $indexDoc = $docs->first(function ($doc) {
                    return Str::endsWith($doc->filepath, 'index.md');
                }) ?? $docs->first();

                $docData = app(DocumentData::class)::fromModel($indexDoc);
                $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

                return (object) [
                    'slug' => $seriesSlug,
                    'title' => Str::headline($seriesSlug), // Fallback title
                    'data' => $docData,
                    'postCount' => $docs->count(),
                ];
            });

            return [
                'series' => $series,
                'seo' => PrezetHelper::getSeoData('Chuỗi bài viết'),
                'search' => $q,
            ];
        });

        return view('series.index', array_merge($data, PrezetHelper::getCommonData()));
    }

    /**
     * Display a specific post within a series.
     */
    public function show(string $slug): View
    {
        // $slug will be like 'laravel-basics/introduction'
        $doc = Prezet::getDocumentModelFromSlug('series/'.$slug);

        if (! $doc) {
            abort(404);
        }

        $md = Prezet::getMarkdown($doc->filepath);
        $html = Prezet::parseMarkdown($md)->getContent();
        $docData = Prezet::getDocumentDataFromFile($doc->filepath);
        $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

        $linkedData = json_encode(Prezet::getLinkedData($docData), JSON_UNESCAPED_SLASHES);
        $headings = Prezet::getHeadings($html);

        $readingTime = PrezetHelper::calculateReadingTime($html);

        // Get all posts in this series for the sidebar
        $seriesSlug = explode('/', $slug)[0];
        $seriesPosts = app(Document::class)::query()
            ->where('filepath', 'like', "content/series/{$seriesSlug}/%")
            ->where('draft', false)
            ->get()
            ->map(function (Document $doc) {
                $data = app(DocumentData::class)::fromModel($doc);
                // Remove 'series/' prefix from slug for the series.show route
                $data->series_slug = str_replace('series/', '', $data->slug);
                $data->is_index = Str::endsWith($doc->filepath, 'index.md');

                // Since we registered CustomFrontmatterData, we can access order directly
                $data->order = $data->frontmatter->order ?? null;

                return $data;
            })
            ->sort(function ($a, $b) {
                // 1. Always put index.md first
                if ($a->is_index && ! $b->is_index) {
                    return -1;
                }
                if (! $a->is_index && $b->is_index) {
                    return 1;
                }

                // 2. Use order if available (ASC)
                $orderA = $a->order;
                $orderB = $b->order;

                if ($orderA !== null && $orderB !== null) {
                    if ($orderA != $orderB) {
                        return (int) $orderA <=> (int) $orderB;
                    }
                } elseif ($orderA !== null) {
                    return -1; // $a has order, $b doesn't -> $a comes first
                } elseif ($orderB !== null) {
                    return 1; // $b has order, $a doesn't -> $b comes first
                }

                // 3. Fallback to natural sort on slug (ASC)
                return strnatcasecmp($a->slug, $b->slug);
            })
            ->values(); // Reset keys so $index in @foreach is 0, 1, 2... in order

        return view('series.show', array_merge([
            'document' => $docData,
            'linkedData' => $linkedData,
            'headings' => $headings,
            'body' => $html,
            'readingTime' => $readingTime,
            'seriesPosts' => $seriesPosts,
            'currentSeriesSlug' => $seriesSlug,
            'seo' => [
                'title' => $docData->frontmatter->title,
                'description' => $docData->frontmatter->excerpt,
                'url' => route('prezet.series.show', str_replace('series/', '', $docData->slug)),
                'image' => $docData->frontmatter->image ? url($docData->frontmatter->image) : null,
            ],
        ], PrezetHelper::getCommonData()));
    }
}
