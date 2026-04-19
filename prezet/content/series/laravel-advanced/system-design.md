---
title: System Design Case Study – Thiết kế hệ thống E-commerce (End-to-End)
excerpt: "Case study thiết kế hệ thống thực tế sử dụng Laravel: database, cache, queue, event-driven, scaling và xử lý production."
date: 2026-04-19
category: Advanced Laravel
image: /prezet/img/ogimages/series-laravel-advanced-system-design.webp
tags: [laravel, system-design, architecture, scaling, backend]
order: 13
---

Đây là bài quan trọng nhất trong series.

> Không còn học từng phần
> → Mà là ghép tất cả lại thành 1 system hoàn chỉnh

## 1. Bài toán

Thiết kế hệ thống:

E-commerce (giống Shopee/Lazada mini)

### Yêu cầu

* User đăng ký / đăng nhập
* Xem sản phẩm
* Đặt hàng
* Thanh toán
* Gửi email

### Non-functional

* Scale: 1M user
* Performance cao
* Không double payment

## 2. High-Level Architecture

```txt
Client
  ↓
API (Laravel)
  ↓
Services
  ↓
Database + Cache + Queue
```

### Components

* API Layer
* Service Layer
* Queue
* Cache
* DB

## 3. Database Design

### Tables

* users
* products
* orders
* order_items
* payments

### Index

```sql
(user_id, status, created_at)
```

### Insight

* Optimize theo query

## 4. API Design

### Endpoint

```http
POST /orders
GET /products
POST /payments
```

### Idempotency

```http
Idempotency-Key
```

## 5. Caching Strategy

### Use case

* Product list

```php
Cache::remember('products', 60, fn() => Product::all());
```

### Fix stampede

* Cache lock

## 6. Queue Design

### Jobs

* SendEmail
* ProcessPayment

### Idempotent

```php
if ($processed) return;
```

## 7. Event-Driven Flow

```
OrderCreated
 → ProcessPayment
 → PaymentProcessed
 → SendEmail
```

### Insight

* Decoupled
* Scalable

## 8. Handling Payment (Critical)

### Problem

* Retry → double charge

### Fix

* Idempotency key
* Unique DB constraint

## 9. Scaling Strategy

### 1. Horizontal scaling

* Multiple app servers

### 2. Cache (Redis)

### 3. DB read replica

## 10. Failure Handling

### Case

* Payment service down

### Fix

* Retry
* Queue
* Fallback

## 11. Observability

* Log
* Metrics
* Tracing

## 12. Real Bug 💀

### Scenario

* Queue retry
* Payment chạy 2 lần

### Fix

* Idempotency

## 13. Anti-pattern

* Không cache
* Không idempotent
* Sync mọi thứ

## 14. Mindset Senior

Junior:

> "Build feature"

Senior:

> "Design system chịu tải"

## 15. Interview Questions

<details open>
<summary>1. Thiết kế e-commerce như thế nào?</summary>

DB + Cache + Queue + Event

</details>

<details open>
<summary>2. Làm sao tránh double payment?</summary>

Idempotency

</details>

<details open>
<summary>3. Scale system như thế nào?</summary>

Cache + replica + queue

</details>

<details open>
<summary>4. Tại sao dùng event?</summary>

Decouple

</details>

<details open>
<summary>5. Bug thường gặp?</summary>

Retry + duplicate

</details>

## Kết luận

Đây là cách thiết kế system thực tế.

> Không có silver bullet
> → chỉ có trade-off
