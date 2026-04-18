---
title: "Merge Sort: Thuật toán sắp xếp bền vững"
excerpt: Phân tích tư duy 'Chia để trị' (Divide and Conquer), tại sao Merge Sort luôn giữ O(n log n) và sự đánh đổi về bộ nhớ.
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-merge-sort-deep-dive.webp
tags: [algorithms, sorting, divide-and-conquer, performance]
---

## 1. Bài toán

Sắp xếp một mảng số nguyên. So với QuickSort (có thể O(n²)), Merge Sort đảm bảo độ phức tạp luôn là O(n log n).

## 2. Nguyên lý

1. **Divide:** Chia đôi mảng liên tục cho đến khi mỗi mảng con chỉ còn 1 phần tử.
2. **Conquer:** Trộn (merge) các mảng con đã sắp xếp lại với nhau theo thứ tự tăng dần.

## 3. Code mẫu (PHP)

```php
function mergeSort($arr) {
    if (count($arr) <= 1) return $arr;
    $mid = intdiv(count($arr), 2);
    $left = mergeSort(array_slice($arr, 0, $mid));
    $right = mergeSort(array_slice($arr, $mid));
    return merge($left, $right);
}

function merge($left, $right) {
    $res = [];
    while (count($left) > 0 && count($right) > 0) {
        $res[] = ($left[0] < $right[0]) ? array_shift($left) : array_shift($right);
    }
    return array_merge($res, $left, $right);
}
```

## 4. So sánh

- **vs QuickSort:** Merge Sort ổn định (stable) và không bị trường hợp xấu O(n²), nhưng tốn thêm O(n) bộ nhớ để tạo mảng tạm.
- **vs Bubble/Insertion Sort:** Merge Sort vượt trội hoàn toàn với dữ liệu lớn.

## 5. Câu hỏi nhanh

**Q: Tại sao nói Merge Sort "ổn định" (stable)?**
**A:** Vì các phần tử bằng nhau giữ nguyên thứ tự tương đối như mảng gốc. Rất quan trọng khi bạn sort theo nhiều tiêu chí (ví dụ: sort theo Tên rồi sort theo Ngày).
