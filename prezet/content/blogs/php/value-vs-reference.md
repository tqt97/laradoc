---
title: "PHP: Tham trị (Value) vs Tham chiếu (Reference)"
excerpt: Bản chất việc truyền dữ liệu trong PHP, tại sao truyền tham chiếu làm hỏng COW và ảnh hưởng của nó đến hiệu năng.
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-value-vs-reference.webp
tags: [php, internals, memory-management]
---

## 1. Tham trị (Pass by Value)

Mặc định PHP truyền giá trị. Khi bạn truyền một biến vào hàm, PHP tạo ra một bản sao.
*Đặc biệt:* Nhờ cơ chế **Copy-on-Write (COW)**, PHP thực sự không copy ngay. Chỉ khi bạn thay đổi giá trị trong hàm, bản sao mới thực sự được tạo.

## 2. Tham chiếu (Pass by Reference)

Dùng `&$var`. Hàm sẽ tác động trực tiếp lên biến gốc.

- **Rủi ro:** Làm hỏng cơ chế COW của Zend Engine, buộc PHP phải tạo ra "Reference object" cồng kềnh.
- **Lời khuyên:** Chỉ dùng khi thực sự cần thay đổi biến gốc. Đừng lạm dụng để "tăng tốc".
