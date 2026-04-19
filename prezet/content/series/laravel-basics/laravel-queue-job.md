---
title: Queue & Job trong Laravel – Xử lý bất đồng bộ để scale hệ thống
excerpt: Tìm hiểu Queue và Job trong Laravel, cách hoạt động, khi nào dùng và cách triển khai trong production để tăng khả năng chịu tải.
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/series-laravel-basics-laravel-queue-job.webp
tags: [laravel, queue, job, async, scaling]
order: 7
---

Trong nhiều ứng dụng thực tế, bạn sẽ gặp các tác vụ như:

* Gửi email
* Xử lý ảnh
* Gọi API bên thứ 3

Nếu xử lý trực tiếp trong request:

User sẽ phải chờ → hệ thống chậm → UX tệ

## Queue là gì?

Queue là cơ chế:

> Đưa các tác vụ nặng ra xử lý bất đồng bộ (async)

Giúp:

* Giảm thời gian response
* Tăng trải nghiệm người dùng

## Job là gì?

Job là một đơn vị công việc được đưa vào queue.

Ví dụ:

```php
SendWelcomeEmail::dispatch($user);
```

Job sẽ được xử lý ở background.

## Flow hoạt động

```txt
Request → Dispatch Job → Queue → Worker xử lý → Done
```

## Queue Driver trong Laravel

Laravel hỗ trợ:

* sync (dev)
* database
* redis
* sqs

Production nên dùng **Redis** hoặc **SQS**

## Tạo Job

```bash
php artisan make:job SendWelcomeEmail
```

```php
class SendWelcomeEmail implements ShouldQueue
{
    public function handle()
    {
        // gửi email
    }
}
```

## Dispatch Job

```php
SendWelcomeEmail::dispatch($user);
```

Hoặc delay:

```php
SendWelcomeEmail::dispatch($user)->delay(now()->addMinutes(5));
```

## Queue Worker

Chạy worker:

```bash
php artisan queue:work
```

Worker sẽ:

* Lắng nghe queue
* Xử lý job

## Retry & Failed Jobs

Laravel hỗ trợ:

* Retry job
* Lưu failed job

```bash
php artisan queue:failed
```

## Real Case Production

### Case 1: Gửi email

❌ Sai:

* Gửi trực tiếp trong controller

✅ Đúng:

* Dispatch job gửi email

### Case 2: Xử lý ảnh

* Resize
* Upload S3

Nên dùng queue

### Case 3: Payment

* Gọi API chậm

Không block request

## Queue nâng cao

### Job Chaining

```php
Bus::chain([
    new Job1,
    new Job2,
])->dispatch();
```

### Job Batching

```php
Bus::batch([
    new Job1,
    new Job2,
])->dispatch();
```

### Horizon (Redis)

Monitor queue realtime

## Anti-pattern

**Dùng queue cho task nhỏ**: Overkill

**Không handle retry**: Mất dữ liệu

**Logic quá nặng trong job**: Khó maintain

## Performance Tips

* Tách job nhỏ
* Retry hợp lý
* Monitor queue

## Mindset Senior

Junior:

> Queue để chạy background

Senior:

> Queue để scale hệ thống và tách workload

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. Queue là gì?</summary>

Cơ chế xử lý bất đồng bộ giúp giảm thời gian response

</details>

<details open>
<summary>2. Khi nào nên dùng queue?</summary>

Khi task nặng hoặc không cần xử lý ngay

</details>

<details open>
<summary>3. Job là gì?</summary>

Là một task được đưa vào queue để xử lý

</details>

<details open>
<summary>4. Redis dùng trong queue như thế nào?</summary>

Là driver giúp lưu queue và xử lý nhanh hơn database

</details>

<details open>
<summary>5. Làm sao xử lý job thất bại?</summary>

Dùng retry, failed jobs và logging

</details>

## Kết luận

Queue giúp bạn:

* Tăng tốc độ response
* Xử lý task nặng
* Scale hệ thống

Đây là bước quan trọng để xây dựng hệ thống lớn.
