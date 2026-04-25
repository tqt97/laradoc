---
title: Observer Pattern - Hệ thống phát thanh thông minh
excerpt: Tìm hiểu Observer Pattern - cách các đối tượng theo dõi và phản ứng với thay đổi của nhau, nền tảng của hệ thống Events & Listeners trong Laravel.
category: Design pattern
date: 2026-03-12
order: 5
image: /prezet/img/ogimages/series-design-pattern-observer-pattern.webp
---

> Pattern thuộc nhóm **Behavioral Pattern (Hành vi)**

## 1. Problem & Motivation

Giả sử bạn đang xây dựng một hệ thống E-commerce. Khi một đơn hàng (Order) được thanh toán thành công, bạn cần làm rất nhiều việc:

1. Gửi email xác nhận cho khách hàng.
2. Gửi thông báo đến kho để chuẩn bị hàng.
3. Cập nhật điểm thưởng cho khách hàng.
4. Gửi tin nhắn SMS cho quản lý.

**Naive Solution:** Viết tất cả code này trong hàm `pay()` của class `Order`.

```php
class Order {
    public function pay() {
        // Logic thanh toán...
        $emailService->send();
        $inventoryService->notify();
        $loyaltyService->addPoints();
        // Càng ngày hàm này càng dài và khó maintain
    }
}
```

**Vấn đề:** Class `Order` bị phụ thuộc quá nhiều vào các service khác (Tight Coupling). Mỗi khi thêm một hành động mới (ví dụ: gửi thông báo Slack), bạn lại phải sửa class `Order`. Vi phạm **Open/Closed Principle**.

## 2. Định nghĩa

**Observer Pattern** định nghĩa một mối quan hệ **1-nhiều** giữa các đối tượng sao cho khi một đối tượng thay đổi trạng thái, tất cả các đối tượng phụ thuộc của nó sẽ được thông báo và cập nhật tự động.

**Thành phần chính:**

* **Subject (Chủ thể):** Đối tượng nắm giữ trạng thái và danh sách các "người theo dõi".
* **Observers (Người theo dõi):** Các đối tượng đăng ký để nhận thông báo khi Subject thay đổi.

## 3. Implementation (PHP Clean Code)

### 3.1 PHP Thuần (Sử dụng SplSubject & SplObserver có sẵn)

```php
class OrderSubject implements \SplSubject
{
    private array $observers = [];
    public string $status;

    public function attach(\SplObserver $observer): void {
        $this->observers[] = $observer;
    }

    public function detach(\SplObserver $observer): void {
        $key = array_search($observer, $this->observers, true);
        if ($key !== false) unset($this->observers[$key]);
    }

    public function notify(): void {
        foreach ($this->observers as $observer) {
            $observer->update($this);
        }
    }

    public function pay() {
        $this->status = 'paid';
        echo "Order đã thanh toán!\n";
        $this->notify();
    }
}

class EmailObserver implements \SplObserver {
    public function update(\SplSubject $subject): void {
        if ($subject->status === 'paid') {
            echo "Email: Gửi mail xác nhận đơn hàng...\n";
        }
    }
}

// Sử dụng
$order = new OrderSubject();
$order->attach(new EmailObserver());
$order->pay();
```

### 3.2 Liên hệ Laravel (The Power of Events)

Trong Laravel, Observer Pattern xuất hiện ở khắp mọi nơi dưới hai hình thức chính:

**1. Model Observers:** Chuyên theo dõi vòng đời của Eloquent Model.

```php
// Tạo Observer: php artisan make:observer OrderObserver --model=Order
class OrderObserver {
    public function created(Order $order) {
        // Tự động chạy khi Order được tạo
    }
}
```

**2. Events & Listeners:** Hệ thống phát thanh (Event Dispatcher).

```php
// Phát đi một sự kiện
OrderPaid::dispatch($order);

// Các Listeners tự động "nghe" và thực hiện hành động riêng biệt
class SendInvoiceListener { ... }
class NotifyWarehouseListener { ... }
```

## 4. Ưu & Nhược điểm

**Ưu điểm:**

* **Loose Coupling:** Subject không cần biết Observer là ai, làm gì.
* **Open/Closed Principle:** Thêm Observer mới mà không cần sửa Subject.
* **Tính linh hoạt:** Có thể đăng ký/hủy đăng ký theo dõi tại runtime.

**Nhược điểm:**

* **Thứ tự thực hiện:** Các Observer thường chạy không theo thứ tự định trước.
* **Khó debug:** Vì luồng xử lý bị tách rời, đôi khi khó theo dõi "ai đã gây ra hành động này".
* **Memory Leak:** Nếu không hủy đăng ký (detach) các Observer không còn dùng đến.

## 5. So sánh: Observer vs Pub/Sub

| Đặc điểm | Observer | Pub/Sub |
| :--- | :--- | :--- |
| **Giao tiếp** | Trực tiếp (Subject giữ list Observers) | Qua một Message Broker (Middleware) |
| **Mối quan hệ** | Thường là đồng bộ (Synchronous) | Thường là bất đồng bộ (Asynchronous) |
| **Phạm vi** | Trong cùng một ứng dụng | Có thể giữa nhiều microservices |

## 6. Câu hỏi phỏng vấn

1. **Lợi ích lớn nhất của Observer Pattern là gì?** (Giảm sự phụ thuộc giữa các class - Decoupling).
2. **Trong Laravel, khi nào dùng Model Observer, khi nào dùng Event/Listener?** (Dùng Model Observer cho logic gắn liền với database lifecycle. Dùng Event cho logic nghiệp vụ rộng hơn, cần xử lý queue).
3. **Làm thế nào để tránh vòng lặp vô tận trong Observer?** (Tránh việc trong hàm `update()` của Observer lại gọi ngược lại hành động làm thay đổi trạng thái của Subject).
4. **Tại sao nên đẩy các hành động trong Observer vào Queue?** (Để không làm chậm trải nghiệm của người dùng khi phải đợi gửi email, thông báo...).

## Kết luận

Observer Pattern biến code của bạn từ một mớ hỗn độn phụ thuộc lẫn nhau thành một hệ thống linh hoạt, nơi các thành phần giao tiếp qua các "thông điệp". Đây là chìa khóa để xây dựng các ứng dụng Laravel quy mô lớn mà vẫn giữ được sự ngăn nắp.
