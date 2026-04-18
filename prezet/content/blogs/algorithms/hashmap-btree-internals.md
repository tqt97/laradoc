---
title: "HashMaps & B-Tree: Kiến trúc dữ liệu tối ưu I/O"
excerpt: Giải mã bản chất O(1) của Hash Map và O(log n) của B-Tree. Tại sao chúng là nền tảng của mọi Database hiện đại?
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-hashmap-btree-internals.webp
tags: [algorithms, database, performance, data-structures]
---

## 1. Hash Maps (O(1) - "Thần tốc")

Mọi mảng trong PHP (`array`) thực chất là một Hash Map (HashTable).

- **Nguyên lý:** Hash function ánh xạ `key` tới một địa chỉ bucket trong RAM.
- **Tại sao nhanh:** Truy cập vào `isset($map[$key])` không bao giờ phải duyệt danh sách, nó là một phép tính hash đơn giản.
- **Đánh đổi:** Cần bộ nhớ nhiều hơn để duy trì Hash Table và xử lý **Hash Collision** (va chạm).
- **Ứng dụng:** Caching (Redis), In-memory lookup, Session handling.

## 2. B-Tree (O(log n) - "Người canh cửa Disk")

B-Tree (đặc biệt là B+Tree) tối ưu cho việc truy xuất dữ liệu từ ổ cứng (Disk I/O).

- **Cơ chế:** Nó phân cấp dữ liệu thành nhiều tầng (tầng Root -> Nodes -> Leaves). Với hàng chục triệu bản ghi, bạn chỉ tốn 3-4 lần đọc Disk để tìm thấy dữ liệu.
- **Tại sao dùng B-Tree mà không dùng Hash:** B-Tree duy trì thứ tự. Nó hỗ trợ tìm kiếm theo khoảng (`WHERE id > 100`) và sắp xếp (`ORDER BY`) - những thứ Hash Map hoàn toàn không thể làm được.

## 3. Phỏng vấn Senior

**Q: Khi nào B-Tree trở nên chậm?**
**A:** Khi Index quá lớn (không vừa RAM/Buffer Pool), MySQL phải đọc dữ liệu từ Disk. Nếu Index bị phân mảnh (Fragmentation) do `INSERT` giá trị ngẫu nhiên thay vì tăng dần, performance sẽ giảm mạnh.

**Q: Tại sao Hash Table không dùng cho Range Query?**
**A:** Vì hàm băm là ngẫu nhiên. Ví dụ hash('A') và hash('B') hoàn toàn khác nhau, không có quan hệ "gần nhau" để duyệt.
