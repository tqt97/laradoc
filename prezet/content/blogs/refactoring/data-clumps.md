---
title: "Refactor: Xử lý Data Clumps (Dữ liệu chùm)"
excerpt: Dấu hiệu khi các tham số luôn đi cùng nhau và cách biến chúng thành Value Objects để code sạch hơn.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-data-clumps.webp
tags: [refactoring, value-object, clean-code]
---

## 1. Dấu hiệu (Smell)

Bạn có nhiều hàm mà danh sách tham số y hệt nhau:
`function shipOrder($street, $city, $zip, $country) { ... }`
`function billOrder($street, $city, $zip, $country) { ... }`

## 2. Giải pháp: Introduce Parameter Object (Value Object)

Biến nhóm dữ liệu đó thành một Class duy nhất: `Address`.

```php
class Address {
    public function __construct(
        public string $street, 
        public string $city, 
        public string $zip, 
        public string $country
    ) {}
}

// Hàm mới
function shipOrder(Address $address) { ... }
```

## 3. Lợi ích

- **Type-safe:** Đảm bảo dữ liệu luôn đầy đủ.
- **Dễ mở rộng:** Nếu cần thêm `state`, chỉ cần sửa class `Address`, không cần sửa hàng chục hàm khác.

## 4. Câu hỏi nhanh

**Q: Tại sao gọi là Value Object?**
**A:** Vì nó chỉ chứa dữ liệu, không có logic nghiệp vụ phức tạp. Nếu 2 object Address có cùng giá trị property, chúng được coi là bằng nhau (đừng dùng ID để so sánh).
