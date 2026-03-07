<?php

namespace App\Http\Controllers\Prezet;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;
use Prezet\Prezet\Data\DocumentData;
use Prezet\Prezet\Models\Document;
use Prezet\Prezet\Models\Tag;
use Prezet\Prezet\Prezet;

class IndexController
{
    public function __invoke(Request $request): View
    {
        $category = $request->input('category');
        $tag = $request->input('tag');
        $author = $request->input('author');

        $query = app(Document::class)::query()
            ->where('content_type', 'article')
            ->where('filepath', 'like', 'content/blogs%')
            ->where('draft', false);

        if ($category) {
            $query->whereRaw('LOWER(category) = ?', [strtolower($category)]);
        }

        if ($tag) {
            $query->whereHas('tags', function ($q) use ($tag) {
                $q->where('name', $tag);
            });
        }

        // Filter by author if provided
        if ($author) {
            $query->where('frontmatter->author', $author);
        }

        $currentAuthor = config('prezet.authors.'.$author);
        if ($currentAuthor) {
            $currentAuthor['image'] = $this->checkImageExists($currentAuthor['image']);
        }

        $docs = $query->orderBy('created_at', 'desc')->paginate(10)->withQueryString();

        $docsData = $docs->getCollection()->map(function (Document $doc) {
            $docData = app(DocumentData::class)::fromModel($doc);
            $md = Prezet::getMarkdown($doc->filepath);
            $html = Prezet::parseMarkdown($md)->getContent();
            $wordCount = str_word_count(strip_tags($html));
            $docData->readingTime = max(1, ceil($wordCount / 200));

            // Check post image
            $docData->frontmatter->image = $this->checkImageExists($docData->frontmatter->image);

            // Get and check author
            $authorKey = $docData->frontmatter->author;
            $authorData = config('prezet.authors.'.$authorKey, [
                'name' => 'Anonymous',
                'image' => null,
            ]);
            $authorData['image'] = $this->checkImageExists($authorData['image'] ?? null);

            // We'll wrap it in a simple object to pass to the view if DocumentData is strict
            return (object) [
                'data' => $docData,
                'author' => $authorData,
            ];
        });

        // Group posts by year
        $postsByYear = $docsData->groupBy(function ($post) {
            return $post->data->createdAt->format('Y');
        })->sortKeysDesc();

        $allCategories = app(Document::class)::query()
            ->where('content_type', 'article')
            ->where('draft', false)
            ->whereNotNull('category')
            ->select('category')
            ->selectRaw('count(*) as post_count')
            ->groupBy('category')
            ->orderBy('category')
            ->get();

        $allTags = app(Tag::class)::query()
            ->whereHas('documents', function ($q) {
                $q->where('content_type', 'article')->where('draft', false);
            })
            ->withCount(['documents' => function ($q) {
                $q->where('content_type', 'article')->where('draft', false);
            }])
            ->orderBy('name')
            ->get();

        $allPostsCount = app(Document::class)::query()
            ->where('content_type', 'article')
            ->where('draft', false)
            ->count();

        return view('prezet.index', [
            'articles' => $docsData,
            'paginator' => $docs,
            'currentTag' => $request->query('tag'),
            'currentCategory' => $request->query('category'),
            'currentAuthor' => $currentAuthor,
            'postsByYear' => $postsByYear,
            'allCategories' => $allCategories,
            'allTags' => $allTags,
            'allPostsCount' => $allPostsCount,
        ]);
    }

    /**
     * Check if an image exists on the prezet disk.
     */
    private function checkImageExists(?string $image): ?string
    {
        if (empty($image)) {
            return null;
        }

        if (str_starts_with($image, 'http')) {
            return $image;
        }

        // Remove the /prezet/img/ prefix if it exists
        $imagePath = str_replace('/prezet/img/', '', $image);
        $imagePath = 'images/'.ltrim($imagePath, '/');

        if (! Storage::disk('prezet')->exists($imagePath)) {
            return null;
        }

        return $image;
    }
}
