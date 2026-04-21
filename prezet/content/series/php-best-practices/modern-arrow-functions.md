---
title: Arrow Functions – Viết closure ngắn gọn, sạch và hiện đại
excerpt: "Tìm hiểu Arrow Functions trong PHP 7.4+: cú pháp ngắn gọn, auto capture biến, phù hợp functional style. Kèm ví dụ, best practices, pitfalls và câu hỏi phỏng vấn."
category: PHP Best Practices
date: 2025-09-24
order: 6
image: /prezet/img/ogimages/series-php-best-practices-modern-arrow-functions.webp
---

## Arrow Function là gì?

Arrow function (`fn(...) => expr`) là cú pháp rút gọn của anonymous function cho **single-expression closure**.

👉 Đặc điểm chính:

* Không cần `{}` và `return`
* **Auto-capture** biến từ scope ngoài (không cần `use`)
* Capture **by-value** (immutable theo giá trị)

## Bad Example (Anti-pattern)

```php
$numbers = [1, 2, 3, 4, 5];

$doubled = array_map(function ($n) {
    return $n * 2;
}, $numbers);

$multiplier = 3;
$multiplied = array_map(function ($n) use ($multiplier) {
    return $n * $multiplier;
}, $numbers);
```

**Vấn đề**

* Verbose cho logic đơn giản
* Phải dùng `use` để capture biến
* Nested closures khó đọc

## Good Example (Best Practice)

### 1. Cú pháp ngắn gọn

```php
$doubled = array_map(fn($n) => $n * 2, $numbers);
$evens   = array_filter($numbers, fn($n) => $n % 2 === 0);
```

### 2. Auto capture

```php
$multiplier = 3;
$multiplied = array_map(fn($n) => $n * $multiplier, $numbers);
```

👉 Không cần `use`

### 3. Chain readable

```php
$activeEmails = array_map(
    fn($u) => $u->getEmail(),
    array_filter($users, fn($u) => $u->isActive())
);
```

### 4. Type hints đầy đủ

```php
$withTax = array_map(
    fn(float $price): float => $price * 1.1,
    $prices
);
```

### 5. Higher-order functions

```php
function createMultiplier(int $factor): Closure
{
    return fn(int $n): int => $n * $factor;
}
```

### 6. Sorting

```php
usort($products, fn($a, $b) => $a->getPrice() <=> $b->getPrice());
```

## Giải thích sâu

### 1. Auto-capture by-value

Arrow function **luôn capture theo value**, không phải reference.

```php
$x = 10;
$fn = fn() => $x;
$x = 20;

echo $fn(); // 10 (không phải 20)
```

👉 Tránh side-effect

### 2. Không thay thế hoàn toàn closure

**Không dùng khi:**

* Có nhiều dòng logic
* Cần `return` nhiều nhánh
* Cần capture by-reference

```php
function () use (&$x) { $x++; }
```

👉 Arrow function KHÔNG hỗ trợ reference capture

### 3. Functional style trong PHP

Arrow function giúp viết kiểu:

* map
* filter
* reduce

👉 Clean hơn imperative loop

### 4. Readability vs Overuse

**Lạm dụng:**

```php
fn($a) => fn($b) => fn($c) => ...
```

👉 Khó đọc → nên refactor

### 5. Performance

* Arrow function nhẹ hơn một chút (ít boilerplate)
* Nhưng khác biệt không đáng kể

👉 Ưu tiên readability hơn micro-optimization

## Tips & Tricks (Senior level)

### 1. Rule nhanh

👉 1 dòng → arrow function
👉 >1 dòng → closure thường

### 2. Laravel usage

* Collection:

```php
$users->filter(fn($u) => $u->active);
```

* Query:

```php
User::query()->where(fn($q) => $q->where(...));
```

### 3. Combine với pipe/chain

Giúp code gần functional hơn

### 4. Naming logic phức tạp

Nếu logic dài → tách function riêng

## Interview Questions

<details>
  <summary>1. Arrow function là gì?</summary>

**Summary:**

* Closure rút gọn

**Deep:**
Cú pháp `fn() => expr`, auto capture biến

</details>

<details>
  <summary>2. Arrow function khác gì closure thường?</summary>

**Summary:**

* Ngắn gọn, auto capture

**Deep:**

* Không cần `use`
* Capture by-value
* Chỉ 1 expression

</details>

<details>
  <summary>3. Arrow function có capture by-reference không?</summary>

**Summary:**

* Không

**Deep:**
Luôn by-value → không modify biến ngoài

</details>

<details>
  <summary>4. Khi nào không nên dùng arrow function?</summary>

**Summary:**

* Logic phức tạp

**Deep:**
Nhiều dòng, nhiều nhánh → dùng closure thường

</details>

<details>
  <summary>5. Arrow function có ảnh hưởng performance không?</summary>

**Summary:**

* Không đáng kể

**Deep:**
Ưu tiên readability hơn performance

</details>

## Kết luận

👉 Arrow function giúp:

* Code ngắn gọn
* Dễ đọc
* Phù hợp functional style

Nhưng nếu lạm dụng → sẽ làm code khó hiểu
