---
title: "API Security: Throttling & Signed URLs chuyên sâu"
excerpt: Bảo vệ API khỏi DoS bằng Rate Limiting và cách dùng Signed URLs để tạo các link tạm thời bảo mật.
date: 2026-04-18
category: API
image: /prezet/img/ogimages/blogs-api-throttling-signed-urls.webp
tags: [api, security, throttle, signed-urls]
---

## 1. Rate Limiting (Throttling)

- **Cơ chế:** Đếm số request dựa trên IP hoặc User ID.
- **Tối ưu:** Dùng `Redis` driver để lưu counter. Không dùng `Database` hay `File` vì I/O quá chậm.
- **Kinh nghiệm:** Luôn cấu hình fallback (ví dụ: dùng `Redis` nhưng nếu Redis chết, có thể cấu hình `RateLimiter::for` để fallback về in-memory).

## 2. Signed URLs (Bảo mật tạm thời)

- **Nguyên lý:** Đính kèm một chữ ký số (`signature`) vào URL. Nếu hacker đổi 1 ký tự, chữ ký sẽ không khớp -> Request bị từ chối.
- **Ứng dụng:** Link download file tạm thời, Link xác thực email, Link reset password.

## 3. Phỏng vấn

**Q: Sự khác biệt giữa Throttling dựa trên IP và User ID?**
**A:** IP dễ bị "giả mạo" hoặc chung IP (NAT). User ID an toàn hơn nhưng đòi hỏi User phải login. System tốt nhất là kết hợp cả hai.

**Q: Làm sao để kiểm tra URL có hợp lệ không trước khi nó hết hạn?**
**A:** Dùng `URL::hasValidSignature($request)` trong middleware. Laravel tự động băm lại URL và so sánh với hash được cung cấp.
