---
title: "LeetCode: Two Sum - Giải pháp tối ưu với HashMap"
excerpt: Phân tích sự đánh đổi giữa Brute Force (O(n²)) và HashMap (O(n)) trong bài toán kinh điển Two Sum.
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-leetcode-two-sum.webp
tags: [algorithms, leetcode, hashmap, optimization]
---

## 1. Bài toán

Tìm 2 số trong mảng có tổng bằng `target`. Trả về index của chúng.

## 2. Các cách giải

### Cách 1: Brute Force (O(n²))

Duyệt 2 vòng lặp lồng nhau.

- **Ưu điểm:** Dễ hiểu.
- **Nhược điểm:** Quá chậm với mảng lớn.

### Cách 2: HashMap (O(n) - Tối ưu)

Duyệt qua mảng 1 lần, dùng HashMap lưu `giá trị => index`.
Tại mỗi số `n`, kiểm tra `target - n` đã tồn tại trong Map chưa.

## 3. Code mẫu (PHP)

```php
function twoSum($nums, $target) {
    $map = []; // value => index
    foreach ($nums as $i => $n) {
        $diff = $target - $n;
        if (isset($map[$diff])) return [$map[$diff], $i];
        $map[$n] = $i;
    }
}
```

## 4. So sánh & Phỏng vấn

- **Q: Tại sao dùng HashMap nhanh hơn?**
- **A:** Vì `isset()` trên HashMap là O(1), biến vòng lặp trong thành bước lookup cực nhanh, giảm độ phức tạp từ O(n²) xuống O(n).
- **Q: Đánh đổi là gì?**
- **A:** Tốn thêm O(n) bộ nhớ để lưu HashMap. Đây là sự đánh đổi kinh điển giữa **Time** và **Space**.
