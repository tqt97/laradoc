---
title: "Binary Search: Không chỉ là O(log n)"
excerpt: Kỹ thuật tìm kiếm nhị phân và các biến thể tìm 'điểm bắt đầu/kết thúc' trong mảng đã sắp xếp.
date: 2026-01-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-binary-search-variants.webp
tags: [algorithms, binary-search, performance]
---

## 1. Bài toán

Tìm một giá trị hoặc "vị trí xuất hiện đầu tiên/cuối cùng" của một phần tử trong mảng đã sort.

## 2. Nguyên lý (O(log n))

Chia đôi không gian tìm kiếm. Nếu `mid > target`, tìm bên trái, ngược lại tìm bên phải.

## 3. Các biến thể quan trọng

- **Tìm phần tử đầu tiên (Lower Bound):** Nếu tìm thấy `target`, chưa dừng lại mà tiếp tục tìm bên trái để đảm bảo là phần tử đầu tiên.
- **Tìm phần tử cuối cùng (Upper Bound):** Tương tự, tìm tiếp bên phải.

## 4. Code mẫu (PHP)

```php
function binarySearch($arr, $target) {
    $left = 0; $right = count($arr) - 1;
    while ($left <= $right) {
        $mid = intdiv($left + $right, 2);
        if ($arr[$mid] == $target) return $mid;
        ($arr[$mid] < $target) ? $left = $mid + 1 : $right = $mid - 1;
    }
    return -1;
}
```

## 5. So sánh & Kinh nghiệm

- **So sánh:** Tìm kiếm tuyến tính (O(n)) vs Nhị phân (O(log n)). Với 1 triệu phần tử, Linear cần 1 triệu bước, Binary Search chỉ cần ~20 bước.
- **Kinh nghiệm:** Luôn kiểm tra mảng đã sort chưa. Nếu không, phải Sort trước (O(n log n)). Đừng dùng cho mảng nhỏ (tốn overhead).

## 6. Kết luận

Binary Search là "tiêu chuẩn vàng" cho tìm kiếm dữ liệu đã sắp xếp. Hãy ghi nhớ các biến thể Lower/Upper Bound vì chúng thường xuất hiện trong các bài toán thực tế (ví dụ: tìm dải thời gian trong log).
