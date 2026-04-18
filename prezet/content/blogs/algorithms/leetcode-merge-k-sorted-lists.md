---
title: "LeetCode: Merge K Sorted Lists - Chiến lược chia để trị"
excerpt: Cách gộp K danh sách đã sắp xếp hiệu quả bằng Min-Heap (Priority Queue).
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-leetcode-merge-k-sorted-lists.webp
tags: [algorithms, leetcode, priority-queue, sorting]
---

## 1. Bài toán
Bạn có K danh sách đã sắp xếp. Gộp chúng lại thành 1 danh sách duy nhất đã sắp xếp.

## 2. Giải pháp: Min-Heap (Priority Queue)
- **Nguyên lý:** Luôn lấy phần tử nhỏ nhất trong K danh sách hiện tại.
- **Quy trình:**
    1. Đẩy phần tử đầu tiên của mỗi danh sách vào `SplMinHeap`.
    2. Trong khi Heap không rỗng:
       - `extract()` phần tử nhỏ nhất ra.
       - Nếu danh sách đó còn phần tử tiếp theo, `insert` vào Heap.

## 3. Code mẫu (PHP)
```php
function mergeKLists($lists) {
    $heap = new SplMinHeap();
    foreach ($lists as $list) { if ($list) $heap->insert($list->pop()); }
    // ... continue logic merge ...
}
```

## 4. So sánh & Phỏng vấn
- **Tại sao Heap?** Nếu gộp thủ công từng cái (O(N*K)), rất chậm. Với Heap, độ phức tạp là O(N log K), trong đó N là tổng số phần tử.
- **Ứng dụng:** Merge log file từ nhiều server, xử lý dữ liệu stream từ nhiều nguồn.
