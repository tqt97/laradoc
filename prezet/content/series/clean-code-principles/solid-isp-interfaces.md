---
title: SOLID - Interface Segregation (Small Cohesive Interfaces) từ cơ bản đến Architect + áp dụng Laravel
excerpt: "Phân tích chuyên sâu ISP theo hướng small cohesive interfaces: cách thiết kế interface đúng, phân tách theo domain, áp dụng trong PHP/Laravel, anti-pattern và kiến trúc thực tế."
date: 2025-10-15
order: 16
image: /prezet/img/ogimages/series-clean-code-principles-solid-isp-interfaces.webp
---

## Interface Segregation Principle (ISP - Small Interfaces)

> Interfaces should be small, cohesive, and focused.

Nếu bài trước là **client-centric**, thì bài này là **cohesion-centric**.

👉 Tập trung vào câu hỏi:

> Interface này có đang gom nhiều responsibility không?

## 1. Bản chất của “cohesion” trong interface

#### 1.1 Cohesion là gì?

* Các method trong interface phải **liên quan chặt chẽ với nhau**

#### 1.2 Ví dụ dễ hiểu

```php
interface FileHandler {
    read();
    write();
}
```

👉 Cohesive (cùng domain IO)

```php
interface FileHandler {
    read();
    sendEmail();
}
```

👉 Không cohesive

## 2. Vấn đề của interface lớn

#### 2.1 Violates SRP

* Interface = nhiều responsibility

#### 2.2 Implementation bị ép

```php
throw new Exception("Not supported");
```

👉 Code smell cực mạnh

#### 2.3 Khó reuse

* Không dùng được từng phần

## 3. Nguyên lý tách interface

#### 3.1 Theo responsibility

* Content
* Persistence
* Export

#### 3.2 Theo capability

* Readable
* Writable
* Exportable

#### 3.3 Theo domain

* Billing
* Auth
* Notification

## 4. PHP thuần – thiết kế đúng

```php
interface Readable {
    public function read(): string;
}

interface Writable {
    public function write(string $data): void;
}
```

## 5. Composition interface

```php
interface ReadWrite extends Readable, Writable {}
```

👉 Build từ block nhỏ

## 6. Áp dụng Laravel

#### 6.1 Repository split

```php
interface UserReader {
    public function findById(int $id);
}

interface UserWriter {
    public function save(User $user);
}
```

👉 CQRS style

#### 6.2 Service split

```php
interface AuthService {}
interface ProfileService {}
```

## 7. Advanced: ISP + CQRS

#### 7.1 Read model

```php
interface QueryService {}
```

#### 7.2 Write model

```php
interface CommandService {}
```

👉 scale system tốt hơn

## 8. Advanced: ISP + Microservices

* API Gateway expose subset
* Internal service full capability

## 9. Anti-patterns

#### 9.1 God Interface

* 20+ methods

#### 9.2 Marker interface abuse

* Interface rỗng

#### 9.3 Over-splitting

* Quá nhiều interface nhỏ

## 10. Trade-off

#### Ưu

* Flexible
* Reusable

#### Nhược

* Nhiều file
* Hard navigate

## 11. Best Practices

* Keep interface < 5 methods (rule of thumb)
* Name theo behavior
* Không expose detail

## 12. Real-world Case

#### 12.1 Storage system

* Readable (S3, local)
* Writable

#### 12.2 Payment

* Chargeable
* Refundable

## 13. Interview Questions

<details>
  <summary>ISP là gì?</summary>

**Summary:**

* Interface nhỏ, focused

**Deep:**

* Tránh fat interface

</details>

<details>
  <summary>Cohesion là gì?</summary>

**Summary:**

* Related methods

**Deep:**

* Cùng responsibility

</details>

<details>
  <summary>Khi nào split interface?</summary>

**Summary:**

* Khi nhiều responsibility

**Deep:**

* Khi client không dùng hết

</details>

## 14. Kết luận

ISP (small interfaces) giúp:

* Code rõ ràng
* Dễ scale

👉 Junior: chia nhỏ
👉 Senior: chia đúng
👉 Architect: chia theo domain boundary
