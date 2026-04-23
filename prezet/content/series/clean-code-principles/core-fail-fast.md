---
title: Fail Fast là gì? Áp dụng nguyên tắc fail fast trong PHP & Laravel từ code đến system design
excerpt: Phân tích chuyên sâu Fail Fast Principle, cách validate sớm, bảo vệ dữ liệu và thiết kế hệ thống an toàn trong PHP và Laravel.
tags: [fail-fast, error-handling, validation]
date: 2025-10-05
order: 6
image: /prezet/img/ogimages/series-clean-code-principles-core-fail-fast.webp
---

> "Fail early, fail loudly, fail clearly"

## Phần 1: Bản chất thật sự của Fail Fast

Fail Fast KHÔNG chỉ là:

* throw exception

Fail Fast là:

* Phát hiện lỗi **càng sớm càng tốt**
* Dừng hệ thống ngay khi **state không hợp lệ**

#### Ví dụ bản chất

```php
function withdraw($amount) {
    // ❌ sai
    // xử lý tiếp dù amount invalid
}
```

```php
function withdraw($amount) {
    if ($amount <= 0) {
        throw new Exception('Invalid amount');
    }
}
```

→ Fail ngay từ đầu

## Phần 2: Bad Example (PHP thuần)

```php
class OrderProcessor {

    public function process(array $order) {

        // ❌ không validate
        $customer = $this->findCustomer($order['customer_id']);

        // ❌ có thể null
        $total = 0;

        foreach ($order['items'] ?? [] as $item) {
            $product = $this->findProduct($item['product_id']);

            if ($product) {
                $total += $product['price'] * ($item['quantity'] ?? 1);
            }
        }

        // ❌ vẫn tiếp tục
        $this->createOrder($order, $total);
    }
}
```

#### Vấn đề

* Lỗi bị che giấu
* State không nhất quán
* Debug cực khó

## Phần 3: Refactor (PHP thuần)

#### Step 1: Validate input ngay lập tức

```php
private function validate(array $input): array {
    if (!isset($input['customer_id'])) {
        throw new Exception('customer_id required');
    }

    if (!isset($input['items']) || empty($input['items'])) {
        throw new Exception('items required');
    }

    return $input;
}
```

#### Step 2: Validate dependency

```php
private function getCustomer($id) {
    $customer = $this->repo->find($id);

    if (!$customer) {
        throw new Exception('Customer not found');
    }

    return $customer;
}
```

#### Step 3: Validate business rule

```php
private function checkStock($items) {
    foreach ($items as $item) {
        $product = $this->findProduct($item['product_id']);

        if (!$product) {
            throw new Exception('Product not found');
        }

        if ($product['stock'] < $item['quantity']) {
            throw new Exception('Out of stock');
        }
    }
}
```

#### Step 4: Orchestrate rõ ràng

```php
public function process(array $input) {

    $input = $this->validate($input);

    $customer = $this->getCustomer($input['customer_id']);

    $this->checkStock($input['items']);

    $total = $this->calculateTotal($input['items']);

    return $this->createOrder($customer, $input, $total);
}
```

## Phân tích sâu

#### 1. Fail Fast = Guard Clause

* Validate ở đầu function

#### 2. Fail Fast + Encapsulation

* Object tự bảo vệ state

#### 3. Fail Fast + LSP

* Preconditions phải được check

#### 4. Fail Fast = giảm side-effect

* Không chạy logic khi data sai

## Phần 4: Error Design (rất quan trọng)

#### ❗ Không dùng Exception chung

```php
throw new Exception('Error');
```

#### ✅ Custom Exception

```php
class ValidationException extends Exception {}
class NotFoundException extends Exception {}
class BusinessException extends Exception {}
```

#### Lợi ích

* Phân loại lỗi
* Handle riêng

## Phần 5: Mapping sang Laravel

#### 1. FormRequest = Fail Fast layer

```php
class CreateOrderRequest extends FormRequest {
    public function rules() {
        return [
            'customer_id' => 'required|exists:customers,id',
            'items' => 'required|array|min:1'
        ];
    }
}
```

→ request fail trước khi vào controller

#### 2. Service layer validation

```php
if ($product->stock < $qty) {
    throw new BusinessException('Out of stock');
}
```

#### 3. DB Transaction

```php
DB::transaction(function () {
    // fail -> rollback
});
```

#### 4. Exception Handler

```php
renderable(function (ValidationException $e) {
    return response()->json(['error' => $e->getMessage()], 400);
});
```

## Phần 6: Khi nào cần Fail Fast?

* Input từ user
* API boundary
* Business rule

## Khi nào KHÔNG cần?

* Logging không critical
* Retry logic

## Pitfalls

#### 1. Fail too late

* validate sau khi xử lý

#### 2. Fail too early (sai ngữ cảnh)

* reject khi chưa cần

#### 3. Swallow exception

```php
try {
} catch (Exception $e) {}
```

→ phá fail fast

## Advanced Insight (Staff level)

#### 1. Fail Fast vs Fail Safe

* Fail Fast: dừng ngay
* Fail Safe: fallback

→ cần phân biệt

#### 2. Fail Fast trong distributed system

* Không phải lúc nào cũng throw
* Có thể retry / circuit breaker

#### 3. Fail Fast = giảm blast radius

* lỗi không lan rộng

## Câu hỏi phỏng vấn

<details>
  <summary>1. Fail Fast là gì?</summary>

**Summary:**

* Phát hiện lỗi sớm

**Deep:**

* Tránh inconsistent state

</details>

<details>
  <summary>2. Fail Fast khác gì Validation?</summary>

**Summary:**

* Validation là 1 phần

**Deep:**

* Fail Fast là mindset toàn system

</details>

<details>
  <summary>3. Khi nào không nên Fail Fast?</summary>

**Summary:**

* Khi cần resilience

**Deep:**

* Retry, fallback

</details>

## Kết luận

Fail Fast không phải là:

* throw exception bừa bãi

Mà là:

> phát hiện lỗi sớm để bảo vệ hệ thống

Nếu hệ thống của bạn xử lý tiếp khi data sai → bạn đang tích lũy bug và technical debt.
