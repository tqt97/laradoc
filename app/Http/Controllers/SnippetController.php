<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSnippetRequest;
use App\Models\PrezetDocument;
use App\Services\SnippetService;
use App\Support\PrezetHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Prezet\Prezet\Prezet;

class SnippetController extends Controller
{
    public function __construct(
        protected SnippetService $snippetService
    ) {}

    public function index(Request $request): View
    {
        $search = $request->input('q');
        $data = $this->snippetService->getPaginatedSnippets($search);

        return view('snippets.index', array_merge([
            'snippets' => $data['snippets'],
            'paginator' => $data['paginator'],
            'search' => $search,
            'seo' => PrezetHelper::getSeoData('Code Snippets & Thủ thuật Lập trình', 'Thư viện các đoạn mã nguồn hữu ích, thủ thuật code và giải pháp kỹ thuật giúp tối ưu hóa quá trình phát triển web.', null, config('prezet.seo.snippets_image')),
        ], PrezetHelper::getCommonData()));
    }

    public function create(): View
    {
        $this->authorize('manage-snippets');

        return view('snippets.form', array_merge([
            'snippet' => null,
            'seo' => PrezetHelper::getSeoData('Tạo Snippet mới'),
        ], PrezetHelper::getCommonData()));
    }

    public function store(StoreSnippetRequest $request): RedirectResponse
    {
        $this->authorize('manage-snippets');

        $finalSlug = $this->snippetService->createSnippet($request->validated());

        if ($request->has('continue')) {
            return redirect()->route('snippets.create')
                ->with('success', 'Đã lưu snippet! Bạn có thể tiếp tục tạo thêm.');
        }

        return redirect()->route('snippets.show', $finalSlug)
            ->with('success', 'Đã tạo snippet thành công!');
    }

    public function show($slug): View
    {
        $doc = PrezetDocument::where('slug', 'snippets/'.$slug)->firstOrFail();

        // Increment views
        $sessionKey = 'viewed_post_'.$doc->id;
        if (! session()->has($sessionKey)) {
            $doc->increment('views');
            session()->put($sessionKey, true);
        }

        $snippet = $this->snippetService->getSnippetBySlug($slug);
        $md = Prezet::getMarkdown($snippet->filepath);
        $html = Prezet::parseMarkdown($md)->getContent();

        return view('snippets.show', array_merge([
            'snippet' => $snippet,
            'views' => $doc->views,
            'body' => $html,
            'slug' => $slug,
            'seo' => PrezetHelper::getSeoData(
                $snippet->frontmatter->title,
                $snippet->frontmatter->excerpt,
                null,
                $snippet->frontmatter->image ? url($snippet->frontmatter->image) : null,
                [
                    'type' => 'article',
                    'published_time' => $snippet->createdAt?->toIso8601String(),
                    'section' => 'Snippets',
                    'tags' => $snippet->frontmatter->tags ?? [],
                    'author' => config('prezet.seo.author'),
                ]
            ),
        ], PrezetHelper::getCommonData()));
    }

    public function edit($slug): View
    {
        $this->authorize('manage-snippets');

        $snippet = $this->snippetService->getSnippetBySlug($slug);
        $code = $this->snippetService->getRawCode($snippet->filepath);

        return view('snippets.form', array_merge([
            'snippet' => $snippet,
            'code' => $code,
            'slug' => $slug,
            'seo' => PrezetHelper::getSeoData('Sửa Snippet: '.$snippet->frontmatter->title),
        ], PrezetHelper::getCommonData()));
    }

    public function update(StoreSnippetRequest $request, $slug): RedirectResponse
    {
        $this->authorize('manage-snippets');

        $this->snippetService->updateSnippet($slug, $request->validated());

        return redirect()->to('/snippets/'.$slug)
            ->with('success', 'Đã cập nhật snippet thành công!');
    }
}
