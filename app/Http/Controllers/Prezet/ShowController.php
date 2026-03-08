<?php

namespace App\Http\Controllers\Prezet;

use App\Http\Controllers\Controller;
use App\Support\PrezetHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;
use Prezet\Prezet\Data\DocumentData;
use Prezet\Prezet\Models\Document;
use Prezet\Prezet\Prezet;

class ShowController extends Controller
{
    public function __invoke(Request $request, string $slug): View
    {
        $doc = Prezet::getDocumentModelFromSlug($slug);
        $md = Prezet::getMarkdown($doc->filepath);
        $html = Prezet::parseMarkdown($md)->getContent();
        $docData = Prezet::getDocumentDataFromFile($doc->filepath);

        // Check if post image exists using Helper
        $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

        if ($docData->contentType === 'category') {
            $docs = app(Document::class)::query()
                ->where('content_type', 'article')
                ->where('filepath', 'like', 'content/blogs%')
                ->where('draft', false)
                ->where('category', $doc->category)
                ->orderBy('created_at', 'desc')->get();

            $docsData = $docs->map(function (Document $doc) {
                $docData = app(DocumentData::class)::fromModel($doc);

                // Calculate reading time
                $md = Prezet::getMarkdown($doc->filepath);
                $readingTime = PrezetHelper::calculateReadingTime(Prezet::parseMarkdown($md)->getContent());

                // Check image
                $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

                return (object) [
                    'data' => $docData,
                    'readingTime' => $readingTime,
                ];
            });

            return view('prezet.category', array_merge([
                'document' => $docData,
                'body' => $html,
                'docs' => $docsData,
                'seo' => PrezetHelper::getSeoData('Danh mục: '.$doc->category),
            ], PrezetHelper::getCommonData()));
        }

        $linkedData = json_encode(Prezet::getLinkedData($docData), JSON_UNESCAPED_SLASHES);
        $headings = Prezet::getHeadings($html);

        // Calculate reading time
        $readingTime = PrezetHelper::calculateReadingTime($html);

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

                // Calculate reading time for related posts
                $md = Prezet::getMarkdown($doc->filepath);
                $readingTime = PrezetHelper::calculateReadingTime(Prezet::parseMarkdown($md)->getContent());

                // Check image
                $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

                return (object) [
                    'data' => $docData,
                    'readingTime' => $readingTime,
                ];
            });

        return view('prezet.show', array_merge([
            'document' => $docData,
            'linkedData' => $linkedData,
            'headings' => $headings,
            'body' => $html,
            'readingTime' => $readingTime,
            'relatedPosts' => $relatedPosts,
            'seo' => [
                'title' => $docData->frontmatter->title,
                'description' => $docData->frontmatter->excerpt,
                'url' => route('prezet.show', $docData->slug),
                'image' => $docData->frontmatter->image ? url($docData->frontmatter->image) : null,
            ],
        ], PrezetHelper::getCommonData()));
    }
}
