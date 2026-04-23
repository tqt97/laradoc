---
title: SOLID - Single Responsibility Principle - SRP Function Level Nâng Cao – Cách Viết Function Chuẩn Senior, Clean Code, Dễ Test
excerpt: "Hướng dẫn chuyên sâu SRP ở cấp độ function: cách chia nhỏ đúng cách, tránh over-engineering, orchestration pattern, error handling, performance trade-off, câu hỏi phỏng vấn."
tags: [SOLID, SRP, function-design, clean-code]
date: 2025-10-22
order: 22
image: /prezet/img/ogimages/series-clean-code-principles-solid-srp-function.webp
---

## SRP – Function Level (Advanced)

> “A function should do one thing well.”

Ở level senior/staff, vấn đề không còn là “tách function”, mà là:

👉 **tách đúng boundary + giữ orchestration rõ ràng**

## 1. Sai lầm phổ biến

#### Tách quá mức (over-splitting)

```js
function getPrice() {}
function getTax() {}
function add() {}
```

👉 Mất context, khó đọc

#### Function dài nhưng vẫn “1 responsibility”?

```js
function handleOrder() {
  // 200 lines nhưng cùng 1 flow
}
```

👉 Vẫn vi phạm SRP vì nhiều axis of change

## 2. Nguyên tắc cốt lõi

#### Rule 1 – Không dùng “and” khi mô tả

“fetch and validate order”

👉 tách ra 2 function

#### Rule 2 – Function = 1 abstraction level

mix:

* high-level (business)
* low-level (SQL, API)

👉 phải tách

#### Rule 3 – Top function = orchestration

```js
processOrder()
```

👉 chỉ gọi các function khác

## 3. Orchestration Pattern (rất quan trọng)

#### High-level

```js
async function processOrder(id: string) {
  const order = await fetchOrder(id);
  validate(order);

  const pricing = await calculate(order);

  await reserve(order);
  const payment = await charge(order, pricing);

  return finalize(order, payment);
}
```

👉 Đây là clean SRP chuẩn

## 4. Functional Cohesion vs Logical Cohesion

#### Logical

```js
function handleUser(action) {
  if (action === 'create') {}
  if (action === 'delete') {}
}
```

#### Functional

```js
function createUser() {}
function deleteUser() {}
```

## 5. Error Handling (nâng cao)

#### Pattern: fail-fast + rollback

```js
try {
  await reserveInventory();
  await processPayment();
} catch (e) {
  await rollbackInventory();
  throw e;
}
```

👉 Error không lan lung tung

## 6. SRP vs Performance

Trade-off:

* Nhiều function → nhiều call stack
* Async nhiều → overhead

👉 Nhưng:

* Readable ↑
* Maintainable ↑

👉 Optimize sau, design trước

## 7. SRP + Pure Function

#### Pure function

```js
function calculateTax(amount: number): number {
  return amount * 0.1;
}
```

👉 dễ test, không side-effect

## 8. Anti-pattern nâng cao

#### Hidden side-effect

```js
function calculateTotal() {
  db.update();
}
```

👉 vi phạm SRP

#### Temporal coupling

```js
init();
process();
cleanup();
```

👉 thứ tự phụ thuộc lẫn nhau

#### Flag argument

```js
function process(order, isAdmin) {}
```

👉 2 behavior → 2 function

## 9. Interview Questions (Senior/Staff)

#### Q1

Khi nào KHÔNG nên tách function?

**Answer:**

* Khi logic nhỏ
* Khi tách làm mất readability

#### Q2

SRP function vs class khác gì?

**Answer:**

* Function → behavior
* Class → responsibility boundary

#### Q3

Function dài có vi phạm SRP không?

**Answer:**
Không luôn, chỉ khi có nhiều reason to change

#### Q4

Làm sao detect function vi phạm SRP?

**Answer:**

* Có nhiều “and” trong mô tả
* Có nhiều side-effects

#### Q5

SRP liên quan gì đến clean code?

**Answer:**
SRP là foundation của clean code

## 10. Tips & Tricks

#### 1. Naming = documentation

```js
calculateShipping()
```

#### 2. Function < 20–30 lines (rule of thumb)

#### 3. Tách pure logic ra trước

#### 4. Không mix IO + business logic

#### 5. Combine với

* DRY
* KISS
* OCP

## 11. Kết luận

SRP ở function level là nền tảng của:

* Clean code
* Testability
* Maintainability

👉 Nếu function của bạn:

* khó đọc
* khó test
* hay bị sửa nhiều chỗ

👉 bạn đang **vi phạm SRP**

> Small functions are not the goal. Clear responsibility is.
