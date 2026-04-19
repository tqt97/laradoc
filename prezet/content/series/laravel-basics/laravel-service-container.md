---
title: "Laravel Service Container là gì? Deep Dive để Master Dependency Injection"
excerpt: Tìm hiểu Laravel Service Container từ cơ bản đến nâng cao, cách hoạt động, anti-pattern và áp dụng thực tế trong production.
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-service-container.webp
tags: [laravel, service container, dependency injection, architecture]
order: 3
---

Nếu bạn từng viết Laravel như sau:

```php
$userService = new UserService();
```

Thì bạn đang bypass một trong những thứ mạnh nhất của Laravel.

**Service Container** chính là thứ giúp Laravel trở nên “magic”.

Và cũng là thứ phân biệt:

> Developer bình thường vs Senior Laravel Engineer

## Service Container là gì?

**Service Container** là một công cụ quản lý dependency.

Hiểu đơn giản:

> Nó giúp bạn tạo object mà không cần tự new.

Thay vì:

```php
$service = new UserService(new UserRepository());
```

Laravel sẽ tự resolve:

```php
public function __construct(UserService $service)
```

Không cần new, không cần wiring.

## Dependency Injection (DI) trong Laravel

Laravel sử dụng DI thông qua constructor:

```php
class UserController
{
    public function __construct(UserService $service)
    {
        $this->service = $service;
    }
}
```

Container sẽ:

* Tạo UserService
* Inject vào controller

## Container hoạt động như thế nào?

Flow:

```txt
Controller cần UserService
    ↓
Container kiểm tra binding
    ↓
Nếu có → resolve
Nếu không → auto resolve (reflection)
    ↓
Inject dependency
```

Laravel dùng **Reflection** để tự động resolve class.

## Binding trong Service Container

### Bind cơ bản

```php
app()->bind(UserRepositoryInterface::class, UserRepository::class);
```

Mỗi lần resolve → tạo instance mới

### Singleton

```php
app()->singleton(UserService::class, function () {
    return new UserService();
});
```

Chỉ tạo 1 lần duy nhất

### Bind instance

```php
app()->instance('config.custom', $config);
```

## Service Provider – nơi bind container

```php
public function register()
{
    $this->app->bind(
        UserRepositoryInterface::class,
        UserRepository::class
    );
}
```

Rule quan trọng:

* register() → bind
* boot() → không bind

## Auto Resolution (Laravel cực mạnh)

Laravel có thể tự resolve nếu:

* Class không có dependency phức tạp
* Hoặc dependency cũng resolve được

```php
public function index(UserService $service)
```

Không cần bind vẫn chạy

## Real Case Production

* **Swap implementation**

```php
app()->bind(PaymentInterface::class, StripePayment::class);
```

Sau này:

```php
app()->bind(PaymentInterface::class, PaypalPayment::class);
```

Không cần sửa business logic

* **Testing**

```php
app()->bind(UserService::class, FakeUserService::class);
```

Mock dễ dàng

* **Multi environment**

```php
if (app()->environment('local')) {
    app()->bind(CacheService::class, FakeCache::class);
} else {
    app()->bind(CacheService::class, RedisCache::class);
}
```

## Anti-pattern (rất nhiều dev mắc phải)

**Lạm dụng container**

```php
app(UserService::class)->doSomething();
```

Sai vì:

* Hidden dependency
* Khó test

✅ Đúng:

```php
public function __construct(UserService $service)
```

**Over abstraction**

* Interface cho mọi thứ
* Không cần thiết vẫn abstraction

Dẫn đến:

* Code phức tạp
* Khó maintain

**Logic trong Service Provider**

```php
public function boot()
{
    // xử lý logic business
}
```

Sai hoàn toàn

## Performance & Optimization

* Singleton giúp giảm memory
* Avoid resolve nhiều lần
* Cache container (production)

```bash
php artisan config:cache
php artisan route:cache
```

## Mindset

Junior:

> DI để code đẹp hơn

Senior:

> DI để giảm coupling, tăng testability và scale system

## Khi nào nên dùng Service Container?

### Nên dùng

* Service layer
* Repository
* External integration

### Không cần dùng

* Class đơn giản
* Logic nhỏ

## Kết luận

Service Container là:

> Nền tảng kiến trúc của Laravel

Hiểu nó giúp bạn:

* Viết code clean
* Dễ test
* Dễ scale
