---
title: Encapsulation là gì? Áp dụng trong PHP & Laravel để bảo vệ business logic
excerpt: Hướng dẫn chuyên sâu về Encapsulation, từ PHP thuần đến Laravel, giúp bảo vệ dữ liệu, enforce business rule và thiết kế hệ thống bền vững.
tags: [encapsulation, information-hiding, data-protection]
date: 2025-10-04
order: 5
image: /prezet/img/ogimages/series-clean-code-principles-core-encapsulation.webp
---

> "Hide internal state, expose behavior"

## Phần 1: Bản chất thật sự của Encapsulation

Encapsulation KHÔNG chỉ là:

* private / public

Encapsulation là:

* Ẩn **data**
* Chỉ expose **behavior hợp lệ**

#### Ví dụ bản chất

```php
$account->balance = 1000;
```

→ Sai

```php
$account->deposit(1000);
```

→ Đúng

## Phần 2: Bad Example (PHP thuần)

```php
class BankAccount {
    public string $accountNumber;
    public float $balance;
    public array $transactions = [];
}

$account = new BankAccount();

// ❌ phá vỡ rule
$account->balance = -999999;

// ❌ không có audit
$account->balance += 1000;

// ❌ fake transaction
$account->transactions[] = ['amount' => 1000000];
```

#### Vấn đề

* Không kiểm soát state
* Không enforce business rule
* Không audit

## Phần 3: Refactor (PHP thuần)

#### Step 1: Ẩn data

```php
class BankAccount {
    private string $accountNumber;
    private float $balance;
    private array $transactions = [];

    public function __construct(string $accountNumber, float $balance) {
        if ($balance < 0) {
            throw new Exception('Invalid balance');
        }

        $this->accountNumber = $accountNumber;
        $this->balance = $balance;
    }
}
```

#### Step 2: Expose behavior

```php
public function deposit(float $amount): void {
    if ($amount <= 0) {
        throw new Exception('Invalid amount');
    }

    $this->balance += $amount;
    $this->transactions[] = [
        'type' => 'deposit',
        'amount' => $amount
    ];
}
```

#### Step 3: Business rule

```php
public function withdraw(float $amount): void {
    if ($amount <= 0) {
        throw new Exception('Invalid amount');
    }

    if ($amount > $this->balance) {
        throw new Exception('Insufficient funds');
    }

    $this->balance -= $amount;
}
```

#### Step 4: Read-only access

```php
public function getBalance(): float {
    return $this->balance;
}
```

## Phân tích sâu

#### 1. Encapsulation = bảo vệ invariant

Invariant:

* balance >= 0

#### 2. Encapsulation = enforce rule

* Không ai bypass được withdraw

#### 3. Encapsulation = control side-effect

* transaction luôn được ghi lại

## Phần 4: Advanced - Value Object

```php
class Money {
    private float $amount;

    public function __construct(float $amount) {
        if ($amount < 0) {
            throw new Exception('Money cannot be negative');
        }

        $this->amount = $amount;
    }

    public function add(Money $money): Money {
        return new Money($this->amount + $money->amount);
    }
}
```

#### Insight

* Data không bao giờ invalid
* Không cần validate lại nhiều nơi

## Phần 5: Mapping sang Laravel

#### 1. Model Encapsulation

```php
class User extends Model {

    protected $fillable = ['name'];

    public function changeEmail(string $email): void {
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            throw new Exception('Invalid email');
        }

        $this->email = $email;
    }
}
```

#### 2. Attribute Casting

```php
protected $casts = [
    'balance' => 'float'
];
```

#### 3. Accessor / Mutator

```php
public function setEmailAttribute($value) {
    if (!filter_var($value, FILTER_VALIDATE_EMAIL)) {
        throw new Exception('Invalid email');
    }

    $this->attributes['email'] = $value;
}
```

#### 4. Service Layer bảo vệ logic

```php
class BankService {
    public function deposit(User $user, float $amount) {
        // logic ở đây
    }
}
```

## Phần 6: Encapsulation + các nguyên lý khác

#### 1. SRP

* Class chịu trách nhiệm quản lý state

#### 2. Law of Demeter

* Không expose structure sâu

#### 3. DDD

* Aggregate root bảo vệ state

## Phần 7: Khi nào cần Encapsulation?

* Khi có business rule
* Khi có state quan trọng
* Khi cần audit

## Khi nào KHÔNG cần?

* DTO đơn giản
* Data tạm

## Pitfalls

#### 1. Getter/Setter tràn lan

* Không còn encapsulation

#### 2. Anemic Model

* Data có nhưng không có behavior

#### 3. Over-engineering

* Bọc quá nhiều layer

## Advanced Insight (Staff level)

#### 1. Encapsulation = Boundary

* Giữa domain và external

#### 2. Encapsulation = Anti-corruption layer

* Bảo vệ domain khỏi input bẩn

#### 3. Encapsulation = giảm coupling

* Không ai biết internal structure

## Câu hỏi phỏng vấn

<details>
  <summary>1. Encapsulation là gì?</summary>

**Summary:**

* Ẩn data, expose behavior

**Deep:**

* Bảo vệ invariant
* Enforce rule

</details>

<details>
  <summary>2. Getter/Setter có phải encapsulation?</summary>

**Summary:**

* Không hẳn

**Deep:**

* Nếu chỉ expose data → sai

</details>

<details>
  <summary>3. Encapsulation giúp gì trong system lớn?</summary>

**Summary:**

* Bảo vệ domain

**Deep:**

* Giảm bug
* Dễ maintain

</details>

## Kết luận

Encapsulation không phải là:

* giấu biến

Mà là:

> kiểm soát cách data được thay đổi

Nếu bất kỳ code nào có thể sửa state trực tiếp → hệ thống của bạn đang rất dễ lỗi.
