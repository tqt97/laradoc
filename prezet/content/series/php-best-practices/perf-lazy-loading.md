---
title: Lazy Loading – Tối ưu hiệu năng và memory trong PHP
excerpt: Tìm hiểu Lazy Loading trong PHP để chỉ load dữ liệu khi cần, giảm memory, tăng performance. Kèm ví dụ thực tế, best practices và interview questions.
category: PHP Best Practices
date: 2025-09-27
order: 9
image: /prezet/img/ogimages/series-php-best-practices-perf-lazy-loading.webp
---

## Lazy Loading là gì?

Lazy Loading là kỹ thuật **trì hoãn việc load dữ liệu hoặc khởi tạo object cho đến khi thực sự cần dùng**.

👉 Trái ngược với Eager Loading (load ngay từ đầu)

## Bad Example (Anti-pattern)

```php
class ReportService
{
    private array $allUsers;
    private array $allOrders;
    private PDFGenerator $pdf;

    public function __construct(
        private UserRepository $userRepo,
        private OrderRepository $orderRepo,
    ) {
        $this->allUsers = $this->userRepo->findAll();
        $this->allOrders = $this->orderRepo->findAll();
        $this->pdf = new PDFGenerator();
    }
}
```

**Vấn đề**

* Load tất cả dữ liệu ngay từ constructor
* Tốn memory dù không dùng
* Slow startup

## Good Example (Best Practice)

### 1. Lazy init object

```php
private ?PDFGenerator $pdf = null;

private function getPdf(): PDFGenerator
{
    return $this->pdf ??= new PDFGenerator();
}
```

### 2. Load data khi cần

```php
public function generateReport(): string
{
    $orders = $this->orderRepo->findAll();
    return $this->getPdf()->generate($orders);
}
```

### 3. Query tối ưu

```php
public function getUserCount(): int
{
    return $this->userRepo->count();
}
```

👉 Không cần load toàn bộ user

### 4. Lazy cache data

```php
private ?array $users = null;

private function getUsers(): array
{
    return $this->users ??= $this->userRepo->findAll();
}
```

## Giải thích sâu

### 1. Pay as you go

👉 Chỉ trả cost khi dùng

* Không dùng → không tốn resource

### 2. Constructor nhẹ

Constructor chỉ nên:

* Assign dependency
* Không làm việc nặng

👉 Giúp object khởi tạo nhanh

### 3. Memory optimization

* Eager: load tất cả → tốn RAM
* Lazy: load khi cần → tiết kiệm

### 4. Caching pattern

```php
$this->data ??= expensiveCall();
```

👉 Lazy + cache cùng lúc

### 5. Trade-off

Lazy quá nhiều:

* Khó predict performance
* Có thể gây nhiều query (N+1)

👉 Cần balance

## Tips & Tricks

### 1. Rule đơn giản

👉 Expensive operation → lazy

### 2. Laravel context

* Eloquent lazy loading vs eager loading

```php
User::with('orders')->get(); // eager
```

👉 Tránh N+1

### 3. Combine với cache

```php
Cache::remember('key', fn() => expensive());
```

### 4. Lazy service initialization

Dùng Service Container để defer

### 5. Không lazy mọi thứ

👉 Critical path → preload

## Interview Questions

<details>
  <summary>1. Lazy Loading là gì?</summary>

**Summary:**

* Load khi cần

**Deep:**
Trì hoãn khởi tạo để tiết kiệm resource

</details>

<details>
  <summary>2. Lazy vs Eager Loading?</summary>

**Summary:**

* Lazy: khi cần
* Eager: ngay từ đầu

**Deep:**
Lazy tiết kiệm memory, eager giảm query

</details>

<details>
  <summary>3. Khi nào nên dùng Lazy Loading?</summary>

**Summary:**

* Khi operation tốn tài nguyên

**Deep:**
DB lớn, file, API, object nặng

</details>

<details>
  <summary>4. Nhược điểm của Lazy Loading?</summary>

**Summary:**

* Có thể gây N+1

**Deep:**
Nhiều lần gọi → nhiều query

</details>

<details>
  <summary>5. ??= dùng để làm gì?</summary>

**Summary:**

* Lazy init

**Deep:**
Gán giá trị nếu null → clean code

</details>

## Kết luận

👉 Lazy Loading giúp:

* Tối ưu performance
* Tiết kiệm memory
* Làm hệ thống scalable

> Nhưng nếu dùng sai → gây N+1 và khó debug
