---
title: Event-Driven Architecture Deep Dive – Sync vs Async, Chaining, Decoupling
excerpt: "Phân tích sâu kiến trúc event-driven trong Laravel: sync vs async, event chaining, event storming và thiết kế hệ thống thực tế."
date: 2026-04-19
category: Advanced Laravel
image: /prezet/img/ogimages/series-laravel-advanced-event-driven.webp
tags: [laravel, event, architecture, distributed, system-design]
order: 6
---

Event không chỉ là:

> bắn event rồi xử lý

Nó là nền tảng để:

* Decouple system
* Scale hệ thống
* Xây dựng distributed system

## 1. Problem (Production thật)

Scenario: Khi user đặt hàng

```php
$order = Order::create([...]);

// Sau đó
sendEmail();
updateInventory();
pushNotification();
```

### ❌ Vấn đề

* Code bị **coupled**
* Khó mở rộng
* Khó test
* Fail 1 bước → ảnh hưởng toàn bộ flow

## 2. Giải pháp: Event-Driven

```php
OrderCreated::dispatch($order);
```

Listeners:

* SendEmail
* UpdateInventory
* PushNotification

### Insight

> Producer không cần biết consumer

## 3. Sync vs Async Event (cực quan trọng)

### 3.1 Sync Event

```php
event(new OrderCreated($order));
```

Chạy ngay trong request

#### Ưu điểm

* Đơn giản
* Debug dễ

#### Nhược điểm

* Block request
* Chậm

### 3.2 Async Event

```php
class SendEmail implements ShouldQueue {}
```

Chạy qua queue

#### Ưu điểm

* Không block
* Scale tốt

#### Nhược điểm

* Eventual consistency
* Khó debug

### 🎯 Rule

* Critical logic → sync
* Side effect → async

## 4. Event Chaining (Deep)

### Scenario

```
OrderCreated → PaymentProcessed → OrderCompleted
```

### Flow

```php
OrderCreated
  → ProcessPayment
      → PaymentProcessed
          → CompleteOrder
```

### ⚠️ Vấn đề

* Hard to trace
* Debug khó

### Fix

* Logging
* Correlation ID

## 5. Event Storming (Design Level)

### Khái niệm

> Mapping business → events

### Ví dụ

Domain: E-commerce

Events:

* UserRegistered
* OrderCreated
* PaymentProcessed
* OrderShipped

### Lợi ích

* Hiểu domain
* Thiết kế system rõ ràng

## 6. Decoupling System

### ❌ Coupled

```php
$orderService->sendEmail();
$orderService->updateInventory();
```

### ✅ Decoupled

```php
OrderCreated::dispatch($order);
```

### Insight

* Thêm feature mới → chỉ cần thêm listener

## 7. Real-world Flow (Production)

### Scenario: Order System

```
User → OrderCreated

OrderCreated →
  → Payment Service
  → Inventory Service
  → Notification Service
```

### Code

```php
OrderCreated::dispatch($order);
```

Listener:

```php
class ProcessPayment implements ShouldQueue
```

### Result

* System scalable
* Independent services

## 8. Failure Case (rất quan trọng)

### ❌ Case: Event fail

* Payment fail
* Nhưng email đã gửi

Inconsistent data

### Fix

* Retry strategy
* Compensating action

### Example

```php
if ($payment_failed) {
    cancelOrder();
}
```

## 9. Eventual Consistency

### Khái niệm

> Data không đồng bộ ngay lập tức

### Ví dụ

* Order created
* Inventory update sau vài giây

### Insight

* Phải chấp nhận delay

## 10. Anti-pattern

#### ❌ Event quá nhiều

Khó quản lý

#### ❌ Business logic trong listener

Khó debug

#### ❌ Event chain quá sâu

Debug nightmare

## 11. Tips & Tricks

* Dùng naming rõ ràng
* Log event
* Dùng correlation ID
* Giữ event đơn giản

## 12. Mindset Senior

Junior:

> "Event để tách code"

Senior:

> "Event là cách thiết kế system"

## 13. Interview Questions

<details open>
<summary>1. Event-driven architecture là gì?</summary>

System dựa trên event để giao tiếp

</details>

<details open>
<summary>2. Sync vs async event?</summary>

Sync chạy ngay, async qua queue

</details>

<details open>
<summary>3. Eventual consistency là gì?</summary>

Data không đồng bộ ngay

</details>

<details open>
<summary>4. Event chaining có vấn đề gì?</summary>

Khó debug, khó trace

</details>

<details open>
<summary>5. Làm sao thiết kế event tốt?</summary>

Theo domain (event storming)

</details>

## Kết luận

Event-driven giúp bạn:

* Scale system
* Decouple logic
* Build distributed system

> Nhưng đi kèm complexity rất lớn
