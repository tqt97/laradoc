---
title: "Refactor: Primitive Obsession (Ám ảnh kiểu nguyên thủy)"
excerpt: Khi bạn dùng string thay vì object để lưu giá trị. Cách đưa nghiệp vụ vào các đối tượng Value Object.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-primitive-obsession.webp
tags: [refactoring, value-object, clean-code]
---

## 1. Dấu hiệu (Smell)

- Bạn dùng `string` để lưu `Email`, `Currency`, `Phone`.
- Logic kiểm tra `if (!filter_var($email, FILTER_VALIDATE_EMAIL))` lặp đi lặp lại ở khắp nơi.

## 2. Giải pháp: Replace with Value Object

Tạo class `Email`:

```php
class Email {
    public function __construct(public string $value) {
        if (!filter_var($value, FILTER_VALIDATE_EMAIL)) throw new InvalidEmailException();
    }
}
```

## 3. Lợi ích

- **Đóng gói logic:** Validation được thực hiện ngay khi object được khởi tạo.
- **Type-hinting:** Hàm của bạn rõ ràng hơn: `public function send(Email $email)`.

## 4. Câu hỏi nhanh

**Q: Sự khác biệt giữa Value Object và Entity?**
**A:** Entity có ID (định danh), nếu thay đổi thuộc tính nó vẫn là nó. Value Object không có ID, nếu thay đổi giá trị, nó trở thành một đối tượng khác.
**Q: Có bao giờ nên dùng primitive?**
**A:** Khi giá trị không cần validation và không chứa logic (VD: `name`, `note`). Đừng tạo Value Object cho những thứ chỉ để chứa data đơn thuần.
