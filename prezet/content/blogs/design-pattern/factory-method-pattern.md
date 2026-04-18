---
title: "Factory Method Pattern: Khởi tạo linh hoạt"
excerpt: Factory Method giúp tách biệt việc tạo đối tượng khỏi mã nghiệp vụ, cho phép class con quyết định kiểu đối tượng sẽ được khởi tạo.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-factory-method-pattern.webp
tags: [design-patterns, php, laravel, creational]
---

## 1. Bài toán

Bạn cần tạo các đối tượng (ví dụ: Loggers: `FileLogger`, `DatabaseLogger`, `CloudLogger`). Nếu dùng `new` trực tiếp trong Controller, bạn vi phạm nguyên lý Open/Closed vì mỗi lần thêm Logger mới bạn phải sửa Controller.

## 2. Định nghĩa

Factory Method (Creational) định nghĩa một interface để tạo đối tượng nhưng để lớp con quyết định class nào sẽ được khởi tạo. Nó chuyển việc khởi tạo từ code chính sang các "Factory".

## 3. Cách giải quyết + Code mẫu

```php
abstract class LoggerCreator {
    abstract public function createLogger(): Logger;
}

class FileLoggerFactory extends LoggerCreator {
    public function createLogger(): Logger { return new FileLogger(); }
}
```

## 4. Khi nào dùng & Mẹo

- **Khi nào:** Khi bạn không biết trước chính xác kiểu object cần khởi tạo cho đến khi chạy.
- **Mẹo:** Trong Laravel, `Illuminate\Database\Eloquent\Factories\Factory` là một dạng nâng cao, giúp sinh dữ liệu test linh hoạt.

## 5. Câu hỏi phỏng vấn

- **Q: Factory vs Abstract Factory?** Factory tạo 1 loại sản phẩm (1 class). Abstract Factory tạo 1 họ sản phẩm (nhiều class liên quan).
- **Q: Tại sao dùng Factory Method lại dễ Test hơn?** Bạn có thể dễ dàng mock Factory để trả về một "Mock Logger" thay vì tạo Logger thật kết nối DB.

## 6. Kết luận

Factory Method giúp Controller/Service của bạn "đóng" với việc khởi tạo đối tượng, chỉ quan tâm đến Interface của sản phẩm.
