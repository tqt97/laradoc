---
title: "PHP Memory: Garbage Collection & Reference Counting"
excerpt: Giải mã cách PHP quản lý bộ nhớ. Tìm hiểu về Reference Counting và Cycle Collector để tránh rò rỉ bộ nhớ trong các tác vụ dài (Long-running processes).
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-php-garbage-collection-internals.webp
tags: [php, internals, memory-management, performance]
---

## 1. Bản chất

PHP quản lý bộ nhớ qua hai cơ chế chính:

- **Reference Counting (Đếm tham chiếu):** Mỗi biến có một bộ đếm. Nếu bộ đếm về 0, PHP giải phóng ngay.
- **Cycle Collector:** Nếu 2 object tham chiếu chéo nhau (A trỏ B, B trỏ A), Reference Counting không bao giờ về 0. PHP cần thuật toán này để tìm và xóa các "vòng lặp tham chiếu" (Cyclic References).

## 2. Điểm lưu ý trong Laravel

Trong các tác vụ chạy ngầm (Queue Worker) hoặc Octane (Swoole), ứng dụng không chết sau mỗi request. Nếu bạn tạo một vòng lặp tham chiếu trong Service Container, bộ nhớ sẽ tăng dần cho tới khi sập (Memory Leak).

## 3. Mẹo tối ưu

- Dùng `unset()` hoặc set `null` cho các biến lớn sau khi xử lý xong trong vòng lặp.
- Tránh lưu trữ object lớn vào các `static` property vì chúng tồn tại suốt vòng đời của process.

## 4. Câu hỏi nhanh

**Q: Sự khác biệt giữa `unset($a)` và `$a = null`?**
**A:** `unset` xóa liên kết giữa tên biến và vùng nhớ. `$a = null` chỉ đổi giá trị của vùng nhớ đó thành null (vùng nhớ vẫn tồn tại, nhưng giá trị bị thay đổi). Cả hai đều giúp Reference Count giảm.

**Q: Tại sao Worker chạy lâu lại tốn RAM?**
**A:** Do các object không được giải phóng hoàn toàn vì vẫn còn tham chiếu trong các biến tĩnh (static) hoặc mảng toàn cục của Framework.
