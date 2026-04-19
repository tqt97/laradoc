---
title: CQRS & Event Sourcing – Khi nào nên dùng và khi nào KHÔNG
excerpt: "Phân tích sâu CQRS và Event Sourcing trong bối cảnh Laravel: read/write separation, event store, trade-off, khi nào nên và không nên dùng."
date: 2026-04-19
category: Advanced Laravel
image: /prezet/img/ogimages/series-laravel-advanced-cqrs.webp
tags: [laravel, cqrs, event-sourcing, architecture, system-design]
order: 11
---

Đây là 2 khái niệm:

> Bị lạm dụng nhiều nhất trong system design

Nhưng nếu hiểu đúng:

* Scale cực mạnh
* Flexible

Nếu hiểu sai:

* Complexity tăng x10 💀

# 1. Problem (Production thật)

System:

* Read nhiều (dashboard)
* Write nhiều (orders)

## ❌ Issue

* Query chậm
* DB overload
* Conflict read/write

# 2. CQRS là gì?

> Command Query Responsibility Segregation

## Ý tưởng

* Command → write
* Query → read

## ❌ Truyền thống

```php
User::find(1);
User::update([...]);
```

Chung model

## ✅ CQRS

```php
// Write model
CreateUserCommand

// Read model
UserView
```

## Insight

* Tách read/write
* Optimize riêng

# 3. Lợi ích CQRS

* Scale read riêng
* Optimize query
* Clear responsibility

# 4. Trade-off CQRS

* Code phức tạp hơn
* Data duplication
* Eventual consistency

# 5. Event Sourcing là gì?

> Lưu toàn bộ event thay vì state

## ❌ Traditional

```php
balance = 1000;
```

## ✅ Event Sourcing

```text
+1000 (deposit)
-200 (withdraw)
```

## State = replay events

# 6. Lợi ích Event Sourcing

* Audit log đầy đủ
* Debug dễ
* Time travel

# 7. Trade-off Event Sourcing

* Khó implement
* Storage lớn
* Replay cost

# 8. CQRS + Event Sourcing (kết hợp)

## Flow

```
Command → Event → Update Read Model
```

## Example

```php
CreateOrderCommand
 → OrderCreatedEvent
 → UpdateOrderView
```

# 9. Real Case (Production)

## Banking system

* Transaction log
* Audit

## E-commerce

* Order history
* Analytics

# 10. Khi nào nên dùng?

## ✅ Nên

* System lớn
* Audit quan trọng
* Complex domain

## ❌ Không nên

* CRUD đơn giản
* Startup nhỏ

# 11. Real Bug 💀

## Scenario

* Event fail
* Read model không update

## Issue

* Data mismatch

## Fix

* Retry event
* Rebuild read model

# 12. Anti-pattern

### ❌ Dùng CQRS cho CRUD đơn giản

### ❌ Event quá nhiều

### ❌ Không handle consistency

# 13. Tips & Tricks

* Bắt đầu từ small module
* Log event
* Monitor system

# 14. Mindset Senior

Junior:

> "CQRS là best practice"

Senior:

> "CQRS chỉ dùng khi cần"

# 15. Interview Questions

<details open>
<summary>1. CQRS là gì?</summary>

Tách read/write

</details>

<details open>
<summary>2. Event sourcing là gì?</summary>

Lưu event thay vì state

</details>

<details open>
<summary>3. Khi nào nên dùng CQRS?</summary>

System lớn, read/write khác biệt

</details>

<details open>
<summary>4. Trade-off là gì?</summary>

Complexity + consistency

</details>

<details open>
<summary>5. Làm sao fix data mismatch?</summary>

Rebuild read model

</details>

# Kết luận

CQRS & Event Sourcing rất mạnh.

> Nhưng không dành cho mọi hệ thống

Đây là level của **architect thực thụ**.

## CTA

Bài tiếp theo:
**System Design Case Study – Thiết kế hệ thống thực tế (end-to-end)**

## Internal Link

* Microservices
* Event-Driven Architecture
