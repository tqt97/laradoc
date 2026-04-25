---
title: Bridge Pattern - Cây cầu kết nối
excerpt: Tìm hiểu Bridge Pattern - cách tách biệt cấu trúc trừu tượng và triển khai, giải quyết bài toán "bùng nổ class".
category: Design pattern
date: 2026-04-12
order: 36
image: /prezet/img/ogimages/series-design-pattern-bridge-pattern.webp
---

> Pattern thuộc nhóm **Structural Pattern (Cấu trúc)**

## 1. Problem & Motivation
Có 2 chiều thay đổi độc lập: **Loại bài viết** (Blog, Snippet) và **Định dạng** (Web, JSON). Nếu kế thừa (inheritance), bạn cần 2x2 = 4 class. Nếu thêm 1 loại và 1 định dạng → bùng nổ class.

## 2. Định nghĩa
**Bridge Pattern** tách biệt cấu trúc trừu tượng (Abstraction) và triển khai (Implementation) thành 2 phân cấp riêng biệt, kết nối chúng qua một "cây cầu" (Composition).

## 3. Implementation
```php
abstract class Post {
    public function __construct(protected Renderer $renderer) {}
}

class BlogPost extends Post {
    public function show() { return $this->renderer->render("Blog"); }
}
```

## 4. Liên hệ Laravel
Hệ thống Driver của Laravel (Storage, Mail) chính là Bridge: Interface (`Storage`) là trừu tượng, Driver (`S3`, `Local`) là triển khai.

## 5. Kết luận
Bridge giúp tránh "bùng nổ class" bằng cách ưu tiên Composition thay vì Inheritance.
