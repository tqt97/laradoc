---
title: "Service Container Deep Dive: Cơ chế Auto-wiring & Reflection"
excerpt: Giải mã sức mạnh của Service Container. Tại sao bạn không cần 'new' class? Tìm hiểu về Reflection API và Dependency Injection.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-laravel-service-container-deep-dive.webp
tags: [laravel, service-container, di, internals]
---

## 1. Bài toán

Laravel cho phép bạn type-hint `Request $request` trong controller. Nó lấy instance từ đâu? Tại sao nó biết class đó cần gì?

## 2. Bản chất (Reflection)

Container dùng Reflection API (`ReflectionClass`, `ReflectionMethod`) để soi constructor của class.

1. Tìm constructor.
2. Kiểm tra các tham số của constructor.
3. Với mỗi tham số, Container lại đệ quy tìm cách khởi tạo.

## 3. Tại sao dùng Container?

- **Decoupling:** Code không bị "cứng" vào một implementation. Có thể đổi class `EmailService` thành `SnsService` chỉ bằng 1 dòng bind.
- **Dễ Unit Test:** Thay vì gọi Service thật, ta bind một Mock vào Container khi chạy test.

## 4. Câu hỏi nhanh

**Q: Singleton vs Bind?**
**A:** Singleton: Tạo 1 instance duy nhất, dùng lại mãi mãi. Bind: Tạo mới mỗi lần được gọi (Factory pattern).
**Q: Lỗi "Circular Dependency" xảy ra khi nào?**
**A:** Khi Class A cần Class B, và Class B lại cần Class A. Container sẽ đứng hình (loop đệ quy).
*Mẹo:* Sử dụng `Closure` hoặc `Setter Injection` để ngắt vòng lặp này.
