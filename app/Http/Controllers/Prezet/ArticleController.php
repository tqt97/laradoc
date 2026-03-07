<?php

namespace App\Http\Controllers\Prezet;

use App\Http\Controllers\Controller;
use App\Support\PrezetCache;
use App\Support\PrezetHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\HtmlString;
use Illuminate\View\View;
use Prezet\Prezet\Data\DocumentData;
use Prezet\Prezet\Models\Document;
use Prezet\Prezet\Models\Tag;
use Prezet\Prezet\Prezet;

class ArticleController extends Controller
{
    /**
     * Handle the request for the all articles page.
     */
    public function __invoke(Request $request): View
    {
        $category = $request->input('category');
        $tag = $request->input('tag');
        $author = $request->input('author');
        $page = $request->get('page', 1);

        $version = PrezetCache::version();
        $cacheKey = "prezet_v{$version}_articles_p{$page}_c{$category}_t{$tag}_a{$author}";

        $data = Cache::remember($cacheKey, 86400, function () use ($category, $tag, $author) {
            $query = app(Document::class)::query()
                ->where('content_type', 'article')
                ->where('filepath', 'like', 'content/blogs%')
                ->where('draft', false);

            if ($category) {
                $query->whereRaw('LOWER(category) = ?', [strtolower($category)]);
            } elseif ($tag) {
                $query->whereHas('tags', function ($q) use ($tag) {
                    $q->where('name', $tag);
                });
            } elseif ($author) {
                $query->where('frontmatter->author', $author);
            }

            $currentAuthor = config('prezet.authors.'.$author);
            if ($currentAuthor) {
                $currentAuthor['image'] = PrezetHelper::checkImageExists($currentAuthor['image']);
            }

            $docs = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

            $docsData = $docs->getCollection()->map(function (Document $doc) {
                $docData = app(DocumentData::class)::fromModel($doc);

                // Calculate reading time
                $md = Prezet::getMarkdown($doc->filepath);
                $readingTime = PrezetHelper::calculateReadingTime(Prezet::parseMarkdown($md)->getContent());

                // Check post image
                $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);
                // Get and check author
                $authorKey = $docData->frontmatter->author;
                $authorData = config('prezet.authors.'.$authorKey, [
                    'name' => 'Anonymous',
                    'image' => null,
                ]);
                $authorData['image'] = PrezetHelper::checkImageExists($authorData['image'] ?? null);

                return (object) [
                    'data' => $docData,
                    'author' => $authorData,
                    'readingTime' => $readingTime,
                ];
            });

            // Group posts by year
            $postsByYear = $docsData->groupBy(function ($post) {
                return $post->data->createdAt->format('Y');
            })->sortKeysDesc();

            $allCategories = app(Document::class)::query()
                ->where('content_type', 'article')
                ->where('draft', false)
                ->where('filepath', 'like', 'content/blogs%')
                ->whereNotNull('category')
                ->select('category')
                ->selectRaw('count(*) as post_count')
                ->groupBy('category')
                ->orderBy('category')
                ->get();

            $allTags = app(Tag::class)::query()
                ->whereHas('documents', function ($q) {
                    $q->where('content_type', 'article')
                        ->where('draft', false)
                        ->where('filepath', 'like', 'content/blogs%');
                })
                ->withCount(['documents' => function ($q) {
                    $q->where('content_type', 'article')
                        ->where('draft', false)
                        ->where('filepath', 'like', 'content/blogs%');
                }])
                ->orderBy('name')
                ->get();

            $allPostsCount = app(Document::class)::query()
                ->where('content_type', 'article')
                ->where('draft', false)
                ->where('filepath', 'like', 'content/blogs%')
                ->count();

            // UI Logic moved to Controller
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
            } elseif ($author) {
                $headerTitle = new HtmlString('<span class="text-zinc-400 dark:text-zinc-600 block text-lg font-bold uppercase tracking-[0.2em] mb-2">Tác giả</span>'.($currentAuthor['name'] ?? 'Anonymous'));
                $headerSubtitle = null;
                $seoTitle = 'Tác giả: '.($currentAuthor['name'] ?? 'Anonymous');
            }

            return [
                'articles' => $docsData,
                'paginator' => $docs,
                'currentAuthor' => $currentAuthor,
                'postsByYear' => $postsByYear,
                'allCategories' => $allCategories,
                'allTags' => $allTags,
                'allPostsCount' => $allPostsCount,
                'headerTitle' => $headerTitle,
                'headerSubtitle' => $headerSubtitle,
                'seo' => PrezetHelper::getSeoData($seoTitle),
            ];
        });

        return view('prezet.articles', array_merge($data, PrezetHelper::getCommonData(), [
            'currentTag' => $tag,
            'currentCategory' => $category,
        ]));
    }
}
