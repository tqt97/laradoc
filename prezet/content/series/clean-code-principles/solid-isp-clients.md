---
title: SOLID - Interface Segregation Principle (ISP) từ góc nhìn Client + áp dụng PHP/Laravel chuyên sâu
excerpt: "Phân tích chuyên sâu Interface Segregation Principle (ISP): thiết kế interface theo client, tránh fat interface, áp dụng thực chiến trong PHP/Laravel, kiến trúc hệ thống và anti-pattern."
date: 2025-10-13
order: 15
image: /prezet/img/ogimages/series-clean-code-principles-solid-isp-clients.webp
---

## Interface Segregation Principle (ISP)

> Clients should not be forced to depend on interfaces they do not use.

ISP không chỉ là "chia nhỏ interface" — mà là **thiết kế interface từ góc nhìn của client**.

## 1. Bản chất của ISP (hiểu đúng từ gốc)

#### 1.1 Interface là contract cho AI?

Sai.

👉 Interface là contract cho **client (consumer)**

#### 1.2 Sai lầm phổ biến

* Design theo implementation
* Gom tất cả method vào 1 interface

👉 Result: FAT INTERFACE

## 2. Vấn đề của Fat Interface

#### 2.1 Coupling lan rộng

```text
LoginPage → UserService (15 methods)
```

👉 dù chỉ dùng 1 method

#### 2.2 Test khó

* Mock 15 methods
* Noise trong test

#### 2.3 Change ripple

* Thêm method → ảnh hưởng tất cả client

## 3. Nguyên lý thiết kế đúng

#### 3.1 Client-first design

👉 Hỏi:

> Client này cần gì?

Không phải:

> System có gì?

#### 3.2 Interface theo use-case

* Auth
* Profile
* Analytics

#### 3.3 Granularity hợp lý

* Không quá nhỏ
* Không quá lớn

## 4. Ví dụ PHP thuần

#### Bad

```php
interface UserService {
    public function login();
    public function updateProfile();
    public function sendEmail();
}
```

#### Good

```php
interface AuthService {
    public function login(string $email, string $password);
}

interface ProfileService {
    public function updateProfile(int $userId, array $data);
}
```

## 5. Áp dụng trong Laravel

#### 5.1 Service Layer

```php
class LoginController {
    public function __construct(private AuthService $auth) {}
}
```

#### 5.2 Binding

```php
$this->app->bind(AuthService::class, AuthServiceImpl::class);
```

## 6. ISP + DIP

👉 ISP chia nhỏ interface
👉 DIP inject interface

→ Kết hợp = powerful architecture

## 7. ISP + SRP

* SRP: class 1 responsibility
* ISP: interface 1 responsibility

## 8. Advanced: Role-based Interface

#### 8.1 Read vs Write

```php
interface UserReader {}
interface UserWriter {}
```

👉 CQRS style

#### 8.2 Permission-based

* AdminService
* UserService

## 9. Anti-patterns

#### 9.1 One interface per class

Sai.

👉 Interface phải phục vụ client

#### 9.2 Over-segmentation

* Quá nhiều interface
* Khó maintain

#### 9.3 Leaky abstraction

```php
interface Repo {
    public function queryRawSQL(string $sql);
}
```

👉 expose detail

## 10. Testing benefit

* Mock nhỏ
* Test focused

## 11. Real-world

#### 11.1 API layer

* Controller chỉ cần 1 phần service

#### 11.2 Microservices

* Client chỉ expose subset API

## 12. Tips & Tricks

* Naming theo hành vi (Auth, Reader)
* Keep interface small
* Combine khi cần

## 13. Interview Questions

<details>
  <summary>ISP là gì?</summary>

**Summary:**

* Không ép client phụ thuộc method không dùng

**Deep:**

* Design interface theo client

</details>

<details>
  <summary>Fat interface là gì?</summary>

**Summary:**

* Interface quá lớn

**Deep:**

* Gây coupling + khó test

</details>

<details>
  <summary>ISP khác SRP?</summary>

**Summary:**

* SRP: class

**Deep:**

* ISP: interface

</details>

## 14. Kết luận

ISP giúp:

* Giảm coupling
* Tăng testability

👉 Junior: chia interface
👉 Senior: design theo client
👉 Architect: kiểm soát boundary system
