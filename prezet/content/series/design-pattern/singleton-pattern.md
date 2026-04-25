---
title: Singleton Pattern - Độc bản duy nhất
excerpt: Tìm hiểu Singleton Pattern - cách đảm bảo một Class chỉ có duy nhất một thực thể trong suốt vòng đời ứng dụng, cách nó xuất hiện trong Laravel Service Container.
category: Design pattern
date: 2026-03-11
order: 4
image: /prezet/img/ogimages/series-design-pattern-singleton-pattern.webp
---

> Pattern thuộc nhóm **Creational Pattern (Khởi tạo)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang quản lý một kết nối đến Database hoặc một đối tượng lưu trữ cấu hình (Config) của toàn bộ hệ thống.

**Vấn đề:**

* Nếu mỗi nơi cần dùng Database lại khởi tạo một `new DatabaseConnection()`, hệ thống sẽ sớm bị cạn kiệt tài nguyên (Memory, Connection Pool).
* Khó kiểm soát trạng thái đồng nhất của dữ liệu trên toàn hệ thống.

**Naive Solution:** Dùng biến toàn cục (Global variable). Nhưng biến toàn cục vi phạm tính đóng gói và có thể bị ghi đè bất cứ lúc nào.

## 2. Định nghĩa

**Singleton Pattern** đảm bảo rằng một lớp chỉ có **duy nhất một instance** và cung cấp một điểm truy cập toàn cầu (global access point) đến instance đó.

**Ý tưởng cốt lõi:**

* Giấu hàm khởi tạo (`__construct`) để bên ngoài không thể `new`.
* Tự class đó sẽ quản lý việc tạo ra chính nó.

## 3. Cách hoạt động

1. **Private constructor:** Ngăn chặn việc khởi tạo trực tiếp từ bên ngoài.
2. **Private static variable:** Lưu trữ instance duy nhất.
3. **Public static method (getInstance):** Kiểm tra nếu instance chưa tồn tại thì tạo mới, ngược lại trả về instance đã có.

## 4. Implementation (PHP Clean Code)

### 4.1 PHP Thuần

```php
class Database
{
    private static ?Database $instance = null;
    private $connection;

    // 1. Private constructor
    private function __construct()
    {
        $this->connection = "Kết nối DB đã được thiết lập";
    }

    // 2. Ngăn chặn clone đối tượng
    private function __clone() {}

    // 3. Ngăn chặn unserialize (nếu cần bảo mật tuyệt đối)
    public function __wakeup()
    {
        throw new \Exception("Cannot unserialize a singleton.");
    }

    // 4. Public static method
    public static function getInstance(): Database
    {
        if (self::$instance === null) {
            self::$instance = new self();
        }

        return self::$instance;
    }

    public function query(string $sql)
    {
        return "Đang thực thi: $sql";
    }
}

// Sử dụng
$db1 = Database::getInstance();
$db2 = Database::getInstance();

var_dump($db1 === $db2); // true - Cả hai là một
```

### 4.2 Liên hệ Laravel (The Better Way)

Trong Laravel, chúng ta hiếm khi phải tự viết code "cứng" như trên. Laravel cung cấp **Service Container** để quản lý Singleton một cách cực kỳ linh hoạt.

```php
// Trong AppServiceProvider.php
public function register()
{
    $this->app->singleton(PaymentGateway::class, function ($app) {
        return new PaymentGateway(config('services.payment.key'));
    });
}
```

**Tại sao Laravel làm vậy?**

* **Dễ Test hơn:** Bạn có thể dễ dàng thay thế (Mock) một Singleton bằng một đối tượng khác khi viết Unit Test (Singleton thuần rất khó test).
* **Quản lý tập trung:** Không cần lo lắng về logic khởi tạo rải rác.

## 5. Khi nào nên dùng

* **Shared Resources:** Kết nối Database, Logger, File System, Configuration.
* **Cần kiểm soát truy cập đồng thời:** Tránh việc nhiều instance cùng ghi đè vào một file.

## 6. Tips & Best Practices

* **Đừng lạm dụng:** Singleton thường bị coi là một "Anti-pattern" nếu dùng quá nhiều vì nó tạo ra các phụ thuộc ẩn (Hidden dependencies) và gây khó khăn khi Test.
* **Sử dụng Dependency Injection:** Thay vì gọi `Class::getInstance()` trong controller, hãy dùng DI để Laravel tự inject vào. Điều này giúp code linh hoạt hơn.

## 7. So sánh: Singleton vs Static Class

| Đặc điểm | Singleton | Static Class |
| :--- | :--- | :--- |
| **Bản chất** | Là một đối tượng thực sự | Chỉ là tập hợp các phương thức |
| **Interface** | Có thể kế thừa, implement interface | Không thể |
| **Lifecycle** | Có thể quản lý thời điểm khởi tạo | Luôn tồn tại khi app chạy |
| **Testability** | Khó (nhưng đỡ hơn Static) | Cực kỳ khó |

## 8. Câu hỏi phỏng vấn

1. **Tại sao phải đặt `__construct` là private?** (Để ngăn chặn việc tạo đối tượng bằng từ khóa `new`).
2. **Singleton có vi phạm Single Responsibility Principle không?** (Có, vì nó vừa lo logic nghiệp vụ, vừa lo quản lý vòng đời của chính nó).
3. **Làm thế nào để xử lý Singleton trong môi trường đa luồng (Multi-threading)?** (Trong PHP không quá lo lắng, nhưng trong Java/C# cần dùng `lock` hoặc `double-checked locking`).
4. **Tại sao Laravel Service Container lại ưu tiên dùng Singleton binding thay vì code Singleton thuần?** (Vì tính linh hoạt, hỗ trợ Mocking và Dependency Injection).

## Kết luận

Singleton là con dao hai lưỡi. Hãy dùng nó khi bạn thực sự cần một "điểm tin cậy duy nhất" (Single Source of Truth) cho tài nguyên hệ thống, nhưng hãy ưu tiên quản lý chúng qua **Service Container** của Laravel để code sạch và dễ test hơn.
