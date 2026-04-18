---
title: "Service Container: Tips tối ưu & Vòng đời thực chiến"
excerpt: Kinh nghiệm quản lý Service Provider, Singleton vs Bind, và cách tránh lỗi vòng lặp phụ thuộc (Circular Dependency).
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-service-container-lifecycle-tips.webp
tags: [laravel, service-container, ioc, performance]
---

## 1. Khi nào dùng gì?

- **Bind:** Cho các service cần tạo mới mỗi lần (VD: `PaymentGateway` phụ thuộc vào `Order`).
- **Singleton:** Cho các service giữ state (VD: `Settings`, `Config`, `DatabaseConnection`).
- **Scoped (Laravel 8+):** Singleton nhưng chỉ tồn tại trong 1 request. Cực hữu ích để chia sẻ dữ liệu giữa các component trong cùng 1 request mà không sợ bị leak sang request sau.

## 2. Bài học xương máu: Circular Dependency

Đây là lỗi kinh điển khi class A cần B, B cần C, C cần A.

- **Giải pháp:**
    1. **Sử dụng Closure:** Thay vì inject object, hãy inject closure: `function($app) { return $app->make(B::class); }`.
    2. **Refactor:** Nếu gặp lỗi này, nghĩa là thiết kế của bạn đang bị dính quá chặt (tight coupling). Hãy tách một phần logic chung ra một class thứ 3.

## 3. Tips cho Service Provider

- Đừng dùng `Route::get` hay `View::share` trong method `register()`. Laravel chưa sẵn sàng. Hãy để dành chúng cho `boot()`.
- **Deferred Provider:** Nếu service của bạn rất nặng (VD: kết nối service AI, gọi API bên thứ 3), hãy implement `DeferrableProvider`. Laravel sẽ chỉ load service đó khi nó được gọi thực sự. Giảm tải cho toàn bộ các request không dùng đến nó.
