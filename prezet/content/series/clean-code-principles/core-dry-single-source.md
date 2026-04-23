---
title: Single Source of Truth là gì? Áp dụng DRY trong PHP & Laravel từ core đến system design
excerpt: Phân tích chuyên sâu nguyên tắc Single Source of Truth (SSOT) trong PHP và Laravel, từ code cơ bản đến kiến trúc hệ thống, tránh magic value, config drift.
tags: [DRY, single-source-of-truth, constants, configuration]
date: 2025-10-02
order: 4
image: /prezet/img/ogimages/series-clean-code-principles-core-dry-single-source.webp
---

**Nguyên tắc cốt lõi:**

> Mỗi "sự thật" (rule, config, constant, business logic) chỉ nên tồn tại **một nơi duy nhất** trong hệ thống.

## Phần 1: Bản chất thật sự của Single Source of Truth (SSOT)

### SSOT không chỉ là constants

Rất nhiều dev hiểu sai:

* Nghĩ rằng SSOT = define constant

Sai.

SSOT thực chất là:

* Nơi duy nhất chứa **business rule**
* Nơi duy nhất chứa **configuration**
* Nơi duy nhất chứa **domain knowledge**

### Ví dụ bản chất

```php
if ($order->status === 'pending')
```

→ "pending" KHÔNG phải string
→ Nó là **business state**

## Phần 2: Bad Example (PHP thuần)

```php
class OrderService {

    public function handle($order) {
        if ($order->status === 'pending') {
            // xử lý
        }

        if ($order->status === 'completed') {
            // xử lý khác
        }
    }
}

class OrderRepository {
    public function findPending() {
        return $this->db->where('status', 'pending')->get();
    }
}
```

### Vấn đề

##### 1. Magic string

* "pending" lặp nhiều nơi

##### 2. Drift

* Một dev đổi "pending" → "waiting"
* Quên sửa chỗ khác → bug

##### 3. Không kiểm soát domain

* Có thể typo: "pendng"

## Phần 3: Refactor chuẩn (PHP thuần)

### Step 1: Tạo Single Source

```php
class OrderStatus {
    public const PENDING = 'pending';
    public const COMPLETED = 'completed';
    public const CANCELLED = 'cancelled';
}
```

### Step 2: Sử dụng lại

```php
if ($order->status === OrderStatus::PENDING) {
    // đúng
}
```

### Step 3: Centralize logic

```php
class OrderStatusChecker {

    public static function isPending(string $status): bool {
        return $status === OrderStatus::PENDING;
    }

    public static function canCancel(string $status): bool {
        return in_array($status, [OrderStatus::PENDING]);
    }
}
```

### Phân tích sâu

##### 1. Constant = data SSOT

##### 2. Checker = logic SSOT

→ tách rõ data vs behavior

## Phần 4: Nâng cấp lên Enum (PHP 8.1+)

```php
enum OrderStatus: string {
    case PENDING = 'pending';
    case COMPLETED = 'completed';
    case CANCELLED = 'cancelled';

    public function canCancel(): bool {
        return $this === self::PENDING;
    }
}
```

### Sử dụng

```php
if ($order->status->canCancel()) {
    // clean hơn rất nhiều
}
```

### Lợi ích

* Type-safe
* Không typo
* Logic đi cùng data

## Phần 5: SSOT cho Config

### ❌ Sai

```php
$api = 'https://api.example.com';
```

xuất hiện nhiều nơi

### ✅ Đúng

```php
class Config {
    public const API_URL = 'https://api.example.com';
}
```

### Advanced

```php
class Config {
    public static function apiUrl(): string {
        return getenv('API_URL') ?: 'default';
    }
}
```

## Phần 6: Mapping sang Laravel

### 1. Config system

```php
config('app.url');
```

→ Laravel đã làm SSOT

### 2. Enum + Eloquent

```php
protected $casts = [
    'status' => OrderStatus::class
];
```

### 3. Validation Rules

```php
Rule::in([OrderStatus::PENDING->value]);
```

### 4. Centralized permission

```php
Gate::define('edit-post', fn($user) => $user->isAdmin());
```

### 5. Config-driven system

```php
config('payment.driver');
```

→ runtime behavior

## Phần 7: Khi nào cần SSOT?

* Business rule
* Status
* Config
* Permission
* Validation rule

## Khi nào KHÔNG cần?

* Giá trị local
* Logic nhỏ

## Pitfalls

### 1. Fake SSOT

* Define constant nhưng không dùng

### 2. Over-centralization

* Tất cả dồn 1 file → khó maintain

### 3. Sai abstraction

* Gom nhiều thứ không liên quan

## Advanced Insight (Staff level)

### 1. SSOT = nền tảng của Consistency

* System lớn → consistency quan trọng hơn speed

### 2. SSOT vs Duplication trade-off

* Microservice: đôi khi chấp nhận duplicate

### 3. SSOT trong distributed system

* Không có global truth
* Phải dùng eventual consistency

## Câu hỏi phỏng vấn

<details>
  <summary>1. Single Source of Truth là gì?</summary>

**Summary:**

* Mỗi rule tồn tại 1 nơi

**Deep:**

* Tránh drift
* Dễ maintain

</details>

<details>
  <summary>2. Enum vs Constant?</summary>

**Summary:**

* Enum mạnh hơn

**Deep:**

* Type-safe
* Gắn logic

</details>

<details>
  <summary>3. Laravel hỗ trợ SSOT như thế nào?</summary>

**Summary:**

* Config + Enum

**Deep:**

* config()
* validation
* policy

</details>

## Kết luận

SSOT không chỉ là clean code.

Nó là nền tảng của:

* consistency
* maintainability
* scalability

> Nếu 1 giá trị xuất hiện ở 2 nơi → system của bạn đang có bug tiềm ẩn.
