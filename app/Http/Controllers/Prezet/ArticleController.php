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
        $page = $request->input('page', 1);

        // Cache danh mục và thẻ riêng để tối ưu
        $allCategories = Cache::remember("prezet_v{$version}_categories", 86400, function () {
            return PrezetDocument::active()
                ->blogs()
                ->whereNotNull('category')
                ->select('category')
                ->selectRaw('count(*) as post_count')
                ->groupBy('category')
                ->orderBy('category')
                ->get();
        });

        $allTags = Cache::remember("prezet_v{$version}_tags", 86400, function () {
            return Tag::query()
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
                ->orderByDesc('documents_count')
                ->orderBy('name')
                ->limit(30)
                ->get();
        });

        $allPostsCount = Cache::remember("prezet_v{$version}_all_posts_count", 86400, function () {
            return PrezetDocument::active()->blogs()->count();
        });

        // Chỉ cache kết quả bài viết theo trang và filter
        $paginator = Cache::remember("prezet_v{$version}_articles_p{$page}_c{$category}_t{$tag}", 86400, function () use ($category, $tag) {
            return $this->articleService->getPaginatedArticles($category, $tag);
        });

        // UI Titles logic
        $headerTitle = 'Kiến thức Lập trình';
        $headerSubtitle = 'Tổng hợp các bài viết kỹ thuật, hướng dẫn lập trình và kinh nghiệm thực chiến từ tuantq.online.';
        $seoTitle = 'Tất cả bài viết kỹ thuật';

        if ($category) {
            $headerTitle = new HtmlString('<span class="text-zinc-400 dark:text-zinc-600 block text-lg font-bold uppercase tracking-[0.2em] mb-2">Danh mục</span>'.ucfirst($category));
            $headerSubtitle = 'Khám phá bài viết thuộc danh mục '.ucfirst($category).' tại tuantq.online.';
            $seoTitle = 'Danh mục: '.ucfirst($category);
        } elseif ($tag) {
            $headerTitle = new HtmlString('<span class="text-zinc-400 dark:text-zinc-600 block text-lg font-bold uppercase tracking-[0.2em] mb-2">Thẻ</span>'.ucfirst($tag));
            $headerSubtitle = 'Các bài viết về '.ucfirst($tag).' trên tuantq.online.';
            $seoTitle = 'Thẻ: '.ucfirst($tag);
        }

        return view('prezet.articles', array_merge(PrezetHelper::getCommonData(), [
            'articles' => $paginator->getCollection(),
            'paginator' => $paginator,
            'allCategories' => $allCategories,
            'allTags' => $allTags,
            'allPostsCount' => $allPostsCount,
            'headerTitle' => $headerTitle,
            'headerSubtitle' => $headerSubtitle,
            'seo' => PrezetHelper::getSeoData($seoTitle, $headerSubtitle, null, config('prezet.seo.articles_image')),
            'postsByYear' => $paginator->getCollection()->groupBy(fn ($post) => $post->data->createdAt->format('Y'))->sortKeysDesc(),
            'currentTag' => $tag,
            'currentCategory' => $category,
        ]));
    }
}
