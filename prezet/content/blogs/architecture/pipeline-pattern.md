---
title: "Pipeline Pattern: Chuỗi xử lý Middleware chuyên sâu"
excerpt: Giải mã cơ chế array_reduce của Laravel Pipeline, cách middleware thực thi theo 'Onion Model' và cách áp dụng cho tác vụ nghiệp vụ phức tạp.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-pipeline-pattern.webp
tags: [architecture, laravel, middleware, pipeline, design-pattern]
---

## 1. Bản chất: Onion Model
Pipeline biến một chuỗi các Middleware thành các hàm lồng nhau (nested closures). Khi request đi vào, nó "xuyên qua" các lớp Middleware. Khi response đi ra, nó đi ngược lại.

## 2. Cách Laravel vận hành
Laravel sử dụng `Illuminate\Pipeline\Pipeline`. Bên dưới là hàm `array_reduce`. Nó đảo ngược mảng các Middleware, và dùng mỗi middleware làm "lớp bao bọc" (wrapper) cho lớp kế tiếp.

## 3. Ứng dụng thực tế: Xử lý Business Logic
Nếu bạn có một class `OrderProcessor`, thay vì 1 hàm 500 dòng, hãy chia thành: `CheckInventory`, `ApplyTax`, `ChargePayment`.
```php
app(Pipeline::class)
    ->send($order)
    ->through([CheckInventory::class, ApplyTax::class])
    ->thenReturn();
```

## 4. Quizz cho Senior
**Câu hỏi:** Điều gì xảy ra nếu một Pipe không gọi `$next($request)`?
**Trả lời:** Pipeline dừng lại. Request bị chặn hoàn toàn (đây là cách Middleware chặn request trái phép).

**Câu hỏi mẹo:** Tại sao dùng Pipeline tốt hơn `if/else`?
**Trả lời:** Tăng tính khai báo (declarative), dễ unit test từng bước, và dễ thêm/bớt luồng xử lý mà không làm ảnh hưởng đến code cũ (Open/Closed Principle).
