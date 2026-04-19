---
title: Modular Monolith – Kiến trúc trung gian trước Microservices
excerpt: "Tìm hiểu Modular Monolith trong Laravel: cách tổ chức module, giảm coupling, scale hệ thống mà không cần microservices."
date: 2026-04-19
category: Advanced Laravel
image: /prezet/img/ogimages/series-laravel-advanced-modular.webp
tags: [laravel, architecture, modular, monolith, system-design]
order: 9
---

Rất nhiều team mắc sai lầm:

> System lớn → phải dùng microservices

Sai.

## 1. Problem (Production thật)

Monolith truyền thống:

```txt
app/
 ├── Models
 ├── Controllers
 ├── Services
```

### Vấn đề

* Code bị trộn lẫn
* Coupling cao
* Khó maintain
* Team conflict

## 2. Naive Solution (Sai lầm phổ biến)

"Chia microservices"

### Vấn đề

* Over-engineering
* DevOps phức tạp
* Debug khó

## 3. Giải pháp: Modular Monolith

> Vẫn là monolith, nhưng chia theo module

### Structure

```
app/Modules/
 ├── User/
 │   ├── Models
 │   ├── Services
 │   ├── Controllers
 │
 ├── Order/
 │   ├── Models
 │   ├── Services
 │   ├── Controllers
```

### Insight

* Mỗi module = 1 domain
* Tách biệt rõ ràng

## 4. Decoupling giữa Module

### Sai

```php
$user = User::find(1);
$order = Order::create([...]);
```

### ✅ Đúng

```php
OrderService::createOrder($userId);
```

### Rule

* Không gọi trực tiếp model module khác
* Giao tiếp qua service

## 5. Communication giữa Module

### 1. Service call

```php
$userService->getUser($id);
```

### 2. Event (khuyến khích)

```php
OrderCreated::dispatch($order);
```

### Insight

* Event → loose coupling hơn

## 6. Boundaries (rất quan trọng)

### Mỗi module có:

* Domain logic riêng
* Database access riêng
* API riêng

### Sai

* Share logic lung tung

## 7. Real Case (Production)

System lớn:

* User module
* Order module
* Payment module

Flow:

```
Order → Payment → Notification
```

Tất cả vẫn trong 1 codebase

## 8. Khi nào cần Microservices?

### Không cần khi

* Team nhỏ
* System chưa lớn

### ✅ Cần khi

* Scale lớn
* Team độc lập

## 9. Migration Strategy

### Monolith → Modular

* Refactor từng phần

### Modular → Microservices

* Extract từng module

## 10. Anti-pattern

#### Fake modular

Chỉ chia folder

#### Cross module dependency

Coupling cao

## 11. Tips & Tricks

* Naming rõ ràng
* Tách domain sớm
* Dùng event

## 12. Mindset Senior

Junior:

> "Project lớn → microservices"

Senior:

> "Phải kiểm soát complexity trước"

## 13. Interview Questions

<details open>
<summary>1. Modular monolith là gì?</summary>

Monolith chia theo module

</details>

<details open>
<summary>2. Khi nào nên dùng?</summary>

System vừa và lớn

</details>

<details open>
<summary>3. Khác gì microservices?</summary>

Không tách service

</details>

<details open>
<summary>4. Làm sao tránh coupling?</summary>

Service + event

</details>

<details open>
<summary>5. Khi nào migrate sang microservices?</summary>

Khi cần scale và team lớn

</details>

## Kết luận

Modular Monolith là bước trung gian quan trọng.

> Giúp bạn scale system mà không tăng complexity quá sớm

Đây là mindset của **senior/architect thực thụ**.
