---
title: Open/Closed Principle – Mở rộng hệ thống mà không sửa code cũ
excerpt: "Hiểu rõ OCP trong SOLID: thiết kế hệ thống cho phép mở rộng bằng cách thêm code mới thay vì sửa code cũ, giảm bug và tăng maintainability."
category: PHP Best Practices
date: 2025-09-30
order: 19
image: /prezet/img/ogimages/series-php-best-practices-solid-ocp.webp
---

## Nguyên tắc cốt lõi

👉 **Open for extension – Closed for modification**

👉 Rule:

* Không sửa code cũ
* Thêm behavior bằng class mới

## Bad Example (if/else hell)

```php
if ($type === 'credit_card') {}
if ($type === 'paypal') {}
```

### Vấn đề

* Mỗi lần thêm feature → sửa code cũ
* Dễ gây regression bug
* Vi phạm OCP

## Good Example (Strategy Pattern)

```php
interface PaymentMethod {
    public function process(Money $amount): PaymentResult;
}
```

👉 Mỗi payment = 1 class

## Giải thích sâu (Senior mindset)

### 1. OCP thực sự giải quyết vấn đề gì?

👉 Tránh sửa code đã chạy ổn định

### 2. Extension point là gì?

👉 Nơi cho phép thêm behavior

### 3. OCP + DIP

👉 Interface là nền tảng để mở rộng

### 4. Strategy Pattern = OCP điển hình

### 5. Plugin architecture

👉 Register dynamic behavior

## Tips & Tricks

### 1. Tránh switch/if theo type

### 2. Dùng polymorphism

### 3. Identify change axis

👉 Thứ nào hay thay đổi → tách ra

### 4. Combine với DI container

### 5. Không over-engineer

👉 Chỉ áp dụng khi có nhiều variation

## Interview Questions

<details>
  <summary>1. OCP là gì?</summary>

**Summary:**

* Mở rộng không sửa code

**Deep:**
Thêm class mới thay vì modify class cũ

</details>

<details>
  <summary>2. Tại sao if/else vi phạm OCP?</summary>

**Summary:**

* Phải sửa code

**Deep:**
Mỗi feature mới → modify

</details>

<details>
  <summary>3. Pattern nào thường dùng cho OCP?</summary>

**Summary:**

* Strategy

</details>

<details>
  <summary>4. Khi nào không cần OCP?</summary>

**Summary:**

* Code đơn giản

</details>

<details>
  <summary>5. OCP liên quan DIP không?</summary>

**Summary:**

* Có

**Deep:**
Phải có abstraction mới mở rộng được

</details>

## Kết luận

👉 OCP giúp:

* Giảm bug production
* Dễ mở rộng
* Dễ maintain

👉 Nhưng:

* Tránh over-design
