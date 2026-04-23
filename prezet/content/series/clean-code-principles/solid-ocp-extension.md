---
title: SOLID - Open/Closed Principle - Nguyên Lý Open/Closed (OCP) Nâng Cao – Extension, Plugin Architecture, Strategy Pattern
excerpt: "Tìm hiểu chuyên sâu Open/Closed Principle (OCP): cách thiết kế hệ thống mở rộng không sửa code, plugin architecture, strategy pattern, anti-pattern, câu hỏi phỏng vấn senior/staff."
tags: [SOLID, LSP, liskov-substitution, contracts, invariants, design-by-contract]
date: 2025-10-20
order: 20
image: /prezet/img/ogimages/series-clean-code-principles-solid-ocp-extension.webp
---

## Open/Closed Principle – Extension (Advanced)

> “Code should be open for extension, but closed for modification.”

Ở level senior → staff, OCP không chỉ là tránh `switch-case`, mà là **thiết kế hệ thống có thể evolve liên tục mà không phá vỡ stability của core**.

## 1. Vấn đề thực tế ở production

Anti-pattern phổ biến:

* Business logic tập trung trong 1 class lớn
* Mỗi feature mới = sửa code cũ
* Deploy = rủi ro regression

👉 Đây chính là dấu hiệu **vi phạm OCP ở mức kiến trúc**

## 2. OCP không phải chỉ là "thêm class"

Sai lầm phổ biến:

> "Tách ra class là xong OCP"

 Sai

OCP đúng phải đạt:

* Không sửa code core
* Thêm behavior mới = plug-in
* Không ảnh hưởng hệ thống cũ
* Có thể bật/tắt feature runtime

## 3. Evolution path (junior → staff)

#### Level 1 – switch-case

```js
switch (type) {
  case 'A':
  case 'B':
}
```

#### Level 2 – polymorphism

```js
interface Handler { handle(): void }
```

#### Level 3 – registry pattern

```js
Map<string, Handler>
```

#### Level 4 – plugin system

```js
loadPlugins()
registerDynamically()
```

#### Level 5 – runtime extensibility (staff level)

* Load từ config / DB
* Enable feature bằng flag
* Inject dependency runtime

## 4. Advanced Pattern: Strategy + Registry + DI

```js
class PaymentProcessor {
  constructor(private handlers: Map<string, PaymentHandler>) {}

  async process(payment: Payment) {
    const handler = this.handlers.get(payment.method);

    if (!handler) {
      throw new Error('Unsupported');
    }

    return handler.process(payment);
  }
}
```

👉 Điểm quan trọng:

* Không if/else
* Không sửa class khi thêm handler

## 5. Plugin Architecture (real-world)

#### Dynamic registration

```js
class PluginManager {
  private plugins: PaymentHandler[] = [];

  register(plugin: PaymentHandler) {
    this.plugins.push(plugin);
  }

  getHandlers() {
    return this.plugins;
  }
}
```

#### Load plugin từ config

```js
const enabledPlugins = config.plugins;

enabledPlugins.forEach(p => {
  const plugin = require(p);
  manager.register(new plugin());
});
```

👉 Đây là OCP ở cấp **system design**

## 6. Feature Flag + OCP

```js
if (featureFlag.isEnabled('crypto')) {
  processor.register(new CryptoHandler());
}
```

👉 Không sửa logic core
👉 Chỉ thay đổi config

## 7. Anti-pattern nâng cao

#### God Strategy

```js
class BigHandler {
  handleA() {}
  handleB() {}
}
```

👉 Vi phạm SRP + OCP

#### Enum-driven logic

```js
enum PaymentType {}
```

👉 Thêm enum = sửa code

#### Hidden coupling

```js
if (handler instanceof X)
```

👉 Break polymorphism

## 8. Trade-offs (quan trọng ở senior level)

OCP không phải lúc nào cũng đúng.

#### Cost

* Tăng số lượng class
* Harder to navigate
* Over-engineering

#### Khi KHÔNG nên dùng

* Code nhỏ
* Domain ổn định
* Không có requirement thay đổi

👉 Staff mindset:

> “Apply OCP only where change is expected.”

## 9. OCP + Clean Architecture

* Core (UseCase) = closed
* Infrastructure = open

👉 Dependency flow:

```
Core → Interface ← Implementation
```

## 10. Interview Questions (Senior/Staff)

#### Q1

OCP khác gì SRP?

**Answer:**

* SRP: 1 reason to change
* OCP: không sửa khi change

#### Q2

OCP có thể bị overuse không?

**Answer:**
Có. Khi abstraction không cần thiết → complexity tăng

#### Q3

Làm sao enforce OCP trong team?

**Answer:**

* Code review
* Architecture guideline
* Ban switch-case trong domain core

#### Q4

OCP liên quan gì đến plugin system?

**Answer:**
Plugin system là implementation thực tế của OCP

#### Q5

Laravel áp dụng OCP ở đâu?

**Answer:**

* Service Provider
* Middleware
* Event Listener
* Queue Job

## 11. Tips & Tricks (thực chiến)

#### 1. Luôn hỏi

> “Feature này có khả năng thay đổi không?”

#### 2. Dùng Map thay vì switch

```js
Map<string, Handler>
```

#### 3. Tách validation khỏi processing

👉 Tránh coupling

#### 4. Combine với DIP

👉 OCP không sống một mình

#### 5. Test bằng contract

👉 Test interface, không test implementation

## 12. Kết luận

OCP ở level cao không còn là pattern nhỏ nữa mà là:

* Architectural principle
* Plugin system foundation
* Scaling team enabler

👉 Nếu bạn thấy:

* Code phải sửa liên tục
* Feature mới phá code cũ

=> Bạn đang **vi phạm OCP**

> “Good systems don’t resist change. They absorb it.”
