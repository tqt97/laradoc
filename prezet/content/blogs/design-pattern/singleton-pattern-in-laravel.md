---
title: "Singleton Pattern: Khi nào là cứu cánh, khi nào là 'Anti-pattern'?"
excerpt: Tìm hiểu về Singleton Pattern trong PHP, cách Laravel Service Container quản lý Singleton và những sai lầm phổ biến dẫn đến khó khăn khi viết Unit Test.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-singleton-pattern-in-laravel.webp
tags: [design-patterns, php, laravel, architecture, clean-code]
---

**Singleton Pattern** là một trong những pattern đơn giản nhất nhưng cũng gây tranh cãi nhất. Mục tiêu của nó là đảm bảo một class chỉ có duy nhất một instance trong suốt vòng đời của ứng dụng và cung cấp một điểm truy cập toàn cục cho nó.

## 1. Implement Singleton thuần túy trong PHP

Để tạo một Singleton "chính hiệu", bạn cần:

1. Một biến `static` để giữ instance.
2. Constructor phải là `private` (ngăn dùng `new`).
3. Hàm `__clone` và `__wakeup` phải là `private` (ngăn nhân bản/deserialization).

```php
class DatabaseConnection {
    private static $instance = null;
    private function __construct() {} // Private constructor

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }
}
```

## 2. Cách Laravel làm Singleton "Sang" hơn

Trong Laravel, bạn hiếm khi phải viết code như trên. Thay vào đó, bạn sử dụng **Service Container**.

```php
// Trong AppServiceProvider
$this->app->singleton(ApiService::class, function ($app) {
    return new ApiService(config('services.api.key'));
});
```

Lợi ích: Class `ApiService` của bạn vẫn là một class bình thường, dễ test, nhưng Laravel sẽ đảm bảo chỉ khởi tạo nó một lần duy nhất.

## 3. Tại sao Singleton bị coi là Anti-pattern?

- **Khó Unit Test:** Vì nó giữ trạng thái toàn cục, các test case có thể ảnh hưởng lẫn nhau nếu không được reset kỹ.
- **Hidden Dependencies:** Khi bạn dùng `DatabaseConnection::getInstance()` ở khắp nơi, bạn đang che giấu sự phụ thuộc của class đó, làm code khó bảo trì.

## 4.Câu hỏi nhanh

**Câu hỏi:** Trong môi trường **Laravel Octane** (Swoole/RoadRunner), việc sử dụng Singleton cần lưu ý điều gì đặc biệt?

**Trả lời:**
Trong Octane, ứng dụng không bị "chết" sau mỗi request mà worker sẽ sống liên tục.

- **Rủi ro:** Nếu bạn lưu dữ liệu của User A vào một thuộc tính của Singleton Service, User B vào sau có thể nhìn thấy dữ liệu đó (**State Leak**).
- **Giải pháp:** Phải cực kỳ cẩn thận với các thuộc tính class trong Singleton. Luôn reset trạng thái trong phương thức `boot` của Service Provider hoặc sử dụng cơ chế `flush` của Octane.

**Câu hỏi mẹo:** Phân biệt Singleton và Static Class?
**Trả lời:** Singleton là một **Object** thực sự (có thể kế thừa, implement interface, truyền vào hàm như một tham số), còn Static Class chỉ là một tập hợp các hàm và biến. Singleton linh hoạt hơn rất nhiều cho việc mở rộng và testing.

## 5. Kết luận

Singleton vẫn rất hữu ích cho các tài nguyên dùng chung như DB Connection, Logger, Config. Tuy nhiên, hãy để Framework (Container) quản lý thay vì tự viết logic Singleton cứng nhắc.
