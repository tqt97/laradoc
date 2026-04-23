---
title: SOLID - Dependency Inversion Principle (DIP) từ cơ bản đến Architect + áp dụng Laravel
excerpt: "Phân tích chuyên sâu Dependency Inversion Principle (DIP): bản chất, kiến trúc, cách áp dụng đúng trong PHP/Laravel, anti-pattern, trade-off và case study production."
tags: [solid-dip-abstractions]
date: 2025-10-13
order: 13
image: /prezet/img/ogimages/series-clean-code-principles-solid-dip-abstractions.webp
---

## Dependency Inversion Principle (DIP)

> High-level modules should not depend on low-level modules. Both should depend on abstractions.

DIP là nguyên lý **quan trọng nhất trong SOLID ở level kiến trúc**. Nếu hiểu sai hoặc áp dụng sai → dễ dẫn đến over-engineering.

## 1. Bản chất của DIP (hiểu đúng từ gốc)

#### 1.1 High-level vs Low-level là gì?

* High-level: business logic (OrderService)
* Low-level: implementation (MySQL, Redis, Stripe)

👉 Sai lầm phổ biến: nghĩ high-level là "controller"

#### 1.2 Inversion nghĩa là gì?

Thông thường:

```text
Service → MySQL
```

DIP:

```text
Service → Interface ← MySQL
```

👉 Dependency bị đảo chiều

## 2. Vấn đề khi không áp dụng DIP

#### 2.1 Tight coupling

```php
class OrderService {
    private MySQLDatabase $db;
}
```

👉 Không thể đổi DB

#### 2.2 Khó test

* Phải mock DB thật
* Phải gọi external service

#### 2.3 Code fragile

* Đổi Stripe → sửa toàn bộ service

## 3. Kiến trúc đúng với DIP

#### 3.1 Dependency direction

```text
Domain → Abstraction ← Infrastructure
```

#### 3.2 Ownership của abstraction

👉 Insight quan trọng:

> Interface nên được define bởi high-level module

## 4. Ví dụ PHP thuần (production mindset)

#### Interface

```php
interface PaymentGateway {
    public function charge(float $amount): string;
}
```

#### Implementation

```php
class StripeGateway implements PaymentGateway {
    public function charge(float $amount): string {
        return 'txn_123';
    }
}
```

#### Service

```php
class OrderService {
    public function __construct(private PaymentGateway $gateway) {}

    public function checkout(float $amount): string {
        return $this->gateway->charge($amount);
    }
}
```

## 5. Áp dụng trong Laravel

#### 5.1 Service Container (DI container)

```php
app()->bind(PaymentGateway::class, StripeGateway::class);
```

#### 5.2 Usage

```php
class OrderService {
    public function __construct(private PaymentGateway $gateway) {}
}
```

👉 Laravel inject tự động

#### 5.3 Swap implementation

```php
app()->bind(PaymentGateway::class, PaypalGateway::class);
```

👉 Không cần sửa code

## 6. DIP vs Dependency Injection

| DIP         | DI             |
| ----------- | -------------- |
| Principle   | Technique      |
| Design rule | Implementation |

👉 DI giúp implement DIP

## 7. DIP vs Interface Overuse (bẫy phổ biến)

#### Sai

```php
interface UserServiceInterface {}
class UserService implements UserServiceInterface {}
```

👉 Không có multiple implementation → vô nghĩa

#### Đúng

* Khi có nhiều implementation
* Khi cần test isolation
* Khi có external dependency

## 8. Advanced: DIP trong Clean Architecture

#### 8.1 Layer

* Domain (Entity)
* Application (Use case)
* Interface (Controller)
* Infrastructure (DB, API)

👉 Infrastructure phụ thuộc vào Domain

#### 8.2 Boundary

```text
Application → Interface ← Infrastructure
```

## 9. Real-world Case

#### 9.1 Payment system

* Stripe
* PayPal
* VNPay

👉 DIP giúp plug-in dễ dàng

#### 9.2 Storage system

* Local
* S3
* GCS

👉 chỉ cần đổi implementation

## 10. Trade-off

#### Ưu điểm

* Flexible
* Testable
* Decoupled

#### Nhược điểm

* Boilerplate
* Over-engineering

## 11. Khi nào KHÔNG nên dùng DIP

* Code đơn giản
* Không có variation
* YAGNI

## 12. Tips & Tricks

* Interface nên nhỏ (ISP)
* Không expose implementation detail
* Naming rõ ràng
* Combine với Repository

## 13. Interview Questions

<details>
  <summary>DIP là gì?</summary>

**Summary:**

* Depend on abstraction

**Deep:**

* Tách business khỏi detail

</details>

<details>
  <summary>DIP khác DI như thế nào?</summary>

**Summary:**

* DIP là principle

**Deep:**

* DI là tool implement

</details>

<details>
  <summary>Khi nào không nên dùng DIP?</summary>

**Summary:**

* Khi đơn giản

**Deep:**

* Tránh over-engineering

</details>

## 14. Kết luận

DIP là nền tảng của architecture hiện đại.

* Dùng đúng → system flexible
* Dùng sai → system phức tạp

👉 Senior biết dùng
👉 Architect biết dùng đúng chỗ
