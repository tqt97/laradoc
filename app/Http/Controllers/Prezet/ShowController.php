<?php

namespace App\Http\Controllers\Prezet;

use App\Http\Controllers\Controller;
use App\Models\PrezetDocument;
use App\Services\ArticleService;
use App\Support\PrezetHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prezet\Prezet\Prezet;

class ShowController extends Controller
{
    public function __construct(
        protected ArticleService $articleService
    ) {}

    /**
     * Handle the request for a specific article.
     */
    public function __invoke(Request $request, string $slug = ''): View
    {
        if (empty($slug)) {
            abort(404);
        }

        $doc = PrezetDocument::where('slug', $slug)->first();

        if (! $doc) {
            abort(404);
        }

        // Increment views
        $sessionKey = 'viewed_post_'.$doc->id;
        if (! session()->has($sessionKey)) {
            $doc->increment('views');
            session()->put($sessionKey, true);
        }

        $md = Prezet::getMarkdown($doc->filepath);
        $html = Prezet::parseMarkdown($md)->getContent();
        $docData = Prezet::getDocumentDataFromFile($doc->filepath);
        $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

        // If it's a category page (handled by Prezet as a document sometimes)
        if ($docData->frontmatter->contentType === 'category') {
            $docs = PrezetDocument::active()
                ->whereRaw('LOWER(category) = ?', [strtolower($doc->category)])
                ->orderBy('created_at', 'desc')
                ->get()
                ->map(fn ($d) => $this->articleService->mapToArticleData($d));

            return view('prezet.category', array_merge([
                'document' => $docData,
                'body' => $html,
                'docs' => $docs,
                'seo' => PrezetHelper::getSeoData('Danh mục: '.$doc->category),
            ], PrezetHelper::getCommonData()));
        }

        $linkedData = json_encode(Prezet::getLinkedData($docData), JSON_UNESCAPED_SLASHES);
        $headings = Prezet::getHeadings($html);
        $readingTime = PrezetHelper::calculateReadingTime($html);

        // Fetch related posts
        $relatedPosts = PrezetDocument::active()
            ->blogs()
            ->where('category', $doc->category)
            ->where('slug', '!=', $slug)
            ->limit(4)
            ->get()
            ->map(fn ($d) => $this->articleService->mapToArticleData($d));

        return view('prezet.show', array_merge([
            'document' => $docData,
            'views' => $doc->views,
            'linkedData' => $linkedData,
            'headings' => $headings,
            'body' => $html,
            'readingTime' => $readingTime,
            'relatedPosts' => $relatedPosts,
            'seo' => PrezetHelper::getSeoData(
                $docData->frontmatter->title,
                $docData->frontmatter->excerpt,
                route('prezet.show', $docData->slug),
                $docData->frontmatter->image ? url($docData->frontmatter->image) : null,
                [
                    'type' => 'article',
                    'published_time' => $doc->created_at?->toIso8601String(),
                    'modified_time' => $doc->updated_at?->toIso8601String(),
                    'section' => $docData->category,
                    'tags' => $docData->frontmatter->tags ?? [],
                    'author' => config('prezet.seo.author'),
                ]
            ),
        ], PrezetHelper::getCommonData()));
    }
}
