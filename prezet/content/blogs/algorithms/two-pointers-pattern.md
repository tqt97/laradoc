---
title: "Two Pointers: Chiến lược tối ưu O(n) cho mảng"
excerpt: Kỹ thuật dùng 2 con trỏ để giải quyết các bài toán tìm cặp số, mảng con trong O(n) thay vì O(n²).
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-two-pointers-pattern.webp
tags: [algorithms, array, two-pointers, optimization]
---

## 1. Bài toán
Tìm 2 số trong mảng có tổng bằng `target` (mảng đã sort). Brute force là O(n²), với Two Pointers là O(n).

## 2. Nguyên lý
Đặt 1 con trỏ ở đầu (left), 1 con trỏ ở cuối (right).
- Nếu `sum > target` -> Giảm `right` để sum nhỏ lại.
- Nếu `sum < target` -> Tăng `left` để sum lớn hơn.

## 3. Code mẫu (PHP)
```php
function twoSumSorted($arr, $target) {
    $left = 0; $right = count($arr) - 1;
    while ($left < $right) {
        $sum = $arr[$left] + $arr[$right];
        if ($sum == $target) return [$left, $right];
        $sum < $target ? $left++ : $right--;
    }
}
```

## 4. Ứng dụng & So sánh
- **So sánh:** Thay vì lồng 2 vòng lặp (O(n²)), bạn chỉ duyệt 1 lần (O(n)).
- **Ứng dụng:** Tìm cặp số, lọc phần tử trùng (xóa trùng mảng sort), đảo ngược mảng tại chỗ (in-place).

## 5. Kết luận
Two Pointers là kỹ thuật cơ bản nhất để tối ưu các bài toán liên quan đến mảng, là công cụ "thần thánh" cho mọi Senior khi đối mặt với LeetCode.
