---
title: "API Architecture: Global Exception Handler & Standard Response"
excerpt: Cách chuẩn hóa response API và bắt toàn bộ ngoại lệ tập trung để tránh lộ stack trace và tạo trải nghiệm đồng nhất cho client.
date: 2026-04-18
category: API
image: /prezet/img/ogimages/blogs-api-global-exception-handler.webp
tags: [api, architecture, exception-handling, laravel]
---

## 1. Vấn đề

Mỗi khi có lỗi (ví dụ: `ModelNotFoundException`), Laravel trả về trang HTML "404 Not Found" hoặc Stack Trace. Client (Mobile/Frontend) sẽ bị crash vì mong đợi JSON.

## 2. Giải pháp: Centralized Error Handler

Sử dụng `App\Exceptions\Handler` để bắt mọi lỗi và chuyển đổi sang một chuẩn JSON.

```php
// app/Exceptions/Handler.php
public function register() {
    $this->renderable(function (NotFoundHttpException $e, $request) {
        return response()->json(['error' => 'Resource not found'], 404);
    });
}
```

## 3. Tư duy "Standard Response"

Luôn trả về 1 cấu trúc duy nhất cho cả thành công và thất bại:

```json
{
  "success": false,
  "message": "Validation failed",
  "data": null,
  "errors": { "email": ["The email is invalid"] }
}
```

- **Kinh nghiệm:** Tránh trả về HTTP 200 cho lỗi nghiệp vụ (ví dụ: `{"status": "error", "message": "..."}`). Hãy dùng đúng HTTP Status Code (400, 401, 403, 422, 500).

## 4. Câu hỏi nhanh

**Q: Tại sao phải ẩn Stack Trace trên Production?**
**A:** Stack trace lộ cấu trúc thư mục, phiên bản PHP, cấu hình Database. Đây là nguồn thông tin "vàng" cho hacker thực hiện SQL Injection hoặc local file inclusion.
**Q: Nên log những gì ở Global Handler?**
**A:** Chỉ log các lỗi `500`. Các lỗi 4xx (404, 422) là do client, không cần spam log server trừ khi muốn track behavior của user.
