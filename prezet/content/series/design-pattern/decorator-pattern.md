---
title: Decorator Pattern - Kỹ thuật bọc hành vi tinh tế
excerpt: Tìm hiểu Decorator Pattern - cách thêm tính năng vào đối tượng mà không cần dùng kế thừa, ứng dụng thực tế trong hệ thống Middleware và Logger của Laravel.
category: Design pattern
date: 2026-03-16
order: 9
image: /prezet/img/ogimages/series-design-pattern-decorator-pattern.webp
---

> Pattern thuộc nhóm **Structural Pattern (Cấu trúc)**

## 1. Problem & Motivation

Giả sử bạn đang xây dựng một hệ thống thông báo (`Notifier`). Ban đầu, bạn chỉ cần gửi Email.
Sau đó, khách hàng muốn:

* Vừa gửi Email, vừa gửi SMS.
* Vừa gửi Email, vừa gửi Slack.
* Gửi cả Email, SMS và Slack cùng lúc.

**Naive Solution: Dùng kế thừa (Inheritance)**
Bạn sẽ tạo ra các class: `EmailNotifier`, `EmailAndSmsNotifier`, `EmailAndSlackNotifier`, `AllInOneNotifier`...
**Vấn đề:** Số lượng class con sẽ bùng nổ theo cấp số nhân (Class Explosion). Code cực kỳ khó duy trì khi có thêm kênh thông báo thứ 4, thứ 5.

## 2. Định nghĩa

**Decorator Pattern** cho phép bạn thêm các hành vi mới vào một đối tượng một cách động bằng cách đặt đối tượng đó vào trong các class "bọc" (wrapper) đặc biệt.

**Ý tưởng cốt lõi:** Thay vì kế thừa Class, hãy **"bọc"** nó. Giống như bạn mặc thêm áo khoác khi trời lạnh: bạn vẫn là bạn, nhưng bạn có thêm khả năng "chống rét".

## 3. Implementation (PHP Clean Code)

### 3.1 Interface chung

```php
interface NotifierInterface {
    public function send(string $message): void;
}
```

### 3.2 Component gốc (Cái lõi)

```php
class EmailNotifier implements NotifierInterface {
    public function send(string $message): void {
        echo "Gửi Email: $message\n";
    }
}
```

### 3.3 Decorator trừu tượng

```php
abstract class NotifierDecorator implements NotifierInterface {
    public function __construct(protected NotifierInterface $notifier) {}
    
    public function send(string $message): void {
        $this->notifier->send($message);
    }
}
```

### 3.4 Các Decorator cụ thể

```php
class SmsDecorator extends NotifierDecorator {
    public function send(string $message): void {
        parent::send($message); // Gửi Email trước
        echo "Gửi SMS: $message\n"; // Sau đó gửi SMS
    }
}

class SlackDecorator extends NotifierDecorator {
    public function send(string $message): void {
        parent::send($message);
        echo "Gửi Slack: $message\n";
    }
}

// Sử dụng (Lắp ráp linh hoạt)
$stack = new EmailNotifier();
$stack = new SmsDecorator($stack);
$stack = new SlackDecorator($stack);

$stack->send("Có đơn hàng mới!"); 
// Kết quả: Gửi Email -> Gửi SMS -> Gửi Slack
```

## 4. Liên hệ Laravel (The Middleware Mindset)

Bản chất của **Middleware** trong Laravel chính là một dạng ứng dụng của Decorator Pattern:

* Request đi qua lớp bọc thứ nhất (Auth).
* Nếu ổn, đi tiếp qua lớp bọc thứ hai (Log).
* Cuối cùng mới chạm vào nhân (Controller).

Ngoài ra, Laravel sử dụng Decorator trong hệ thống **Filesystem** hoặc khi bạn muốn "trang trí" thêm các chức năng cho Model mà không muốn làm dơ class gốc.

## 5. Khi nào nên dùng

* Khi muốn thêm chức năng vào đối tượng tại runtime mà không làm ảnh hưởng đến các đối tượng khác cùng class.
* Khi việc dùng kế thừa trở nên quá phức tạp và tạo ra quá nhiều class con.
* Khi bạn cần tuân thủ **Single Responsibility Principle** (chia nhỏ các tính năng thành từng lớp bọc riêng).

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* Linh hoạt hơn kế thừa rất nhiều.
* Có thể kết hợp nhiều hành vi bằng cách bọc nhiều lớp.
* Tuân thủ nguyên tắc Open/Closed.

**Nhược điểm:**

* Thứ tự các lớp bọc đôi khi rất quan trọng và dễ nhầm lẫn.
* Tạo ra nhiều đối tượng nhỏ, có thể gây khó khăn khi debug luồng dữ liệu bên trong.

## 7. So sánh: Decorator vs Adapter vs Strategy

| Pattern | Khác biệt cốt lõi |
| :--- | :--- |
| **Decorator** | Giữ nguyên Interface, thêm hành vi mới. |
| **Adapter** | Thay đổi Interface để tương thích. |
| **Strategy** | Thay đổi logic thực hiện (thuật toán) bên trong. |

## 8. Câu hỏi phỏng vấn

1. **Tại sao Decorator lại tốt hơn kế thừa?** (Vì nó cho phép thay đổi hành vi tại runtime và tránh việc bùng nổ số lượng class con).
2. **Decorator Pattern có bắt buộc phải dùng kế thừa không?** (Trong PHP, class Decorator thường kế thừa từ một abstract decorator hoặc trực tiếp implement cùng interface với object gốc để đảm bảo tính đồng nhất).
3. **Làm sao để gỡ bỏ một Decorator tại runtime?** (Decorator thuần khá khó gỡ bỏ giữa chừng trong chuỗi bọc, thường bạn sẽ phải build lại chuỗi mới).

## Kết luận

Decorator Pattern là "nghệ thuật sắp xếp" các lớp bọc. Hãy nghĩ đến nó khi bạn thấy mình đang bắt đầu viết những class có tên dài loằng ngoằng như `AuthAndLogAndCacheRepository`. Hãy chia nhỏ chúng ra và bọc chúng lại!
