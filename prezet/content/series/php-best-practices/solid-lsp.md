---
title: Interface Segregation Principle – Tránh fat interface trong PHP
excerpt: "Hiểu rõ nguyên lý ISP trong SOLID: chia nhỏ interface, tránh ép class implement những thứ không cần thiết, giúp code dễ maintain và test."
category: PHP Best Practices
date: 2025-09-30
order: 18
image: /prezet/img/ogimages/series-php-best-practices-solid-lsp.webp
---

## Nguyên tắc cốt lõi

👉 **Client không nên bị ép phụ thuộc vào những method mà nó không dùng**

👉 Rule:

* Interface phải nhỏ, focused

## Bad Example (Fat Interface)

```php
interface WorkerInterface
{
    public function work(): void;
    public function eat(): void;
    public function sleep(): void;
}
```

**Vấn đề**

* Class bị ép implement method không cần
* Throw exception → smell design
* Vi phạm ISP

## Good Example (Segregation)

```php
interface Workable { public function work(): void; }
interface Eatable { public function eat(): void; }
```

👉 Class chỉ implement cái nó cần

## Giải thích sâu (Senior mindset)

### 1. Fat interface là gì?

👉 Interface chứa quá nhiều method

### 2. ISP vs SRP

* SRP: class
* ISP: interface

### 3. Interface composition

👉 Combine nhiều interface nhỏ

### 4. Real-world Laravel

```php
ReadableRepository
WritableRepository
```

### 5. Intersection type (PHP 8.1)

```php
ReadableRepository&PaginatableRepository
```

## Tips & Tricks (Senior level)

### 1. Prefer small interfaces

### 2. Avoid “God interface”

### 3. Design by use-case

### 4. Combine với DIP

### 5. Refactor dần

## Interview Questions

<details>
  <summary>1. ISP là gì?</summary>

**Summary:**

* Interface nhỏ, focused

**Deep:**
Không ép class implement method không dùng

</details>

<details>
  <summary>2. Fat interface gây vấn đề gì?</summary>

**Summary:**

* Code smell

**Deep:**
Khó maintain, nhiều method dư

</details>

<details>
  <summary>3. ISP khác SRP như thế nào?</summary>

**Summary:**

* SRP: class
* ISP: interface

</details>

<details>
  <summary>4. Khi nào nên tách interface?</summary>

**Summary:**

* Khi class không dùng hết method

</details>

<details>
  <summary>5. ISP liên quan DIP không?</summary>

**Summary:**

* Có

**Deep:**
Interface nhỏ giúp dependency rõ ràng

</details>

## Kết luận

👉 ISP giúp:

* Code sạch
* Dễ test
* Dễ mở rộng

👉 Tránh:

* Fat interface
