---
title: "Geohash: Tối ưu bài toán vị trí địa lý"
excerpt: Cách biến tọa độ (Latitude, Longitude) thành chuỗi ký tự để thực hiện tìm kiếm gần nhất cực nhanh bằng B-Tree Index.
date: 2026-01-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-geohash-spatial-indexing.webp
tags: [algorithms, geohash, spatial-indexing, database, performance]
---

## 1. Bài toán

Bạn cần tìm "các cửa hàng trong bán kính 5km" từ vị trí của user. Nếu dùng công thức tính khoảng cách `Haversine` (căn, bình phương, sin, cos) trên 1 triệu record, hệ thống sẽ chết vì I/O.

## 2. Giải pháp: Geohash

Geohash chia trái đất thành một lưới các ô vuông (Grid). Nó chuyển đổi (Lat, Lon) thành một chuỗi ký tự (ví dụ: `w21z`).

- **Nguyên lý:** Chuỗi càng dài, diện tích ô vuông càng nhỏ. Các điểm nằm gần nhau sẽ có chuỗi Geohash bắt đầu giống nhau (Prefix).

## 3. Ứng dụng

- Lưu Geohash vào DB dưới dạng `string` và đánh **B-Tree Index**.
- Query: `WHERE geohash LIKE 'w21z%'` (Tìm tất cả điểm trong cùng ô vuông đó). Cực nhanh!

## 4.Câu hỏi nhanh

**Q: Geohash có bị lỗi ở biên không (Border problem)?**
**A:** Có. Hai điểm rất gần nhau có thể nằm ở 2 ô Geohash khác nhau hoàn toàn (ví dụ: cạnh đường xích đạo).
**Giải pháp:** Luôn query thêm 8 ô xung quanh (dùng `WHERE geohash IN (...)`) để đảm bảo không bỏ sót đối tượng.

**Q: Tại sao Geohash lại tốt hơn Haversine trong DB?**
**A:** Haversine cần tính toán trên từng dòng (O(n)), không dùng được Index. Geohash chuyển bài toán hình học phức tạp thành tìm kiếm chuỗi prefix (O(log n)) trên B-Tree Index.
