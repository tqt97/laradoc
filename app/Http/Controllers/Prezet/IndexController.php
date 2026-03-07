<?php

namespace App\Http\Controllers\Prezet;

use App\Http\Controllers\Controller;
use App\Support\PrezetCache;
use App\Support\PrezetHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;
use Prezet\Prezet\Data\DocumentData;
use Prezet\Prezet\Models\Document;
use Prezet\Prezet\Prezet;

class IndexController extends Controller
{
    /**
     * Handle the request for the home page.
     */
    public function __invoke(Request $request): View
    {
        $version = PrezetCache::version();
        $cacheKey = "prezet_v{$version}_index_home_latest_12";

        $data = Cache::remember($cacheKey, 86400, function () {
            $query = app(Document::class)::query()
                ->where('content_type', 'article')
                ->where('filepath', 'like', 'content/blogs%')
                ->where('draft', false);

            $docs = $query->orderBy('created_at', 'desc')->limit(12)->get();

            $articles = $docs->map(function (Document $doc) {
                $docData = app(DocumentData::class)::fromModel($doc);

                // Calculate reading time
                $md = Prezet::getMarkdown($doc->filepath);
                $readingTime = PrezetHelper::calculateReadingTime(Prezet::parseMarkdown($md)->getContent());

                // Check post image using Helper
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

            return [
                'articles' => $articles,
                'seo' => [
                    'title' => 'TuanTQ: Chia sẻ kiến thức, kinh nghiệm phát triển ứng dụng web',
                    'description' => 'Chia sẻ kiến thức lập trình, kỹ thuật xây dựng hệ thống và những bài học trong quá trình phát triển ứng dụng web',
                    'url' => route('prezet.index'),
                ],
            ];
        });

        return view('prezet.index', array_merge($data, PrezetHelper::getCommonData()));
    }
}
