---
title: "KMP (Knuth-Morris-Pratt): Tìm kiếm chuỗi tối ưu"
excerpt: Giải quyết bài toán tìm kiếm chuỗi con bằng bảng tiền tố để đạt độ phức tạp O(n+m).
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-kmp-string-search.webp
tags: [algorithms, search, string, kmp]
---

## 1. Bài toán
Tìm chuỗi con (pattern) trong chuỗi mẹ (text). Cách tìm thông thường (`strpos` ngây thơ) có thể tốn O(n*m).

## 2. Nguyên lý (O(n+m))
- **Lỗi của cách cũ:** Khi khớp sai, con trỏ quay lại từ đầu. KMP dùng bảng tiền tố (LPS - Longest Prefix Suffix) để biết được "đã khớp được bao nhiêu" và nhảy cóc bỏ qua các bước thừa.

## 3. Code mẫu (PHP)
```php
function kmpSearch($text, $pattern) {
    $n = strlen($text); $m = strlen($pattern);
    $lps = computeLPS($pattern);
    // ... logic duyệt ...
}
```

## 4. So sánh
- **vs Naive Search:** Naive O(n*m), KMP O(n+m). Trong trường hợp chuỗi dài và pattern lặp lại nhiều (ví dụ "aaaaab"), KMP cực nhanh.

## 5. Ứng dụng
- Tìm kiếm từ khóa trong các file log lớn hoặc hệ thống kiểm tra đạo văn (plagiarism detection).
