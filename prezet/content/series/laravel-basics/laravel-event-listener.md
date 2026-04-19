---
title: "Event & Listener trong Laravel – Xây dựng Event-Driven Architecture"
excerpt: Tìm hiểu Event và Listener trong Laravel, cách hoạt động, khi nào dùng và áp dụng kiến trúc event-driven trong production.
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-event-listener.webp
tags: [laravel, event, listener, architecture, event-driven]
order: 8
---

Trong một hệ thống thực tế, bạn sẽ gặp tình huống như:

* User đăng ký → gửi email
* Order tạo → trừ tồn kho → gửi notification → log

Nếu viết trực tiếp trong controller:

Code sẽ:

* Dài
* Khó maintain
* Khó mở rộng

## Event & Listener là gì?

### Event

> Là một sự kiện xảy ra trong hệ thống

Ví dụ:

* UserRegistered
* OrderCreated

### Listener

> Là nơi xử lý khi event xảy ra

Ví dụ:

* SendWelcomeEmail
* UpdateInventory

## Flow hoạt động

```txt
Event xảy ra → Dispatch → Listener xử lý
```

## Tạo Event & Listener

```bash
php artisan make:event UserRegistered
php artisan make:listener SendWelcomeEmail
```

## Ví dụ thực tế

### Dispatch event

```php
UserRegistered::dispatch($user);
```

### Listener

```php
class SendWelcomeEmail
{
    public function handle(UserRegistered $event)
    {
        // gửi email
    }
}
```

## Tại sao nên dùng Event?

### Không dùng event

```php
// Controller
User::create($data);
Mail::send(...);
Log::info(...);
```

Tight coupling

### Dùng event

```php
UserRegistered::dispatch($user);
```

Decoupled

## Event + Queue = Powerful

Bạn có thể queue listener:

```php
class SendWelcomeEmail implements ShouldQueue
```

Async + decoupled

## Real Case Production

### Case: Order System

Event:

* OrderCreated

Listeners:

* SendEmail
* UpdateInventory
* PushNotification
* LogActivity

Dễ mở rộng

## Khi nào nên dùng Event?

### Nên dùng khi

* Có nhiều hành động sau một sự kiện
* Muốn tách logic
* Cần mở rộng dễ dàng

### Không nên dùng khi

* Logic đơn giản
* Không cần decouple

## Anti-pattern

* **Overuse event**: Mọi thứ đều event → khó debug

* **Business logic trong listener quá nhiều**: Khó maintain

* **Không dùng queue cho listener nặng**: Block system

## Performance Tips

* Queue listener nặng
* Log event
* Monitor hệ thống

## Mindset Senior

Junior:

> Event để tách code

Senior:

> Event để xây dựng hệ thống loosely coupled và scalable

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. Event là gì?</summary>

Là một sự kiện xảy ra trong hệ thống

</details>

<details open>
<summary>2. Listener là gì?</summary>

Là nơi xử lý khi event xảy ra

</details>

<details open>
<summary>3. Khi nào nên dùng Event?</summary>

Khi cần tách logic và mở rộng hệ thống

</details>

<details open>
<summary>4. Event có thể kết hợp với Queue không?</summary>

Có, để xử lý async

</details>

<details open>
<summary>5. Event-driven architecture là gì?</summary>

Là kiến trúc dựa trên sự kiện để tách các thành phần hệ thống

</details>

## Kết luận

Event giúp bạn:

* Tách logic
* Dễ mở rộng
* Xây dựng hệ thống scalable

Đây là nền tảng cho microservices.
