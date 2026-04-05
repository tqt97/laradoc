<?php

namespace App\Jobs;

use App\Models\File;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcessFileUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected string $fileName,
        protected string $tempId,
        protected int $totalChunks,
        protected string $mimeType,
        protected int $totalSize
    ) {}

    public function handle(): void
    {
        $finalPath = 'uploads/'.Str::random(40).'.'.pathinfo($this->fileName, PATHINFO_EXTENSION);
        $tempDisk = Storage::disk('local');
        $finalDisk = Storage::disk('public');

        // Ensure directory exists
        if (! $finalDisk->exists('uploads')) {
            $finalDisk->makeDirectory('uploads');
        }

        $finalFilePath = $finalDisk->path($finalPath);
        $fileHandle = fopen($finalFilePath, 'ab');

        for ($i = 0; $i < $this->totalChunks; $i++) {
            $chunkPath = "chunks/{$this->tempId}/{$i}";
            if ($tempDisk->exists($chunkPath)) {
                $chunkContent = $tempDisk->get($chunkPath);
                fwrite($fileHandle, $chunkContent);
                $tempDisk->delete($chunkPath);
            }
        }

        fclose($fileHandle);
        $tempDisk->deleteDirectory("chunks/{$this->tempId}");

        File::create([
            'name' => $this->fileName,
            'path' => $finalPath,
            'mime_type' => $this->mimeType,
            'size' => $this->totalSize,
            'disk' => 'public',
            'share_token' => (string) Str::uuid(),
        ]);
    }
}
