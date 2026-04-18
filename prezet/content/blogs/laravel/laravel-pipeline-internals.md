---
title: "Laravel Pipeline: Giải mã 'Onion Model' của Middleware"
excerpt: Phân tích cơ chế `array_reduce` tạo nên ma thuật Middleware và cách áp dụng Pipeline cho Business Logic phức tạp.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-laravel-pipeline-internals.webp
tags: [laravel, internals, middleware, pipeline, architecture]
---

## 1. Bài toán

Bạn có một hệ thống xử lý Request đi qua 10 lớp Filter (Auth, XSS, Rate limit, Log, Cache...). Code `if/else` sẽ thành thảm họa.

## 2. Giải pháp: Pipeline Pattern

Middleware trong Laravel không chạy tuần tự độc lập, chúng lồng nhau (Onion Model). Khi request vào, nó đi từ ngoài vào trong. Khi response ra, nó đi từ trong ra ngoài.

## 3. Bản chất code

Laravel sử dụng `array_reduce` để cuốn gói các middleware thành một chuỗi closure:

```php
$pipeline = array_reduce(array_reverse($pipes), function ($next, $pipe) {
    return function ($request) use ($next, $pipe) {
        return $pipe->handle($request, $next);
    };
}, $destination);
```

## 4. Ứng dụng & Mẹo

- Dùng Pipeline để làm các "Business Workflow" thay vì middleware: `Pipeline::send($order)->through([...])->thenReturn()`.
- Mỗi lớp chỉ làm đúng 1 việc.

## 5. Phỏng vấn

**Q: Sự khác biệt giữa Filter và Pipe?**
**A:** Filter chỉ trả về true/false để quyết định có đi tiếp không. Pipe có thể biến đổi đối tượng dữ liệu trước khi gửi cho Pipe tiếp theo.
**Q: Pipeline có hỗ trợ async không?**
**A:** Không, Pipeline của Laravel chạy đồng bộ. Để chạy async, bạn cần đẩy vào Queue worker.
