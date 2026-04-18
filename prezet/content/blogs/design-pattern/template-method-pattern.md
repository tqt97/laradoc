---
title: "Template Method Pattern: Định nghĩa bộ khung xử lý"
excerpt: Định nghĩa khung của một thuật toán trong class cha, cho phép các class con ghi đè một số bước mà không thay đổi cấu trúc tổng thể.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-template-method-pattern.webp
tags: [design-patterns, php, laravel, behavioral]
---

## 1. Vấn đề

Bạn có nhiều thuật toán giống nhau đến 80% (ví dụ: các bước xuất file Excel, PDF, CSV: đều là: Lấy data -> Format data -> Xuất file). Việc lặp lại code ở mỗi class xuất file là không cần thiết.

## 2. Định nghĩa

Template Method (Nhóm Behavioral) định nghĩa khung của một thuật toán trong class cha, và các lớp con sẽ implement các "bước" cụ thể của thuật toán đó.

## 3. Cách giải quyết

```php
abstract class ExportTemplate {
    public function export() {
        $data = $this->fetchData(); // Bước chung
        $formatted = $this->format($data); // Bước con implement
        return $formatted;
    }
    abstract protected function format($data);
}
```

## 4. Ứng dụng & Mẹo

- **Ứng dụng:** Xuất báo cáo, xử lý data flow, các tác vụ cron job có bước chung.
- **Mẹo:** Trong Laravel, `Console\Command` là một template method lớn. Bạn kế thừa và chỉ cần tập trung viết logic trong `handle()`.

## 5. Câu hỏi phỏng vấn

- **Q: Template Method khác Strategy thế nào?** Template Method dùng kế thừa (Class con). Strategy dùng Composition (Inject class).
- **Q: Khi nào KHÔNG dùng?** Khi các thuật toán khác nhau quá nhiều, không thể tìm ra bộ khung chung.

## 6. Kết luận

Template Method giúp bạn tránh lặp lại code trong cấu trúc thuật toán bằng cách tạo bộ khung cố định (Template) và để các bước chi tiết cho các lớp con hoàn thiện.
