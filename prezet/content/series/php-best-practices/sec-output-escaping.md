---
title: Output Escaping – Chống XSS trong PHP đúng cách
excerpt: Hướng dẫn escape output theo từng context trong PHP để tránh XSS. Bao gồm HTML, attribute, JavaScript và URL với best practices và ví dụ thực tế.
category: PHP Best Practices
date: 2025-09-28
order: 13
image: /prezet/img/ogimages/series-php-best-practices-sec-output-escaping.webp
---

## Nguyên tắc cốt lõi

👉 **Escape khi output, không phải khi input**

👉 Rule quan trọng nhất:

* Input → Validate
* Output → Escape

## Bad Example (Anti-pattern)

```php
echo "<h1>{$user->name}</h1>";
```

**Vấn đề**

Nếu user nhập:

```html
<script>alert('hacked')</script>
```

👉 Browser sẽ execute script → XSS

## Good Example (Best Practice)

### 1. HTML context

```php
$name = htmlspecialchars($user->name, ENT_QUOTES, 'UTF-8');
echo "<h1>{$name}</h1>";
```

### 2. Attribute context

```php
$value = htmlspecialchars($search, ENT_QUOTES, 'UTF-8');
echo "<input value=\"{$value}\">";
```

### 3. JavaScript context

```php
$json = json_encode($user->name, JSON_HEX_TAG | JSON_HEX_AMP);
echo "<script>var name = {$json};</script>";
```

👉 Không dùng string nối trực tiếp

### 4. URL context

```php
$q = urlencode($query);
echo "<a href=\"/search?q={$q}\">";
```

### 5. Helper function

```php
function e(string $v): string
{
    return htmlspecialchars($v, ENT_QUOTES | ENT_SUBSTITUTE, 'UTF-8');
}
```

### 6. Template engine

```php
{{ $user->name }} // safe
{!! $html !!}     // dangerous
```

## Giải thích sâu (Senior mindset)

### 1. XSS (Cross-Site Scripting)

Attacker inject JS:

```html
<script>stealCookie()</script>
```

👉 Chạy trên browser user

### 2. Context matters

| Context   | Function         |
| --------- | ---------------- |
| HTML      | htmlspecialchars |
| Attribute | htmlspecialchars |
| JS        | json_encode      |
| URL       | urlencode        |

👉 Sai context = vẫn bị hack

### 3. Escape ≠ Validate

Sai:

```php
$input = htmlspecialchars($_POST['name']);
```

👉 Làm vậy sẽ corrupt data

### 4. Double escaping

```php
htmlspecialchars(htmlspecialchars($v));
```

👉 Hiển thị sai

### 5. UTF-8 attacks

👉 Luôn chỉ định encoding

## Tips & Tricks (Senior level)

### 1. Always escape at output layer

👉 View / Template

### 2. Default escape

👉 Blade, Twig auto escape

### 3. Trusted HTML only

👉 Dùng raw chỉ khi sanitize trước

### 4. CSP (Content Security Policy)

👉 Layer bảo vệ thêm

### 5. Audit legacy code

👉 Tìm echo raw

## Interview Questions

<details>
  <summary>1. XSS là gì?</summary>

**Summary:**

* Inject script

**Deep:**
Chạy JS trên browser user

</details>

<details>
  <summary>2. Escape khi nào?</summary>

**Summary:**

* Khi output

**Deep:**
Không phải lúc input

</details>

<details>
  <summary>3. htmlspecialchars dùng để làm gì?</summary>

**Summary:**

* Escape HTML

**Deep:**
Convert special chars thành entity

</details>

<details>
  <summary>4. Tại sao cần ENT_QUOTES?</summary>

**Summary:**

* Escape cả ' và "

**Deep:**
Tránh break attribute

</details>

<details>
  <summary>5. json_encode dùng trong JS context tại sao?</summary>

**Summary:**

* Safe encode

**Deep:**
Tránh injection vào script

</details>

## Kết luận

👉 Output escaping là layer cuối cùng chống XSS

Nếu thiếu → toàn bộ system có thể bị compromise
