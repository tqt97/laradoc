---
title: Authentication & Authorization trong Laravel – Bảo mật hệ thống đúng cách
excerpt: Phân biệt Authentication và Authorization trong Laravel, sử dụng Guards, Policies, Gates, Sanctum/Passport và áp dụng RBAC trong production.
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/series-laravel-basics-laravel-auth.webp
tags: [laravel, authentication, authorization, security, sanctum, policy]
---

Trong mọi hệ thống thực tế, bạn luôn cần:

* Xác thực người dùng (login)
* Phân quyền (ai làm được gì)

Nếu làm sai:

* Lộ dữ liệu
* Bypass quyền
* Rủi ro bảo mật nghiêm trọng

## Authentication vs Authorization

### Authentication (Auth)

> Xác định bạn là ai

* Login / Logout
* Token / Session

### Authorization (AuthZ)

> Xác định bạn được làm gì

* Role
* Permission

Nhớ nhanh:

* Auth = Who are you?
* AuthZ = What can you do?

## Authentication trong Laravel

Laravel cung cấp nhiều cách:

* Session-based (web)
* Token-based (API)

### Guards

```php
config/auth.php
```

Ví dụ:

```php
auth('web')->user();
auth('api')->user();
```

Guard xác định cách authenticate

## Sanctum vs Passport

### Sanctum

* Nhẹ
* Dễ dùng
* Phù hợp SPA / mobile

### Passport

* OAuth2
* Phức tạp hơn
* Phù hợp hệ thống lớn

Rule:

* 90% case dùng Sanctum

## Authorization trong Laravel

### Gate (simple)

```php
Gate::define('is-admin', function ($user) {
    return $user->is_admin;
});
```

### Policy (best practice)

```bash
php artisan make:policy PostPolicy
```

```php
public function update(User $user, Post $post)
{
    return $user->id === $post->user_id;
}
```

### Sử dụng

```php
$this->authorize('update', $post);
```

## RBAC (Role-Based Access Control)

### Ví dụ

* Admin → full quyền
* Editor → edit content
* User → chỉ xem

### Cách triển khai

* roles table
* permissions table
* pivot tables

Hoặc dùng package (vd: spatie/laravel-permission)

## Real Case Production

**Admin Panel**

* Chỉ admin vào được

```php
Route::middleware(['auth', 'role:admin'])
```

**Edit Post**

```php
$this->authorize('update', $post);
```

**API**

* Dùng Sanctum
* Token-based auth

## Anti-pattern

**Check quyền trong controller**

```php
if ($user->role === 'admin')
```

Hardcode, khó maintain

**Không dùng policy**: Logic phân tán

### Token không expire

Security risk

## Security Best Practices

* Hash password (bcrypt/argon2)
* Rate limit login
* CSRF protection
* Validate input

## Performance Tips

* Cache permission
* Tránh query quyền nhiều lần

## Mindset

Junior:

> Check login là đủ

Senior:

> Phải thiết kế hệ thống auth & permission rõ ràng, scalable

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. Authentication và Authorization khác nhau như thế nào?</summary>

Auth xác định user là ai, AuthZ xác định user làm được gì

</details>

<details open>
<summary>2. Guard trong Laravel là gì?</summary>

Là cách Laravel xác định phương thức authenticate (session, token)

</details>

<details open>
<summary>3. Sanctum vs Passport khác nhau thế nào?</summary>

Sanctum đơn giản, Passport hỗ trợ OAuth2 phức tạp hơn

</details>

<details open>
<summary>4. Gate và Policy khác nhau thế nào?</summary>

Gate dùng cho logic đơn giản, Policy dùng cho model-based authorization

</details>

<details open>
<summary>5. RBAC là gì?</summary>

Role-Based Access Control – phân quyền theo vai trò

</details>

## Kết luận

Authentication & Authorization là nền tảng bảo mật hệ thống.

> Làm đúng → hệ thống an toàn
> Làm sai → rủi ro rất lớn
