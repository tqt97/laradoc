---
title: "Abstract Factory: Kiến trúc tạo họ đối tượng"
excerpt: Giải mã Abstract Factory Pattern - Giải pháp tạo ra các họ đối tượng liên quan mà không cần chỉ định class cụ thể.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-abstract-factory-pattern.webp
tags: [design-patterns, php, architecture, creational]
---

Nếu **Factory Method** tạo ra một sản phẩm, thì **Abstract Factory** tạo ra một "gia đình" các sản phẩm liên quan.

## 1. Khi nào dùng?

Bạn cần tạo các bộ UI cho nhiều nền tảng (Ví dụ: bộ Component của iOS và bộ Component của Android). Bạn cần đảm bảo rằng một nút bấm (Button) của iOS phải đi kèm với một thanh cuộn (Scrollbar) của iOS, chứ không được lẫn lộn với của Android.

## 2. Code ví dụ

```php
interface WidgetFactory {
    public function createButton(): Button;
    public function createCheckbox(): Checkbox;
}

class IOSFactory implements WidgetFactory {
    public function createButton(): Button { return new IOSButton(); }
    public function createCheckbox(): Checkbox { return new IOSCheckbox(); }
}
```

## 3. Tại sao cần cho Senior?

Nó giúp bạn thiết lập "Hợp đồng" (Interface) cho một hệ thống lớn. Khi hệ thống cần mở rộng sang nền tảng mới (ví dụ: Windows Phone), bạn chỉ cần implement thêm `WindowsFactory` mà không thay đổi bất kỳ dòng code Client nào.
