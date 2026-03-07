<?php

namespace App\Http\Controllers;

use App\Support\PrezetCache;
use App\Support\PrezetHelper;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Prezet\Prezet\Data\DocumentData;
use Prezet\Prezet\Models\Document;
use Prezet\Prezet\Prezet;

class SnippetController extends Controller
{
    private $snippetPath = 'content/snippets';

    public function index(Request $request)
    {
        $search = $request->input('q');

        $query = Document::query()
            ->where('filepath', 'like', $this->snippetPath.'%')
            ->where('draft', false)
            ->orderBy('created_at', 'desc');

        if ($search) {
            $query->where(function ($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                    ->orWhere('excerpt', 'like', "%{$search}%");
            });
        }

        $docs = $query->paginate(20);

        $snippets = $docs->getCollection()->map(function ($doc) {
            $docData = app(DocumentData::class)::fromModel($doc);

            $filePath = base_path('prezet/'.$doc->filepath);
            if (File::exists($filePath)) {
                $content = File::get($filePath);
                if (preg_match('/language:\s*["\']?([^"\']\S+)["\']?/i', $content, $matches)) {
                    $docData->language = $matches[1];
                } else {
                    $docData->language = 'txt';
                }
            } else {
                $docData->language = 'txt';
            }

            return $docData;
        });

        return view('snippets.index', array_merge([
            'snippets' => $snippets,
            'paginator' => $docs,
            'search' => $search,
            'seo' => PrezetHelper::getSeoData('Snippets', 'Thư viện các đoạn mã nguồn hữu ích, giúp bạn tiết kiệm thời gian và công sức.'),
        ], PrezetHelper::getCommonData()));
    }

    public function create()
    {
        return view('snippets.form', array_merge([
            'snippet' => null,
            'seo' => PrezetHelper::getSeoData('Tạo Snippet mới'),
        ], PrezetHelper::getCommonData()));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'language' => 'required|string|max:50',
            'description' => 'nullable|string',
            'code' => 'required|string',
        ]);

        $slug = Str::slug($request->title);
        $filename = $slug.'.md';
        $fullPath = base_path('prezet/'.$this->snippetPath.'/'.$filename);

        $count = 1;
        while (File::exists($fullPath)) {
            $filename = $slug.'-'.$count.'.md';
            $fullPath = base_path('prezet/'.$this->snippetPath.'/'.$filename);
            $count++;
        }

        $content = $this->formatMarkdown($request);
        File::put($fullPath, $content);

        \Illuminate\Support\Facades\Artisan::call('prezet:index');
        PrezetCache::invalidate();

        $finalSlug = Str::replaceLast('.md', '', $filename);

        if ($request->has('continue')) {
            return redirect()->route('snippets.create')
                ->with('success', 'Đã lưu snippet! Bạn có thể tiếp tục tạo thêm.');
        }

        return redirect()->route('snippets.show', $finalSlug)
            ->with('success', 'Đã tạo snippet thành công!');
    }

    public function show($slug)
    {
        $fullSlug = 'snippets/'.$slug;
        $doc = Document::where('slug', $fullSlug)->firstOrFail();
        $docData = app(DocumentData::class)::fromModel($doc);

        $fullFilePath = base_path('prezet/'.$doc->filepath);
        if (File::exists($fullFilePath)) {
            $content = File::get($fullFilePath);
            if (preg_match('/language:\s*["\']?([^"\']\S+)["\']?/i', $content, $matches)) {
                $docData->language = $matches[1];
            } else {
                $docData->language = 'txt';
            }
        } else {
            $docData->language = 'txt';
        }

        $md = Prezet::getMarkdown($doc->filepath);
        $html = Prezet::parseMarkdown($md)->getContent();

        return view('snippets.show', array_merge([
            'snippet' => $docData,
            'body' => $html,
            'slug' => $slug,
            'seo' => PrezetHelper::getSeoData($docData->frontmatter->title, $docData->frontmatter->excerpt),
        ], PrezetHelper::getCommonData()));
    }

    public function edit($slug)
    {
        $fullSlug = 'snippets/'.$slug;
        $doc = Document::where('slug', $fullSlug)->firstOrFail();
        $docData = app(DocumentData::class)::fromModel($doc);

        $fullFilePath = base_path('prezet/'.$doc->filepath);
        if (! File::exists($fullFilePath)) {
            $fullFilePath = base_path($doc->filepath);
        }

        $content = File::get($fullFilePath);
        $parts = explode('---', $content);
        $rawBody = isset($parts[2]) ? trim($parts[2]) : '';

        $code = preg_replace('/^```[a-z]*\n/i', '', $rawBody);
        $code = preg_replace('/\n```$/', '', $code);

        return view('snippets.form', array_merge([
            'snippet' => $docData,
            'code' => $code,
            'slug' => $slug,
            'seo' => PrezetHelper::getSeoData('Sửa Snippet: '.$docData->frontmatter->title),
        ], PrezetHelper::getCommonData()));
    }

    public function update(Request $request, $slug)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'language' => 'required|string|max:50',
            'description' => 'nullable|string',
            'code' => 'required|string',
        ]);

        $fullSlug = 'snippets/'.$slug;
        $doc = Document::where('slug', $fullSlug)->firstOrFail();

        $content = $this->formatMarkdown($request);
        $fullPath = base_path('prezet/'.$doc->filepath);

        if (! File::exists($fullPath)) {
            return back()->withErrors(['file' => 'Không tìm thấy tệp tin snippet để cập nhật.']);
        }

        File::put($fullPath, $content);

        \Illuminate\Support\Facades\Artisan::call('prezet:index');
        PrezetCache::invalidate();

        return redirect()->to('/snippets/'.$slug)
            ->with('success', 'Đã cập nhật snippet thành công!');
    }

    private function formatMarkdown(Request $request): string
    {
        $date = now()->format('Y-m-d');
        $title = str_replace('"', '', $request->title);
        $description = str_replace('"', '', $request->description ?? '');
        $lang = $request->language;

        return <<<EOT
---
title: {$title}
excerpt: {$description}
date: {$date}
category: snippets
language: {$lang}
---

```{$lang}
{$request->code}
```
EOT;
    }
}
