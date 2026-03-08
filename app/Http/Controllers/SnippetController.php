<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreSnippetRequest;
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
            'seo' => PrezetHelper::getSeoData('Snippets', 'Thư viện các đoạn mã nguồn hữu ích, giúp bạn tiết kiệm thời gian và công sức.'),
        ], PrezetHelper::getCommonData()));
    }

    public function create(): View
    {
        return view('snippets.form', array_merge([
            'snippet' => null,
            'seo' => PrezetHelper::getSeoData('Tạo Snippet mới'),
        ], PrezetHelper::getCommonData()));
    }

    public function store(StoreSnippetRequest $request): RedirectResponse
    {
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
        $snippet = $this->snippetService->getSnippetBySlug($slug);
        $md = Prezet::getMarkdown($snippet->filepath);
        $html = Prezet::parseMarkdown($md)->getContent();

        return view('snippets.show', array_merge([
            'snippet' => $snippet,
            'body' => $html,
            'slug' => $slug,
            'seo' => PrezetHelper::getSeoData($snippet->frontmatter->title, $snippet->frontmatter->excerpt),
        ], PrezetHelper::getCommonData()));
    }

    public function edit($slug): View
    {
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
        $this->snippetService->updateSnippet($slug, $request->validated());

        return redirect()->to('/snippets/'.$slug)
            ->with('success', 'Đã cập nhật snippet thành công!');
    }
}
