---
title: Password Hashing – Cách lưu mật khẩu an toàn với Argon2id
excerpt: Hướng dẫn hash password an toàn trong PHP với password_hash, Argon2id, bcrypt, chống brute force và timing attack.
category: PHP Best Practices
date: 2025-09-28
order: 14
image: /prezet/img/ogimages/series-php-best-practices-sec-password-hashing.webp
---

## Nguyên tắc cốt lõi

👉 **Không bao giờ lưu password dạng plain text hoặc hash yếu**

👉 Rule:

* Hash password → lưu DB
* Verify password → login

## Bad Example (Anti-pattern)

```php
$hash = md5($password);
$hash = sha1($password);
$hash = hash('sha256', $password);
```

**Vấn đề**

* Quá nhanh → dễ brute force
* Không có salt đúng chuẩn
* Bị rainbow table attack

## Good Example (Best Practice)

### 1. Hash password

```php
$hash = password_hash($password, PASSWORD_ARGON2ID);
```

### 2. Verify password

```php
if (password_verify($input, $hash)) {
    // login success
}
```

### 3. Rehash khi cần

```php
if (password_needs_rehash($hash, PASSWORD_ARGON2ID)) {
    $hash = password_hash($input, PASSWORD_ARGON2ID);
}
```

### 4. Regenerate session

```php
session_regenerate_id(true);
```

### 5. Custom Argon2

```php
password_hash($password, PASSWORD_ARGON2ID, [
    'memory_cost' => 65536,
    'time_cost' => 4,
    'threads' => 3,
]);
```

## Giải thích sâu (Senior mindset)

### 1. Hashing vs Encryption

* Hash: 1 chiều
* Encrypt: có thể decrypt

👉 Password chỉ nên hash

### 2. Argon2id

👉 Memory-hard → chống GPU brute force

### 3. Salt

👉 password_hash tự generate salt

### 4. Timing attack

👉 So sánh string thường bị leak timing

👉 password_verify an toàn

### 5. bcrypt limitation

👉 72 bytes max → cần validate

## Tips & Tricks (Senior level)

### 1. Always use PASSWORD_DEFAULT hoặc ARGON2ID

### 2. Không tự viết hash

### 3. Thêm rate limit login

### 4. Không log password

### 5. Password reset phải dùng token

## Interview Questions

<details>
  <summary>1. Tại sao không dùng MD5?</summary>

**Summary:**

* Quá yếu

**Deep:**
Dễ brute force và rainbow table

</details>

<details>
  <summary>2. password_hash làm gì?</summary>

**Summary:**

* Hash password

**Deep:**
Tự salt + chọn algorithm

</details>

<details>
  <summary>3. Argon2id vs bcrypt?</summary>

**Summary:**

* Argon2id tốt hơn

**Deep:**
Memory-hard chống GPU

</details>

<details>
  <summary>4. password_verify an toàn ở đâu?</summary>

**Summary:**

* Timing-safe

**Deep:**
Không leak thời gian so sánh

</details>

<details>
  <summary>5. password_needs_rehash dùng khi nào?</summary>

**Summary:**

* Khi nâng cấp hash

**Deep:**
Update algorithm/cost

</details>

## Kết luận

👉 Password hashing là tuyến phòng thủ quan trọng nhất

Nếu sai → toàn bộ user bị compromise

👉 Luôn:

* password_hash
* password_verify
* Argon2id
* Rehash khi cần
