---
title: "Database Partitioning: Chia để trị dữ liệu lớn"
excerpt: Phân tích kỹ thuật Partitioning (Range, List, Hash) giúp tối ưu I/O và query performance trên các bảng dữ liệu hàng trăm triệu record.
date: 2026-04-18
category: Database
image: /prezet/img/ogimages/blogs-database-database-partitioning-deep-dive.webp
tags: [database, sql, mysql, performance, partitioning]
---

## 1. Bản chất
Partitioning chia một table lớn thành các "phân vùng" vật lý (được lưu trữ thành các file riêng biệt). Khi bạn query, MySQL chỉ cần "nhảy" vào đúng phân vùng chứa dữ liệu (Partition Pruning), bỏ qua các phân vùng không liên quan.

## 2. Các chiến lược phổ biến
- **Range Partitioning:** Dựa trên dải giá trị (ví dụ: `created_at` theo năm). Cực tốt cho việc xóa dữ liệu cũ (chỉ cần drop partition).
- **Hash Partitioning:** Dùng hàm băm trên cột (ví dụ: `id`) để phân phối dữ liệu đều ra các partition. Tránh hiện tượng Hot Partition.
- **List Partitioning:** Phân loại theo danh sách giá trị cố định (ví dụ: `region` gồm `VN`, `US`, `EU`).

## 3. Mẹo phỏng vấn
**Q: Sự khác biệt giữa Partitioning và Sharding?**
**A:** Partitioning chia table trên **1 máy chủ** để tối ưu I/O. Sharding chia dữ liệu ra **nhiều máy chủ** để tối ưu CPU/RAM và dung lượng đĩa.

**Q: Khi nào Partitioning trở thành "cái bẫy"?**
**A:** Khi bạn query không có cột Partition Key trong `WHERE`. MySQL buộc phải quét toàn bộ các partition (Full scan toàn bộ dữ liệu), lúc này còn chậm hơn một bảng thường.

## 4. Kết luận
Dùng Partitioning khi bảng dữ liệu quá lớn (100tr+ row) và bạn có các query lọc theo thời gian hoặc danh mục rõ ràng.
