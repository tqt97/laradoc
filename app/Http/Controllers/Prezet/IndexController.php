<?php

namespace App\Http\Controllers\Prezet;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use App\Services\SeriesService;
use App\Support\PrezetCache;
use App\Support\PrezetHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __construct(
        protected ArticleService $articleService,
        protected SeriesService $seriesService
    ) {}

    /**
     * Handle the request for the home page.
     */
    public function __invoke(): View
    {
        $version = PrezetCache::version();
        $cacheKey = "prezet_v{$version}_index_home_v3";

        $data = Cache::remember($cacheKey, 86400, function () {
            return [
                'articles' => $this->articleService->getLatestArticles(6),
                'series' => $this->seriesService->getAllSeries()->take(4),
                'seo' => [
                    'title' => 'TuanTQ | Chia sẻ kiến thức, kinh nghiệm phát triển ứng dụng web',
                    'description' => config('prezet.seo.default_description'),
                    'url' => route('prezet.index'),
                ],
            ];
        });

        return view('prezet.index', array_merge($data, PrezetHelper::getCommonData()));
    }
}
