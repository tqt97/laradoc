---
title: "Laravel Middleware Mechanics: Cơ chế hoạt động của 'Chuỗi' xử lý"
excerpt: Giải mã cách Laravel đăng ký, load và thực thi Middleware thông qua Pipeline pattern và HTTP Kernel.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-laravel-middleware-mechanics.webp
tags: [laravel, middleware, internals, architecture]
---

Middleware là hàng phòng thủ, là lớp trung gian, là nơi xử lý các cross-cutting concerns (logging, auth). Nhưng bạn có biết middleware thực sự hoạt động như thế nào bên dưới lớp vỏ `php artisan make:middleware`?

## 1. Bản chất

Middleware trong Laravel không chỉ là một class. Nó là một **Pipe** trong Pipeline Pattern. Mỗi middleware đều phải có method `handle($request, Closure $next)`.

## 2. Luồng thực thi

1. Request tới `Kernel`.
2. `Kernel` lấy danh sách middleware tương ứng.
3. Middleware chạy trước `return $next($request)`.
4. Sau khi các middleware lồng nhau kết thúc, Response đi ngược lại, chạy các đoạn code sau `$next($request)`.

## 3. Quizz phỏng vấn

**Câu hỏi:** Phân biệt Middleware chạy trước (Before) và chạy sau (After).
**Trả lời:** Trước là code nằm trên `$next()`. Sau là code nằm dưới `$next()`.

**Câu hỏi mẹo:** Middleware của Laravel có thể thay đổi Response không?
**Trả lời:** Có, middleware nhận vào `$response` từ `$next($request)` và có thể modify trước khi return cho client.
