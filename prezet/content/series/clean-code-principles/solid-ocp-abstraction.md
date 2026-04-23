---
title: "SOLID - Open Closed Principle (OCP) trong thực tế: Abstraction, Plugin Architecture & Design Pattern cho Senior Developer"
excerpt: Hướng dẫn chuyên sâu về Open Closed Principle (OCP), cách dùng abstraction để mở rộng hệ thống không sửa code cũ, kèm kiến trúc plugin, ví dụ thực tế, interview questions và best practices.
tags: [SOLID, LSP, liskov-substitution, contracts, invariants, design-by-contract]
date: 2025-10-20
order: 19
image: /prezet/img/ogimages/series-clean-code-principles-solid-ocp-abstraction.webp
---

## Open/Closed Principle (OCP) - Abstraction (Chuyên sâu)

### 1. Tư duy cốt lõi (Senior → Architect)

> **Open for Extension, Closed for Modification**

Nhưng ở level cao hơn:

> 🔥 "Không chỉ tránh sửa code — mà phải thiết kế hệ thống cho việc mở rộng trở thành mặc định"

### 2. OCP thực sự giải quyết vấn đề gì?

#### Nếu không có OCP

* Mỗi feature mới → sửa code cũ
* High risk bug
* Regression liên tục
* Team conflict (merge conflict)

#### Nếu có OCP

* Feature mới = thêm class mới
* Không đụng code cũ
* Dễ scale team
* Dễ maintain

### 3. Sai lầm phổ biến khi áp dụng OCP

#### 3.1 if/else hell (classic anti-pattern)

```js
if (type === 'A') {}
else if (type === 'B') {}
else if (type === 'C') {}
```

👉 Mỗi lần thêm type → sửa code

#### 3.2 Switch-based architecture

```js
switch (strategy) {
  case 'paypal':
  case 'stripe':
}
```

👉 Không scalable

#### 3.3 Enum-driven logic

```js
enum PaymentType { STRIPE, PAYPAL }
```

👉 Khi enum thay đổi → code everywhere break

### 4. Cách thiết kế đúng (Production-grade)

#### 4.1 Abstraction-first design

```js
interface PaymentMethod {
  pay(amount: number): Promise<void>
}
```

#### 4.2 Polymorphism thay vì condition

```js
class StripePayment implements PaymentMethod {}
class PaypalPayment implements PaymentMethod {}
```

#### 4.3 Registry pattern

```js
class PaymentRegistry {
  private methods = new Map<string, PaymentMethod>()

  register(key: string, method: PaymentMethod) {
    this.methods.set(key, method)
  }

  get(key: string) {
    return this.methods.get(key)
  }
}
```

👉 Extension = register thêm

#### 4.4 Plugin Architecture (rất quan trọng)

```js
interface Plugin {
  name: string
  setup(): void
}
```

👉 Cho phép hệ thống mở rộng runtime

### 5. OCP + DIP = Kiến trúc chuẩn

OCP luôn đi với DIP

```js
class OrderService {
  constructor(private payment: PaymentMethod) {}
}
```

👉 Không phụ thuộc implementation

### 6. Case study thực tế (Laravel)

#### Sai

```php
if ($paymentType === 'stripe') {
    // stripe logic
}
```

#### Đúng

```php
interface PaymentMethod {
    public function pay(float $amount);
}
```

### 7. So sánh kiến trúc

| Tiêu chí     | Không OCP | Có OCP     |
| ------------ | --------- | ---------- |
| Thêm feature | sửa code  | thêm class |
| Risk         | cao       | thấp       |
| Maintain     | khó       | dễ         |
| Scale team   | khó       | tốt        |

### 8. Interview Questions (Senior → Staff)

#### Q1: OCP khác gì DRY?

**Answer:**

* DRY → tránh duplicate
* OCP → tránh modify

#### Q2: OCP vs Strategy Pattern?

**Answer:**

Strategy là cách implement OCP

#### Q3: Khi nào KHÔNG nên dùng OCP?

**Answer:**

* YAGNI (chưa cần mở rộng)
* System nhỏ

#### Q4: OCP liên quan gì đến Microservices?

**Answer:**

Service mới = extension

#### Q5: OCP + Plugin system?

**Answer:**

Cho phép third-party extend system

### 9. Advanced Tips

#### Tip 1: Design for change points

👉 Xác định nơi sẽ thay đổi

#### Tip 2: Avoid premature abstraction

👉 Chỉ abstract khi có ≥2 implementation

#### Tip 3: Use configuration over condition

```js
config.payment = 'stripe'
```

#### Tip 4: Favor composition

#### Tip 5: Use DI container

### 10. Checklist áp dụng

* [ ] Có if/switch không?
* [ ] Có abstraction chưa?
* [ ] Có thể thêm feature mà không sửa code không?
* [ ] Có phụ thuộc concrete không?

### 11. Tổng kết

> 🔥 OCP = nền tảng của scalable architecture

Nếu không có OCP:

* Code fragile
* Khó scale

Nếu có OCP:

* Code extensible
* System ổn định

👉 Rule cuối:

> Nếu thêm feature mà phải sửa code cũ → bạn đang vi phạm OCP
