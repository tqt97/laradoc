---
title: "Refactor: Thay thế If-Else bằng Strategy Pattern"
excerpt: Cách xóa bỏ các chuỗi 'if-else' hoặc 'switch-case' khổng lồ bằng tính đa hình (Polymorphism).
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-replace-conditionals-with-strategy.webp
tags: [refactoring, design-patterns, clean-code]
---

## 1. Bài toán

Bạn có một hàm xử lý giảm giá: `if ($type == 'vip') ... elseif ($type == 'new') ...`. Khi thêm loại giảm giá mới, bạn lại phải sửa hàm này.

## 2. Cách giải quyết

Tạo một Interface `DiscountStrategy`, sau đó tạo các class cụ thể: `VipDiscount`, `NewUserDiscount`.
Trong code, bạn chỉ cần gọi: `$strategy->apply($price)`.

## 3. Code mẫu

```php
// Thay vì if-else, dùng container để resolve
$strategy = app("DiscountStrategy.{$type}");
return $strategy->apply($price);
```

## 4. Câu hỏi nhanh

**Q: Khi nào KHÔNG nên dùng Strategy?**
**A:** Nếu logic chỉ có 1-2 `if` đơn giản, việc tạo ra 3-4 class Strategy là **Over-engineering**. Chỉ refactor khi logic nghiệp vụ phức tạp và cần thêm mới thường xuyên.
