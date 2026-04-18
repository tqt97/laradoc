---
title: "Laravel Architecture: Tư duy Senior Architect"
excerpt: Phân tích sâu về Service Container, Repository, Action Pattern và cách áp dụng SOLID để xây dựng ứng dụng bền vững.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-laravel-architect-best-practices.webp
tags: [laravel, architecture, solid, clean-code]
---

## 1. Tư duy "Thin Controller"

Controller chỉ làm 2 việc:

1. Validate (qua FormRequest).
2. Gọi Action/Service và trả về Response.

## 2. Repository hay Action?

- **Repository:** Dành cho việc truy vấn dữ liệu phức tạp, ẩn giấu Eloquent khỏi Business Logic.
- **Action:** Dành cho các hành động nghiệp vụ (VD: `CreateOrder`).
*Lời khuyên:* Kết hợp cả hai. Repository lấy data, Action thực thi nghiệp vụ.

## 3. SOLID & Dependency Inversion

Luôn inject Interface vào Constructor thay vì class cụ thể:

```php
public function __construct(PaymentGatewayInterface $gateway) { ... }
```

Nhờ đó, bạn có thể dễ dàng swap giữa `StripeGateway` và `PaypalGateway` chỉ bằng cách thay đổi Binding trong ServiceProvider.

## 4.Câu hỏi nhanh

**Q: Tại sao SerializesModels quan trọng?**
**A:** Nó bảo vệ dữ liệu trong Job. Nếu model bị thay đổi trong DB trước khi worker chạy, nó sẽ fetch lại data mới nhất thay vì dùng data cũ đã bị serialize.

**Q: Làm sao để làm sạch Controller bằng FormRequest?**
**A:** `php artisan make:request`. Chuyển toàn bộ logic validate và authorize ra đó. Controller lúc này chỉ còn 1 dòng: `$request->validated()`.
