---
title: "Subarray Sum Equals K: Tối ưu với Prefix Sum & HashMap"
excerpt: Giải quyết bài toán tìm số lượng mảng con có tổng bằng K trong O(n) thay vì O(n²) bằng kỹ thuật Prefix Sum.
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-subarray-sum-k.webp
tags: [algorithms, hashmap, optimization, array]
---

## 1. Bài toán

Tìm số lượng mảng con liên tiếp có tổng bằng `K`.

## 2. Bản chất (Prefix Sum + HashMap)

- Tổng mảng con `[i, j]` = `Sum[j] - Sum[i-1]`.
- Ta cần: `Sum[j] - Sum[i-1] == K` => `Sum[i-1] == Sum[j] - K`.
- Dùng HashMap để đếm số lần `Sum[i-1]` xuất hiện trước đó.

## 3. Code mẫu (PHP)

```php
function subarraySum($nums, $k) {
    $count = 0; $sum = 0; $map = [0 => 1];
    foreach ($nums as $n) {
        $sum += $n;
        if (isset($map[$sum - $k])) $count += $map[$sum - $k];
        $map[$sum] = ($map[$sum] ?? 0) + 1;
    }
    return $count;
}
```

## 4. Phỏng vấn Senior

**Q: Tại sao dùng HashMap lại tối ưu hơn lồng vòng lặp?**
**A:** Brute force duyệt O(n²) vì mỗi điểm kết thúc, nó phải lặp lại từ đầu. HashMap cho phép tra cứu O(1) xem "đã từng có đoạn nào có tổng X chưa".

**Q: Khi nào bài toán này hữu ích trong Web?**
**A:** Khi cần phân tích log, đếm các cửa sổ thời gian có tổng lỗi vượt ngưỡng hoặc logic giao dịch tài chính.
