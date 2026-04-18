---
title: "PHP Array Optimization: Bản chất thuật toán của các hàm Core"
excerpt: Phân tích độ phức tạp của array_unique, array_intersect và cách sử dụng Hashing để biến bài toán O(n²) thành O(n).
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-php-array-optimization.webp
tags: [algorithms, php, optimization, hashmap]
---

## 1. Bài toán

Bạn cần lọc trùng 1 triệu ID từ 2 mảng. Nếu dùng `in_array` lồng nhau, bạn sẽ có O(n*m). Nếu dùng `array_intersect`, Laravel/PHP sẽ làm gì?

## 2. Bản chất (Hashing)

- **`array_unique`:** PHP dùng nội bộ một `HashTable` để theo dõi các giá trị đã gặp. Chỉ tốn O(n).
- **`array_intersect`:** PHP xây dựng một `HashTable` từ mảng thứ 2, sau đó lặp mảng 1 để kiểm tra sự tồn tại trong `HashTable` đó (O(n+m)).

## 3. Kinh nghiệm thực chiến

- Đừng bao giờ lồng `in_array` bên trong `foreach`. Hãy luôn dùng `array_flip` để tạo `Hash Map` trước (biến Value thành Key).
- Khi xử lý dữ liệu lớn, hãy dùng `Generator` kết hợp với `Hash Map` để tiết kiệm RAM.

## 4. Câu hỏi nhanh

**Q: Tại sao `array_flip` lại giúp tăng tốc O(1)?**
**A:** Vì PHP dùng Hash Table cho Array, truy cập qua Key là O(1), còn qua Value phải quét O(n). Đổi Value thành Key giúp ta sử dụng khả năng truy xuất thần tốc của Hash Table.
