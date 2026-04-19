---
title: "Repository Pattern vs Service Layer trong Laravel – Dùng đúng hay over-engineering?"
excerpt: "Phân biệt Repository Pattern và Service Layer trong Laravel, khi nào nên dùng, khi nào không và các anti-pattern thường gặp trong thực tế."
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-repository-service.webp
tags: [laravel, repository pattern, service layer, architecture]
order: 4
---

Sau khi hiểu Service Container, nhiều developer bắt đầu:

* Tạo interface cho mọi thứ
* Tạo repository cho mọi model
* Tạo service cho mọi logic

Và rồi project trở nên **phức tạp không cần thiết**.

Đây là lúc bạn cần hiểu rõ:

> Repository Pattern và Service Layer khác nhau như thế nào?

## Repository Pattern là gì?

Repository Pattern là một layer:

> Đứng giữa Business Logic và Data Layer

Nó giúp:

* Tách logic truy vấn database
* Dễ thay đổi data source

Ví dụ:

```php
interface UserRepositoryInterface
{
    public function findById($id);
}
```

```php
class UserRepository implements UserRepositoryInterface
{
    public function findById($id)
    {
        return User::find($id);
    }
}
```

## Service Layer là gì?

Service Layer là nơi chứa:

> Business Logic của hệ thống

Ví dụ:

```php
class UserService
{
    public function register($data)
    {
        // validate
        // create user
        // send email
        // log
    }
}
```

Đây là nơi orchestration logic.

## So sánh Repository vs Service

| Tiêu chí     | Repository  | Service        |
| ------------ | ----------- | -------------- |
| Mục đích     | Data access | Business logic |
| Làm việc với | Database    | Domain         |
| Nên chứa gì  | Query       | Logic          |

Rule đơn giản:

* Repository → "Lấy dữ liệu như thế nào"
* Service → "Làm gì với dữ liệu"

## Sai lầm phổ biến (Over-engineering)

### Repository cho mọi model

```php
UserRepository
PostRepository
ProductRepository
```

Trong khi chỉ cần:

```php
User::query()
```

### Service chỉ gọi repository

```php
public function getUser($id)
{
    return $this->repo->find($id);
}
```

Đây không phải service, chỉ là proxy.

### Abstraction không cần thiết

* Interface nhưng chỉ có 1 implementation
* Không có khả năng thay đổi

Làm code khó đọc hơn.

## Khi nào nên dùng Repository?

### Nên dùng khi

* Query phức tạp
* Nhiều data source (DB, API, cache)
* Cần mock trong test

### Không cần khi

* CRUD đơn giản
* Chỉ dùng Eloquent

## Khi nào nên dùng Service Layer?

### Nên dùng khi

* Có business logic
* Có nhiều bước xử lý
* Có side effects (email, log, queue)

## Real Case Production

**Case: Đăng ký user**

```php
class UserService
{
    public function register($data)
    {
        DB::transaction(function () use ($data) {
            $user = User::create($data);

            Mail::to($user)->send(new WelcomeMail());
        });
    }
}
```

Đây là service đúng nghĩa.

## Best Practice (Senior Level)

* Không dùng Repository nếu không cần
* Dùng Service để tách business logic
* Kết hợp với Service Container để inject

Kiến trúc tốt = đơn giản + rõ ràng

## Mindset

Junior:

> Pattern nào cũng phải dùng

Senior:

> Dùng pattern khi nó giải quyết vấn đề thật

## Câu hỏi thường gặp (Interview)

### 1. Repository Pattern dùng để làm gì?

Tách logic truy vấn dữ liệu khỏi business logic

### 2. Service Layer khác gì Repository?

Service xử lý business logic, Repository xử lý data

### 3. Có nên dùng Repository cho mọi model không?

Không, chỉ dùng khi cần abstraction hoặc query phức tạp

### 4. Khi nào nên dùng Service Layer?

Khi có nhiều bước xử lý hoặc business logic phức tạp

### 5. Laravel có cần Repository không?

Không bắt buộc, vì Eloquent đã rất mạnh

## Kết luận

Repository và Service không phải là “bắt buộc”.

> Chúng là công cụ – dùng đúng thì mạnh, dùng sai thì rối.

Senior không dùng nhiều pattern hơn,
Senior dùng **đúng pattern**.
