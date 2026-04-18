---
title: "Chain of Responsibility: Chuỗi xử lý Middleware"
excerpt: Chain of Responsibility cho phép chuyển yêu cầu qua một chuỗi các trình xử lý. Đây là cách Laravel vận hành Middleware.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-chain-of-responsibility.webp
tags: [design-patterns, php, laravel, middleware, architecture]
---

## 1. Ý tưởng

Bạn có một Request đi qua: Kiểm tra Auth -> Kiểm tra Spam -> Check CSRF -> Đến Controller. Thay vì viết 1 hàm dài, mỗi bước là 1 object độc lập.

## 2. Cách Laravel vận hành

Laravel sử dụng `Pipeline` để thực hiện pattern này.

```php
$pipeline->send($request)
    ->through([CheckAuth::class, CheckSpam::class])
    ->then($router);
```

## 3. Bản chất

Mỗi handler giữ một tham chiếu tới "handler tiếp theo". Nếu nó xử lý xong, nó gọi tiếp. Nếu không, nó chặn đứng yêu cầu (ví dụ: Auth lỗi -> trả về 401 ngay).
