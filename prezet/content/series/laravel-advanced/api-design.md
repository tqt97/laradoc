---
title: API Design Advanced – Idempotency, Rate Limiting, Security, Versioning
excerpt: "Phân tích sâu thiết kế API trong Laravel: idempotency, rate limiting, bảo mật (JWT vs OAuth), versioning và các bug production thực tế."
date: 2026-04-19
category: Advanced Laravel
image: /prezet/img/ogimages/series-laravel-advanced-api-design.webp
tags: [laravel, api, security, rate-limit, idempotency]
order: 8
---

API không chỉ là:

> "trả JSON cho frontend"

Nó là contract giữa systems.

Sai design →

* Bug production
* Security issue
* Khó scale

## 1. Problem (Production thật)

API:

```http
POST /api/payments
```

Client retry do timeout → gửi 2 request

### ❌ Issue

* User bị charge 2 lần 💀

## 2. Idempotency (cực kỳ quan trọng)

### Khái niệm

> Gọi API nhiều lần nhưng kết quả như 1 lần

### ❌ Sai

```php
Payment::create([...]);
```

### ✅ Đúng

#### Dùng Idempotency Key

```http
POST /payments
Idempotency-Key: abc123
```

### Server

```php
if (Cache::has($key)) {
    return Cache::get($key);
}

$result = processPayment();
Cache::put($key, $result, 60);
```

### Insight

* Critical API → bắt buộc idempotent

## 3. Rate Limiting Strategy

### Vấn đề

* Spam API
* DDoS

### Laravel

```php
Route::middleware('throttle:60,1');
```

### Advanced Strategy

#### 1. User-based

```php
user_id + IP
```

#### 2. Dynamic limit

* Free: 60 req/min
* Premium: 1000 req/min

#### 3. Sliding window (advanced)

Chính xác hơn fixed window

### ⚠️ Sai lầm

* Rate limit global
* Không phân user

## 4. API Security (JWT vs OAuth)

### JWT

Stateless

#### Ưu điểm

* Nhanh
* Không cần DB

#### Nhược điểm

* Khó revoke

### OAuth

Authorization framework

#### Ưu điểm

* Secure hơn
* Delegation

#### Nhược điểm

* Phức tạp

### 🎯 Rule

* Internal API → JWT
* Public API → OAuth

## 5. API Versioning

### Vấn đề

* Thay đổi API → break client

### Cách làm

#### 1. URL version

```http
/api/v1/users
```

#### 2. Header version

```http
Accept: application/vnd.api.v1+json
```

### Best practice

* Không break version cũ

## 6. Real Bug (Production 💀)

### Scenario

* Client retry
* Không idempotent

### Result

* Double payment

### Fix

* Idempotency key
* Logging

## 7. API Design Best Practices

* RESTful naming
* Use HTTP status đúng
* Validate input
* Consistent response

## 8. Anti-pattern

#### ❌ Không idempotent

#### ❌ Không rate limit

#### ❌ Expose sensitive data

## 9. Tips & Tricks

* Log request/response
* Use API gateway
* Monitor traffic

## 10. Mindset Senior

Junior:

> "API trả data là xong"

Senior:

> "API là contract, phải đảm bảo consistency + security"

## 11. Interview Questions

<details open>
<summary>1. Idempotency là gì?</summary>

Gọi nhiều lần không đổi kết quả

</details>

<details open>
<summary>2. Rate limit để làm gì?</summary>

Bảo vệ hệ thống

</details>

<details open>
<summary>3. JWT vs OAuth?</summary>

JWT đơn giản, OAuth mạnh hơn

</details>

<details open>
<summary>4. Version API như thế nào?</summary>

URL hoặc header

</details>

<details open>
<summary>5. Bug double payment xảy ra khi nào?</summary>

Retry + không idempotent

</details>

## Kết luận

API design là nền tảng của hệ thống.

> Sai từ đầu → sửa rất tốn kém

Hiểu API = hiểu system integration
