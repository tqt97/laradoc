---
title: "CQRS trong Laravel: Tách biệt tư duy đọc và ghi"
excerpt: Triển khai kiến trúc CQRS để tối ưu hóa hiệu năng cho các ứng dụng Laravel có luồng dữ liệu phức tạp.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-cqrs-in-laravel.webp
tags: [architecture, cqrs, laravel, performance, scalability]
---

## 1. Vấn đề

Mô hình MVC truyền thống (Fat Model) thường khiến Class bị quá tải. Việc truy vấn (Read) bị trộn lẫn với logic nghiệp vụ (Command) làm performance khó tối ưu.

## 2. Giải pháp

Tách biệt:

- **Command:** Thực hiện logic (tạo đơn, update tiền).
- **Query:** Chỉ lấy dữ liệu (thống kê, search).

## 3. Thực hiện

Trong Laravel:

- **Commands:** Tạo các class `RegisterUserCommand`, `PlaceOrderCommand` và sử dụng `CommandBus`.
- **Queries:** Tạo các `QueryService` trả về DTOs, dùng Database thô để đạt tốc độ nhanh nhất.

## 4. Câu hỏi nhanh

**Q: Tại sao phải tách biệt?**
**A:** Vì việc Đọc và Ghi có yêu cầu tài nguyên khác nhau. Đọc có thể cache, ghi cần nhất quán.
**Q: Nhược điểm?**
**A:** Codebase bị tăng gấp đôi, cần hệ thống sync dữ liệu giữa Read/Write DB (nếu tách DB).
