<?php

namespace App\Http\Controllers;

use App\Services\KnowledgeService;
use App\Support\PrezetHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Prezet\Prezet\Prezet;

class KnowledgeController extends Controller
{
    public function __construct(
        protected KnowledgeService $knowledgeService
    ) {}

    public function index(Request $request): View
    {
        $search = $request->input('q');
        $data = $this->knowledgeService->getPaginatedKnowledge($search);

        return view('knowledge.index', array_merge([
            'knowledge' => $data['knowledge'],
            'paginator' => $data['paginator'],
            'search' => $search,
            'seo' => PrezetHelper::getSeoData('Review Kiến thức Lập trình', 'Thư viện các kiến thức lập trình được tóm tắt và đúc kết dưới dạng các thẻ kiến thức dễ nhớ, dễ ôn tập.', null, config('prezet.seo.default_image')),
        ], PrezetHelper::getCommonData()));
    }

    public function show($slug): View
    {
        $knowledge = $this->knowledgeService->getKnowledgeBySlug($slug);
        $md = Prezet::getMarkdown($knowledge->filepath);
        $html = Prezet::parseMarkdown($md)->getContent();

        return view('knowledge.show', array_merge([
            'knowledge' => $knowledge,
            'body' => $html,
            'slug' => $slug,
            'seo' => PrezetHelper::getSeoData(
                $knowledge->frontmatter->title,
                $knowledge->frontmatter->excerpt,
                null,
                $knowledge->frontmatter->image ? url($knowledge->frontmatter->image) : null,
                [
                    'type' => 'article',
                    'published_time' => $knowledge->createdAt?->toIso8601String(),
                    'section' => 'Knowledge',
                    'tags' => $knowledge->frontmatter->tags ?? [],
                    'author' => config('prezet.seo.author'),
                ]
            ),
        ], PrezetHelper::getCommonData()));
    }
}
