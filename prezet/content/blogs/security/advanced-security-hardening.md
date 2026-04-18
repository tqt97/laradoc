---
title: "Bảo mật nâng cao: Hardening ứng dụng & OWASP thực chiến"
excerpt: "Các kỹ thuật bảo mật mức Architect: Content Security Policy, HSTS, bảo mật session, và phòng thủ trước các cuộc tấn công tinh vi"
date: 2026-04-18
category: Security
image: /prezet/img/ogimages/blogs-security-advanced-security-hardening.webp
tags: [security, owasp, hardening, web-security]
---

## 1. Content Security Policy (CSP)

Không chỉ là header, CSP là "tường lửa" chặn đứng XSS bằng cách quy định nguồn script/style nào được phép chạy.

- **Cấu hình:** Dùng `Content-Security-Policy` header.
- **Mẹo:** Sử dụng `nonce` (number used once) cho các inline script để ngăn chặn script lạ bị inject.

## 2. HSTS & Bảo mật đường truyền

Ép buộc trình duyệt luôn dùng HTTPS.

- Header: `Strict-Transport-Security: max-age=63072000; includeSubDomains; preload`
- **Tác dụng:** Chặn hoàn toàn các cuộc tấn công SSL Stripping (ép người dùng về HTTP).

## 3. Session Hardening

- **`HttpOnly` & `Secure`:** Ngăn chặn truy cập cookie qua JS (XSS) và đảm bảo chỉ gửi cookie qua HTTPS.
- **Session Rotation:** Luôn gọi `session()->regenerate()` sau khi login để chống **Session Fixation**.

## 4. Quizz cho phỏng vấn

**Q: Làm sao để chống Clickjacking?**
**A:** Dùng header `X-Frame-Options: DENY` hoặc `SAMEORIGIN`. Điều này cấm website khác nhúng trang của bạn vào iframe.

**Q: Tại sao phải tắt `APP_DEBUG` trên Production?**
**A:** Để tránh làm lộ thông tin hệ thống (Database cấu hình, các file code, stack trace) khi ứng dụng gặp lỗi.
