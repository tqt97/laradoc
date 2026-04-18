---
title: "PHP Traits: Giải quyết xung đột và tư duy Composition"
excerpt: Cách xử lý xung đột tên phương thức khi dùng nhiều Traits và tại sao Traits là chìa khóa để thay thế đa kế thừa (Multiple Inheritance).
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-php-traits-conflict-resolution.webp
tags: [php, oop, traits, composition, clean-code]
---

## 1. Bản chất Trait

PHP không hỗ trợ đa kế thừa để tránh "Diamond Problem". Trait là giải pháp "Composition" cho phép bạn "cắm" logic vào class mà không làm ảnh hưởng đến cấu trúc kế thừa cha-con.

## 2. Giải quyết xung đột

Nếu 2 Trait cùng có phương thức `run()`:

```php
class User {
    use TraitA, TraitB {
        TraitA::run insteadof TraitB; // Chọn TraitA
        TraitB::run as runB; // Rename TraitB
    }
}
```

## 3. Mẹo phỏng vấn

**Q: Trait khác Interface thế nào?**
**A:** Interface định nghĩa HỢP ĐỒNG (cần implement hàm nào), Trait định nghĩa LOGIC (code thực tế để tái sử dụng).

**Q: Tại sao Trait được gọi là "Horizontal Reuse"?**
**A:** Vì bạn đang thêm tính năng theo chiều ngang vào các class độc lập, thay vì phải đặt tính năng đó vào lớp cha (chiều dọc kế thừa).
