---
title: "API Design: Từ RESTful đến Versioning chuyên nghiệp"
excerpt: Bí kíp thiết kế API nhất quán, dễ dùng và cách Versioning không gây 'đứt gãy' hệ thống cũ.
date: 2026-04-18
category: API
image: /prezet/img/ogimages/blogs-api-restful-design-versioning.webp
tags: [api, rest, versioning, best-practices]
---

## 1. Triết lý RESTful

- **Resource-based:** URL đại diện cho tài nguyên (VD: `/users`, `/orders/123`), không dùng động từ (`/getUsers`).
- **HTTP Methods:** Tuân thủ `GET` (đọc), `POST` (tạo), `PUT/PATCH` (update), `DELETE` (xóa).
- **Status Codes:** Dùng đúng chuẩn: `200` OK, `201` Created, `400` Bad Request, `401` Unauthorized, `403` Forbidden, `422` Validation Error, `500` Server Error.

## 2. Versioning: Đừng bao giờ 'Breaking change'

- **Header Versioning:** `Accept: application/vnd.myapi.v1+json`. (Sạch nhất, chuẩn REST).
- **URI Versioning:** `/api/v1/users`. (Dễ dùng, phổ biến nhất).
- **Kinh nghiệm:** Luôn giữ ít nhất 2 phiên bản (đang dùng và cũ nhất). Khi deprecated, hãy trả về header `Warning: 299 - "This API version will be removed on 2026-12-31"`.

## 3. Phỏng vấn

**Q: PUT vs PATCH?**
**A:** `PUT` thay thế toàn bộ resource (replace). `PATCH` chỉ cập nhật một phần (partial update).
**Q: Tại sao phải dùng API Resources?**
**A:** Để tách lớp giữa Cấu trúc Database và Cấu trúc JSON trả về. Điều này giúp bạn đổi cấu trúc DB mà không làm ảnh hưởng đến Client.
