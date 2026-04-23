---
title: SOLID - Single Responsibility Principle - SRP Nâng Cao – Single Responsibility Principle cho Senior/Staff, Tách Responsibility Đúng Cách
excerpt: "Hướng dẫn chuyên sâu SRP (Single Responsibility Principle): cách xác định responsibility đúng, tránh over-engineering, áp dụng trong kiến trúc Laravel, câu hỏi phỏng vấn kèm đáp án."
tags: [SOLID, SRP, single-responsibility, architecture]
date: 2025-10-20
order: 21
image: /prezet/img/ogimages/series-clean-code-principles-solid-srp-class.webp
---

## Single Responsibility Principle – Advanced

> A class should have only one reason to change.

Ở level junior → dễ hiểu là “1 class = 1 việc”.

Ở level senior/staff → câu hỏi thật sự là:

👉 **Thế nào là một responsibility đúng?**

## 1. Hiểu sai phổ biến về SRP

#### Hiểu sai 1: 1 method = 1 class

→ Over-engineering

#### Hiểu sai 2: tách nhỏ càng nhiều càng tốt

→ Code fragmentation, khó maintain

#### Hiểu sai 3: tách theo technical layer

```js
UserService
UserRepository
UserHelper
```

👉 Nhưng vẫn chứa nhiều responsibilities bên trong

## 2. Responsibility = Reason to change

SRP không nói về số method

👉 Nó nói về **nguồn gốc của sự thay đổi (axis of change)**

#### Ví dụ

User logic có thể thay đổi vì:

* Business rule thay đổi
* DB schema thay đổi
* Email template thay đổi
* Logging strategy thay đổi

👉 Đây là **4 responsibilities khác nhau**

## 3. SRP ở nhiều level

#### 3.1 Class level

* 1 class = 1 responsibility

#### 3.2 Module level

* 1 module = 1 domain concern

#### 3.3 System level (Staff)

* 1 service = 1 bounded context

## 4. Advanced Example – Refactor sâu

#### God Service

```js
class OrderService {
  createOrder() {
    // validate
    // calculate price
    // apply discount
    // save DB
    // send email
    // push event
  }
}
```

#### Refactor đúng SRP

```js
class OrderValidator {}
class PricingService {}
class DiscountService {}
class OrderRepository {}
class NotificationService {}
class EventPublisher {}

class OrderApplicationService {
  constructor(
    private validator: OrderValidator,
    private pricing: PricingService,
    private discount: DiscountService,
    private repo: OrderRepository,
    private notifier: NotificationService,
    private events: EventPublisher
  ) {}

  createOrder(input: CreateOrderInput) {
    this.validator.validate(input);

    const price = this.pricing.calculate(input);
    const finalPrice = this.discount.apply(price);

    const order = this.repo.save({ ...input, price: finalPrice });

    this.notifier.send(order);
    this.events.publish(order);

    return order;
  }
}
```

👉 Đây là **SRP + orchestration pattern**

## 5. SRP vs Layered Architecture

Sai lầm:

> “Controller → Service → Repository là SRP”

❌ Không đúng

👉 SRP nằm trong từng layer, không phải layer structure

## 6. SRP + Laravel (thực chiến)

#### Anti-pattern

```php
class UserController {
  public function store() {
    // validate
    // business logic
    // DB
    // email
  }
}
```

#### Best practice

* FormRequest → validation
* Service → business logic
* Job → async task
* Event → decouple

## 7. SRP vs Performance

Trade-off:

* Nhiều class → nhiều abstraction
* Có thể ảnh hưởng performance nhẹ

👉 Nhưng đổi lại:

* Maintainable
* Testable
* Scalable

## 8. Anti-pattern nâng cao

#### Anemic Service

```js
class UserService {
  create() {}
  update() {}
}
```

👉 Không có logic thật

#### Feature envy

Class dùng data của class khác nhiều hơn chính nó

#### God Object

Class biết quá nhiều

## 9. Interview Questions (Senior/Staff)

#### Q1

SRP khác gì Separation of Concerns?

**Answer:**

* SRP: 1 reason to change
* SoC: tách concern rộng hơn (UI, DB, logic)

#### Q2

SRP có thể conflict với performance không?

**Answer:**
Có. Nhưng thường trade-off acceptable

#### Q3

Làm sao detect SRP violation?

**Answer:**

* Class đổi vì nhiều lý do
* PR thường sửa cùng 1 class cho nhiều feature

#### Q4

SRP có liên quan gì đến microservices?

**Answer:**
SRP ở system level → bounded context

#### Q5

SRP có thể overuse không?

**Answer:**
Có → dẫn tới fragmentation

## 10. Tips & Tricks (thực chiến)

#### 1. Hỏi câu này

> “Class này thay đổi vì lý do gì?”

#### 2. Nếu >1 lý do → tách

#### 3. Nhóm theo domain, không theo technical

#### 4. Dùng naming rõ ràng

* Validator
* Repository
* Service
* Handler

#### 5. Combine với

* DIP
* OCP
* ISP

## 11. Kết luận

SRP không phải là “chia nhỏ code”

👉 Nó là:

* Boundary design
* Change management
* Foundation của clean architecture

> “If a class changes for more than one reason, it's doing too much.”
