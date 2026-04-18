---
title: "API Security: Bảo mật và Kiểm soát tải"
excerpt: Bảo mật API với Sanctum, cơ chế Rate Limiting, CORS và phòng chống tấn công API.
date: 2026-04-18
category: API
image: /prezet/img/ogimages/blogs-api-api-security-best-practices.webp
tags: [api, security, sanctum, rate-limiting]
---

## 1. Authentication

- **Sanctum (SPA/Mobile):** Dùng `Stateful session` cho web (cookie) và `API Token` cho mobile.
- **Passport (OAuth2):** Cho các hệ thống phức tạp, cho phép bên thứ 3 cấp quyền (Scopes).

## 2. Bảo mật & Rate Limiting

- **CORS:** Cấu hình đúng `cors.php` để chỉ cho phép domain tin cậy gọi API.
- **Rate Limiting:** Sử dụng `RateLimiter` của Laravel để chống DoS và brute-force.

```php
RateLimiter::for('api', function (Request $request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```

## 3. Câu hỏi nhanh

**Q: Sự khác biệt giữa Authentication và Authorization?**
**A:** Authentication (bạn là ai? - Token, Password). Authorization (bạn được làm gì? - Policies, Gates).
**Q: Tại sao phải dùng Hashing cho API Tokens?**
**A:** Giống như mật khẩu, API Token nếu lưu dạng thô (plain text) trong DB sẽ cực kỳ nguy hiểm. Laravel Sanctum băm token bằng `SHA-256` trước khi lưu vào DB.
