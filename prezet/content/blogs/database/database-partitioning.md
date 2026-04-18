---
title: "Database Partitioning: Chia để trị dữ liệu"
excerpt: Hiểu cách chia bảng dữ liệu thành các phần vật lý nhỏ hơn (Partition) để tăng tốc truy vấn mà không cần thay đổi cấu trúc query.
date: 2026-04-18
category: Database
image: /prezet/img/ogimages/blogs-database-database-partitioning.webp
tags: [database, sql, performance, partitioning, mysql]
---

## 1. Bài toán

Bảng `orders` có 50 triệu dòng. Query `SELECT * FROM orders WHERE created_at > '2026-01-01'` quét qua 50 triệu dòng gây treo hệ thống.

## 2. Giải pháp: Partitioning

Thay vì chia nhỏ DB ra nhiều server (Sharding), bạn chia nhỏ bảng thành các phân vùng vật lý trên **cùng 1 server**.

- **Range Partitioning:** Chia theo khoảng giá trị (vd: theo năm). MySQL sẽ tự động bỏ qua các partition không liên quan khi quét query.

## 3. Lợi ích

- **Query performance:** Quét nhanh hơn hẳn vì chỉ cần đọc tập dữ liệu nhỏ.
- **Maintenance:** Dễ dàng xóa dữ liệu cũ (chỉ cần drop 1 partition thay vì chạy `DELETE` hàng triệu dòng gây lock bảng).

## 4. Câu hỏi nhanh

**Câu hỏi:** Partitioning khác Sharding thế nào?
**Trả lời:** Partitioning nằm trên 1 server, Sharding nằm trên nhiều server. Partitioning giúp tối ưu I/O local, Sharding giúp giải quyết giới hạn phần cứng của 1 máy.
