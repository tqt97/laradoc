---
title: "Builder Pattern: Giải thoát khỏi 'Constructor Hell'"
excerpt: Cách xây dựng các đối tượng phức tạp từng bước một mà không cần những constructor dài ngoằng với hàng chục tham số.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-builder-pattern-deep-dive.webp
tags: [design-patterns, php, clean-code, creational]
---

## 1. Vấn đề & Bài toán

Khi khởi tạo một đối tượng (ví dụ: `Order`), bạn cần quá nhiều tham số: `new Order($user, $items, $address, $discount, $paymentMethod, $note, $isGift)`.

- **Vấn đề:** "Constructor Hell". Nếu chỉ cần 2 tham số, bạn phải truyền `null` cho các tham số còn lại. Code cực khó đọc và dễ sai sót khi thứ tự tham số thay đổi.

## 2. Định nghĩa Pattern

**Builder Pattern** (Nhóm Creational) cho phép bạn xây dựng các đối tượng phức tạp từng bước một. Nó tách biệt quá trình xây dựng đối tượng ra khỏi lớp biểu diễn của chính nó.

## 3. Cách giải quyết + Code mẫu

```php
class OrderBuilder {
    protected $order;
    public function __construct() { $this->order = new Order(); }
    public function setShipping(string $address) { $this->order->address = $address; return $this; }
    public function setGift(bool $isGift) { $this->order->isGift = $isGift; return $this; }
    public function build() { return $this->order; }
}
```

## 4. Khi nào áp dụng & Mẹo

- **Áp dụng:** Khi object cần nhiều cấu hình, hoặc cần cấu hình tùy chọn (optional).
- **Mẹo:** Trong Laravel, `Query Builder` chính là một Builder Pattern điển hình. Bạn nên áp dụng nó khi viết các service xây dựng object phức tạp (ví dụ: PDF Generator, Complex Report).

## 5. Câu hỏi phỏng vấn

- **Q: Builder khác gì Factory?** Factory tạo object trong 1 bước (dành cho object đơn giản). Builder tạo qua nhiều bước (dành cho object cần config nhiều trạng thái).
- **Q: Tại sao Builder lại giúp code Clean hơn?** Nó bỏ qua việc truyền tham số `null` vào constructor và giúp khai báo các thuộc tính rõ ràng hơn (`->setAddress()`).

## 6. Kết luận & So sánh

Khác với **Factory** (trả về kết quả ngay), **Builder** cho phép bạn dừng lại để cấu hình từng phần nhỏ trước khi "chốt" tạo đối tượng qua phương thức `build()`.
