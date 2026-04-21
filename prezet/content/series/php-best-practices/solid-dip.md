---
title: Dependency Inversion Principle – Viết code linh hoạt, dễ test
excerpt: "Tìm hiểu nguyên lý DIP trong SOLID: phụ thuộc abstraction thay vì implementation, giúp code dễ test, dễ mở rộng và maintain."
category: PHP Best Practices
date: 2025-09-28
order: 16
image: /prezet/img/ogimages/series-php-best-practices-solid-dip.webp
---

## Nguyên tắc cốt lõi

👉 **High-level module không được phụ thuộc vào low-level module**

👉 Cả hai phải phụ thuộc vào **abstraction (interface)**

## Bad Example (Anti-pattern)

```php
class OrderService
{
    private MySqlDatabase $db;

    public function __construct()
    {
        $this->db = new MySqlDatabase();
    }
}
```

**Vấn đề**

* Tight coupling
* Không test được
* Không thay đổi implementation được

## Good Example (Best Practice)

### 1. Define abstraction

```php
interface OrderRepository
{
    public function save(Order $order): void;
}
```

### 2. Inject dependency

```php
class OrderService
{
    public function __construct(private OrderRepository $repo) {}
}
```

### 3. Implementation

```php
class MySqlOrderRepository implements OrderRepository {}
```

### 4. DI Container

```php
$container->bind(OrderRepository::class, MySqlOrderRepository::class);
```

## Giải thích sâu (Senior mindset)

### 1. Abstraction là gì?

👉 Interface định nghĩa hành vi, không quan tâm implementation

### 2. Dependency direction

❌ Sai:

High-level → Low-level

✅ Đúng:

High-level → Interface ← Low-level

### 3. DIP vs DI

* DIP: principle
* DI: technique

👉 DI giúp implement DIP

### 4. Testability

👉 Mock dễ dàng

```php
$mock = $this->createMock(OrderRepository::class);
```

### 5. Clean Architecture

👉 Domain không phụ thuộc framework

## Tips & Tricks (Senior level)

### 1. Không inject concrete class

### 2. Interface đặt ở domain layer

### 3. Không over-engineer

👉 Chỉ abstraction khi cần

### 4. Laravel binding

```php
$this->app->bind(Interface::class, Impl::class);
```

### 5. Null object pattern

👉 Tránh if null trong code

## Interview Questions

<details>
  <summary>1. DIP là gì?</summary>

**Summary:**

* Phụ thuộc abstraction

**Deep:**
Tách business logic khỏi implementation

</details>

<details>
  <summary>2. DIP khác DI như thế nào?</summary>

**Summary:**

* DIP là nguyên lý
* DI là cách implement

</details>

<details>
  <summary>3. Tại sao DIP giúp test tốt hơn?</summary>

**Summary:**

* Có thể mock

**Deep:**
Không phụ thuộc implementation thật

</details>

<details>
  <summary>4. Khi nào không nên dùng DIP?</summary>

**Summary:**

* Khi đơn giản

**Deep:**
Over-engineering

</details>

<details>
  <summary>5. DIP có liên quan Clean Architecture không?</summary>

**Summary:**

* Có

**Deep:**
Core rule của Clean Architecture

</details>

## Kết luận

👉 DIP giúp code:

* Dễ test
* Dễ maintain
* Dễ mở rộng

👉 Nhưng:

* Không lạm dụng abstraction
