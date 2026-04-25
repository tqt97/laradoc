<?php

namespace App\Services;

use App\Jobs\IncrementPostView;
use App\Models\PrezetDocument;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\Str;

class PostViewService
{
    /**
     * Thời gian (phút) để tính lại 1 lượt xem cho cùng 1 IP
     */
    protected int $ttl = 60;

    /**
     * Xử lý đếm lượt xem cho bài viết
     */
    public function track(PrezetDocument $doc): void
    {
        // 1. Bot Detection: Bỏ qua nếu là bot hoặc crawler
        if ($this->isBot()) {
            return;
        }

        // 2. Anti-Spam: Sử dụng Rate Limiter để giới hạn 10 requests mỗi phút cho mỗi IP/bài viết
        $limiterKey = 'view_limit:'.$doc->id.':'.request()->ip();
        if (RateLimiter::tooManyAttempts($limiterKey, 10)) {
            return;
        }
        RateLimiter::hit($limiterKey, 60);

        // 3. Deduplication: Sử dụng Cache TTL để tránh tăng view khi F5 liên tục
        $cacheKey = "post_viewed:{$doc->id}:".request()->ip();
        if (Cache::has($cacheKey)) {
            return;
        }

        // Đánh dấu đã xem trong vòng $this->ttl phút
        Cache::put($cacheKey, true, now()->addMinutes($this->ttl));

        // 4. Queueing: Đẩy vào queue để xử lý tăng view ngầm, không block request của người dùng
        IncrementPostView::dispatch($doc->id);
    }

    /**
     * Kiểm tra xem request có phải từ Bot/Crawler không
     */
    protected function isBot(): bool
    {
        $userAgent = request()->userAgent();
        if (empty($userAgent)) {
            return true;
        }

        return Str::contains(strtolower($userAgent), [
            'bot', 'crawl', 'spider', 'slurp', 'search', 'mediapartners',
            'lighthouse', 'bingbot', 'googlebot', 'ahrefs', 'semrush',
        ]);
    }
}
