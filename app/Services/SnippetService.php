<?php

namespace App\Services;

use App\Models\PrezetDocument;
use App\Support\PrezetCache;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Prezet\Prezet\Data\DocumentData;

class SnippetService
{
    private string $snippetPath = 'content/snippets';

    /**
     * Get paginated snippets with search.
     */
    public function getPaginatedSnippets(?string $search = null, int $perPage = 20): array
    {
        $query = PrezetDocument::active()->snippets()->orderBy('created_at', 'desc');

        if ($search) {
            $query->search($search);
        }

        $docs = $query->paginate($perPage);

        $snippets = $docs->getCollection()->map(function ($doc) {
            $docData = app(DocumentData::class)::fromModel($doc);
            $docData->language = $this->extractLanguage($doc->filepath);

            return $docData;
        });

        return [
            'snippets' => $snippets,
            'paginator' => $docs,
        ];
    }

    /**
     * Get a specific snippet by slug.
     */
    public function getSnippetBySlug(string $slug): DocumentData
    {
        $doc = PrezetDocument::where('slug', 'snippets/'.$slug)->firstOrFail();
        $docData = app(DocumentData::class)::fromModel($doc);
        $docData->language = $this->extractLanguage($doc->filepath);
        $docData->filepath = $doc->filepath; // Keep for markdown reading

        return $docData;
    }

    /**
     * Create a new snippet file.
     */
    public function createSnippet(array $data): string
    {
        $slug = Str::slug($data['title']);
        $filename = $slug.'.md';
        $fullPath = base_path('prezet/'.$this->snippetPath.'/'.$filename);

        $count = 1;
        while (File::exists($fullPath)) {
            $filename = $slug.'-'.$count.'.md';
            $fullPath = base_path('prezet/'.$this->snippetPath.'/'.$filename);
            $count++;
        }

        $content = $this->formatMarkdown($data);
        File::put($fullPath, $content);

        $this->refreshIndex();

        return Str::replaceLast('.md', '', $filename);
    }

    /**
     * Update an existing snippet file.
     */
    public function updateSnippet(string $slug, array $data): void
    {
        $doc = PrezetDocument::where('slug', 'snippets/'.$slug)->firstOrFail();
        $content = $this->formatMarkdown($data);
        $fullPath = base_path('prezet/'.$doc->filepath);

        if (! File::exists($fullPath)) {
            throw new \Exception('Snippet file not found.');
        }

        File::put($fullPath, $content);
        $this->refreshIndex();
    }

    /**
     * Extract raw code from markdown file.
     */
    public function getRawCode(string $filepath): string
    {
        $fullPath = base_path('prezet/'.$filepath);
        if (! File::exists($fullPath)) {
            $fullPath = base_path($filepath);
        }

        $content = File::get($fullPath);
        $parts = explode('---', $content);
        $rawBody = isset($parts[2]) ? trim($parts[2]) : '';

        $code = preg_replace('/^```[a-z]*\n/i', '', $rawBody);
        $code = preg_replace('/\n```$/', '', $code);

        return $code;
    }

    private function extractLanguage(string $filepath): string
    {
        $fullPath = base_path('prezet/'.$filepath);
        if (File::exists($fullPath)) {
            $content = File::get($fullPath);
            if (preg_match('/language:\s*["\']?([^"\']\S+)["\']?/i', $content, $matches)) {
                return $matches[1];
            }
        }

        return 'txt';
    }

    private function formatMarkdown(array $data): string
    {
        $date = now()->format('Y-m-d');
        $title = str_replace('"', '', $data['title']);
        $description = str_replace('"', '', $data['description'] ?? '');
        $lang = $data['language'];

        return <<<EOT
---
title: {$title}
excerpt: {$description}
date: {$date}
category: snippets
language: {$lang}
---

```{$lang}
{$data['code']}
```
EOT;
    }

    private function refreshIndex(): void
    {
        Artisan::call('prezet:index');
        PrezetCache::invalidate();
    }
}
