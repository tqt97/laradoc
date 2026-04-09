<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use Spatie\LaravelMarkdown\MarkdownRenderer;

class FilePreviewService
{
    public function render(File $file): string
    {
        $extension = pathinfo($file->name, PATHINFO_EXTENSION);

        if (in_array(strtolower($extension), ['md', 'markdown'])) {
            return $this->md($file);
        }

        return match ($file->mime_type) {
            'text/plain' => $this->txt($file),
            'text/markdown', 'text/x-markdown' => $this->md($file),
            'application/pdf' => $this->pdf($file),
            default => abort(415),
        };
    }

    private function txt(File $file): string
    {
        $content = Storage::disk($file->disk)->get($file->path);

        return '<div class="w-full h-full p-8"><pre class="h-full p-6 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl overflow-auto text-sm border border-zinc-100 dark:border-zinc-800 whitespace-pre-wrap">'.e($content).'</pre></div>';
    }

    private function md(File $file): string
    {
        $content = Storage::disk($file->disk)->get($file->path);

        $html = app(MarkdownRenderer::class)->toHtml($content);

        return "<div class='max-w-6xl mx-auto py-16 px-6 lg:px-12'>
                    <div class='prose prose-zinc dark:prose-invert max-w-none prose-lg'>
                        $html
                    </div>
                </div>";
    }

    private function pdf(File $file): string
    {
        // Use relative URL to avoid APP_URL issues
        $url = '/storage/'.$file->path;

        return "<div class='w-full h-full bg-zinc-100 dark:bg-zinc-900 overflow-hidden'>
                    <iframe src='{$url}' class='w-full h-full border-0' allowfullscreen></iframe>
                </div>";
    }
}
