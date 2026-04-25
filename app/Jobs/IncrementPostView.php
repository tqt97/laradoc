<?php

namespace App\Jobs;

use App\Models\PrezetDocument;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class IncrementPostView implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(
        public int $postId
    ) {}

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        // Sử dụng model PrezetDocument đã được cấu hình connection 'prezet'
        PrezetDocument::where('id', $this->postId)->increment('views');
    }
}
