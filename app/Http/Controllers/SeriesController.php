<?php

namespace App\Http\Controllers;

use App\Services\SeriesService;
use App\Support\PrezetCache;
use App\Support\PrezetHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Prezet\Prezet\Prezet;

class SeriesController extends Controller
{
    public function __construct(
        protected SeriesService $seriesService
    ) {}

    /**
     * Display a listing of all series.
     */
    public function index(Request $request): View
    {
        $search = $request->query('q');
        $series = $this->seriesService->getAllSeries($search);

        return view('series.index', array_merge([
            'series' => $series,
            'search' => $search,
            'seo' => PrezetHelper::getSeoData('Series Lập trình Chuyên sâu', 'Khám phá các chuỗi bài viết hướng dẫn lập trình web chuyên sâu, từ cơ bản đến nâng cao tại tuantq.online.', null, config('prezet.seo.series_image')),
        ], PrezetHelper::getCommonData()));
    }

    /**
     * Display a specific post within a series.
     */
    public function show(string $slug): View
    {
        $version = PrezetCache::version();
        $cacheKey = "series_post_content_{$slug}_v{$version}";

        $cachedData = Cache::remember($cacheKey, 86400, function () use ($slug) {
            $doc = Prezet::getDocumentModelFromSlug('series/'.$slug);

            if (! $doc) {
                return null;
            }

            $md = Prezet::getMarkdown($doc->filepath);
            $html = Prezet::parseMarkdown($md)->getContent();
            $docData = Prezet::getDocumentDataFromFile($doc->filepath);

            $image = PrezetHelper::checkImageExists($docData->frontmatter->image);

            $linkedData = json_encode(Prezet::getLinkedData($docData), JSON_UNESCAPED_SLASHES);
            $headings = Prezet::getHeadings($html);
            $readingTime = PrezetHelper::calculateReadingTime($html);

            return [
                'doc_dates' => [
                    'created_at' => $doc->created_at?->toIso8601String(),
                    'updated_at' => $doc->updated_at?->toIso8601String(),
                ],
                'frontmatter' => [
                    'title' => $docData->frontmatter->title,
                    'excerpt' => $docData->frontmatter->excerpt,
                    'image' => $image,
                    'tags' => $docData->frontmatter->tags ?? [],
                ],
                'slug' => $docData->slug,
                'category' => $docData->category,
                'html' => $html,
                'linkedData' => $linkedData,
                'headings' => $headings,
                'readingTime' => $readingTime,
            ];
        });

        if (! $cachedData) {
            abort(404);
        }

        // Khôi phục Document object với đầy đủ thuộc tính cho Component
        $document = (object) [
            'slug' => $cachedData['slug'],
            'category' => $cachedData['category'],
            'frontmatter' => (object) $cachedData['frontmatter'],
            'createdAt' => $cachedData['doc_dates']['created_at'] ? Carbon::parse($cachedData['doc_dates']['created_at']) : null,
            'updatedAt' => $cachedData['doc_dates']['updated_at'] ? Carbon::parse($cachedData['doc_dates']['updated_at']) : null,
        ];

        $seriesSlug = explode('/', $slug)[0];
        $seriesPosts = $this->seriesService->getSeriesPosts($seriesSlug);

        return view('series.show', array_merge([
            'document' => $document,
            'linkedData' => $cachedData['linkedData'],
            'headings' => $cachedData['headings'],
            'body' => $cachedData['html'],
            'readingTime' => $cachedData['readingTime'],
            'seriesPosts' => $seriesPosts,
            'currentSeriesSlug' => $seriesSlug,
            'seo' => PrezetHelper::getSeoData(
                $document->frontmatter->title,
                $document->frontmatter->excerpt,
                route('prezet.series.show', str_replace('series/', '', $document->slug)),
                $document->frontmatter->image ? url($document->frontmatter->image) : null,
                [
                    'type' => 'article',
                    'published_time' => $cachedData['doc_dates']['created_at'],
                    'modified_time' => $cachedData['doc_dates']['updated_at'],
                    'section' => $document->category,
                    'tags' => $document->frontmatter->tags,
                    'author' => config('prezet.seo.author'),
                ]
            ),
        ], PrezetHelper::getCommonData()));
    }
}
