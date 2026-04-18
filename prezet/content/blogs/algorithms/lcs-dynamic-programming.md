---
title: "Longest Common Subsequence: Quy hoạch động trong so sánh chuỗi"
excerpt: Tìm độ dài chuỗi con chung dài nhất giữa 2 chuỗi. Ứng dụng trong hệ thống Version Control và so sánh dữ liệu.
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-lcs-dynamic-programming.webp
tags: [algorithms, dynamic-programming, optimization]
---

## 1. Bài toán

Cho 2 chuỗi `S1` và `S2`, tìm độ dài chuỗi con chung dài nhất (không nhất thiết liên tiếp).

## 2. Nguyên lý (Quy hoạch động)

Dùng mảng 2D `dp[i][j]` là LCS của `S1[0..i]` và `S2[0..j]`.

- Nếu `S1[i] == S2[j]` -> `dp[i][j] = 1 + dp[i-1][j-1]`
- Nếu khác -> `dp[i][j] = max(dp[i-1][j], dp[i][j-1])`

## 3. Code mẫu

```php
function lcs($s1, $s2) {
    $n = strlen($s1); $m = strlen($s2);
    $dp = array_fill(0, $n+1, array_fill(0, $m+1, 0));
    for($i=1; $i<=$n; $i++) {
        for($j=1; $j<=$m; $j++) {
            if ($s1[$i-1] == $s2[$j-1]) $dp[$i][$j] = 1 + $dp[$i-1][$j-1];
            else $dp[$i][$j] = max($dp[$i-1][$j], $dp[$i][$j-1]);
        }
    }
    return $dp[$n][$m];
}
```

## 4. Câu hỏi nhanh

**Q: Độ phức tạp?**
**A:** O(n*m). Nếu dữ liệu cực lớn, ta phải dùng **Space Optimization** (chỉ lưu 2 dòng cuối cùng của mảng DP) để giảm bộ nhớ từ O(n*m) xuống O(min(n, m)).
