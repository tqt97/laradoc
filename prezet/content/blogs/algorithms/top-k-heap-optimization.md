---
title: "Top-K Elements: Tối ưu với Min-Heap"
excerpt: Giải quyết bài toán 'lấy Top K' từ tập dữ liệu khổng lồ với Min-Heap thay vì Sort, giúp tiết kiệm RAM vượt trội.
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-top-k-heap-optimization.webp
tags: [algorithms, heap, performance, big-data]
---

## 1. Bài toán

Bạn cần lấy Top 10 bài viết có lượt xem cao nhất từ 1 triệu bài viết. Dùng `sort()` toàn bộ sẽ tốn O(n log n) và gây OOM (Out Of Memory).

## 2. Giải pháp: Min-Heap (Kích thước K)

Sử dụng cấu trúc dữ liệu `SplMinHeap` (tích hợp sẵn trong PHP):

- Duyệt qua mảng:
  - Nếu Heap size < 10: `insert` phần tử vào.
  - Nếu Heap size = 10: so sánh phần tử mới với gốc (min). Nếu mới > min, `extract` min ra và `insert` phần tử mới vào.
- **Độ phức tạp:** O(n log K). RAM tốn đúng O(K).

## 3. Code mẫu

```php
$heap = new SplMinHeap();
foreach ($data as $val) {
    $heap->insert($val);
    if ($heap->count() > $k) $heap->extract();
}
// Kết quả là K phần tử còn lại trong Heap
```

## 4. Quizz cho Senior

**Q: Tại sao dùng Heap lại tốt hơn Sort?**
**A:** Sort cần copy toàn bộ dữ liệu, còn Heap chỉ cần giữ K phần tử. O(n log K) luôn tốt hơn O(n log n) khi K << n.
**Q: Khi nào dùng Max-Heap?**
**A:** Khi cần lấy Top K phần tử *nhỏ nhất*. Min-Heap để lấy Top K phần tử *lớn nhất*.
