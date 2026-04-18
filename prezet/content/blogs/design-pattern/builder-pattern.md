---
title: "Builder Pattern: Xây dựng đối tượng phức tạp từng bước"
excerpt: Tránh 'Constructor Hell' với Builder Pattern. Cách tạo ra các đối tượng phức tạp từng bước mà không cần constructor dài ngoằng.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-builder-pattern.webp
tags: [design-patterns, php, clean-code, creational]
---

## 1. Vấn đề

Khi khởi tạo một đối tượng (vd: `ReportGenerator`) với hàng chục tham số, code trở nên cực kỳ khó đọc và dễ sai sót. Nếu có nhiều tham số tùy chọn, bạn phải truyền `null` liên tục.

## 2. Định nghĩa

**Builder Pattern** tách việc tạo đối tượng phức tạp khỏi lớp của nó. Cho phép xây dựng object qua nhiều bước gọi phương thức.

## 3. Cách giải quyết

```php
class ReportBuilder {
    protected $report;
    public function __construct() { $this->report = new Report(); }
    public function withTitle($title) { $this->report->title = $title; return $this; }
    public function withFormat($format) { $this->report->format = $format; return $this; }
    public function build() { return $this->report; }
}

// Sử dụng
$report = (new ReportBuilder())->withTitle('Q1')->withFormat('pdf')->build();
```

## 4. Ứng dụng & Mẹo

- **Ứng dụng:** Xây dựng câu query (Query Builder của Laravel), tạo PDF/Email phức tạp.
- **Mẹo:** Dùng `return $this` trong các method để cho phép Fluent Interface (gọi liên tiếp).

## 5. Phỏng vấn

- **Q: Builder khác Factory?** Factory tạo object 1 bước, Builder tạo qua nhiều bước.
- **Q: Khi nào KHÔNG dùng?** Khi object quá đơn giản.

## 6. Kết luận

Builder Pattern giúp code của bạn có tính mô tả cao (self-documenting) và tách biệt logic khởi tạo phức tạp.
