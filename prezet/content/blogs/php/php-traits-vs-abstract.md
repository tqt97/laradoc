---
title: "Traits & Abstract Classes: Khi nào Composition thắng Inheritance?"
excerpt: Tìm hiểu về Traits trong PHP, sự khác biệt với Abstract Classes và cách dùng Traits để xây dựng tính năng có thể tái sử dụng.
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-php-traits-vs-abstract.webp
tags: [php, oop, traits, composition, clean-code]
---

## 1. Bản chất

- **Abstract Class:** Dùng cho quan hệ "IS-A" (ví dụ: `Admin` là một `User`).
- **Traits:** Dùng cho hành vi "CAN-DO" (ví dụ: `User` có thể `HasApiTokens`). Trait giúp tránh thảm họa đa kế thừa trong PHP.

## 2. Code mẫu

```php
trait Loggable {
    public function log(string $msg) { /* ... */ }
}

class Order {
    use Loggable; // Composition qua Trait
}
```

## 3. Mẹo phỏng vấn

**Q: Trait khác Interface thế nào?**
**A:** Interface định nghĩa HỢP ĐỒNG (cần implement hàm nào), Trait định nghĩa LOGIC (code thực tế để tái sử dụng).

**Q: Trait có thể gây xung đột tên không?**
**A:** Có, nếu 2 Trait cùng có phương thức tên giống nhau. Phải dùng cú pháp `use T1, T2 { T1::method insteadof T2; }` để giải quyết.
