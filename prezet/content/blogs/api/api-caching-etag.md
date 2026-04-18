---
title: "API Performance: Chiến lược Cache & ETag"
excerpt: Sử dụng Cache layer để tối ưu API và dùng ETag để client không cần tải lại dữ liệu không thay đổi.
date: 2026-04-18
category: API
image: /prezet/img/ogimages/blogs-api-api-caching-etag.webp
tags: [api, performance, cache, etag, http]
---

## 1. ETag (Bí mật của băng thông)

- **Cơ chế:** Server gửi ETag (hash của dữ liệu) trong header. Ở request sau, client gửi lại `If-None-Match: [etag]`.
- **Server:** Nếu dữ liệu chưa đổi, trả về `304 Not Modified` (không gửi dữ liệu, body trống) -> Cực kỳ tiết kiệm băng thông.

## 2. Chiến lược Caching

- **Cache-Control:** `public, max-age=3600`.
- **Kinh nghiệm:** Luôn tách biệt Cache cho User-specific (ví dụ: profile của user A không được cache cho user B). Dùng `Vary: Authorization` header để cache đúng context.

## 3. Phỏng vấn

**Q: Sự khác biệt giữa `304 Not Modified` và `200 OK`?**
**A:** `304` có nghĩa là client vẫn đang giữ bản sao mới nhất, không cần tải lại. `200` có nghĩa là dữ liệu đã được gửi mới hoàn toàn.
**Q: Khi nào KHÔNG nên cache API?**
**A:** Khi dữ liệu có tính biến động cao (Real-time stock, chat, transaction status).
