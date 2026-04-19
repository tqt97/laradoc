---
title: Performance Tuning trong Laravel – Tối ưu toàn hệ thống từ code đến hạ tầng
excerpt: "Hướng dẫn tối ưu hiệu năng Laravel: phân tích bottleneck, tối ưu query, cache strategy, profiling và tuning PHP-FPM."
date: 2026-04-19
category: Performance
image: /prezet/img/ogimages/series-laravel-basics-laravel-performance-tuning.webp
tags: [laravel, performance, optimization, cache, database]
order: 17
---

Khi hệ thống tăng traffic, bạn sẽ gặp:

* Response chậm
* CPU cao
* DB quá tải

Đây là lúc cần **Performance Tuning**.

## Performance Tuning là gì?

> Là quá trình tìm và tối ưu các điểm nghẽn (bottleneck) trong hệ thống.

## Xác định Bottleneck

3 nguồn chính

* CPU
* Database
* I/O (network, disk)

Không đo = không tối ưu

## Profiling Tools

### Laravel Debugbar

* Query
* Time execution

### Laravel Telescope

* Request
* Job
* Exception

### Log + APM

* Sentry
* New Relic

## Database Optimization (quan trọng nhất)

### N+1 Query

❌ Sai:

```php
foreach ($users as $user) {
    echo $user->posts;
}
```

✅ Đúng:

```php
User::with('posts')->get();
```

### Index

```sql
CREATE INDEX idx_users_email ON users(email);
```

### Select field cần thiết

```php
User::select('id', 'name')->get();
```

## Caching Strategy

### Query Cache

```php
Cache::remember('users', 60, fn() => User::all());
```

### Config Cache

```bash
php artisan config:cache
```

### Route Cache

```bash
php artisan route:cache
```

### View Cache

```bash
php artisan view:cache
```

## Queue Optimization

* Đưa task nặng vào queue
* Tăng worker

## PHP-FPM Tuning

Ví dụ config:

```txt
pm.max_children = 50
pm.start_servers = 10
pm.min_spare_servers = 5
pm.max_spare_servers = 20
```

Tùy theo RAM/CPU

## HTTP Optimization

* Gzip
* HTTP/2
* CDN

## Real Case Production

**API chậm**

* Fix N+1
* Add index
* Cache response

Tốc độ tăng x10

## Anti-pattern

* **Optimize sớm** Premature optimization

* **Không đo đạc** Tối ưu sai chỗ

* **Lạm dụng cache** Data stale

## Performance Checklist

* Query đã optimize?
* Có index chưa?
* Có cache chưa?
* Có queue chưa?

## Mindset Senior

Junior:

> Code chạy là được

Senior:

> Code phải nhanh và chịu tải tốt

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. Bottleneck là gì?</summary>

Là điểm gây chậm trong hệ thống

</details>

<details open>
<summary>2. N+1 query là gì?</summary>

Là việc query lặp lại nhiều lần gây chậm

</details>

<details open>
<summary>3. Cache giúp gì?</summary>

Giảm load DB và tăng tốc

</details>

<details open>
<summary>4. Khi nào nên dùng queue?</summary>

Khi task nặng, không cần xử lý ngay

</details>

<details open>
<summary>5. Tại sao không nên optimize sớm?</summary>

Vì có thể tối ưu sai chỗ

</details>

## Kết luận

Performance không phải optional.

> Nó quyết định hệ thống sống hay chết khi scale.

Tối ưu đúng giúp:

* Tăng tốc độ
* Giảm chi phí
* Tăng trải nghiệm user
