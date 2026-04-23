---
title: DRY là gì? Áp dụng Don't Repeat Yourself trong PHP & Laravel từ code đến kiến trúc
excerpt: Phân tích chuyên sâu nguyên lý DRY, cách refactor duplication trong PHP thuần và Laravel, liên hệ SOLID, design pattern và system design
tags: [DRY, duplication, single-source-of-truth, maintainability]
date: 2025-10-02
order: 4
image: /prezet/img/ogimages/series-clean-code-principles-core-dry.webp
---

> "Every piece of knowledge should have a single, authoritative representation"

## Phần 1: Hiểu đúng DRY (rất quan trọng)

#### DRY ≠ chỉ là không copy code

DRY thực chất là:

* Không lặp **business rule**
* Không lặp **logic**
* Không lặp **knowledge**

#### Ví dụ bản chất

```php
if ($total > 100) {
    $total *= 0.9;
}
```

→ Đây không phải code
→ Đây là **rule giảm giá 10%**

Nếu lặp lại ở nhiều nơi → bạn đang vi phạm DRY

## Phần 2: Bad Example (PHP thuần)

```php
class OrderService {

    public function calculateTotal(array $items): float {
        $total = 0;

        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // ❌ duplicated rule
        if ($total > 100) {
            $total *= 0.9;
        }

        return $total;
    }
}

class CartService {

    public function calculateTotal(array $items): float {
        $total = 0;

        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        // ❌ duplicated rule
        if ($total > 100) {
            $total *= 0.9;
        }

        return $total;
    }
}
```

#### Vấn đề thực tế

##### 1. Bug propagation

* Fix 1 nơi → quên nơi khác

##### 2. Logic drift

* Order giảm 10%
* Cart giảm 15% (do dev khác sửa)

##### 3. Khó maintain

* Không biết rule nằm ở đâu

## Phần 3: Refactor bằng DRY

#### Step 1: Extract logic

```php
class PricingService {

    private const DISCOUNT_THRESHOLD = 100;
    private const DISCOUNT_RATE = 0.1;

    // Tính subtotal (không discount)
    public static function calculateSubtotal(array $items): float {
        $total = 0;

        foreach ($items as $item) {
            $total += $item['price'] * $item['quantity'];
        }

        return $total;
    }

    // Áp dụng discount
    public static function applyDiscount(float $total): float {
        if ($total > self::DISCOUNT_THRESHOLD) {
            return $total * (1 - self::DISCOUNT_RATE);
        }

        return $total;
    }

    // Orchestrate
    public static function calculateTotal(array $items): float {
        $subtotal = self::calculateSubtotal($items);
        return self::applyDiscount($subtotal);
    }
}
```

#### Step 2: Reuse

```php
$orderTotal = PricingService::calculateTotal($orderItems);
$cartTotal = PricingService::calculateTotal($cartItems);
```

## Phân tích sâu (rất quan trọng)

#### 1. DRY + SRP

* PricingService = 1 responsibility
* Không trộn với controller/service khác

#### 2. DRY + Single Source of Truth

* Discount rule nằm 1 nơi

#### 3. DRY + Testability

```php
PricingService::applyDiscount(200);
```

→ test độc lập

#### 4. DRY + Maintainability

* Thay đổi rule → sửa 1 nơi

## Phần 4: DRY ở nhiều level

#### 1. Code level

* Function
* Class

#### 2. Domain level

* Business rules

#### 3. Config level

* Constant

#### 4. System level

* Shared service

## Phần 5: Mapping sang Laravel

#### 1. Service Layer

```php
class PricingService {
    public function calculateTotal(array $items): float {}
}
```

Inject vào controller

#### 2. Container binding

```php
$this->app->bind(PricingService::class);
```

#### 3. Reuse trong nhiều nơi

* Controller
* Job
* Command

#### 4. Validation DRY

```php
class UserRequest extends FormRequest {
    public function rules() {
        return [
            'email' => 'required|email',
            'password' => 'required|min:8'
        ];
    }
}
```

#### 5. Config DRY

```php
config('pricing.discount_rate');
```

## Phần 6: Khi nào nên DRY?

#### Rule of Three

* Lặp 3 lần → extract

#### Khi là business rule

* Discount
* Permission

## Khi nào KHÔNG nên DRY?

#### 1. Coincidental duplication

```php
if ($age >= 18) {}
if ($quantity >= 18) {}
```

→ khác meaning → không DRY

#### 2. Premature abstraction

* Code chưa ổn định

## Pitfalls

#### 1. Over-DRY

* Abstract quá sớm

#### 2. Wrong abstraction

* Gom logic không liên quan

#### 3. Hidden coupling

* Shared code nhưng phụ thuộc ngầm

## Advanced Insight (Staff level)

#### 1. DRY vs AHA

* DRY: tránh duplication
* AHA: tránh abstraction sớm

#### 2. DRY vs Microservices

* Có thể chấp nhận duplication để giảm coupling

#### 3. DRY = giảm entropy system

* Ít nơi chứa logic → ít bug hơn

## Câu hỏi phỏng vấn

<details>
  <summary>1. DRY là gì?</summary>

**Summary:**

* Không lặp knowledge

**Deep:**

* Single source of truth
* Maintainability

</details>

<details>
  <summary>2. DRY khác gì Code Reuse?</summary>

**Summary:**

* DRY là concept

**Deep:**

* Code reuse là implementation

</details>

<details>
  <summary>3. Khi nào không nên DRY?</summary>

**Summary:**

* Khi abstraction chưa rõ

**Deep:**

* Tránh over-engineering

</details>

## Kết luận

DRY không phải là:

* giảm số dòng code

Mà là:

> giảm số nơi chứa sự thật

Nếu một rule tồn tại ở nhiều nơi → system của bạn đang có rủi ro bug rất lớn.
