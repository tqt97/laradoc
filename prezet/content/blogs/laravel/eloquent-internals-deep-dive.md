---
title: "Eloquent Internals: Hydration & Builder - Bên dưới lớp ma thuật"
excerpt: Giải mã quy trình Hydration, sự khác biệt giữa Query Builder và Eloquent Builder, cùng cách tối ưu hóa truy vấn cho dữ liệu lớn.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-eloquent-internals-deep-dive.webp
tags: [laravel, eloquent, internals, database, performance]
---

## 1. Vấn đề

Nhiều dev dùng `User::all()` một cách vô tội vạ, dẫn đến lỗi OOM (Out of Memory) trên các bảng dữ liệu lớn. Bạn cần hiểu tại sao Eloquent lại "ngốn" RAM.

## 2. Định nghĩa & Cơ chế

- **Builder:** `Illuminate\Database\Query\Builder` (SQL thuần) vs `Eloquent\Builder` (Wrapper).
- **Hydration:** Quá trình biến mảng dữ liệu từ Database thành Instance của Model.
- **Quy trình:**
    1. Executing SQL via PDO.
    2. Tạo Model Instance (`new User`).
    3. Đổ dữ liệu vào mảng `$attributes`.
    4. Kích hoạt Event `retrieved`.

## 3. Cách giải quyết tối ưu

- **Query Builder:** Dùng `DB::table()` khi không cần tính năng Model (Accessors, Events).
- **Chunk/Cursor:** Xử lý hàng triệu record bằng `chunk()` (load từng phần) hoặc `cursor()` (dùng Generator load từng dòng).

## 4. Mẹo phỏng vấn

- **Q: Tại sao `update()` trên Builder không chạy Observers?**
- **A:** Vì `update()` chạy SQL trực tiếp xuống DB, bỏ qua bước Hydration (không khởi tạo model) nên Observers không có instance để chạy.
- **Q: `withCount` xử lý N+1 thế nào?**
- **A:** Nó thêm subquery vào câu SELECT chính, tránh phải query thêm bảng quan hệ.

## 5. Kết luận

Eloquent là công cụ tuyệt vời nhưng không phải là "viên đạn bạc". Một Architect cần biết lúc nào nên hy sinh sự tiện lợi của ORM để đổi lấy hiệu năng của SQL thô.
