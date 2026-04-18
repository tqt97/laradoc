---
title: "Nested Sets & Adjacency List: Cách Laravel xử lý danh mục đa cấp"
excerpt: Giải mã thuật toán duyệt cây danh mục (Category Tree) trong Laravel. So sánh cách truy vấn đệ quy và kỹ thuật Nested Sets.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-algorithms-laravel-nested-sets.webp
tags: [laravel, algorithms, database, tree, nested-sets]
---

## 1. Bài toán
Bạn cần hiển thị danh mục sản phẩm 5 cấp. Truy vấn đệ quy `findChildren()` trong vòng lặp sẽ tạo ra lỗi **N+1 Query** kinh điển.

## 2. Giải pháp 1: Adjacency List (Dễ dùng)
Dùng cột `parent_id`. 
- **Cách xử lý:** Load toàn bộ bảng vào RAM (nếu ít danh mục) và dùng đệ quy hoặc một vòng lặp để build cây.
- **Bản chất:** Đồ thị đơn giản.

## 3. Giải pháp 2: Nested Sets (Tối ưu cho Đọc)
Mỗi node lưu `_lft` (trái) và `_rgt` (phải).
- **Nguyên lý:** Mọi node con đều nằm trong khoảng `(_lft, _rgt)` của node cha.
- **Ưu điểm:** Lấy toàn bộ cây con chỉ bằng 1 câu query SQL: `WHERE _lft > X AND _rgt < Y`. Cực nhanh!

## 4. Ứng dụng trong Laravel
Laravel không build-in Nested Sets, nhưng các package như `franzliedke/larastudent` hoặc `kalnoy/nestedset` là tiêu chuẩn ngành.

## 5. Phỏng vấn Senior
**Q: Khi nào chọn Adjacency List, khi nào chọn Nested Sets?**
**A:** Adjacency List dễ quản lý nhưng `Read` chậm (đệ quy). Nested Sets cực nhanh để `Read` nhưng tốn kém khi `Insert/Move` (phải cập nhật `lft/rgt` của toàn bộ cây).

**Q: Tại sao Laravel Collections lại giúp xử lý cây danh mục dễ hơn?**
**A:** Nhờ `groupBy()` hoặc `recursive()` closure trong Collection, bạn có thể biến danh sách phẳng (flat) từ DB thành cấu trúc cây phức tạp chỉ trong vài dòng code mà không cần đụng tới đệ quy ở tầng DB.
