---
title: Prepared Statements – Cách chống SQL Injection trong PHP
excerpt: Hướng dẫn sử dụng prepared statements với PDO để chống SQL Injection, đảm bảo an toàn dữ liệu và tối ưu hiệu năng.
category: PHP Best Practices
date: 2025-09-28
order: 15
image: /prezet/img/ogimages/series-php-best-practices-sec-sql-prepared.webp
---

## Nguyên tắc cốt lõi

👉 **Không bao giờ nối chuỗi SQL với input từ user**

👉 Rule:

* SQL + input → luôn dùng prepared statement

## Bad Example (Anti-pattern)

```php
$email = $_POST['email'];
$db->query("SELECT * FROM users WHERE email = '$email'");
```

**Vấn đề**

Input:

```sql
' OR '1'='1
```

👉 Query trở thành:

```sql
SELECT * FROM users WHERE email = '' OR '1'='1'
```

👉 Leak toàn bộ data

## Good Example (Best Practice)

### 1. Named parameters

```php
$stmt = $pdo->prepare('SELECT * FROM users WHERE email = :email');
$stmt->execute(['email' => $email]);
```

### 2. Positional parameters

```php
$stmt = $pdo->prepare('SELECT * FROM users WHERE id = ?');
$stmt->execute([$id]);
```

### 3. Bind type

```php
$stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
```

### 4. Insert safe

```php
$stmt = $pdo->prepare(
    'INSERT INTO users (name, email) VALUES (:name, :email)'
);
```

### 5. PDO config

```php
PDO::ATTR_EMULATE_PREPARES => false
```

👉 Bắt buộc dùng real prepared

### 6. Dynamic column (whitelist)

```php
$allowed = ['id', 'name'];
$col = in_array($sort, $allowed, true) ? $sort : 'id';
```

## Giải thích sâu (Senior mindset)

### 1. SQL Injection là gì?

👉 Inject SQL vào query

```sql
'; DROP TABLE users; --
```

### 2. Prepared statement hoạt động thế nào?

👉 Query và data tách riêng:

* SQL: template
* Data: bind sau

👉 DB không parse data như SQL

### 3. Tại sao escape string không đủ?

👉 Escape thủ công dễ sai

👉 Prepared statement = chuẩn nhất

### 4. Emulated vs real prepared

* Emulated: PHP xử lý
* Real: DB xử lý

👉 Real an toàn hơn

### 5. Không bind được column/table

```php
ORDER BY :column ❌
```

👉 Phải whitelist

## Tips & Tricks (Senior level)

### 1. Luôn dùng PDO hoặc ORM

### 2. Disable emulate prepares

### 3. Log query lỗi

### 4. Combine với validation

### 5. ORM không phải lúc nào cũng an toàn

👉 Raw query vẫn cần prepared

## Interview Questions

<details>
  <summary>1. SQL Injection là gì?</summary>

**Summary:**

* Inject SQL

**Deep:**
User control query → leak data

</details>

<details>
  <summary>2. Prepared statement giúp gì?</summary>

**Summary:**

* Tách data khỏi SQL

**Deep:**
DB không parse data thành SQL

</details>

<details>
  <summary>3. Có thể bind column name không?</summary>

**Summary:**

* Không

**Deep:**
Phải whitelist

</details>

<details>
  <summary>4. PDO::ATTR_EMULATE_PREPARES là gì?</summary>

**Summary:**

* Fake prepared

**Deep:**
Nên tắt để dùng real prepared

</details>

<details>
  <summary>5. ORM có chống SQL injection không?</summary>

**Summary:**

* Có nhưng không hoàn toàn

**Deep:**
Raw query vẫn nguy hiểm

</details>

## Kết luận

👉 Prepared statement là cách duy nhất để chống SQL Injection đúng chuẩn

👉 Nếu không dùng → hệ thống có thể bị hack ngay lập tức

👉 Luôn:

* Prepare
* Bind
* Whitelist
