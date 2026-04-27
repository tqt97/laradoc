---
title: Laravel Queue là gì? Hướng dẫn từ cơ bản đến Production (Retry, Idempotency, Scaling)
excerpt: Tìm hiểu Laravel Queue từ bản chất hoạt động, cách triển khai, retry, idempotency, xử lý lỗi, scaling và best practices production với ví dụ code chi tiết.
date: 2026-04-27
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-index.webp
tags: [laravel, queue]
---

## Glossary (Giải thích thuật ngữ – BẮT BUỘC ĐỌC)

> Mục này giúp người đọc không bị “ngợp” bởi thuật ngữ tiếng Anh

* **Queue (Hàng đợi):** nơi chứa các job để xử lý sau
* **Job:** một công việc cụ thể (ví dụ: gửi email)
* **Worker:** process chạy nền để xử lý job
* **Asynchronous (Bất đồng bộ):** không chạy ngay lập tức, xử lý sau
* **Synchronous (Đồng bộ):** chạy ngay trong request
* **Consistency (Tính nhất quán):** dữ liệu có đúng ngay lập tức hay không

  * **Strong consistency:** dữ liệu luôn đúng ngay lập tức
  * **Eventual consistency:** dữ liệu sẽ đúng sau một khoảng thời gian
* **Idempotent:** gọi nhiều lần nhưng kết quả như 1 lần
* **Retry:** thử lại khi job fail
* **Backoff:** delay giữa các lần retry
* **Concurrency:** nhiều worker xử lý cùng lúc
* **Throughput:** số job xử lý mỗi giây
* **Latency:** thời gian xử lý 1 job
* **Inventory oversell (bán vượt tồn kho):** bán nhiều hơn số lượng thực có

## 1. Queue là gì? (Bản chất kỹ thuật)

Queue là cơ chế giúp **tách xử lý nặng ra khỏi request**.

#### Vì sao cần?

Ví dụ:

* Gửi email mất 300ms
* Request cần <100ms

👉 Nếu không dùng queue:

* user phải chờ
* server bị block

👉 Nếu dùng queue:

* response trả ngay
* xử lý phía sau

## 2. Worker là gì?

#### Định nghĩa

Worker là process chạy nền liên tục để xử lý job.

#### Bản chất kỹ thuật

```
while (true) {
    $job = getJob();
    process($job);
}
```

👉 Không giống request HTTP (chạy xong là chết)
👉 Worker chạy mãi

#### Tạo worker

```
php artisan queue:work
```

#### Production setup (chi tiết)

###### 1. Supervisor

* giữ worker luôn chạy
* restart khi crash

###### 2. Multiple worker

* scale theo CPU core

###### 3. Queue separation

* emails
* heavy_jobs

## 3. Problem

* Task nặng (email, API)
* Traffic cao
* Không muốn block request

## 4. Naive Approach (Fail chi tiết)

```
Mail::send(...);
```

###### Fail vì

**Blocking**

* request phải chờ email gửi xong

**Timeout**

* SMTP chậm → request timeout

**Throughput thấp**

* 1 request = 1 job

## 5. Laravel Queue Solution

```
SendEmailJob::dispatch($user);
```

👉 Job được đẩy vào queue thay vì chạy ngay

## 6. Queue Driver (Giải thích đúng bản chất)

Laravel hỗ trợ nhiều driver:

| Driver   | Bản chất    | Ưu điểm   | Nhược điểm  | Khi dùng   |
| -------- | ----------- | --------- | ----------- | ---------- |
| sync     | chạy ngay   | đơn giản  | không async | dev/test   |
| database | lưu DB      | durable   | chậm        | nhỏ        |
| Redis    | in-memory   | rất nhanh | tốn RAM     | production |
| SQS      | cloud queue | scale tốt | cost        | cloud      |

👉 KHÔNG bắt buộc Redis
👉 Redis chỉ là lựa chọn phổ biến vì tốc độ

## 7. Under the Hood

1. Serialize job
2. Push vào driver
3. Worker poll
4. Execute

## 8. Decision Tree (Chi tiết)

```
if task < 50ms
    → sync

if task > 100ms
    → queue

if cần strong consistency
    → KHÔNG dùng queue

if traffic cao
    → Redis
```

## 9. Strong Consistency vs Queue (Giải thích sâu)

###### Vì sao không dùng queue?

Ví dụ inventory:

* tồn kho = 10
* 2 job chạy async
  → cả 2 đều đọc = 10
  → bán 2 lần

👉 gây oversell

## 10. Failure Matrix

| Failure             | Nguyên nhân | Hậu quả       | Giải pháp   |
| ------------------- | ----------- | ------------- | ----------- |
| Duplicate           | retry       | dữ liệu sai   | idempotent  |
| Worker chết         | crash       | job mất       | retry       |
| Job fail giữa chừng | exception   | inconsistency | transaction |
| Queue backlog       | load cao    | delay         | scale       |

## 11. Cost Estimation

#### Redis

* mỗi job ~1KB–10KB
* 1M job = ~1–10GB RAM

#### Worker scaling formula

```
worker = jobs/sec * time/job
```

Ví dụ:

* 1000 job/sec
* 0.1s/job
  → cần ~100 worker

## 12. Scaling Strategy

| Level | Giải pháp         | Vì sao chọn     |
| ----- | ----------------- | --------------- |
| 1     | 1 worker          | đơn giản        |
| 2     | multi worker      | tăng throughput |
| 3     | multi queue       | tách workload   |
| 4     | Redis cluster     | scale storage   |
| 5     | distributed queue | extreme scale   |

## 13. Extreme Scale

| Scenario     | Giải pháp    | Lý do            |
| ------------ | ------------ | ---------------- |
| 1M job/sec   | sharding     | tránh bottleneck |
| multi-region | region queue | giảm latency     |

## 14. Idempotency

```
if (Cache::has($key)) return;
```

👉 đảm bảo không duplicate

## 15. Concurrency

```
Cache::lock('job')->get(function () {
    // xử lý
});
```

## 16. Example Code

```
class SendEmailJob implements ShouldQueue
{
    public $tries = 3; // retry 3 lần
    public $timeout = 30; // tối đa 30s

    public function handle()
    {
        // kiểm tra đã gửi chưa
        if (Cache::has("email_sent_{$this->user->id}")) {
            return;
        }

        // gửi email
        Mail::to($this->user)->send(new WelcomeMail());

        // đánh dấu đã gửi
        Cache::put("email_sent_{$this->user->id}", true, 3600);
    }
}
```

## 17. Interview Q&A

#### Q1: Queue có đảm bảo đúng 1 lần không?

👉 Không.
→ vì retry
→ phải idempotent

#### Q2: Idempotent là gì?

👉 gọi nhiều lần vẫn như 1 lần

#### Q3: Khi nào không dùng queue?

👉 khi cần strong consistency (payment, inventory)

#### Q4: Redis vs DB?

👉 Redis nhanh, DB bền

## 18. Production Incident

* email gửi 2 lần
* do retry
* fix: idempotency

## 19. Backpressure Strategy (Xử lý khi hệ thống quá tải)

**Backpressure là gì?**

* Backpressure = cơ chế kiểm soát khi hệ thống bị quá tải (overload).

👉 Khi tốc độ job vào > tốc độ xử lý
→ hệ thống cần “giảm áp lực”

**Nếu KHÔNG có backpressure:**

* Queue tăng vô hạn → tốn RAM (Redis có thể OOM)
* Worker xử lý không kịp
* Delay tăng mạnh → user bị chậm
* Có thể dẫn đến:
* crash Redis
* timeout hàng loạt

**Các chiến lược Backpressure**

| Strategy       | Là gì            | Khi dùng           | Trade-off       |
| -------------- | ---------------- | ------------------ | --------------- |
| Drop job       | bỏ job           | job không critical | mất dữ liệu     |
| Delay job      | xử lý sau        | traffic spike      | tăng latency    |
| Rate limit     | giới hạn request | API public         | giảm throughput |
| Priority queue | ưu tiên job      | nhiều loại job     | phức tạp        |

Ví dụ Rate Limit trước khi dispatch

```
use Illuminate\Support\Facades\RateLimiter;

$key = 'send-email';

if (RateLimiter::tooManyAttempts($key, 100)) {
    // quá tải → không đẩy job vào queue
    return;
}

RateLimiter::hit($key);

SendEmailJob::dispatch($user);
```

👉 Ý nghĩa:

* tránh queue bị flood
* giảm áp lực cho worker

## 20. Dead Letter Queue (DLQ)

**DLQ là gì?**

Dead Letter Queue = nơi chứa các job đã fail nhiều lần.

👉 Tránh:

* retry vô hạn
* loop vô tận

**Flow chuẩn**

```
Job → Fail → Retry → Fail → Retry → Fail → DLQ
```

**Laravel implement**

Laravel dùng bảng:

```
failed_jobs
```

**Xem job fail**

```
php artisan queue:failed
```

**Retry lại**

```
php artisan queue:retry all
```

**Best Practice**

* Log lỗi chi tiết (exception + context)
* Alert khi số lượng failed_jobs tăng bất thường
* Không retry vô hạn (giới hạn tries)

Ví dụ job fail

```
public function handle()
{
    throw new Exception("External API down");
}
```

👉 Job sẽ:

* retry
* sau đó vào DLQ

## 21. Benchmark (Hiệu năng thực tế)

**Redis**

~100k → 1M operations/sec (tuỳ hardware)
latency rất thấp (~microseconds)

**Worker throughput**

| Job type          | Job/sec |
| ----------------- | ------- |
| nhẹ (log, cache)  | 200–500 |
| trung bình (DB)   | 50–200  |
| nặng (API, image) | 5–50    |

**Ví dụ tính toán**

* 10,000 job/sec
* 1 worker xử lý 100 job/sec

👉 cần:

```
10,000 / 100 = 100 worker
```

## 22. Advanced Failure Scenarios

**Case 1: Worker memory leak**
Nguyên nhân:

* PHP process chạy lâu
* memory không được giải phóng hoàn toàn

Fix:

```
php artisan queue:work --max-jobs=100
```

👉 restart worker định kỳ

**Case 2: Zombie job (job bị treo)**

Nguyên nhân:

* API không response
* infinite loop

Fix:

```
public $timeout = 30;
```

👉 kill job sau 30s

**Case 3: Thundering Herd**
Hiện tượng:

* nhiều worker xử lý cùng 1 resource

Fix:

```
Cache::lock('order_'.$id)->get(function () {
    // xử lý critical section
});
```

## 23. Production Setup (Chi tiết thực tế)

Supervisor config

```
[program:laravel-worker]
command=php artisan queue:work redis --sleep=3 --tries=3 --timeout=60
numprocs=5
autostart=true
autorestart=true
stdout_logfile=/var/log/worker.log
```

**Giải thích:**

* numprocs=5 → 5 worker chạy song song
* autorestart=true → crash tự restart
* sleep=3 → nghỉ 3s khi không có job
* tries=3 → retry tối đa 3 lần

**Deploy strategy**

Sau khi deploy code mới: ``` artisan queue:restart```

👉 reload worker để load code mới
👉 nếu không restart → worker vẫn chạy code cũ

## 24. Full System Flow (Tổng hợp)

```
Request
 → dispatch job
 → queue (Redis / DB / SQS)
 → worker xử lý
 → retry nếu fail
 → DLQ nếu fail nhiều lần
```
