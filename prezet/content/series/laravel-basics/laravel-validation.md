---
title: Validation Deep Dive trong Laravel – Từ Form Request đến Custom Rule & Security
excerpt: Tìm hiểu validation trong Laravel từ cơ bản đến nâng cao, Form Request, custom rule và các vấn đề bảo mật trong production.
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/series-laravel-basics-laravel-validation.webp
tags: [laravel, validation, security, form request]
order: 11
---

Validation là một trong những phần quan trọng nhất trong hệ thống.

Nếu làm sai:

* Dữ liệu bẩn
* Bug khó debug
* Lỗ hổng bảo mật

> Nhưng nhiều developer chỉ dừng ở mức cơ bản.

## Validation là gì?

> Là quá trình kiểm tra dữ liệu đầu vào trước khi xử lý.

Ví dụ:

```php
$request->validate([
    'email' => 'required|email',
]);
```

## Các cách validate trong Laravel

### Validate trực tiếp

```php
$request->validate([...]);
```

Nhanh nhưng khó reuse

### Form Request (best practice)

```bash
php artisan make:request StoreUserRequest
```

```php
public function rules()
{
    return [
        'email' => 'required|email'
    ];
}
```

Clean + reusable

## Custom Validation Rule

### Rule Object

```bash
php artisan make:rule ValidPhone
```

```php
public function passes($attribute, $value)
{
    return preg_match('/^0[0-9]{9}$/', $value);
}
```

### Closure

```php
'email' => function ($attr, $value, $fail) {
    if (!str_contains($value, '@company.com')) {
        $fail('Invalid email');
    }
}
```

## Conditional Validation

```php
'required_if:type,admin'
```

Validate theo điều kiện

## Validate Array & Nested Data

```php
'users.*.email' => 'required|email'
```

Rất quan trọng trong API

## Security trong Validation

### Không tin input

Luôn validate mọi input

### XSS

* Escape output
* Không tin HTML input

### Mass Assignment

```php
protected $fillable = ['name', 'email'];
```

Tránh ghi dữ liệu ngoài ý muốn

## Real Case Production

### Case: API

* Validate request body
* Return JSON error

### Case: Form

* Validate UI + backend

## Anti-pattern

* **Validate trong controller**: Code rối

* **Không validate**: Security risk

* **Validate nhưng không sanitize**: Data vẫn nguy hiểm

## Performance Tips

* Validate sớm
* Tránh validate dư thừa

## Mindset

Junior:

> “Validate để tránh lỗi”

Senior:

> “Validate để bảo vệ hệ thống”

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. Validation trong Laravel là gì?</summary>

Kiểm tra dữ liệu đầu vào trước khi xử lý

</details>

<details open>
<summary>2. Form Request dùng để làm gì?</summary>

Tách validation logic ra khỏi controller

</details>

<details open>
<summary>3. Khi nào dùng custom rule?</summary>

Khi rule phức tạp hoặc cần tái sử dụng

</details>

<details open>
<summary>4. Validation có liên quan gì đến security?</summary>

Giúp tránh XSS, injection và dữ liệu không hợp lệ

</details>

<details open>
<summary>5. Mass assignment là gì?</summary>

Là việc gán dữ liệu hàng loạt vào model, cần kiểm soát bằng fillable

</details>

## Kết luận

Validation không chỉ là kiểm tra dữ liệu.

> Nó là lớp bảo vệ đầu tiên của hệ thống.

Làm đúng giúp:

* Tránh bug
* Tăng security
* Dữ liệu sạch
