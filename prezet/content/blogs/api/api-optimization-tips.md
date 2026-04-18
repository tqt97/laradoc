---
title: "API Optimization: Tối ưu hiệu năng ở mức Architect"
excerpt: "Các kỹ thuật tăng tốc API: Eager Loading, JSON Compression, và Pagination chiến lược"
date: 2026-04-18
category: API
image: /prezet/img/ogimages/blogs-api-api-optimization-tips.webp
tags: [api, performance, optimization, json]
---

## 1. Pagination chiến lược

- **Offset Pagination:** (`?page=1`) - Chậm khi offset quá lớn (phải scan qua N bản ghi).
- **Cursor Pagination:** Dùng `cursorPaginate()` của Laravel. Nó không dựa vào page mà dựa vào ID cuối cùng (`where id > last_id`). Cực kỳ nhanh với bảng triệu dòng.

## 2. JSON Optimization

- **Eager Loading:** Luôn `with()` quan hệ.
- **API Resources:** Dùng để lọc field (chỉ trả về những gì client cần).
- **JSON Compression:** Bật `Gzip` hoặc `Brotli` ở tầng Nginx. Payload giảm 70-80% là chuyện bình thường.

## 3. Phỏng vấn

**Q: Làm sao xử lý API trả về 10.000 record mà không treo server?**
**A:** Không bao giờ trả về 10.000 record trong 1 request. Sử dụng **Pagination** hoặc **Streaming Response**. Nếu bắt buộc, dùng `LazyCollection` để đọc từng dòng và stream ra response trực tiếp.
