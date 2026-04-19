---
title: Queue Internals Deep Dive – At-least-once, Idempotency, Retry Strategy
excerpt: "Phân tích sâu queue trong Laravel: delivery semantics, idempotency, retry, failure handling và các bug production thực tế."
date: 2026-04-19
category: Advanced Laravel
image: /prezet/img/ogimages/series-laravel-advanced-queue.webp
tags: [laravel, queue, redis, performance, distributed]
order: 5
---

Queue không chỉ là:

> "Đưa job vào background"

Nó là **distributed system thu nhỏ**.

Nếu bạn không hiểu rõ:

* Job có thể chạy 2 lần
* Data có thể sai
* Email có thể gửi 2 lần

## 1. Problem (Production thật)

Scenario:

```php
SendEmailJob::dispatch($user);
```

### Symptoms

* User nhận 2 email
* DB bị update 2 lần

Bug khó debug

## 2. Root Cause

Queue KHÔNG đảm bảo:

* Exactly-once execution

Thực tế:

> Queue = **At-least-once delivery**

## 3. At-least-once vs Exactly-once

### At-least-once

* Job chạy ≥ 1 lần
* Có thể chạy lại

Laravel, Redis queue = default

### Exactly-once (gần như không tồn tại)

* Cực khó
* Tốn chi phí cao

Thường phải simulate bằng idempotency

## 4. Idempotency (cực quan trọng)

> Chạy nhiều lần nhưng kết quả như 1 lần

### ❌ Sai

```php
$user->increment('points', 10);
```

Chạy 2 lần = +20 ❌

### ✅ Đúng

```php
if (!$user->has_received_bonus) {
    $user->increment('points', 10);
    $user->has_received_bonus = true;
    $user->save();
}
```

### Cách chuẩn hơn (production)

#### 1. Unique Job Key

```php
Cache::add("job:{$id}", true, 60);
```

#### 2. Database constraint

* unique key

## 5. Retry Strategy

### Vấn đề

* Job fail → retry
* Retry nhiều lần → duplicate effect

### Config

```php
public $tries = 3;
public $backoff = [10, 30, 60];
```

### Insight

* Retry không phải lúc nào cũng tốt

## 6. Job Failure Handling

### Handle

```php
public function failed(Exception $e)
{
    Log::error($e);
}
```

### Queue Failed Jobs

```bash
php artisan queue:failed
```

### Retry thủ công

```bash
php artisan queue:retry
```

## 7. Real Bug (Production 💀)

### Scenario

* User đặt hàng
* Job gửi email

### Issue

* Worker crash giữa chừng
* Job retry

Email gửi 2 lần

### Fix

* Idempotent logic
* Log gửi email

## 8. Queue Visibility Timeout

### Vấn đề

* Job chạy lâu
* Worker chết

Job được re-queue

### Fix

* Set timeout hợp lý

## 9. Distributed System Thinking

Queue = eventual consistency

### Rule

* Không assume job chạy 1 lần
* Luôn idempotent

## 10. Anti-pattern

#### ❌ Không idempotent

Bug production

#### ❌ Retry vô hạn

System overload

#### ❌ Logic phức tạp trong job

Khó debug

## 11. Tips & Tricks

* Log job execution
* Dùng unique key
* Monitor queue

## 12. Mindset Senior

Junior:

> "Queue chỉ để async"

Senior:

> "Queue là distributed system, phải đảm bảo consistency"

## 13. Interview Questions

<details open>
<summary>1. At-least-once là gì?</summary>

Job có thể chạy nhiều lần

</details>

<details open>
<summary>2. Idempotency là gì?</summary>

Chạy nhiều lần nhưng kết quả không đổi

</details>

<details open>
<summary>3. Làm sao tránh duplicate job?</summary>

Unique key + DB constraint

</details>

<details open>
<summary>4. Retry strategy là gì?</summary>

Retry job khi fail

</details>

<details open>
<summary>5. Tại sao email bị gửi 2 lần?</summary>

Job retry + không idempotent

</details>

## Kết luận

Queue không đơn giản.

> Nó là distributed system thu nhỏ.

Hiểu queue giúp bạn tránh bug production nghiêm trọng.
