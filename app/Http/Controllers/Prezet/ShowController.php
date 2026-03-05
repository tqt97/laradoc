<?php

namespace App\Http\Controllers\Prezet;

use Illuminate\Http\Request;
use Illuminate\View\View;
use Prezet\Prezet\Data\DocumentData;
use Prezet\Prezet\Models\Document;
use Prezet\Prezet\Prezet;

class ShowController
{
    public function __invoke(Request $request, string $slug): View
    {
        $doc = Prezet::getDocumentModelFromSlug($slug);
        $md = Prezet::getMarkdown($doc->filepath);
        $html = Prezet::parseMarkdown($md)->getContent();
        $docData = Prezet::getDocumentDataFromFile($doc->filepath);

        if ($docData->contentType === 'category') {
            $docs = app(Document::class)::query()
                ->where('content_type', 'article')
                ->where('draft', false)
                ->where('category', $doc->category)
                ->orderBy('created_at', 'desc')->get();

            $docsData = $docs->map(function (Document $doc) {
                $docData = app(DocumentData::class)::fromModel($doc);
                $md = Prezet::getMarkdown($doc->filepath);
                $html = Prezet::parseMarkdown($md)->getContent();
                $wordCount = str_word_count(strip_tags($html));
                $docData->readingTime = max(1, ceil($wordCount / 200));

                return $docData;
            });

            return view('prezet.category', [
                'document' => $docData,
                'body' => $html,
                'docs' => $docsData,
            ]);
        }

        $linkedData = json_encode(Prezet::getLinkedData($docData), JSON_UNESCAPED_SLASHES);
        $headings = Prezet::getHeadings($html);
        $authorKey = $docData->frontmatter->author;
        $author = config('prezet.authors.'.$authorKey, [
            'name' => 'Anonymous',
            'image' => '',
            'bio' => '',
        ]);

        // Calculate reading time
        $wordCount = str_word_count(strip_tags($html));
        $readingTime = max(1, ceil($wordCount / 200));

        // Fetch related posts
        $relatedPosts = app(Document::class)::query()
            ->where('content_type', 'article')
            ->where('draft', false)
            ->where('category', $doc->category)
            ->where('slug', '!=', $slug)
            ->limit(4)
            ->get()
            ->map(function (Document $doc) {
                $docData = app(DocumentData::class)::fromModel($doc);
                $md = Prezet::getMarkdown($doc->filepath);
                $html = Prezet::parseMarkdown($md)->getContent();
                $wordCount = str_word_count(strip_tags($html));
                $docData->readingTime = max(1, ceil($wordCount / 200));

                return $docData;
            });

        return view('prezet.show', [
            'document' => $docData,
            'linkedData' => $linkedData,
            'headings' => $headings,
            'body' => $html,
            'author' => $author,
            'readingTime' => $readingTime,
            'relatedPosts' => $relatedPosts,
        ]);
    }
}
