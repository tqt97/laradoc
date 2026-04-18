---
title: "Refactor: Xử lý Feature Envy (Đố kỵ tính năng)"
excerpt: Dấu hiệu khi một method 'quan tâm' đến dữ liệu của class khác nhiều hơn class của chính nó.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-feature-envy.webp
tags: [refactoring, clean-code, solid]
---

## 1. Dấu hiệu (Smell)

Bạn có một hàm trong `OrderController` nhưng nó liên tục gọi các getter của `User` model để tính toán (ví dụ: `$user->getPoints()`, `$user->getRank()`). Hàm này đang "ghen tị" với data của `User`.

## 2. Giải pháp

- **Move Method:** Di chuyển hàm đó vào class `User`.
- **Nguyên tắc:** Dữ liệu và logic xử lý dữ liệu đó nên nằm chung một chỗ (Encapsulation).

## 3. Code mẫu

```php
// Tránh: OrderService làm việc này
public function getDiscount($user) { return $user->points * 0.1; }

// NÊN: Chuyển vào User
public function getDiscount() { return $this->points * 0.1; }
```

## 4. Câu hỏi nhanh

**Q: "Tại sao Feature Envy lại gây khó bảo trì?"**
**A:** Nó gây ra sự phụ thuộc chéo. Nếu cấu trúc class `User` thay đổi, bạn phải tìm tất cả các Service/Controller sử dụng nó để sửa. Đóng gói logic vào đúng "chủ sở hữu" dữ liệu giúp giảm phạm vi ảnh hưởng khi sửa đổi.
