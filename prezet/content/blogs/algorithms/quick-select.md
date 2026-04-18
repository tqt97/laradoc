---
title: "QuickSelect: Tìm phần tử K-th trong O(n)"
excerpt: Tìm phần tử lớn thứ K mà không cần sort toàn bộ mảng. Thuật toán tối ưu dựa trên tư duy của QuickSort.
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-quick-select.webp
tags: [algorithms, sorting, performance]
---

## 1. Bài toán

Tìm số lớn thứ K trong một mảng chưa sắp xếp. QuickSort tốn O(n log n). QuickSelect tốn trung bình O(n).

## 2. Bản chất

Dựa trên tư duy của **QuickSort**:

1. Chọn Pivot.
2. Partition mảng (trái nhỏ hơn, phải lớn hơn).
3. Thay vì đệ quy cả 2 phía, chỉ đệ quy vào phía chứa vị trí K.

## 3. Code mẫu

```php
function quickSelect(array $arr, $k) {
    $pivot = $arr[array_rand($arr)];
    $left = array_filter($arr, fn($x) => $x < $pivot);
    $right = array_filter($arr, fn($x) => $x > $pivot);
    
    if ($k <= count($right)) return quickSelect($right, $k);
    if ($k == count($right) + 1) return $pivot;
    return quickSelect($left, $k - count($right) - 1);
}
```

## 4. Câu hỏi nhanh

**Q: Độ phức tạp xấu nhất của QuickSelect?**
**A:** O(n²), xảy ra khi pivot chọn tệ nhất liên tục. **Mẹo:** Dùng Median-of-three để chọn pivot nhằm tránh trường hợp này.
