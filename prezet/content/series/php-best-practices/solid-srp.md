---
title: Single Responsibility Principle – Tránh God Class trong PHP
excerpt: "Hiểu rõ nguyên lý SRP trong SOLID: mỗi class chỉ có một trách nhiệm, giúp code dễ test, dễ maintain và dễ mở rộng."
category: PHP Best Practices
date: 2025-09-30
order: 20
image: /prezet/img/ogimages/series-php-best-practices-solid-srp.webp
---

## Nguyên tắc cốt lõi

👉 **Một class chỉ nên có 1 lý do để thay đổi**

👉 Rule:

* 1 class = 1 responsibility

## Bad Example (God Class)

```php
class User {
    public function save() {}
    public function sendEmail() {}
    public function validate() {}
}
```

### Vấn đề

* 1 class làm quá nhiều việc
* Khó test
* Khó maintain
* Dễ bug dây chuyền

## Good Example (Separation)

👉 Tách responsibility:

* User → domain
* Repository → DB
* Validator → validate
* Notifier → email
* Service → orchestration

## Giải thích sâu (Senior mindset)

### 1. “Reason to change” là gì?

👉 Là nguyên nhân làm class thay đổi

Ví dụ:

* Thay đổi DB → Repository thay đổi
* Thay đổi email template → Notifier thay đổi

👉 Nếu 1 class bị ảnh hưởng bởi nhiều lý do → vi phạm SRP

### 2. SRP không phải “1 method”

❌ Sai:

* 1 class chỉ có 1 method

✅ Đúng:

* 1 class có thể có nhiều method
* Nhưng cùng 1 responsibility

### 3. God Class là gì?

👉 Class làm tất cả mọi thứ

Dấu hiệu:

* 1000+ lines
* 10+ dependencies

### 4. SRP trong Laravel

❌ Controller:

* validate
* query DB
* gửi mail

✅ Tách:

* FormRequest
* Service
* Job/Event

### 5. SRP + Clean Architecture

👉 Domain layer phải clean

## Tips & Tricks (Senior level)

### 1. Nếu class có nhiều “and” → tách

UserServiceAndMailer ❌

### 2. Giới hạn dependency

> 4-5 dependencies = smell

### 3. Tách theo change axis

### 4. Controller phải thin

### 5. Không over-split

👉 Tránh tạo quá nhiều class nhỏ vô nghĩa

## Interview Questions

<details>
  <summary>1. SRP là gì?</summary>

**Summary:**

* 1 class = 1 responsibility

**Deep:**
Chỉ có 1 lý do để thay đổi

</details>

<details>
  <summary>2. Làm sao biết class vi phạm SRP?</summary>

**Summary:**

* Làm nhiều việc

**Deep:**
Có nhiều reason to change

</details>

<details>
  <summary>3. SRP có phải 1 method/class không?</summary>

**Summary:**

* Không

**Deep:**
Nhiều method nhưng cùng responsibility

</details>

<details>
  <summary>4. SRP giúp gì cho testing?</summary>

**Summary:**

* Dễ test

**Deep:**
Mock dễ, isolate logic

</details>

<details>
  <summary>5. SRP liên quan Clean Architecture không?</summary>

**Summary:**

* Có

**Deep:**
Giúp tách layer rõ ràng

</details>

## Kết luận

👉 SRP là nền tảng của:

* Clean code
* Clean architecture
* Maintainability

👉 Nếu vi phạm SRP:

* Code sẽ trở thành “God object”
