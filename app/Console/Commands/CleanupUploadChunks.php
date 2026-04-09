<?php

namespace App\Console\Commands;

use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Storage;

class CleanupUploadChunks extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:cleanup-chunks {--hours=24 : Xóa các chunks cũ hơn số giờ này}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Dọn dẹp các tệp tin chunk tải lên bị gián đoạn hoặc quá cũ';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $hours = $this->option('hours');
        $disk = Storage::disk('local');
        $directory = 'chunks';

        if (! $disk->exists($directory)) {
            $this->info('Không tìm thấy thư mục chunks. Không có gì để dọn dẹp.');

            return;
        }

        $directories = $disk->directories($directory);
        $count = 0;
        $now = Carbon::now();

        foreach ($directories as $dir) {
            // Lấy thời gian sửa đổi cuối cùng của thư mục
            $lastModified = Carbon::createFromTimestamp($disk->lastModified($dir));

            if ($lastModified->diffInHours($now) >= $hours) {
                $disk->deleteDirectory($dir);
                $this->line("Đã xóa: {$dir} (Cũ hơn {$hours} giờ)");
                $count++;
            }
        }

        if ($count > 0) {
            $this->info("Đã hoàn tất dọn dẹp {$count} thư mục chunk.");
        } else {
            $this->info('Không có thư mục chunk nào đủ cũ để xóa.');
        }
    }
}
