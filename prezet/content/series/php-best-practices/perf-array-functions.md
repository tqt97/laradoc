---
title: Native Array Functions – Viết code nhanh hơn, sạch hơn, chuẩn functional
excerpt: Tìm hiểu cách sử dụng các hàm array built-in trong PHP thay cho loop thủ công. Tăng performance, readability và maintainability.
category: PHP Best Practices
date: 2025-09-25
order: 7
image: /prezet/img/ogimages/series-php-best-practices-perf-array-functions.webp
---

## Nguyên tắc cốt lõi

👉 **Ưu tiên dùng hàm built-in thay vì foreach**

👉 Vì chúng:

* Viết bằng C → nhanh hơn
* Code ngắn gọn hơn
* Dễ đọc hơn

## Bad Example (Anti-pattern)

```php
$activeUsers = [];
foreach ($users as $user) {
    if ($user->isActive()) {
        $activeUsers[] = $user;
    }
}
```

**Vấn đề**

* Verbose
* Lặp logic
* Khó combine với các operation khác

## Good Example (Best Practice)

### 1. Filter

```php
$activeUsers = array_filter($users, fn(User $u) => $u->isActive());
```

### 2. Map

```php
$emails = array_map(fn(User $u) => $u->getEmail(), $users);
```

### 3. Check existence

```php
$hasAdmin = (bool) array_filter($users, fn(User $u) => $u->isAdmin());
```

### 4. Combine operations

```php
$activeEmails = array_map(
    fn(User $u) => $u->getEmail(),
    array_filter($users, fn(User $u) => $u->isActive())
);
```

### 5. Reduce

```php
$total = array_reduce(
    $orders,
    fn($sum, Order $o) => $sum + $o->getTotal(),
    0
);
```

### 6. array_column

```php
$userNames = array_column($userData, 'name', 'id');
```

### 7. Spread operator

```php
$merged = [...$defaults, ...$overrides];
```

### 8. Sorting

```php
usort($products, fn($a, $b) => $a->price <=> $b->price);
```

## Giải thích sâu

### 1. Performance

* Built-in viết bằng C → nhanh hơn loop PHP
* Giảm overhead interpreter

👉 Nhưng không phải lúc nào cũng critical

### 2. Functional style

```php
array_map → transform
array_filter → select
array_reduce → aggregate
```

👉 Giống pattern trong functional programming

### 3. Immutability

Hầu hết hàm trả về array mới

👉 Không mutate data → ít bug hơn

#### 4. Trade-off readability

```php
array_map(fn(...) => ..., array_filter(fn(...) => ..., array_reduce(...)))
```

👉 Quá lồng nhau → khó đọc

#### 5. Big O vẫn giữ nguyên

👉 Không thay đổi complexity

* O(n) vẫn là O(n)
* Nhưng constant factor nhỏ hơn

## Tips & Tricks

### 1. Rule đơn giản

👉 Simple loop → dùng array function
👉 Complex logic → dùng foreach

### 2. Prefer readability

Tách step nếu chain dài

### 3. Laravel Collection

```php
collect($users)
    ->filter(fn($u) => $u->active)
    ->map(fn($u) => $u->email);
```

👉 Readable hơn array thuần

### 4. Avoid in_array trong loop

👉 Dùng set (array_flip) để O(1)

### 5. Memory consideration

* array_map tạo array mới
* Với data lớn → cần cân nhắc

## Interview Questions

<details>
  <summary>1. Tại sao array function nhanh hơn foreach?</summary>

**Summary:**

* Vì viết bằng C

**Deep:**
Giảm overhead PHP interpreter → nhanh hơn

</details>

<details>
  <summary>2. array_map vs foreach?</summary>

**Summary:**

* array_map clean hơn

**Deep:**

* array_map: functional, immutable
* foreach: flexible hơn

</details>

<details>
  <summary>3. Khi nào không nên dùng array function?</summary>

**Summary:**

* Logic phức tạp

**Deep:**
Nhiều điều kiện, side-effect → dùng foreach

</details>

<details>
  <summary>4. array_reduce dùng khi nào?</summary>

**Summary:**

* Aggregate

**Deep:**
Sum, count, combine data

</details>

<details>
  <summary>5. Có nên chain nhiều array function?</summary>

**Summary:**

* Không quá nhiều

**Deep:**
Chain dài → khó đọc, khó debug

</details>

## Kết luận

👉 Native array functions giúp:

* Code sạch hơn
* Dễ đọc hơn
* Performance tốt hơn

> Nhưng lạm dụng → code sẽ khó maintain
