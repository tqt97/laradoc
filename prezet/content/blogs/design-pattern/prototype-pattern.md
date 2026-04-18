---
title: "Prototype Pattern: Clone đối tượng linh hoạt"
excerpt: Prototype Pattern cho phép sao chép các đối tượng hiện có mà không làm cho mã của bạn phụ thuộc vào các class của chúng.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-prototype-pattern.webp
tags: [design-patterns, php, creational]
---

## 1. Vấn đề

Khi việc khởi tạo một đối tượng quá phức tạp (phải query DB, tính toán nhiều bước), việc dùng `new` lại mỗi lần rất tốn kém. Bạn cần một bản sao (clone) của đối tượng cũ để chỉnh sửa.

## 2. Định nghĩa

Prototype Pattern (Nhóm Creational) cho phép sao chép các đối tượng hiện có mà không cần biết chính xác class của chúng. Trong PHP, chúng ta tận dụng keyword `clone`.

## 3. Giải pháp + Code mẫu

```php
abstract class Prototype {
    abstract public function __clone();
}

class Invoice extends Prototype {
    public function __clone() {
        // Thực hiện deep copy nếu cần thiết
    }
}

// Sử dụng
$invoice = new Invoice();
$newInvoice = clone $invoice;
```

## 4. Khi nào áp dụng & Mẹo

- **Ứng dụng:** Khi hệ thống cần tạo nhiều đối tượng gần giống nhau (VD: báo cáo, template invoice).
- **Mẹo:** Trong Laravel Eloquent, `clone` model sẽ sao chép toàn bộ thuộc tính, rất tiện để tạo bản ghi mới từ bản ghi cũ.

## 5. Câu hỏi phỏng vấn

- **Q: Tại sao Prototype cần `__clone()`?** Khi clone object chứa object con (vd: `Address`), mặc định PHP chỉ copy tham chiếu. `__clone` giúp tạo "deep copy" để object mới không ảnh hưởng object gốc.

## 6. Kết luận

Prototype là cách nhanh nhất để khởi tạo đối tượng khi chi phí "new" quá cao.
