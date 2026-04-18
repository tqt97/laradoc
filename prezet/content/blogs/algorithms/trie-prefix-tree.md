---
title: "Trie (Prefix Tree): Sức mạnh của tìm kiếm từ khóa"
excerpt: Tìm hiểu cấu trúc dữ liệu Trie, ứng dụng trong tính năng Auto-complete và kiểm tra từ điển siêu tốc.
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-trie-prefix-tree.webp
tags: [algorithms, trie, search, optimization]
---

## 1. Bài toán

Bạn cần xây dựng tính năng "Gợi ý từ khóa" (Autocomplete) cho hàng triệu từ. Nếu dùng `LIKE %keyword%` trong SQL, database sẽ sập ngay.

## 2. Định nghĩa

**Trie** (Prefix Tree) là cấu trúc cây đặc biệt, nơi mỗi nút (node) đại diện cho một ký tự. Các từ có chung tiền tố sẽ chia sẻ các nút chung ở đầu cây.

## 3. Code mẫu đơn giản

```php
class TrieNode {
    public $children = [];
    public $isEndOfWord = false;
}
```

## 4. Ứng dụng & Mẹo

- **Ứng dụng:** Autocomplete, T9 texting, Kiểm tra chính tả, định tuyến IP (Longest Prefix Match).
- **Mẹo:** Trie chiếm nhiều RAM. Với hệ thống lớn, hãy dùng **Compressed Trie (Radix Tree)** để gộp các nút đơn lẻ.

## 5. Phỏng vấn

**Q: Tại sao Trie nhanh hơn Hash Map khi tìm tiền tố?**
**A:** Với Hash Map, bạn không thể tìm "mọi từ bắt đầu bằng 'php'". Với Trie, bạn chỉ cần duyệt từ gốc đến nút 'p'->'h'->'p' rồi in ra toàn bộ cây con bên dưới.

**Q: Độ phức tạp là bao nhiêu?**
**A:** O(L) với L là độ dài từ cần tìm. Cực kỳ hiệu quả vì nó không phụ thuộc vào tổng số từ đang có trong hệ thống.
