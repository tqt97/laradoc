---
title: "Bloom Filter: Kiểm tra dữ liệu khổng lồ với RAM cực nhỏ"
excerpt: Kỹ thuật kiểm tra sự tồn tại của dữ liệu bằng xác suất (probabilistic data structure), dùng để chống Cache Penetration.
date: 2026-02-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-bloom-filter.webp
tags: [algorithms, bloom-filter, performance, big-data]
---

## 1. Bài toán

Bạn có danh sách 1 tỷ user đã đăng ký. Khi có người đăng ký mới, bạn phải kiểm tra ngay xem username đó đã tồn tại chưa. Đọc 1 tỷ row từ DB hoặc load vào RAM là quá chậm.

## 2. Định nghĩa

**Bloom Filter** là cấu trúc dữ liệu xác suất. Nó có thể trả về:

- **"Chắc chắn KHÔNG tồn tại"**: Kết quả chính xác 100%.
- **"Có thể ĐÃ tồn tại"**: Có sai số nhỏ (False positive).

## 3. Bản chất

Dùng một mảng bit lớn. Khi thêm 1 key, dùng nhiều hàm băm khác nhau để set các vị trí tương ứng trong mảng bit thành 1. Khi check, nếu bất kỳ vị trí nào bằng 0 -> Chắc chắn chưa tồn tại.

## 4. Ứng dụng

- Chống **Cache Penetration**: Nếu Bloom Filter báo không tồn tại, chặn luôn request, không cho chạm vào DB.
- Lọc spam email, kiểm tra URL độc hại.

## 5. Câu hỏi nhanh

**Q: Tại sao không xóa được dữ liệu khỏi Bloom Filter?**
**A:** Vì nhiều phần tử dùng chung 1 bit trong mảng. Nếu bạn xóa (set 0), bạn có thể vô tình xóa luôn sự tồn tại của các phần tử khác.
**Q: Làm sao giảm sai số (False positive)?**
**A:** Tăng kích thước mảng bit hoặc tăng số lượng hàm băm.
