---
title: Composition Over Inheritance là gì? So sánh với Inheritance trong Clean Code
excerpt: Hiểu rõ nguyên tắc Composition Over Inheritance, cách áp dụng trong PHP, ví dụ thực tế, best practices và câu hỏi phỏng vấn nâng cao
category: Clean Code Principles
tags: [composition, inheritance, flexibility, design]
date: 2025-10-01
order: 2
image: /prezet/img/ogimages/series-clean-code-principles-core-composition.webp
---

**Nguyên tắc cốt lõi:**

> Không build system bằng cách `extends` nhiều lớp.
> Thay vào đó, build bằng cách **ghép (compose)** nhiều behavior nhỏ lại.

## Phần 1: Hiểu bản chất qua PHP thuần

### Cách sai: Inheritance

```php
<?php

class Bird {
    public function fly() {
        echo "Flying...";
    }
}

class Penguin extends Bird {
    public function fly() {
        // ❌ Sai hoàn toàn về design
        throw new Exception("Penguin cannot fly");
    }
}
```

### Vấn đề gì xảy ra?

* Penguin **không nên có method fly ngay từ đầu**
* Nhưng vì kế thừa → bị ép phải có
* Đây là **vi phạm LSP (Liskov Substitution Principle)**

## Cách đúng: Composition

#### Step 1: Tách behavior thành interface

```php
interface Flyer {
    public function fly(): void;
}
```

#### Step 2: Tạo implementation cụ thể

```php
class BirdFlyer implements Flyer {
    public function fly(): void {
        echo "Flying with wings";
    }
}
```

#### Step 3: Compose vào object

```php
class Duck {
    private Flyer $flyer;

    public function __construct(Flyer $flyer) {
        // Inject behavior từ bên ngoài
        $this->flyer = $flyer;
    }

    public function fly(): void {
        // Delegate: không tự xử lý, mà gọi sang behavior
        $this->flyer->fly();
    }
}
```

#### Step 4: Sử dụng

```php
$duck = new Duck(new BirdFlyer());
$duck->fly();
```

#### Penguin (không bay)

```php
class Penguin {
    // Không có Flyer → không có fly()
}
```

→ Thiết kế đúng domain

## Phân tích cực sâu

#### 1. Đây chính là Dependency Injection

```php
new Duck(new BirdFlyer());
```

* Không hardcode logic bên trong
* Inject từ ngoài vào

#### 2. Đây chính là Strategy Pattern

```php
$duck = new Duck(new JetFlyer());
```

→ đổi behavior runtime

#### 3. Đây chính là DIP

```php
public function __construct(Flyer $flyer)
```

→ phụ thuộc abstraction

#### 4. Runtime vs Compile time

| Kiểu        | Inheritance  | Composition |
| ----------- | ------------ | ----------- |
| Quyết định  | Compile time | Runtime     |
| Flexibility | Thấp         | Cao         |

## Phần 2: Nâng cấp design (real-world PHP)

**Ví dụ: Payment System**

**Inheritance**

```php
class BasePayment {
    public function pay() {}
}

class StripePayment extends BasePayment {}
class PaypalPayment extends BasePayment {}
```

→ Không linh hoạt

**Composition + Strategy**

```php
interface PaymentStrategy {
    public function pay(int $amount): void;
}

class StripePayment implements PaymentStrategy {
    public function pay(int $amount): void {
        echo "Pay with Stripe: $amount";
    }
}

class PaypalPayment implements PaymentStrategy {
    public function pay(int $amount): void {
        echo "Pay with Paypal: $amount";
    }
}

class PaymentService {
    private PaymentStrategy $strategy;

    public function __construct(PaymentStrategy $strategy) {
        $this->strategy = $strategy;
    }

    public function pay(int $amount): void {
        // Delegate
        $this->strategy->pay($amount);
    }
}
```

**Sử dụng**

```php
$service = new PaymentService(new StripePayment());
$service->pay(100);

$service = new PaymentService(new PaypalPayment());
$service->pay(200);
```

## Phần 3: Mapping sang Laravel

#### 1. Service Container

```php
$this->app->bind(PaymentStrategy::class, StripePayment::class);
```

→ Laravel inject tự động

#### 2. Controller

```php
class PaymentController {
    public function __construct(private PaymentStrategy $payment) {}

    public function pay() {
        $this->payment->pay(100);
    }
}
```

#### 3. Runtime swap (config-based)

```php
$this->app->bind(PaymentStrategy::class, function () {
    return config('payment.driver') === 'stripe'
        ? new StripePayment()
        : new PaypalPayment();
});
```

#### 4. Middleware = Composition

```php
// mỗi middleware = 1 behavior
```

Pipeline = chain behavior

#### 5. Event System

* Listener = behavior độc lập
* Event = trigger

→ Composition

## Phần 4: Khi nào nên dùng?

* Behavior thay đổi runtime
* Có nhiều strategy
* System cần scale
* Cần test isolation

## Khi nào không nên dùng?

* Code đơn giản
* Không cần abstraction
* YAGNI

## Pitfalls

#### 1. Over-engineering

* Interface quá nhiều

#### 2. Class explosion

* 1 feature → 10 class

#### 3. Sai abstraction

* Interface không rõ ràng

## Best Practices

* Luôn inject qua constructor
* Không new cứng trong class
* Interface nhỏ, rõ ràng
* Delegate logic

## Advanced Insight

#### 1. Composition = nền tảng của Clean Architecture

* Use case độc lập
* Infrastructure tách rời

#### 2. Composition = enable microservice thinking

* Module hóa system

#### 3. Composition = giảm blast radius

* Change 1 component → không ảnh hưởng hệ thống

## Câu hỏi phỏng vấn

<details>
  <summary>1. Composition Over Inheritance là gì?</summary>

**Summary:**

* Ghép behavior thay vì kế thừa

**Deep:**

* Runtime flexibility
* Loose coupling
* Testable

</details>

<details>
  <summary>2. Composition khác gì Strategy?</summary>

**Summary:**

* Strategy là 1 dạng composition

**Deep:**

* Encapsulate behavior
* Swap runtime

</details>

<details>
  <summary>3. Laravel dùng composition ở đâu?</summary>

**Summary:**

* Khắp nơi

**Deep:**

* Container
* Middleware
* Events
* Jobs

</details>

## Kết luận

Composition không phải là option.

Nó là **default mindset** khi thiết kế system hiện đại.

> Nếu bạn thấy mình đang viết extends lần thứ 2 → hãy dừng lại.
> 90% khả năng bạn đang design sai.
