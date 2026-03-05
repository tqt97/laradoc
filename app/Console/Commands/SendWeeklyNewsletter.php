<?php

namespace App\Console\Commands;

use App\Mail\WeeklyNewsletter;
use App\Models\Subscriber;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;
use Prezet\Prezet\Data\DocumentData;
use Prezet\Prezet\Models\Document;

class SendWeeklyNewsletter extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'newsletter:send-weekly';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Send the weekly newsletter to subscribers';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $lastWeek = now()->subDays(7);
        $articles = app(Document::class)::query()
            ->where('content_type', 'article')
            ->where('draft', false)
            ->where('created_at', '>=', $lastWeek)
            ->orderBy('created_at', 'desc')
            ->get()
            ->map(fn (Document $doc) => app(DocumentData::class)::fromModel($doc));

        if ($articles->isEmpty()) {
            $this->info('No new articles this week. Skipping newsletter.');

            return;
        }

        $subscribers = Subscriber::where('is_active', true)->get();

        if ($subscribers->isEmpty()) {
            $this->info('No active subscribers found.');

            return;
        }

        foreach ($subscribers as $subscriber) {
            Mail::to($subscriber->email)->send(new WeeklyNewsletter($articles));
        }

        $this->info('Weekly newsletter sent to '.$subscribers->count().' subscribers.');
    }
}
