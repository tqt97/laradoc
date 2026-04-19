---
title: Clean Architecture trong Laravel – Tổ chức code cho hệ thống lớn
excerpt: Tìm hiểu Clean Architecture trong Laravel, cách tổ chức layer, dependency rule và áp dụng vào hệ thống thực tế.
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/series-laravel-basics-laravel-clean-architecture.webp
tags: [laravel, clean architecture, system design, architecture]
order: 14
---

Khi project Laravel lớn dần, bạn sẽ gặp vấn đề:

* Controller quá to
* Model chứa quá nhiều logic
* Code khó test
* Khó scale team

Đây là lúc bạn cần **Clean Architecture**.

## Clean Architecture là gì?

> Là cách tổ chức code theo layer, tách biệt trách nhiệm rõ ràng.

Mục tiêu:

* Dễ maintain
* Dễ test
* Dễ mở rộng

## Các layer cơ bản

### Controller (Interface Layer)

* Nhận request
* Trả response

Không chứa business logic

### Service (Application Layer)

* Xử lý business logic
* Orchestrate flow

### Domain (Core)

* Business rules
* Entity logic

Quan trọng nhất

### Infrastructure

* Database
* External API

## Flow chuẩn

```txt
Controller → Service → Domain → Repository → DB
```

Dependency chỉ đi một chiều.

## Dependency Rule (cốt lõi)

> Layer ngoài phụ thuộc layer trong, không ngược lại

❌ Sai:

* Domain gọi Controller

✅ Đúng:

* Controller gọi Service
* Service gọi Domain

## So sánh với MVC truyền thống

| MVC              | Clean Architecture |
| ---------------- | ------------------ |
| Model chứa logic | Tách Domain riêng  |
| Controller lớn   | Controller mỏng    |
| Khó test         | Dễ test            |

## Ví dụ thực tế

### MVC truyền thống

```php
class UserController
{
    public function register()
    {
        $user = User::create(...);
        Mail::send(...);
    }
}
```

### Clean Architecture

```php
class UserController
{
    public function register(UserService $service)
    {
        $service->register(...);
    }
}
```

```php
class UserService
{
    public function register($data)
    {
        // logic
    }
}
```

## Real Case Production

### Case: Order System

* Controller: nhận request
* Service: xử lý order
* Domain: validate business rule
* Repository: lưu DB

Tách rõ ràng → dễ scale

## Anti-pattern

* **Fat Controller** Chứa toàn bộ logic

* **Fat Model** Model làm quá nhiều việc

* **Over-engineering** Quá nhiều layer không cần thiết

## Khi nào nên dùng Clean Architecture?

### Nên dùng khi

* Project lớn
* Team nhiều người
* Business logic phức tạp

### Không cần khi

* Project nhỏ
* CRUD đơn giản

## Performance Tips

* Không lạm dụng abstraction
* Giữ flow đơn giản

## Mindset Senior

Junior:

> Code chạy là được

Senior:

> Code phải dễ maintain và scale lâu dài

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. Clean Architecture là gì?</summary>

Là cách tổ chức code theo layer để tách biệt trách nhiệm

</details>

<details open>
<summary>2. Dependency rule là gì?</summary>

Layer ngoài phụ thuộc layer trong, không ngược lại

</details>

<details open>
<summary>3. Tại sao không nên dùng fat controller?</summary>

Khó maintain, khó test

</details>

<details open>
<summary>4. Clean Architecture khác MVC thế nào?</summary>

Tách domain và business logic rõ ràng hơn

</details>

<details open>
<summary>5. Khi nào không nên dùng Clean Architecture?</summary>

Khi project nhỏ, đơn giản

</details>

## Kết luận

Clean Architecture giúp bạn:

* Tổ chức code rõ ràng
* Dễ test
* Dễ scale hệ thống

Đây là bước tiến từ developer → architect.
