<?php

namespace App\Http\Controllers;

use App\Services\SeriesService;
use App\Support\PrezetHelper;
use Illuminate\Http\Request;
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
            'seo' => PrezetHelper::getSeoData('Chuỗi bài viết'),
        ], PrezetHelper::getCommonData()));
    }

    /**
     * Display a specific post within a series.
     */
    public function show(string $slug): View
    {
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

        $seriesSlug = explode('/', $slug)[0];
        $seriesPosts = $this->seriesService->getSeriesPosts($seriesSlug);

        return view('series.show', array_merge([
            'document' => $docData,
            'linkedData' => $linkedData,
            'headings' => $headings,
            'body' => $html,
            'readingTime' => $readingTime,
            'seriesPosts' => $seriesPosts,
            'currentSeriesSlug' => $seriesSlug,
            'seo' => PrezetHelper::getSeoData(
                $docData->frontmatter->title,
                $docData->frontmatter->excerpt,
                route('prezet.series.show', str_replace('series/', '', $docData->slug))
            ),
        ], PrezetHelper::getCommonData()));
    }
}
