---
title: Prototype Pattern - Nhân bản đối tượng tức thì
excerpt: Tìm hiểu Prototype Pattern - cách tạo đối tượng mới bằng cách sao chép (clone) đối tượng có sẵn, tối ưu hóa hiệu năng khởi tạo nặng nề.
category: Design pattern
date: 2026-04-11
order: 35
image: /prezet/img/ogimages/series-design-pattern-prototype-pattern.webp
---

> Pattern thuộc nhóm **Creational Pattern (Khởi tạo)**

## 1. Problem & Motivation

Khởi tạo đối tượng tốn quá nhiều tài nguyên (truy vấn DB, load file nặng). Nhân bản (clone) nhanh hơn nhiều so với việc khởi tạo mới từ đầu (`new`).

## 2. Định nghĩa

**Prototype Pattern** tạo ra các đối tượng mới dựa trên việc sao chép (clone) một đối tượng đã tồn tại (đối tượng mẫu).

## 3. Implementation

Sử dụng từ khóa `clone` trong PHP:

```php
class Soldier {
    public function __clone() {
        // Xử lý deep copy các đối tượng con nếu cần
    }
}
$s1 = clone $original;
```

## 4. Liên hệ Laravel

`$model->replicate()` trong Eloquent chính là áp dụng Prototype để tạo ra một bản sao của Model mà chưa lưu vào Database.

## 5. Kết luận

Dùng khi khởi tạo tốn kém, hoặc muốn giữ một "bản mẫu" để sinh ra các đối tượng con có trạng thái tương tự.
