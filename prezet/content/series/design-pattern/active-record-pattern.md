---
title: Active Record - Linh hồn của Laravel Eloquent
excerpt: Tìm hiểu Active Record Pattern - cách kết hợp dữ liệu và hành vi trong một Class duy nhất, giải mã sức mạnh và sự tiện lợi của Eloquent trong Laravel.
category: Design pattern
date: 2026-04-08
order: 32
image: /prezet/img/ogimages/series-design-pattern-active-record-pattern.webp
---

> Pattern thuộc nhóm **Architectural / Enterprise Pattern**

## 1. Problem & Motivation

Khi làm việc với Database, bạn thường có các bảng dữ liệu. Ví dụ bảng `users`.

**Vấn đề:** Làm thế nào để thao tác với dữ liệu trong bảng này một cách tự nhiên nhất trong ngôn ngữ lập trình hướng đối tượng?

* Bạn có thể viết SQL thuần ở khắp mọi nơi (Spaghetti code).
* Bạn có thể dùng Data Mapper (như đã học), nhưng nó yêu cầu viết rất nhiều class trung gian.

**Ý tưởng:** Tại sao không biến mỗi **hàng** (row) trong Database thành một **đối tượng** (object), và class đại diện cho bảng đó sẽ chứa luôn các hàm để Lưu, Xóa, Cập nhật?

## 2. Định nghĩa

**Active Record** là một mẫu thiết kế trong đó một đối tượng bao gồm cả dữ liệu và hành vi. Hầu hết dữ liệu này được lưu trữ trong Database. Mẫu này kết nối trực tiếp logic truy cập dữ liệu vào đối tượng nghiệp vụ.

**Quy tắc vàng:**

1. Một Class = Một Bảng (Table).
2. Một Instance (Object) = Một Hàng (Row).

## 3. Implementation (Tư duy thiết kế)

Trong Active Record, class Model sẽ có các phương thức static để tìm kiếm và các phương thức instance để lưu trữ:

```php
class User {
    public $id;
    public $name;

    // Tìm kiếm (Static)
    public static function find($id) {
        // SQL: SELECT * FROM users WHERE id = $id
        return new self($data);
    }

    // Hành vi lưu trữ (Instance)
    public function save() {
        if ($this->id) {
            // SQL: UPDATE users SET ...
        } else {
            // SQL: INSERT INTO users ...
        }
    }
}
```

## 4. Liên hệ Laravel (Eloquent)

Eloquent chính là bản triển khai Active Record hoàn hảo nhất trong thế giới PHP:

```php
$user = new User();
$user->name = "Tuấn";
$user->save(); // Đối tượng tự lưu chính nó

$existingUser = User::find(1);
$existingUser->delete(); // Đối tượng tự xóa chính nó
```

**Tại sao Laravel chọn Active Record?**

* **Cực kỳ nhanh:** Phát triển tính năng (Rapid Prototyping) rất nhanh.
* **Dễ hiểu:** Ngay cả Junior cũng có thể nắm bắt cách dùng Eloquent chỉ trong vài phút.
* **Cú pháp đẹp (Fluent):** `User::where('active', 1)->latest()->get()`.

## 5. Ưu & Nhược điểm

**Ưu điểm:**

* **Đơn giản:** Phù hợp với 90% các ứng dụng web thông thường.
* **Gần gũi:** Logic nghiệp vụ và dữ liệu nằm cạnh nhau, dễ theo dõi.
* **Hệ sinh thái:** Laravel cung cấp sẵn vô vàn tính năng bổ trợ (Relations, Scopes, Observers).

**Nhược điểm:**

* **Vi phạm SRP (Single Responsibility):** Class Model vừa lo logic nghiệp vụ, vừa lo việc kết nối DB.
* **Khó Unit Test:** Vì Model luôn "dính" chặt với Database thực tế.
* **Cồng kềnh:** Khi logic nghiệp vụ quá lớn, Model sẽ trở thành "God Object".

## 6. Khi nào nên dùng

* Các dự án vừa và nhỏ, hoặc các dự án cần tốc độ phát triển nhanh.
* Các ứng dụng có cấu trúc Database tương đối ổn định và khớp với logic code.
* Khi bạn muốn tận dụng tối đa sức mạnh của hệ sinh thái Laravel.

## 7. Câu hỏi phỏng vấn

1. **Sự khác biệt lớn nhất giữa Active Record và Data Mapper?** (Active Record: Model biết cách lưu chính nó. Data Mapper: Model thuần khiết, cần class Mapper riêng để lưu).
2. **Tại sao Active Record lại bị coi là vi phạm nguyên tắc SOLID?** (Vi phạm Single Responsibility Principle vì gộp cả Data và Data Access vào một chỗ).
3. **Làm thế nào để giảm bớt sự cồng kềnh của Model trong Active Record?** (Sử dụng Traits, Service Classes hoặc Action Classes để tách bớt logic nghiệp vụ ra khỏi Model).

## Kết luận

Active Record là "đặc sản" của Laravel. Nó mang lại sự tiện lợi vô song và giúp lập trình viên tập trung vào việc tạo ra giá trị cho người dùng một cách nhanh nhất. Hãy hiểu rõ sức mạnh và giới hạn của nó để sử dụng một cách thông minh.
