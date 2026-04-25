<?php

namespace App\Console\Commands;

use App\Models\PrezetDocument;
use Illuminate\Console\Command;

class FakeViews extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'prezet:fake-views {min=1} {max=50}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Gán số lượt xem ngẫu nhiên cho toàn bộ bài viết Prezet';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $min = (int) $this->argument('min');
        $max = (int) $this->argument('max');

        $this->info("Đang cập nhật lượt xem ngẫu nhiên từ $min đến $max...");

        $docs = PrezetDocument::all();
        $bar = $this->output->createProgressBar(count($docs));

        $bar->start();

        foreach ($docs as $doc) {
            $doc->views = rand($min, $max);
            $doc->save();
            $bar->advance();
        }

        $bar->finish();
        $this->newLine();
        $this->info('Đã cập nhật thành công cho '.count($docs).' bài viết!');
    }
}
