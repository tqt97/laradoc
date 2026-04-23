---
title: SOLID - Liskov Substitution (Preconditions & Postconditions Advanced) Deep Dive
excerpt: Hướng dẫn chuyên sâu về Liskov Substitution Principle (LSP), cách xử lý preconditions và postconditions đúng chuẩn
tags: [SOLID, LSP, preconditions, postconditions, design-by-contract]
date: 2025-10-15
order: 18
image: /prezet/img/ogimages/series-clean-code-principles-solid-lsp-preconditions.webp
---

## Liskov Substitution Principle - Preconditions & Postconditions (Chuyên sâu)

#### 1. Tư duy cốt lõi (Staff/Architect mindset)

LSP KHÔNG chỉ là “thay thế được” mà là:

> **Giữ nguyên contract hành vi (behavioral contract)** giữa abstraction và implementation

Contract gồm:

* Preconditions (điều kiện đầu vào)
* Postconditions (điều kiện đầu ra)
* Invariants (bất biến hệ thống)

#### 2. Quy tắc vàng

##### Không được làm

1. Strengthen Preconditions (yêu cầu nhiều hơn)
2. Weaken Postconditions (đảm bảo ít hơn)

##### Được phép

1. Weaken Preconditions (linh hoạt hơn)
2. Strengthen Postconditions (đảm bảo tốt hơn)

#### 3. Phân tích sâu từng khái niệm

###### 3.1 Preconditions (Điều kiện đầu vào)

Là những gì client PHẢI đảm bảo trước khi gọi function

Ví dụ:

```js
amount > 0
user != null
email phải hợp lệ
```

👉 Nếu subclass yêu cầu thêm:

```js
amount > 100
```

=> Vi phạm LSP

###### 3.2 Postconditions (Điều kiện đầu ra)

Là những gì method CAM KẾT sau khi thực thi

Ví dụ:

```js
return transactionId: string
status = success
```

👉 Nếu subclass trả:

```js
null
undefined
random failure
```

=> Vi phạm LSP

###### 3.3 Invariants

Luôn đúng trước & sau method

Ví dụ:

```js
balance >= 0
user.id không thay đổi
```

#### 4. Anti-pattern phổ biến (Production issue)

###### 4.1 Hidden constraints (cực nguy hiểm)

```js
class PaymentProcessor {
  process(amount: number)
}

class CryptoProcessor extends PaymentProcessor {
  process(amount: number) {
    if (amount < 1000) throw Error()
  }
}
```

👉 Client không biết rule này → crash production

###### 4.2 Silent failure

```js
return null
return false
return {}
```

👉 Làm client assume sai → bug chain reaction

###### 4.3 Exception inconsistency

```js
Base: throw PaymentError
Child: throw string | null
```

👉 Break error handling

#### 5. Kiến trúc đúng (Production-grade)

###### 5.1 Explicit Contract

```js
interface PaymentProcessor {
  process(amount: number): Promise<PaymentResult>
  canProcess(amount: number): boolean
}
```

👉 Tách:

* validation → canProcess
* execution → process

###### 5.2 Fail-fast đúng chuẩn

```js
if (amount <= 0) throw InvalidInputError
```

👉 Không im lặng

###### 5.3 Result Object Pattern

```js
interface Result<T> {
  success: boolean
  data?: T
  error?: Error
}
```

👉 Tránh null/exception không kiểm soát

###### 5.4 Strategy + Factory

```js
class ProcessorFactory {
  get(amount) {
    return processors.find(p => p.canProcess(amount))
  }
}
```

👉 Không để client tự guess logic

#### 6. So sánh thiết kế sai vs đúng

| Tiêu chí        | Sai          | Đúng         |
| --------------- | ------------ | ------------ |
| Preconditions   | hidden       | explicit     |
| Postconditions  | inconsistent | guaranteed   |
| Error handling  | random       | standardized |
| Client safety   | thấp         | cao          |
| Maintainability | kém          | cao          |

#### 7. Real-world case (Laravel)

##### Sai

```php
interface PaymentService {
    public function pay(float $amount): string;
}

class VNPayService implements PaymentService {
    public function pay(float $amount): string {
        if ($amount < 10000) throw new Exception();
    }
}
```

👉 Hidden rule

##### Đúng

```php
interface PaymentService {
    public function pay(float $amount): PaymentResult;
    public function canPay(float $amount): bool;
}
```

#### 8. Interview Questions (Senior → Staff)

###### Q1: LSP violation nguy hiểm nhất là gì?

**Answer:**

Hidden preconditions → vì client không detect được → production bug

###### Q2: Tại sao weaken postconditions lại nguy hiểm?

**Answer:**

Client assume guarantee → nếu mất guarantee → crash dây chuyền

###### Q3: Làm sao enforce LSP trong team?

**Answer:**

* Code review contract
* Interface rõ ràng
* Typed return (no null)
* Domain exception chuẩn hóa

###### Q4: LSP liên quan gì đến API design?

**Answer:**

API contract = LSP

Breaking contract = breaking API

###### Q5: Có nên validate trong subclass không?

**Answer:**

Có, nhưng:

* Không được thêm precondition
* Chỉ validate business logic → throw domain error

###### Q6: LSP vs Defensive Programming?

**Answer:**

* LSP → design level
* Defensive → runtime protection

###### Q7: Null có vi phạm LSP không?

**Answer:**

Có nếu contract không cho phép null

#### 9. Advanced Tips (Staff level)

###### Tip 1: Never return null

→ dùng:

* Result object
* Option/Maybe

###### Tip 2: Make contract explicit bằng Type

```js
type NonEmptyString = string
```

###### Tip 3: Domain Error > Generic Error

```js
class PaymentError extends Error {}
```

###### Tip 4: Separate validation khỏi execution

```js
canProcess()
process()
```

###### Tip 5: Contract test (rất mạnh)

```js
function testProcessor(processor: PaymentProcessor) {
  expect(processor.process(10)).not.toBeNull()
}
```

👉 chạy cho mọi implementation

#### 10. Checklist áp dụng

* [ ] Interface có define rõ contract?
* [ ] Có hidden rule không?
* [ ] Có return null không?
* [ ] Error có consistent không?
* [ ] Client có thể dùng interchangeably không?

#### 11. Tổng kết

LSP không phải lý thuyết — nó là:

> 🔥 **Nền tảng của API stability & system reliability**

Nếu vi phạm LSP:

* Bug production
* Code fragile
* Impossible to scale system

Nếu tuân thủ:

* Code predictable
* System stable
* Dễ scale & refactor

👉 Rule cuối cùng:

> Nếu thay implementation mà phải sửa client → bạn đã vi phạm LSP
