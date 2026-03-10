<?php

namespace App\Console\Commands;

use App\Mail\IdeaPublished;
use App\Models\Idea;
use App\Models\PrezetDocument;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SyncPublishedIdeas extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'idea:sync-published';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sync published Prezet documents with Ideas table and notify users';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Starting idea synchronization...');

        // We use whereJsonContains or whereNotNull on the JSON field if possible,
        // but since it's a dynamic frontmatter, let's pull those that might have it.
        $documents = PrezetDocument::whereNotNull('frontmatter->idea_id')->get();

        if ($documents->isEmpty()) {
            $this->warn('No documents found with linked idea_id.');

            return 0;
        }

        $count = 0;

        foreach ($documents as $doc) {
            $ideaId = $doc->frontmatter->idea_id;

            if (! $ideaId) {
                continue;
            }

            $idea = Idea::find($ideaId);

            if ($idea && $idea->status === 'submitted') {
                $this->info("Found new published post for Idea #{$idea->id}: {$doc->slug}");

                // Update Idea
                $idea->update([
                    'status' => 'published',
                    'post_slug' => $doc->slug,
                ]);

                // Notify User if email exists
                if ($idea->email) {
                    $this->info("Queuing notification email to: {$idea->email}");
                    Mail::to($idea->email)->queue(new IdeaPublished($idea, $doc));
                } else {
                    $this->warn("No email provided for Idea #{$idea->id}, skipping notification.");
                }

                $count++;
            }
        }

        if ($count > 0) {
            $this->info("Successfully synced and notified for {$count} ideas.");
        } else {
            $this->info('All linked ideas are already up to date.');
        }

        return 0;
    }
}
