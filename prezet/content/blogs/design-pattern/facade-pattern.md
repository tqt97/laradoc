---
title: "Facade Pattern: Đơn giản hóa hệ thống phức tạp"
excerpt: Facade Pattern cung cấp một interface đơn giản cho một tập hợp các class phức tạp.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-facade-pattern.webp
tags: [design-patterns, structural, laravel]
---

## 1. Vấn đề

Khi bạn cần sử dụng một hệ thống phức tạp gồm hàng chục class (ví dụ: khởi tạo Audio/Video converter), việc gọi từng cái làm code rối tung.

## 2. Định nghĩa

Facade Pattern (Structural) tạo ra một lớp duy nhất đóng gói (wrap) toàn bộ các class phức tạp bên trong, cung cấp một giao diện dễ dùng nhất.

## 3. Cách giải quyết

```php
class ConverterFacade {
    public function convert($file) {
        $parser = new Parser(); $encoder = new Encoder(); $writer = new Writer();
        // logic kết hợp chúng...
    }
}
```

## 4. Ứng dụng Laravel

**Facades của Laravel** chính là ứng dụng đỉnh cao nhất của Pattern này. Bạn gọi `Cache::get()` - bên dưới nó là một tập hợp các driver, store, event dispatcher phức tạp mà bạn không cần biết.

## 5. Phỏng vấn

- **Q: Tại sao gọi là Facade (Mặt tiền)?** Vì nó che giấu sự phức tạp đằng sau giống như một bức tường mặt tiền của ngôi nhà.
- **Q: Khác biệt với Adapter?** Adapter đổi interface cho khớp. Facade đơn giản hóa interface cho gọn.
