---
title: "Knapsack Problem: Bài toán tối ưu hóa tài nguyên"
excerpt: Giải quyết bài toán cái túi với Quy hoạch động. Ứng dụng trong phân bổ tài nguyên, budget-management.
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-knapsack-dp.webp
tags: [algorithms, dynamic-programming, optimization]
---

## 1. Bài toán

Bạn có một cái túi sức chứa `W`. Bạn có `n` vật phẩm, mỗi cái có `weight` và `value`. Làm sao để chọn vật phẩm sao cho tổng giá trị lớn nhất mà không vượt quá `W`?

## 2. Giải pháp: Quy hoạch động

Dùng một mảng 2D `dp[n][W]` lưu giá trị lớn nhất tại mỗi mức trọng lượng.

- **Công thức:** `dp[i][w] = max(dp[i-1][w], value[i] + dp[i-1][w - weight[i]])`

## 3. Code mẫu (PHP)

```php
function knapsack($W, $wt, $val, $n) {
    $dp = array_fill(0, $n + 1, array_fill(0, $W + 1, 0));
    for ($i = 1; $i <= $n; $i++) {
        for ($w = 1; $w <= $W; $w++) {
            if ($wt[$i-1] <= $w)
                $dp[$i][$w] = max($val[$i-1] + $dp[$i-1][$w-$wt[$i-1]], $dp[$i-1][$w]);
            else
                $dp[$i][$w] = $dp[$i-1][$w];
        }
    }
    return $dp[$n][$W];
}
```

## 4. Ứng dụng & Phỏng vấn

- **Ứng dụng:** Tối ưu hóa phân bổ tài nguyên server, chọn gói combo bán hàng.
- **Q: Độ phức tạp là gì?** A: O(n*W). Nếu W rất lớn, cần dùng cách tiếp cận khác hoặc xấp xỉ (heuristic).
