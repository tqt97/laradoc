---
title: "LRU Cache: Kiến trúc bộ nhớ thông minh"
excerpt: Thiết kế hệ thống Cache loại bỏ dữ liệu cũ dựa trên nguyên tắc Least Recently Used.
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-lru-cache.webp
tags: [algorithms, cache, system-design, linked-list]
---

## 1. Bài toán

Bạn cần xây dựng một bộ nhớ đệm có dung lượng cố định. Khi đầy, phần tử nào lâu không được truy cập nhất sẽ bị loại bỏ.

## 2. Giải pháp: Hash Map + Doubly Linked List

- **Cấu trúc:**
  - `HashMap`: Lưu `key` -> `node` (để tìm kiếm O(1)).
  - `Doubly Linked List`: Lưu thứ tự truy cập (để xóa/thêm ở đầu/cuối O(1)).
- **Nguyên lý:** Mỗi lần `get()` hoặc `put()`, chuyển node đó về đầu danh sách. Khi đầy, xóa node cuối cùng.

## 3. Code mẫu (Tư duy)

```php
// PHP có sẵn SplDoublyLinkedList kết hợp với một mảng làm map
```

## 4. Câu hỏi nhanh

**Q: Tại sao phải dùng Doubly Linked List mà không phải Array?**
**A:** Array khi xóa phần tử ở giữa tốn O(n) do phải dịch chuyển index. Doubly Linked List chỉ tốn O(1) để ngắt liên kết và nối lại.

**Q: Ứng dụng thực tế ngoài Redis?**
**A:** Cache Database queries, Session store, Web page caching.
