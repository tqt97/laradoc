<?php

namespace App\Jobs;

use App\Enums\FileModerationStatus;
use App\Enums\FileUploadStatus;
use App\Mail\FileApprovalRequest;
use App\Models\File;
use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ProcessFileUpload implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(
        protected File $fileRecord,
        protected string $tempId,
        protected int $totalChunks
    ) {}

    public function handle(): void
    {
        $finalPath = 'uploads/'.Str::random(40).'.'.pathinfo($this->fileRecord->name, PATHINFO_EXTENSION);
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

        $this->fileRecord->update([
            'path' => $finalPath,
            'status_upload' => FileUploadStatus::READY,
        ]);

        // Send email to admin if guest upload
        if ($this->fileRecord->status_moderation === FileModerationStatus::PENDING) {
            $admin = User::role('admin')->first() ?? User::where('email', 'admin@example.com')->first();
            $adminEmail = $admin ? $admin->email : config('mail.from.address');

            Mail::to($adminEmail)->send(new FileApprovalRequest($this->fileRecord));
        }
    }
}
