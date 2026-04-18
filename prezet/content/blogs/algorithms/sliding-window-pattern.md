---
title: "Sliding Window: Tối ưu bài toán mảng con"
excerpt: Kỹ thuật cửa sổ trượt (Sliding Window) - cách giải quyết các bài toán mảng con (subarray) trong thời gian O(n).
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-sliding-window-pattern.webp
tags: [algorithms, array, sliding-window, optimization]
---

## 1. Vấn đề

Tìm mảng con có tổng lớn nhất với độ dài cố định `k` trong một mảng `n`. Cách ngây thơ là tính tổng từng đoạn, độ phức tạp O(n*k).

## 2. Định nghĩa

**Sliding Window** là kỹ thuật duy trì một "cửa sổ" trượt trên mảng. Khi trượt sang phải, ta chỉ cần trừ đi phần tử cũ bên trái và cộng thêm phần tử mới bên phải. Độ phức tạp: O(n).

## 3. Code mẫu

```php
function maxSubarraySum($arr, $k) {
    $currentSum = array_sum(array_slice($arr, 0, $k));
    $maxSum = $currentSum;
    for ($i = $k; $i < count($arr); $i++) {
        $currentSum += $arr[$i] - $arr[$i - $k];
        $maxSum = max($maxSum, $currentSum);
    }
    return $maxSum;
}
```

## 4. Câu hỏi nhanh

**Q: Khi nào cửa sổ "co giãn" (Variable window)?**
**A:** Khi bạn cần tìm mảng con ngắn nhất/dài nhất thỏa mãn điều kiện (ví dụ: mảng con có tổng >= S). Ta mở rộng window bên phải, nếu điều kiện thỏa mãn thì co window bên trái lại để tối ưu.

**Q: Lợi ích lớn nhất?**
**A:** Biến bài toán O(n²) thành O(n). Cực kỳ quan trọng trong xử lý dữ liệu stream.
