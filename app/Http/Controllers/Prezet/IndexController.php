<?php

namespace App\Http\Controllers\Prezet;

use App\Http\Controllers\Controller;
use App\Services\ArticleService;
use App\Services\KnowledgeService;
use App\Services\SeriesService;
use App\Support\PrezetCache;
use App\Support\PrezetHelper;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class IndexController extends Controller
{
    public function __construct(
        protected ArticleService $articleService,
        protected SeriesService $seriesService,
        protected KnowledgeService $knowledgeService
    ) {}

    /**
     * Handle the request for the home page.
     */
    public function __invoke(): View
    {
        $version = PrezetCache::version();
        $cacheKey = "prezet_v{$version}_index_home_v5";

        $data = Cache::remember($cacheKey, 86400, function () {
            return [
                'articles' => $this->articleService->getLatestArticles(5),
                'articlesByCategory' => $this->articleService->getArticlesByCategory(4),
                'series' => $this->seriesService->getAllSeries()->take(4),
                'knowledgeArticles' => $this->knowledgeService->getPaginatedKnowledge(perPage: 8)['knowledge'],
                'seo' => [
                    'title' => 'tuantq.online | Blog Chia sẻ Kiến thức & Kinh nghiệm Lập trình Web',
                    'description' => 'Chào mừng bạn đến với tuantq.online - Blog chuyên sâu về phát triển ứng dụng web, kiến trúc hệ thống, code snippets và những ghi chép kỹ thuật giá trị.',
                    'url' => route('prezet.index'),
                    'image' => url('/images/og/home.svg'), // Using SVG as it's cleaner and scalable
                ],
            ];
        });

        return view('prezet.index', array_merge($data, PrezetHelper::getCommonData()));
    }
}
