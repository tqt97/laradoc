---
title: Dependency Injection & Service Container
excerpt: "Phân tích chuyên sâu Dependency Injection và Service Container trong Laravel: định nghĩa, cơ chế hoạt động, vòng đời, binding nâng cao, pitfalls, tối ưu hiệu năng và bộ câu hỏi interview chi tiết."
category: Laravel
date: 2026-03-08
order: 15
image: /prezet/img/ogimages/series-laravel-advanced-dependency-injection-service-container.webp
---

Trong Laravel, Service Container là nền tảng để **resolve dependency**, **inject phụ thuộc**, và **quản lý vòng đời object**. Nắm vững DI + IoC không chỉ giúp code sạch mà còn quyết định khả năng test, mở rộng và scale hệ thống.

## I. Định nghĩa nền tảng

### 1. Dependency là gì?

**Dependency** là một đối tượng/lớp mà một class cần để hoạt động.

```php
class OrderService
{
    public function __construct(PaymentGateway $payment) {}
}
```

Ở đây `PaymentGateway` là dependency của `OrderService`.

### 2. Dependency Injection (DI) là gì?

**DI (Dependency Injection)** là kỹ thuật **cung cấp dependency từ bên ngoài** vào class thay vì class tự tạo.

#### So sánh

❌ Tight coupling (không DI)

```php
class OrderService {
    public function __construct() {
        $this->payment = new StripePayment();
    }
}
```

✅ Loose coupling (DI)

```php
class OrderService {
    public function __construct(PaymentGateway $payment) {}
}
```

#### Bản chất

* Class **không biết implementation cụ thể**
* Chỉ phụ thuộc vào abstraction (interface)

### 3. Inversion of Control (IoC) là gì?

**IoC** là nguyên lý đảo ngược quyền kiểm soát việc tạo object.

#### Truyền thống (không IoC)

* Class tự tạo dependency

#### IoC

* Một hệ thống bên ngoài (Container) chịu trách nhiệm tạo và inject dependency

👉 DI là **một cách implement IoC**

### 4. DI vs IoC (rất hay hỏi interview)

| Khái niệm | DI                | IoC         |
| --------- | ----------------- | ----------- |
| Bản chất  | Kỹ thuật          | Nguyên lý   |
| Mục tiêu  | Inject dependency | Đảo control |
| Quan hệ   | Là 1 phần của IoC | Bao trùm DI |

👉 Nói ngắn gọn: **IoC = idea, DI = implementation**

### 5. Service Container là gì?

Service Container là **IoC container** có nhiệm vụ:

* Tạo object
* Resolve dependency
* Inject dependency
* Quản lý lifecycle

Trong Laravel, container được truy cập qua:

```php
app()
resolve()
```

## II. Cơ chế hoạt động nội bộ (Deep)

### 1. Reflection-based Resolution

Laravel dùng PHP Reflection để:

1. Đọc constructor
2. Xác định type-hint
3. Resolve dependency đệ quy
4. Instantiate object

### 2. Flow resolve (quan trọng)

Khi gọi:

```php
app(OrderService::class);
```

#### Flow

1. Check binding trong container
2. Nếu có binding → dùng binding
3. Nếu không → dùng reflection
4. Resolve từng dependency trong constructor
5. Instantiate object
6. Trả về instance

### 3. Mapping / Binding là gì?

**Binding** là việc ánh xạ (map) giữa abstraction → implementation

```php
$this->app->bind(PaymentGateway::class, StripePayment::class);
```

👉 Khi resolve `PaymentGateway` → container trả về `StripePayment`

## III. Các loại Binding (Rất chi tiết)

### 1. bind

```php
$this->app->bind(Service::class, function () {
    return new Service();
});
```

#### Đặc điểm:

* Mỗi lần resolve → tạo instance mới
* Không giữ state

### 2. singleton

```php
$this->app->singleton(Service::class, function () {
    return new Service();
});
```

#### Đặc điểm

* Chỉ tạo **1 instance duy nhất**
* Dùng lại trong suốt lifecycle

#### Use case

* Logger
* Cache
* Config service

### 3. instance

```php
$this->app->instance(Service::class, new Service());
```

#### Đặc điểm

* Bạn tự tạo object
* Container chỉ giữ reference

### So sánh nhanh

| Type      | Instance    | Lifecycle |
| --------- | ----------- | --------- |
| bind      | Mỗi lần mới | Transient |
| singleton | 1 lần       | Shared    |
| instance  | Có sẵn      | Shared    |

## IV. Contextual Binding (Nâng cao)

### Problem

1 interface → nhiều implementation

### Solution

```php
$this->app->when(OrderService::class)
    ->needs(PaymentGateway::class)
    ->give(StripePayment::class);
```

👉 Mapping theo context

## V. Lifecycle của Container

### 1. register()

* Bind service vào container

### 2. boot()

* Chạy sau khi tất cả service đã register

👉 Không bind trong boot (anti-pattern)

## VI. Advanced Features

### 1. Tagged services

```php
$this->app->tag([Stripe::class, Paypal::class], 'payment');
```

```php
app()->tagged('payment');
```

### 2. Extending binding (Decorator)

```php
$this->app->extend(Service::class, function ($service) {
    return new LoggingDecorator($service);
});
```

### 3. Rebinding

Override dependency runtime

## VII. Pitfalls (Thực chiến)

### 1. Hidden dependency

Auto resolve → dependency không rõ ràng

### 2. Over-injection

Inject quá nhiều dependency → class khó maintain

### 3. Circular dependency

A → B → A → crash

## VIII. Performance

* Singleton giúp giảm memory
* Avoid heavy logic trong binding
* Cache config/container

## IX. Testing

```php
$this->app->bind(PaymentGateway::class, FakePayment::class);
```

👉 Mock dependency dễ dàng

## X. So sánh DI vs Service Locator

| Tiêu chí      | DI  | Service Locator |
| ------------- | --- | --------------- |
| Dependency rõ | ✅   | ❌               |
| Test          | Dễ  | Khó             |
| Maintain      | Tốt | Kém             |

## XI. Interview Questions

<details open>
<summary>1. DI là gì?</summary>

**Summary:** Inject dependency từ bên ngoài

**Detail:**

* Giảm coupling
* Tăng testability
* Tuân thủ SOLID

</details>

<details>
<summary>2. IoC là gì?</summary>

**Summary:** Đảo quyền control object

**Detail:**

* Container tạo object
* Class không tự new

</details>

<details>
<summary>3. DI khác IoC?</summary>

**Summary:** DI là cách implement IoC

**Detail:**

* IoC = principle
* DI = technique

</details>

<details>
<summary>4. bind vs singleton?</summary>

**Summary:** bind = new instance, singleton = shared

**Detail:**

* bind → nhiều instance
* singleton → 1 instance

</details>

<details>
<summary>5. Container hoạt động như thế nào?</summary>

**Summary:** Dùng reflection để resolve

**Detail:**

* Inspect constructor
* Resolve dependency
* Instantiate class

</details>

## XII. Tổng kết

Để master:

* Hiểu rõ DI vs IoC
* Hiểu binding & lifecycle
* Biết flow resolve
* Tránh pitfalls

👉 Container mastery = kiểm soát kiến trúc hệ thống
