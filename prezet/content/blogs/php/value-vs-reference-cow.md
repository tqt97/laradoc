---
title: "Value vs Reference: Bí mật Copy-On-Write"
excerpt: Hiểu cách PHP tối ưu bộ nhớ bằng cách 'chia sẻ' dữ liệu và khi nào thì việc copy thực sự xảy ra.
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-value-vs-reference-cow.webp
tags: [php, internals, memory, optimization]
---

## 1. Bản chất: Copy-On-Write (COW)

Khi bạn gán `$a = $b`, PHP không thực sự copy mảng `$b`. Cả 2 biến cùng trỏ về một vùng nhớ (Zval). Chỉ khi bạn sửa đổi `$a`, PHP mới thực hiện copy (thực sự tạo ra vùng nhớ mới cho `$a`).

## 2. Lợi ích

Giúp truyền mảng lớn giữa các hàm mà không tốn bộ nhớ.

## 3. Khi nào COW bị phá vỡ?

- Khi bạn dùng toán tử reference `&$a`. Lúc này PHP buộc phải tách vùng nhớ ngay lập tức vì `$a` và `$b` phải luôn luôn đồng bộ.

## 4. Câu hỏi nhanh

**Q: Truyền tham số cho hàm bằng `&` có nhanh hơn không?**
**A:** Với mảng lớn, truyền tham số thường (value) thực tế lại NHANH HƠN hoặc bằng vì cơ chế COW. Truyền tham số bằng `&` (reference) ép PHP phải dừng tối ưu COW, đôi khi còn làm chậm hơn do phải quản lý cấu trúc reference phức tạp.

**Q: Kinh nghiệm thực chiến?**
**A:** Chỉ dùng `&` khi bạn thực sự muốn thay đổi giá trị của biến gốc. Đừng dùng để tối ưu performance vì nó thường phản tác dụng.
