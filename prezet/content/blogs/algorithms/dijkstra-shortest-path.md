---
title: "Dijkstra: Tìm đường đi ngắn nhất trong đồ thị"
excerpt: Ứng dụng thuật toán Dijkstra để giải quyết bài toán định tuyến, tối ưu khoảng cách giữa các node trong mạng lưới phân tán.
date: 2026-03-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-dijkstra-shortest-path.webp
tags: [algorithms, graph, dijkstra, optimization, routing]
---

## 1. Bản chất

Dijkstra tìm đường đi ngắn nhất từ một điểm gốc tới tất cả các điểm còn lại trong đồ thị có trọng số không âm (ví dụ: khoảng cách giữa các server, giá cước vận chuyển giữa các tỉnh).

## 2. Cách giải quyết

Dùng một `PriorityQueue` để lưu các node cần duyệt, ưu tiên node có khoảng cách nhỏ nhất hiện tại.

```php
// Tư duy: Luôn chọn node "gần nhất" chưa được xử lý để mở rộng đường đi.
```

## 3. Ứng dụng thực tế

- **Routing:** Tìm đường đi ngắn nhất giữa các datacenter.
- **Logistics:** Tính toán lộ trình giao hàng tối ưu chi phí.

## 4. Câu hỏi nhanh

**Q: Dijkstra có chạy được với trọng số âm không?**
**A:** Không. Nếu có trọng số âm, Dijkstra sẽ thất bại. Phải dùng thuật toán **Bellman-Ford**.

**Q: Tại sao dùng PriorityQueue?**
**A:** Để lấy ra node có khoảng cách nhỏ nhất với độ phức tạp O(log n) thay vì quét toàn bộ O(n).
