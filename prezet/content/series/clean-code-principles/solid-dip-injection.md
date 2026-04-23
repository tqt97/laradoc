---
title: SOLID - Dependency Injection (DI) từ cơ bản đến Architect + áp dụng Laravel
excerpt: "Phân tích chuyên sâu Dependency Injection (DI): bản chất, các kiểu injection, container, lifecycle, anti-pattern, áp dụng thực chiến trong PHP/Laravel và kiến trúc lớn."
date: 2025-10-13
order: 14
image: /prezet/img/ogimages/series-clean-code-principles-solid-dip-injection.webp
---

## Dependency Injection (DI)

> "Đừng tự tạo dependency bên trong class – hãy nhận nó từ bên ngoài"

DI là **kỹ thuật triển khai của DIP**. Nếu DIP là nguyên lý thiết kế, thì DI là cách hiện thực hoá nguyên lý đó trong code.

## 1. Bản chất của DI

#### 1.1 Inversion ở mức object graph

Không phải class tự new dependency:

```php
class A {
    private B $b;
    public function __construct() {
        $this->b = new B();
    }
}
```

Mà dependency được cung cấp từ bên ngoài:

```php
class A {
    public function __construct(private B $b) {}
}
```

👉 Quyền kiểm soát việc tạo object được chuyển ra ngoài (composition root)

#### 1.2 Object graph

Một hệ thống thực tế là một **đồ thị object**:

```text
Controller → Service → Repository → DB
```

DI giúp:

* Build graph này ở 1 nơi duy nhất
* Quản lý lifecycle
* Thay đổi implementation mà không đổi business logic

## 2. Các loại Dependency Injection

#### 2.1 Constructor Injection

```php
class UserService {
    public function __construct(
        private UserRepository $repo
    ) {}
}
```

**Ưu điểm:**

* Immutable dependency
* Rõ ràng
* Dễ test

#### 2.2 Method Injection

```php
class ReportService {
    public function generate(Logger $logger) {}
}
```

**Use case:** dependency optional hoặc chỉ dùng 1 lần

#### 2.3 Property Injection (không khuyến khích)

```php
class A {
    public B $b;
}
```

**Vấn đề:**

* Không đảm bảo initialized
* Khó trace

## 3. Composition Root (khái niệm cực quan trọng)

> Nơi duy nhất khởi tạo và wiring toàn bộ dependency

#### 3.1 Sai lầm phổ biến

* new object rải rác khắp code

#### 3.2 Đúng

```php
function bootstrap(): App {
    $db = new MySQLConnection();
    $repo = new UserRepository($db);
    $service = new UserService($repo);

    return new App($service);
}
```

## 4. DI Container

#### 4.1 Vai trò

* Resolve dependency
* Manage lifecycle
* Auto wiring

#### 4.2 Tự build container đơn giản

```php
class Container {
    private array $bindings = [];

    public function bind(string $abstract, callable $factory) {
        $this->bindings[$abstract] = $factory;
    }

    public function make(string $abstract) {
        return $this->bindings[$abstract]($this);
    }
}
```

## 5. Laravel DI Container (thực chiến)

#### 5.1 Auto resolve

```php
class UserService {
    public function __construct(UserRepository $repo) {}
}
```

Laravel tự resolve nếu class có thể new được

#### 5.2 Bind interface

```php
$this->app->bind(
    UserRepository::class,
    EloquentUserRepository::class
);
```

#### 5.3 Singleton vs Bind

```php
$this->app->singleton(Logger::class, function () {
    return new Logger();
});
```

| Type      | Behavior             |
| --------- | -------------------- |
| bind      | new instance mỗi lần |
| singleton | shared instance      |

#### 5.4 Contextual binding

```php
$this->app->when(AdminService::class)
    ->needs(Logger::class)
    ->give(AdminLogger::class);
```

## 6. Lifecycle & Scope

#### 6.1 Singleton

* DB connection
* Logger

#### 6.2 Transient

* Service nhẹ

#### 6.3 Scoped (request)

* HTTP request lifecycle

👉 Sai scope = bug khó debug

## 7. Anti-patterns

#### 7.1 Service Locator

```php
app()->make(UserService::class);
```

👉 Hidden dependency

#### 7.2 Over-injection

Constructor 10+ dependencies → smell

#### 7.3 God container

* Bind mọi thứ
* Khó maintain

## 8. DI + Testing

#### 8.1 Mock dễ dàng

```php
$service = new UserService(
    new FakeUserRepository()
);
```

#### 8.2 Isolation

* Không cần DB thật
* Test nhanh

## 9. DI trong kiến trúc lớn

#### 9.1 Clean Architecture

* Outer layer inject vào inner

#### 9.2 Hexagonal

* Adapter inject vào Port

#### 9.3 Microservices

* Inject client (HTTP, gRPC)

## 10. Performance & Trade-off

#### Ưu

* Flexible
* Testable

#### Nhược

* Indirection
* Debug khó hơn

## 11. Khi nào KHÔNG dùng DI

* Script nhỏ
* Không có dependency

## 12. Best Practices

* Constructor injection first
* Interface khi cần
* Keep constructor nhỏ
* Group dependency (Facade/Service)

## 13. Interview Questions

<details>
  <summary>DI là gì?</summary>

**Summary:**

* Inject dependency từ ngoài

**Deep:**

* Control object creation

</details>

<details>
  <summary>DI khác DIP?</summary>

**Summary:**

* DI là technique

**Deep:**

* DIP là principle

</details>

<details>
  <summary>Khi nào dùng singleton?</summary>

**Summary:**

* Shared resource

**Deep:**

* Tránh tạo nhiều instance

</details>

<details>
  <summary>Service Locator là gì?</summary>

**Summary:**

* Lấy dependency từ container

**Deep:**

* Hidden dependency → anti-pattern

</details>

## 14. Kết luận

DI là nền tảng để:

* Viết code testable
* Build architecture scalable

👉 Junior: biết dùng DI
👉 Senior: hiểu lifecycle + container
👉 Architect: thiết kế object graph + boundary
