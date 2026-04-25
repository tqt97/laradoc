---
title: Service Locator - Trạm tra cứu dịch vụ
excerpt: Tìm hiểu Service Locator Pattern - cách lấy đối tượng từ trung tâm điều phối, so sánh với Dependency Injection và ứng dụng trong Laravel.
category: Design pattern
date: 2026-04-05
order: 29
image: /prezet/img/ogimages/series-design-pattern-service-locator-pattern.webp
---

> Pattern thuộc nhóm **Creational / Architectural Pattern**

## 1. Problem & Motivation

Trong một ứng dụng lớn, các Class cần rất nhiều dịch vụ để hoạt động: Mailer, Database, Cache, Logger...

**Vấn đề:**
Nếu bạn dùng Dependency Injection (DI) quá nhiều, Constructor của bạn có thể phình to lên đến 10-15 tham số. Việc khởi tạo các Class này một cách thủ công trở nên cực kỳ mệt mỏi.

**Naive Solution:** Khởi tạo mọi thứ khi cần thiết (`new Mailer()`). Nhưng chúng ta đã biết đây là Hard-coded dependency và cực kỳ khó test.

## 2. Định nghĩa

**Service Locator** là một đối tượng trung tâm đóng vai trò như một "danh bạ" hoặc "tổng đài". Khi một Class cần một dịch vụ, thay vì yêu cầu nó qua Constructor, Class đó sẽ hỏi Service Locator: "Cho tôi xin đối tượng xử lý Mail".

**Ý tưởng cốt lõi:** Một nơi duy nhất biết cách khởi tạo và cung cấp tất cả các dịch vụ trong hệ thống.

## 3. Implementation (PHP Clean Code)

### 3.1 Service Locator Class

```php
class ServiceLocator {
    private array $services = [];
    private array $instantiated = [];

    public function addService(string $name, callable $resolver) {
        $this->services[$name] = $resolver;
    }

    public function get(string $name) {
        if (!isset($this->instantiated[$name])) {
            $this->instantiated[$name] = ($this->services[$name])($this);
        }
        return $this->instantiated[$name];
    }
}
```

### 3.2 Sử dụng (Client)

```php
$locator = new ServiceLocator();
$locator->addService('mailer', fn() => new SmtpMailer());

class OrderService {
    public function process($locator) {
        // Chủ động đi tìm service thay vì được "tiêm" vào
        $mailer = $locator->get('mailer');
        $mailer->send("Thành công!");
    }
}
```

## 4. Liên hệ Laravel

Laravel thực chất là một Service Locator "khổng lồ" nhưng được ẩn giấu dưới lớp vỏ DI:

**1. Hàm `app()` hoặc `resolve()`:**
Đây chính là Service Locator Pattern thuần túy.

```php
$mailer = app('mailer');
$service = resolve(OrderService::class);
```

**2. Facades:**
Các Facade như `Log::info()` hay `Cache::get()` bản chất là dùng Service Locator để tìm đối tượng thực sự trong Container và gọi hàm.

## 5. So sánh: Service Locator vs Dependency Injection

| Đặc điểm | Service Locator | Dependency Injection |
| :--- | :--- | :--- |
| **Tính chủ động** | Class chủ động đi tìm phụ thuộc. | Class bị động nhận phụ thuộc. |
| **Tính minh bạch** | Phụ thuộc bị ẩn (Hidden dependencies). | Phụ thuộc hiện rõ ở Constructor. |
| **Độ linh hoạt** | Rất cao, có thể lấy service bất cứ lúc nào. | Phải định nghĩa ngay từ đầu. |
| **Testability** | Khó test hơn (phải mock cả locator). | Dễ test nhất. |

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* Giảm bớt số lượng tham số trong Constructor.
* Phù hợp cho các ứng dụng có cấu trúc động, nơi các phụ thuộc không cố định.

**Nhược điểm:**

* **Hidden Dependencies:** Bạn không biết Class cần gì cho đến khi đọc hết code bên trong. Điều này vi phạm tính minh bạch của thiết kế.
* **Khó bảo trì:** Nếu Service Locator bị lỗi, toàn bộ app sẽ sụp đổ.
* **Anti-pattern:** Nhiều chuyên gia coi đây là một anti-pattern nếu lạm dụng để thay thế DI.

## 7. Câu hỏi phỏng vấn

1. **Tại sao DI thường được ưu tiên hơn Service Locator?** (Vì DI minh bạch hơn, giúp phát hiện sớm các vấn đề về thiết kế khi Constructor quá lớn).
2. **Trong trường hợp nào Service Locator lại tốt hơn DI?** (Khi bạn đang ở một môi trường không hỗ trợ DI, hoặc khi cần lấy một service một cách tùy chọn dựa trên logic runtime phức tạp).
3. **Laravel Service Container là DI hay Service Locator?** (Nó là cả hai. Nó đóng vai trò Locator khi bạn gọi `app()`, và đóng vai trò DI engine khi nó tự động inject vào Constructor).

## Kết luận

Service Locator là một công cụ mạnh mẽ nhưng cần sử dụng cẩn thận. Hãy dùng DI cho các logic nghiệp vụ chính và chỉ dùng Service Locator (như hàm `app()` trong Laravel) ở các tầng hạ tầng (infrastructure) hoặc khi thực sự cần thiết.
