---
title: "Service Providers: Cách Laravel quản lý vòng đời ứng dụng"
excerpt: Giải mã phương thức register và boot, sự khác biệt giữa eager loading và deferred loading trong Laravel Service Provider.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-laravel-service-provider-internals.webp
tags: [laravel, internals, service-provider, architecture]
---

Service Provider là nơi "bắt đầu" của mọi thứ trong Laravel. Từ việc đăng ký các class vào Container cho đến việc setup middleware, route, view...

## 1. Register vs Boot

- **`register()`:** Chỉ nên thực hiện đăng ký (binding) các class vào Service Container. Tuyệt đối KHÔNG gọi các dịch vụ khác ở đây, vì các provider khác có thể chưa được load.
- **`boot()`:** Chạy sau khi TẤT CẢ các provider đã được load xong. Bạn có thể sử dụng các service đã đăng ký ở bước này.

## 2. Deferred Providers

Để tối ưu, bạn có thể implement `\Illuminate\Contracts\Support\DeferrableProvider`. Khi đó, provider chỉ được load khi service mà nó cung cấp thực sự được gọi đến, giúp request nhẹ hơn đáng kể.

## 3. Quizz phỏng vấn

**Câu hỏi:** Tại sao `boot()` tốn kém hơn `register()`?
**Trả lời:** Vì `boot()` cần kiểm tra và giải quyết toàn bộ dependency graph của các service đã đăng ký.

**Câu hỏi mẹo:** Làm sao để tạo provider load theo cấu hình (ví dụ: chỉ load khi có config `is_enabled`)?
**Trả lời:** Viết điều kiện trong method `isDeferred()` hoặc dùng logic trong `register()` để kiểm tra `config()` trước khi bind.
