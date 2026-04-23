---
title: SOLID - Liskov Substitution (Contracts) Deep Dive
excerpt: SOLID - Liskov Substitution (Contracts) Deep Dive
tags: [SOLID, LSP, liskov-substitution, contracts, invariants, design-by-contract]
date: 2025-10-15
order: 17
image: /prezet/img/ogimages/series-clean-code-principles-solid-lsp-contracts.webp
---

## Liskov Substitution Principle (LSP) — Phân Tích Chuyên Sâu (Contracts)

> “Nếu với mỗi object o1 thuộc kiểu S tồn tại object o2 thuộc kiểu T sao cho mọi chương trình P dùng T không thay đổi hành vi khi thay o2 bằng o1, thì S là subtype hợp lệ của T.” — Barbara Liskov

#### 1. Tư duy cốt lõi (Level Architect)

LSP KHÔNG phải là inheritance.

👉 Nó là về **tính đúng đắn hành vi (behavioral correctness)**.

Một subtype phải:

* Giữ nguyên **invariants (bất biến)**
* Không được **siết chặt preconditions**
* Không được **làm yếu postconditions**
* Không tạo **side-effect bất ngờ**

👉 Hiểu đơn giản:

> “Thay class này bằng class khác mà hệ thống vẫn chạy đúng → bạn đang tuân thủ LSP”

#### 2. Design by Contract (Lý thuyết nền tảng)

Mỗi class/interface đều định nghĩa một **contract**:

###### Preconditions (Điều kiện đầu vào)

* Input phải hợp lệ trước khi gọi

###### Postconditions (Kết quả đảm bảo)

* Output và trạng thái sau khi chạy

###### Invariants (Bất biến)

* Luôn đúng trước & sau mọi method public

#### 3. Luật LSP (Formal Rules)

| Quy tắc                      | Ý nghĩa                                                |
| ---------------------------- | ------------------------------------------------------ |
| Không siết preconditions     | Subtype phải chấp nhận ít nhất những gì base chấp nhận |
| Không làm yếu postconditions | Subtype phải đảm bảo ít nhất những gì base đảm bảo     |
| Không phá invariants         | Không làm hỏng trạng thái hợp lệ                       |

#### 4. Các kiểu vi phạm phổ biến

###### 4.1 Siết chặt điều kiện đầu vào

```typescript
class Bird {
  fly(): void {}
}

class Penguin extends Bird {
  fly(): void {
    throw new Error('Không bay được'); // vi phạm LSP
  }
}
```

👉 Client tin rằng mọi Bird đều bay được → crash.

###### 4.2 Làm yếu kết quả đầu ra

```typescript
class Storage {
  save(): boolean {
    return true;
  }
}

class RandomStorage extends Storage {
  save(): boolean {
    return Math.random() > 0.5; // không đảm bảo
  }
}
```

###### 4.3 Phá vỡ invariant

```typescript
class BankAccount {
  protected balance = 0;

  deposit(amount: number) {
    if (amount <= 0) throw new Error();
    this.balance += amount;
  }
}

class BrokenAccount extends BankAccount {
  deposit(amount: number) {
    this.balance -= amount; // phá invariant
  }
}
```

#### 5. Lỗi LSP trong hệ thống thực tế

###### Case 1: Payment Gateway

```typescript
interface PaymentGateway {
  charge(amount: number): Promise<any>;
}

class FakeGateway implements PaymentGateway {
  async charge(): Promise<any> {
    throw new Error('Not implemented'); //
  }
}
```

👉 Test pass → Production crash

###### Case 2: Repository trả dữ liệu sai contract

```typescript
interface UserRepository {
  findById(id: string): Promise<User>;
}

class CacheRepo implements UserRepository {
  async findById(): Promise<User> {
    return null; // sai contract
  }
}
```

👉 Fix: contract phải là `User | null`

#### 6. Cách thiết kế đúng (Best Practices)

###### 6.1 Ưu tiên interface hơn inheritance

👉 Design theo behavior, không phải hierarchy

###### 6.2 Không tạo “khả năng giả” (Fake capability)

```typescript
interface Flyable {
  fly(): void;
}
```

👉 Penguin không implement Flyable

###### 6.3 Immutability

```typescript
class Money {
  constructor(readonly amount: number) {}

  add(x: number): Money {
    return new Money(this.amount + x);
  }
}
```

👉 Tránh phá invariant

###### 6.4 Make illegal state unrepresentable

👉 Validate ngay từ constructor

#### 7. LSP + SOLID khác

###### LSP + OCP

→ Vi phạm LSP → phải sửa code → phá OCP

###### LSP + DIP

→ Interface sai → toàn bộ system sai

###### LSP + ISP

→ Interface nhỏ → dễ giữ contract

#### 8. Insight nâng cao: Performance cũng là contract

```typescript
interface Cache {
  get(key: string): string;
}
```

```typescript
class SlowCache implements Cache {
  get(): string {
    sleep(2s); // phá kỳ vọng
    return 'data';
  }
}
```

👉 Không crash nhưng vẫn vi phạm LSP

#### 9. Rule về Exception

* Không throw exception rộng hơn
* Có thể throw exception cụ thể hơn

#### 10. Ví dụ Laravel thực chiến

###### Sai

```php
interface PaymentService {
    public function charge(int $amount): bool;
}

class PaypalPayment implements PaymentService {
    public function charge(int $amount): bool {
        throw new Exception('API lỗi'); //
    }
}
```

###### Đúng

```php
class PaymentResult {
    public function __construct(
        public bool $success,
        public ?string $error = null
    ) {}
}
```

👉 Contract rõ ràng → không bất ngờ

#### 11. Testing theo LSP (Contract Test)

```typescript
function testGateway(gateway: PaymentGateway) {
  it('luôn trả kết quả hợp lệ', async () => {
    const result = await gateway.charge(100);
    expect(result).toBeDefined();
  });
}
```

👉 Test 1 lần → áp dụng cho mọi implementation

#### 12. Anti-pattern phổ biến

* throw “Not implemented”
* method không support
* return null bất ngờ
* side effect ẩn
* fake implementation

#### 13. Câu hỏi phỏng vấn (Senior level)

1. LSP khác gì polymorphism?
2. Vì sao Square không nên kế thừa Rectangle?
3. Ví dụ bug production do LSP?
4. Làm sao enforce LSP trong team?
5. Contract test là gì?
6. Performance có thể phá LSP không?

#### 14. Tổng kết

* LSP = đúng về hành vi
* Contract phải rõ ràng
* Không dùng inheritance bừa bãi
* Test theo contract

#### 15. One-line

👉 “Thay class mà không cần nghĩ → đó là LSP đúng.”
