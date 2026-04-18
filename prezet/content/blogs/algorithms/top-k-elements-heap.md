---
title: "Heap & Top K: Tối ưu bài toán xếp hạng"
excerpt: Sử dụng Max/Min Heap để tìm Top K phần tử mà không cần sort toàn bộ mảng, tiết kiệm RAM tối đa cho hệ thống Backend.
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-top-k-elements-heap.webp
tags: [algorithms, heap, performance, optimization]
---

## 1. Bài toán

Bạn cần lấy 10 sản phẩm có nhiều view nhất từ danh sách 1 triệu sản phẩm. Sort toàn bộ là O(n log n), không hiệu quả.

## 2. Giải pháp: Min-Heap

- **Nguyên lý:** Duy trì một cái túi (Heap) chỉ chứa 10 phần tử.
- **Quy trình:**
    1. Với mỗi phần tử mới, nếu Heap chưa đủ 10 -> push vào.
    2. Nếu Heap đã đủ 10 -> so sánh với phần tử nhỏ nhất (gốc heap). Nếu phần tử mới lớn hơn gốc, thay thế gốc và thực hiện *re-heapify*.

## 3. Code mẫu (PHP)

```php
$minHeap = new SplMinHeap();
foreach ($items as $item) {
    $minHeap->insert($item);
    if ($minHeap->count() > 10) $minHeap->extract();
}
```

## 4. Kinh nghiệm

Luôn sử dụng `SplMinHeap` (tích hợp sẵn trong PHP) thay vì tự viết Heap. Nó đã được tối ưu hóa bằng C (Zend Engine).

## 5. Phỏng vấn

- **Q: Tại sao Heap tốt hơn Sort?** Sort cần copy mảng (nếu không sort in-place) và O(n log n). Heap giữ đúng K phần tử trong RAM và O(n log K).
- **Q: Ứng dụng?** Leaderboard trong game, Top 10 bài viết, Log lỗi thường gặp nhất.
