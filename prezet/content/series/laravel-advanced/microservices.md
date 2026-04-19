---
title: Microservices Deep Dive – Trade-off, Communication, Consistency & Failure
excerpt: "Phân tích sâu microservices trong bối cảnh Laravel: trade-off thực tế, giao tiếp service (HTTP vs MQ), consistency, failure handling và case production."
date: 2026-04-19
category: Advanced Laravel
image: /prezet/img/ogimages/series-laravel-advanced-microservices.webp
tags: [laravel, microservices, architecture, distributed, system-design]
order: 10
---

## 🚀 Microservices Deep Dive

Microservices không phải “silver bullet”.

> Dùng sai → complexity tăng x10
> Dùng đúng → scale rất mạnh

## 1. Problem (Production thật)

Monolith lớn:

* Deploy chậm
* Team conflict
* Khó scale theo domain

Team quyết định tách microservices.

### Kết quả (thường gặp)

* Network lỗi
* Timeout
* Data không đồng bộ
* Debug khó 💀

## 2. Microservices là gì (đúng nghĩa)

> Mỗi service = 1 domain độc lập

* Deploy riêng
* Database riêng
* Scale riêng

### Insight

* Không share DB
* Không tight coupling

## 3. Trade-off (rất quan trọng)

| Ưu điểm       | Nhược điểm      |
| ------------- | --------------- |
| Scale độc lập | Complexity cao  |
| Deploy nhanh  | Debug khó       |
| Team autonomy | Network latency |

Không có free lunch

## 4. Communication giữa services

### 4.1 HTTP (Sync)

```php
$response = Http::get('http://order-service/api/orders');
```

#### Ưu điểm

* Đơn giản
* Dễ debug

#### Nhược điểm

* Block
* Timeout

### 4.2 Message Queue (Async)

```php
OrderCreated::dispatch($order);
```

#### Ưu điểm

* Không block
* Loose coupling

#### Nhược điểm

* Eventual consistency
* Khó trace

### 🎯 Rule

* Sync → cần response ngay
* Async → side effects

## 5. Data Consistency (cực khó)

### Vấn đề

* Service A update
* Service B chưa update

Data inconsistent ❌

### Giải pháp

#### 1. Eventual Consistency

* Chấp nhận delay

#### 2. Saga Pattern (advanced)

```
Order → Payment → Inventory
```

Nếu fail → rollback logic

### Insight

* Không có distributed transaction (2PC rất hiếm)

## 6. Failure Handling (Production)

### Scenario

* Payment service down

### Kết quả

* Order bị treo

### ✅ Fix

#### 1. Retry

#### 2. Circuit Breaker

Stop gọi service bị lỗi

#### 3. Fallback

```php
return cached_data();
```

## 7. Real Bug (Production 💀)

### Scenario

* Order service gọi Payment service
* Payment timeout

### Issue

* User không biết trạng thái

### Fix

* Async + event
* Retry + idempotency

## 8. Observability (rất quan trọng)

### Vấn đề

* Debug rất khó

### Giải pháp

* Logging
* Tracing (correlation ID)
* Metrics

## 9. Anti-pattern

#### Microservices quá sớm

#### Shared database

#### Sync chain dài

## 10. Tips & Tricks

* Bắt đầu từ modular monolith
* Tách service dần
* Monitor system

## 11. Mindset Senior

Junior:

> "Microservices để scale"

Senior:

> "Microservices để manage complexity khi cần"

## 12. Interview Questions

<details open>
<summary>1. Microservices là gì?</summary>

Hệ thống chia thành nhiều service độc lập

</details>

<details open>
<summary>2. Trade-off của microservices?</summary>

Complexity vs scalability

</details>

<details open>
<summary>3. HTTP vs Message Queue?</summary>

Sync vs async

</details>

<details open>
<summary>4. Làm sao đảm bảo consistency?</summary>

Eventual consistency + saga

</details>

<details open>
<summary>5. Circuit breaker là gì?</summary>

Ngắt request khi service lỗi

</details>

## Kết luận

Microservices rất mạnh nhưng rất nguy hiểm.

> Dùng đúng → scale tốt
> Dùng sai → hệ thống sụp 💀

Đây là level của **system architect thực thụ**.
