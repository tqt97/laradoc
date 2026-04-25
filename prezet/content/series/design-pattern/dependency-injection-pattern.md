---
title: Dependency Injection - Linh hồn của Laravel
excerpt: Tìm hiểu Dependency Injection (DI) - bí quyết tách biệt phụ thuộc, giải mã cơ chế hoạt động của Service Container và cách viết code linh hoạt, dễ test.
category: Design pattern
date: 2026-04-01
order: 25
image: /prezet/img/ogimages/series-design-pattern-dependency-injection-pattern.webp
---

> Pattern thuộc nhóm **Creational Pattern (Khởi tạo)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang viết một class xử lý đơn hàng (`OrderService`) và cần gửi email thông báo.

**Naive Solution: Khởi tạo trực tiếp bên trong (Hard-coded)**

```php
class OrderService {
    public function process() {
        $mailer = new SmtpMailer(); // Phụ thuộc "cứng" vào SMTP
        $mailer->send("Đơn hàng thành công!");
    }
}
```

**Vấn đề:**

1. **Khó thay đổi:** Nếu muốn đổi từ SMTP sang Mailgun, bạn phải sửa trực tiếp trong class `OrderService`.
2. **Khó Unit Test:** Bạn không thể test `OrderService` mà không thực sự gửi một email thật (hoặc phải dùng những kỹ thuật mock rất phức tạp).
3. **Vi phạm Dependency Inversion:** Class cấp cao (`OrderService`) đang phụ thuộc trực tiếp vào class cấp thấp (`SmtpMailer`).

## 2. Định nghĩa

**Dependency Injection (DI)** là một kỹ thuật trong đó một đối tượng nhận các đối tượng khác mà nó phụ thuộc vào (dependencies). Thay vì tự khởi tạo, các phụ thuộc này được "tiêm" vào đối tượng từ bên ngoài (thường qua Constructor hoặc Method).

**Ý tưởng cốt lõi:** "Đừng gọi cho chúng tôi, chúng tôi sẽ gọi cho bạn." Đối tượng không tự đi tìm đồ dùng, nó đợi người khác mang đồ dùng đến cho mình.

## 3. Implementation (PHP Clean Code)

### 3.1 Bước 1: Trừu tượng hóa bằng Interface

```php
interface MailerInterface {
    public function send(string $message): void;
}
```

### 3.2 Bước 2: Các Implementation cụ thể

```php
class SmtpMailer implements MailerInterface {
    public function send(string $message): void { /* logic SMTP */ }
}

class MailgunMailer implements MailerInterface {
    public function send(string $message): void { /* logic Mailgun */ }
}
```

### 3.3 Bước 3: Dependency Injection (Constructor Injection)

```php
class OrderService {
    // Chúng ta yêu cầu một interface, không phải class cụ thể
    public function __construct(
        protected MailerInterface $mailer
    ) {}

    public function process() {
        $this->mailer->send("Đơn hàng thành công!");
    }
}
```

## 4. Liên hệ Laravel (The Service Container)

Laravel sở hữu một trong những bộ máy DI mạnh mẽ nhất thế giới PHP: **Service Container**.

**1. Tự động giải quyết (Auto-wiring):**
Bạn chỉ cần khai báo kiểu dữ liệu trong Constructor của Controller, Laravel sẽ tự động tìm và "tiêm" đối tượng đó vào cho bạn.

```php
public function store(OrderService $service) {
    $service->process();
}
```

**2. Binding Interface:**
Bạn có thể ra lệnh cho Laravel: "Mỗi khi có ai yêu cầu `MailerInterface`, hãy đưa cho họ `MailgunMailer`".

```php
// AppServiceProvider.php
$this->app->bind(MailerInterface::class, MailgunMailer::class);
```

## 5. Khi nào nên dùng

* Luôn luôn nên dùng khi bạn làm việc với các Service, Repositories, hoặc bất kỳ Class nào có logic nghiệp vụ.
* Khi bạn muốn viết code có khả năng Unit Test cao.

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Loose Coupling:** Giảm sự phụ thuộc giữa các class.
* **Flexibility:** Dễ dàng thay đổi implementation chỉ bằng một dòng cấu hình.
* **Testability:** Cực kỳ dễ dàng Mock các phụ thuộc khi viết Test.

**Nhược điểm:**

* **Hơi khó hiểu ban đầu:** Đòi hỏi kiến thức về Interface và Service Container.
* **Tăng số lượng file:** Do phải tạo Interface và các Implementation riêng biệt.

## 7. Câu hỏi phỏng vấn

1. **Sự khác biệt giữa Dependency Injection và Dependency Inversion?** (DI là kỹ thuật thực hiện, Dependency Inversion là nguyên tắc thiết kế - chữ D trong SOLID).
2. **Có bao nhiêu cách tiêm phụ thuộc?** (3 cách chính: Constructor Injection, Setter Injection, và Interface Injection).
3. **Tại sao DI lại giúp Unit Test dễ dàng hơn?** (Vì bạn có thể tiêm một đối tượng giả - Mock Object - vào thay cho đối tượng thật để kiểm tra logic).

## Kết luận

Dependency Injection là "xương sống" của các ứng dụng Laravel chuyên nghiệp. Hiểu và vận dụng tốt DI sẽ giúp code của bạn linh hoạt, sạch sẽ và sẵn sàng cho việc mở rộng quy mô lớn.
