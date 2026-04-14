---
title: Design pattern
excerpt: Design Pattern (mẫu thiết kế) là những giải pháp đã được kiểm chứng để giải quyết các vấn đề thường gặp trong lập trình phần mềm.
category: Design pattern
date: 2026-03-10
order: 1
image: /prezet/img/ogimages/series-design-pattern-index.webp
---

## 1. Design Pattern là gì?

Design Pattern (mẫu thiết kế) là những giải pháp đã được kiểm chứng để giải quyết các vấn đề thường gặp trong lập trình phần mềm.

> Quan trọng: Design Pattern KHÔNG phải là code cụ thể, mà là **cách tổ chức code**.

Hiểu đơn giản:

* Algorithm = giải bài toán
* Design Pattern = tổ chức hệ thống để code dễ mở rộng, bảo trì

## 2. Tại sao cần Design Pattern?

Nếu không dùng pattern:

* Code dễ bị **spaghetti**
* Khó maintain
* Khó scale
* Khó onboarding team

Nếu dùng đúng pattern:

* Tăng **readability**
* Tăng **maintainability**
* Dễ **refactor**
* Dễ **test**

## 3. Phân loại Design Pattern

Design Pattern được chia thành 3 nhóm chính:

### 3.1. Creational Patterns (Khởi tạo object)

Giải quyết cách tạo object linh hoạt.

Ví dụ:

* Singleton
* Factory Method
* Abstract Factory
* Builder
* Prototype

👉 Khi nào dùng?

* Khi việc tạo object phức tạp
* Khi muốn control lifecycle object

### 3.2. Structural Patterns (Cấu trúc)

Tổ chức mối quan hệ giữa các class/object.

Ví dụ:

* Adapter
* Decorator
* Facade
* Composite
* Proxy

👉 Khi nào dùng?

* Khi cần mở rộng mà không sửa code cũ
* Khi cần wrap logic

### 3.3. Behavioral Patterns (Hành vi)

Xử lý giao tiếp giữa các object.

Ví dụ:

* Observer
* Strategy
* Command
* State
* Chain of Responsibility

👉 Khi nào dùng?

* Khi logic thay đổi theo context
* Khi muốn giảm coupling

## 4. Ví dụ thực tế với PHP

### Code không dùng pattern

```php
class PaymentService {
    public function pay($type) {
        if ($type === 'paypal') {
            // xử lý paypal
        } elseif ($type === 'stripe') {
            // xử lý stripe
        }
    }
}
```

👉 Vấn đề:

* Vi phạm Open/Closed Principle
* Khó mở rộng

### Dùng Strategy Pattern

```php
interface PaymentMethod {
    public function pay();
}

class PaypalPayment implements PaymentMethod {
    public function pay() {
        // xử lý paypal
    }
}

class StripePayment implements PaymentMethod {
    public function pay() {
        // xử lý stripe
    }
}

class PaymentService {
    protected $method;

    public function __construct(PaymentMethod $method) {
        $this->method = $method;
    }

    public function pay() {
        $this->method->pay();
    }
}
```

👉 Lợi ích:

* Tuân thủ SOLID
* Dễ mở rộng
* Test dễ dàng

## 5. Những hiểu lầm phổ biến

### 5.1. Pattern càng nhiều càng tốt

Sai.

👉 Pattern chỉ nên dùng khi:

* Có problem rõ ràng
* Có khả năng scale

### 5.2. Pattern = Clean Code

Sai.

👉 Pattern chỉ là 1 phần của:

* Clean Architecture
* SOLID
* DDD

### 5.3. Junior không cần học pattern

Sai hoàn toàn.

👉 Junior nên:

* Hiểu basic pattern (Strategy, Factory, Singleton)
* Nhận biết khi nào cần dùng

## 6. Khi nào KHÔNG nên dùng Design Pattern?

* Project nhỏ
* Code đơn giản
* Không có requirement mở rộng

👉 Nguyên tắc:

> "Don't over-engineer"
>
## 7. Kết luận

Design Pattern là:

* Công cụ
* Không phải mục tiêu

Người giỏi không phải là người dùng nhiều pattern nhất,
mà là người **dùng đúng pattern, đúng lúc**.
