<?php

namespace App\Http\Controllers\Prezet;

use App\Http\Controllers\Controller;
use App\Models\PrezetDocument;
use App\Services\ArticleService;
use App\Support\PrezetCache;
use App\Support\PrezetHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;
use Prezet\Prezet\Models\Tag;

class ArticleController extends Controller
{
    public function __construct(
        protected ArticleService $articleService
    ) {}

    /**
     * Handle the request for the all articles page.
     */
    public function __invoke(Request $request): View
    {
        $category = $request->input('category');
        $tag = $request->input('tag');
        $page = $request->input('page', 1);

        $version = PrezetCache::version();
        $cacheKey = "prezet_v{$version}_articles_p{$page}_c{$category}_t{$tag}_v3";

        $data = Cache::remember($cacheKey, 86400, function () use ($category, $tag) {
            $paginator = $this->articleService->getPaginatedArticles($category, $tag);

            $allCategories = PrezetDocument::active()
                ->blogs()
                ->whereNotNull('category')
                ->select('category')
                ->selectRaw('count(*) as post_count')
                ->groupBy('category')
                ->orderBy('category')
                ->get();

            $allTags = Tag::query()
                ->whereHas('documents', function ($q) {
                    $q->where('draft', false)
                        ->where('content_type', 'article')
                        ->where('filepath', 'like', 'content/blogs%');
                })
                ->withCount(['documents' => function ($q) {
                    $q->where('draft', false)
                        ->where('content_type', 'article')
                        ->where('filepath', 'like', 'content/blogs%');
                }])
                ->orderBy('name')
                ->get();

            $allPostsCount = PrezetDocument::active()->blogs()->count();

            // UI Titles
            $headerTitle = 'Tất cả bài viết';
            $headerSubtitle = 'Khám phá kho tàng kiến thức và kinh nghiệm thực chiến về phát triển ứng dụng web hiện đại.';
            $seoTitle = 'Tất cả bài viết';

            if ($category) {
                $headerTitle = new HtmlString('<span class="text-zinc-400 dark:text-zinc-600 block text-lg font-bold uppercase tracking-[0.2em] mb-2">Danh mục</span>'.ucfirst($category));
                $headerSubtitle = null;
                $seoTitle = 'Danh mục: '.ucfirst($category);
            } elseif ($tag) {
                $headerTitle = new HtmlString('<span class="text-zinc-400 dark:text-zinc-600 block text-lg font-bold uppercase tracking-[0.2em] mb-2">Thẻ</span>'.ucfirst($tag));
                $headerSubtitle = null;
                $seoTitle = 'Thẻ: '.ucfirst($tag);
            }

            return [
                'articles' => $paginator->getCollection(),
                'paginator' => $paginator,
                'allCategories' => $allCategories,
                'allTags' => $allTags,
                'allPostsCount' => $allPostsCount,
                'headerTitle' => $headerTitle,
                'headerSubtitle' => $headerSubtitle,
                'seo' => PrezetHelper::getSeoData($seoTitle),
                'postsByYear' => $paginator->getCollection()->groupBy(fn ($post) => $post->data->createdAt->format('Y'))->sortKeysDesc(),
            ];
        });

        return view('prezet.articles', array_merge($data, PrezetHelper::getCommonData(), [
            'currentTag' => $tag,
            'currentCategory' => $category,
        ]));
    }
}
