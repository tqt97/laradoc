<?php

namespace App\Services;

use App\Models\File;
use Illuminate\Support\Facades\Storage;
use League\CommonMark\CommonMarkConverter;

class FilePreviewService
{
    public function render(File $file): string
    {
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

        return '<pre class="p-6 bg-zinc-50 dark:bg-zinc-900/50 rounded-2xl overflow-auto text-sm border border-zinc-100 dark:border-zinc-800">'.e($content).'</pre>';
    }

    private function md(File $file): string
    {
        $content = Storage::disk($file->disk)->get($file->path);

        $converter = new CommonMarkConverter;
        $html = (string) $converter->convert($content);

        return "<div class='prose prose-zinc dark:prose-invert max-w-none'>".$html.'</div>';
    }

    private function pdf(File $file): string
    {
        // Use relative URL to avoid APP_URL issues
        $url = '/storage/'.$file->path;

        return "<iframe src='{$url}' class='w-full h-[800px] border-0 rounded-2xl bg-zinc-100 dark:bg-zinc-900 shadow-inner' allowfullscreen></iframe>";
    }
}
