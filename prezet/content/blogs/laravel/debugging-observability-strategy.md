---
title: "Debug & Traceability: Làm chủ hệ thống trong Production"
excerpt: Bí kíp debug, trace lỗi và xây dựng hệ thống logging tập trung để không bao giờ phải 'đoán' lỗi ở đâu.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-debugging-observability-strategy.webp
tags: [laravel, debugging, logging, observability, monitoring]
---

## 1. Tư duy Debug chuyên nghiệp

- **Log Level:** Đừng chỉ dùng `info()`. Hãy phân tách `error()`, `warning()`, `debug()` để dễ dàng filter trên Sentry hoặc ELK Stack.
- **Context:** Khi log, luôn truyền thêm `context` (User ID, Request ID).

```php
Log::error('Order failed', ['order_id' => $id, 'user_id' => $user->id]);
```

## 2. Traceability: Đừng để request bị mất dấu

- **Correlation ID:** Mỗi request cần một ID duy nhất (`X-Correlation-ID`). Hãy lưu nó vào header và truyền qua mọi service/log. Khi lỗi xảy ra, chỉ cần search ID này là thấy toàn bộ hành trình của request.

## 3. Đọc lỗi & Debug

- **Sentry/Flare:** Là bắt buộc cho môi trường Production.
- **Debugbar:** Tuyệt đối không để chạy trên Production. Nó leak memory cực khủng.
- **`php artisan tail`:** Cách nhanh nhất để xem log thời gian thực trên server.

## 4. Câu hỏi nhanh

**Q: Sự khác biệt giữa `Log::info` và `Log::channel('slack')->info`?**
**A:** `Log::info` là default channel. `channel()` cho phép routing log tới nơi phù hợp (Slack, Papertrail, Sentry), giúp việc monitor trở nên chủ động.
