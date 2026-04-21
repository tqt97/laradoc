---
title: Input Validation – Nền tảng bảo mật backend
excerpt: Hướng dẫn validate và sanitize input trong PHP để tránh SQL Injection, XSS, và đảm bảo data integrity. Kèm ví dụ thực tế và interview questions.
category: PHP Best Practices
date: 2025-09-28
order: 12
image: /prezet/img/ogimages/series-php-best-practices-sec-input-validation.webp
---

## Nguyên tắc cốt lõi

👉 **Never trust user input** (Không bao giờ tin dữ liệu từ bên ngoài)

Nguồn input nguy hiểm:

* $_GET, $_POST
* API request
* File upload
* Header
* Cookie

## Bad Example (Anti-pattern)

```php
$name = $_POST['name'];
$email = $_POST['email'];
$age = $_POST['age'];

$user = new User($name, $email, $age);
```

**Vấn đề**

* Không validate
* Có thể inject data xấu
* Phá vỡ data integrity

## Good Example (Best Practice)

### 1. Validate email

```php
$email = filter_var($input['email'] ?? '', FILTER_VALIDATE_EMAIL);
if ($email === false) {
    throw new ValidationException(['email' => 'Invalid email']);
}
```

### 2. Validate string

```php
$name = trim($input['name'] ?? '');
if ($name === '' || mb_strlen($name) > 100) {
    throw new ValidationException(['name' => 'Invalid name']);
}
```

### 3. Validate integer

```php
$age = filter_var($input['age'] ?? null, FILTER_VALIDATE_INT, [
    'options' => ['min_range' => 1, 'max_range' => 150]
]);
```

### 4. Whitelist dynamic input

```php
$allowed = ['id', 'name', 'price'];
$sort = in_array($input['sort'] ?? '', $allowed, true) ? $input['sort'] : 'id';
```

### 5. Pagination safe

```php
$page = max(1, (int) ($input['page'] ?? 1));
```

## Giải thích sâu

### 1. Validation vs Sanitization

* Validation: kiểm tra đúng/sai
* Sanitization: làm sạch dữ liệu

👉 Luôn validate trước

### 2. Whitelist > Blacklist

**Blacklist**

```php
if ($input !== 'DROP TABLE')
```

**Whitelist**

```php
in_array($input, ['id', 'name'])
```

### 3. Boundary validation

👉 Validate ở mọi boundary:

* Controller
* Service
* Domain

### 4. Type safety

```php
(int) 'abc' // 0 → bug
```

👉 filter_var an toàn hơn

### 5. Defense in depth

👉 Không chỉ validate frontend
👉 Backend luôn phải validate lại

## Tips & Tricks (Senior level)

### 1. Centralize validation

👉 Tạo Request DTO / Validator class

### 2. Laravel FormRequest

```php
$request->validate([
    'email' => 'required|email',
]);
```

### 3. Escape output (XSS)

```php
htmlspecialchars($input, ENT_QUOTES);
```

### 4. SQL Injection

👉 Luôn dùng prepared statement

### 5. Validate nested data

👉 JSON, array cần validate sâu

## Interview Questions

<details>
  <summary>1. Tại sao phải validate input?</summary>

**Summary:**

* Để bảo mật

**Deep:**
Ngăn SQL injection, XSS, đảm bảo data integrity

</details>

<details>
  <summary>2. Validation vs Sanitization?</summary>

**Summary:**

* Validation: kiểm tra
* Sanitization: làm sạch

**Deep:**
Phải validate trước khi sanitize

</details>

<details>
  <summary>3. Whitelist vs Blacklist?</summary>

**Summary:**

* Whitelist an toàn hơn

**Deep:**
Blacklist không thể cover hết case xấu

</details>

<details>
  <summary>4. filter_var dùng khi nào?</summary>

**Summary:**

* Validate type

**Deep:**
Email, int, url

</details>

<details>
  <summary>5. Có cần validate frontend không?</summary>

**Summary:**

* Có nhưng chưa đủ

**Deep:**
Backend vẫn phải validate lại

</details>

## Kết luận

👉 Input validation là nền tảng bảo mật

Nếu bỏ qua → hệ thống sẽ bị khai thác

👉 Luôn:

* Validate
* Whitelist
* Type check
* Escape output
