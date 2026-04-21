---
title: Custom Exceptions – Xử lý lỗi chuẩn Senior trong PHP
excerpt: Tìm hiểu cách sử dụng Custom Exceptions trong PHP để xử lý lỗi rõ ràng, dễ maintain và chuẩn kiến trúc. Kèm ví dụ thực tế, best practices, tips & interview questions.
category: PHP Best Practices
date: 2025-09-20
order: 2
image: /prezet/img/ogimages/series-php-best-practices-error-custom-exceptions.webp
---

> Tìm hiểu cách sử dụng Custom Exceptions trong PHP để xử lý lỗi rõ ràng, dễ maintain và chuẩn kiến trúc. Kèm ví dụ thực tế, best practices, tips & interview questions.

## Custom Exceptions là gì?

Custom Exceptions (ngoại lệ tùy chỉnh) là việc bạn **tạo ra các class Exception riêng biệt** cho từng loại lỗi trong hệ thống, thay vì sử dụng chung một loại `\Exception`.

👉 Đây là một practice cực kỳ quan trọng ở level **mid → senior → architect**.

## Bad Example (Anti-pattern)

```php
class UserService
{
    public function register(array $data): User
    {
        if (empty($data['email'])) {
            throw new \Exception('Email is required');
        }

        if ($this->repository->findByEmail($data['email'])) {
            throw new \Exception('Email already exists');
        }

        if (!$this->gateway->charge($data['amount'])) {
            throw new \Exception('Payment failed');
        }

        return $this->repository->create($data);
    }
}
```

### Vấn đề

* Tất cả lỗi đều là `\Exception`
* Không phân biệt được lỗi gì ở phía caller
* Phải **parse string message (anti-pattern nặng)**
* Khó maintain khi hệ thống lớn

👉 Đây là dấu hiệu của code **junior-level hoặc thiếu design**

## Good Example (Best Practice)

### 1. Tạo Domain Exceptions

```php
class ValidationException extends \RuntimeException
{
    public function __construct(private array $errors)
    {
        parent::__construct('Validation failed');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}

class DuplicateEmailException extends \RuntimeException
{
    public function __construct(private string $email)
    {
        parent::__construct("Email already registered: {$email}");
    }

    public function getEmail(): string
    {
        return $this->email;
    }
}

class PaymentFailedException extends \RuntimeException
{
    public function __construct(private string $reason)
    {
        parent::__construct("Payment failed: {$reason}");
    }
}
```

### 2. Sử dụng trong Service

```php
class UserService
{
    public function register(array $data): User
    {
        if (empty($data['email'])) {
            throw new ValidationException(['email' => 'Email is required']);
        }

        if ($this->repository->findByEmail($data['email'])) {
            throw new DuplicateEmailException($data['email']);
        }

        if (!$this->gateway->charge($data['amount'])) {
            throw new PaymentFailedException('Card declined');
        }

        return $this->repository->create($data);
    }
}
```

### 3. Handle ở Caller

```php
try {
    $service->register($data);
} catch (ValidationException $e) {
    return response()->json(['errors' => $e->getErrors()], 422);
} catch (DuplicateEmailException $e) {
    return response()->json(['error' => 'Email already taken'], 409);
} catch (PaymentFailedException $e) {
    return response()->json(['error' => 'Payment failed'], 402);
}
```

## Giải thích sâu

### 1. Tại sao không dùng \Exception?

`\Exception` quá generic → mất thông tin domain

👉 Ví dụ:

* Validation error ≠ Business rule error ≠ External API error

Nếu dùng chung → hệ thống **không thể phân biệt logic xử lý**

### 2. Exception = Domain Language

Ở level senior:

👉 Exception KHÔNG phải chỉ là lỗi
👉 Nó là **ngôn ngữ của domain**

Ví dụ:

* `DuplicateEmailException` → business rule
* `PaymentFailedException` → external system

➡️ Code trở nên **self-documenting**

### 3. Carry Data (rất quan trọng)

Custom exception có thể mang theo data:

```php
$e->getErrors();
$e->getEmail();
```

👉 Đây là điểm khác biệt cực lớn so với string message

### 4. Type-safe handling

```php
catch (ValidationException $e)
```

👉 IDE + static analysis:

* biết chắc loại lỗi
* autocomplete
* tránh bug runtime

### 5. Mapping HTTP chuẩn REST

| Exception               | HTTP Code |
| ----------------------- | --------- |
| ValidationException     | 422       |
| DuplicateEmailException | 409       |
| PaymentFailedException  | 402       |

👉 Đây là cách design API chuẩn production

## Tips & Tricks

### 1. Tạo Base Domain Exception

```php
abstract class DomainException extends \RuntimeException {}
```

👉 Tất cả exception trong domain nên extend từ đây

### 2. Không throw Exception ở Infrastructure bừa bãi

👉 Convert sang domain exception

Ví dụ:

```php
try {
    $paymentGateway->charge();
} catch (\Throwable $e) {
    throw new PaymentFailedException('Gateway error');
}
```

### 3. Không dùng Exception cho flow control

Sai:

```php
try {
    findUser();
} catch (NotFoundException $e) {
    // logic bình thường
}
```

👉 Exception chỉ dùng cho **unexpected errors** hoặc **business rule violation**

### 4. Naming chuẩn

* Luôn kết thúc bằng `Exception`
* Tên phải mô tả rõ business

### 5. Laravel Best Practice

👉 Dùng Exception + Handler:

```php
public function render($request, Throwable $e)
{
    if ($e instanceof ValidationException) {
        return response()->json([...], 422);
    }
}
```

Centralized error handling

## Interview Questions

**Basic**

<details>
  <summary>1. Exception và RuntimeException khác nhau như thế nào?</summary>

  **Trả lời ngắn (summary):**

* `Exception` là base class chung
* `RuntimeException` thường dùng cho lỗi xảy ra trong runtime

**Trả lời chi tiết (deep):**
Trong PHP, cả hai đều là throwable. Tuy nhiên theo convention:

* `Exception`: dùng cho lỗi tổng quát
* `RuntimeException`: dùng cho lỗi runtime (business, external, logic)

👉 Best practice: dùng `RuntimeException` cho domain exception
</details>

<details>
  <summary>2. Tại sao không nên dùng generic Exception?</summary>

  **Summary:**

* Không phân biệt được loại lỗi
* Khó maintain

  **Deep:**
  Khi dùng `\Exception`, bạn mất:

* Type safety
* Context
* Khả năng handle riêng từng case

  👉 Hệ quả: phải parse message → fragile

</details>

**Intermediate**

<details>
  <summary>3. Custom Exception giúp gì cho maintainability?</summary>

  **Summary:**

* Code rõ ràng
* Dễ mở rộng

  **Deep:**

* Mỗi exception = 1 business rule
* Thêm logic mới không phá code cũ (OCP)

</details>

<details>
  <summary>4. Khi nào nên tạo một Exception mới?</summary>
  
  **Summary:**

* Khi có logic xử lý khác biệt

**Deep:**

* Business rule riêng
* HTTP response khác
* Cần carry data

👉 Không tạo nếu chỉ khác message
</details>

<details>
  <summary>5. Thiết kế hierarchy exception như thế nào?</summary>

  **Summary:**

* Có base class
* Phân tầng rõ

**Deep:**

```php
abstract class DomainException extends RuntimeException {}
class ValidationException extends DomainException {}
class BusinessException extends DomainException {}
```

</details>

**Advanced**

<details>
  <summary>6. Mapping exception sang HTTP response như thế nào?</summary>

  **Summary:**

* Map theo loại lỗi

**Deep:**

* Validation → 422
* Conflict → 409
* Payment → 402

👉 Centralize ở Handler
</details>

<details>
  <summary>7. Exception có nên nằm trong Domain Layer không?</summary>

  **Summary:**

* Có

**Deep:**
Exception là domain language (DDD), thể hiện business rule violation
</details>

<details>
  <summary>8. Xử lý exception trong distributed system?</summary>

  **Summary:**

* Không expose trực tiếp

**Deep:**

* Convert → response
* Log + correlation ID

</details>

<details>
  <summary>9. Exception vs Error Code?</summary>

  **Summary:**

* Exception tốt hơn trong OOP

**Deep:**

| Exception | Error Code |
| --------- | ---------- |
| Type-safe | Không      |
| Clean     | Messy      |

</details>

## Kết luận

👉 Custom Exceptions là nền tảng của:

* Clean Architecture
* Domain-Driven Design
* Maintainable codebase

Nếu bạn vẫn đang dùng `\Exception` everywhere → bạn đang giới hạn khả năng scale hệ thống
