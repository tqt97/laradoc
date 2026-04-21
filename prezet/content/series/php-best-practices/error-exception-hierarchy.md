---
title: Exception Hierarchy – Thiết kế hệ thống exception chuẩn Senior
excerpt: Tìm hiểu cách thiết kế Exception Hierarchy trong PHP giúp xử lý lỗi theo tầng, clean architecture, dễ mở rộng. Kèm ví dụ, giải thích sâu, tips và câu hỏi phỏng vấn.
category: PHP Best Practices
date: 2025-09-21
order: 3
image: /prezet/img/ogimages/series-php-best-practices-error-exception-hierarchy.webp
---

> Tìm hiểu cách thiết kế Exception Hierarchy trong PHP giúp xử lý lỗi theo tầng, clean architecture, dễ mở rộng. Kèm ví dụ, giải thích sâu, tips và câu hỏi phỏng vấn.

## Exception Hierarchy là gì?

Exception Hierarchy là việc **tổ chức các exception theo dạng cây kế thừa (inheritance tree)** thay vì để tất cả ở dạng “flat”.

👉 Mục tiêu:

* Cho phép **catch theo nhiều level (broad → specific)**
* Tái sử dụng logic xử lý lỗi
* Phản ánh đúng domain

## Bad Example (Anti-pattern)

```php
class UserNotFoundException extends \Exception {}
class OrderNotFoundException extends \Exception {}
class ProductNotFoundException extends \Exception {}
class InvalidEmailException extends \Exception {}
class InvalidPriceException extends \Exception {}
class DatabaseConnectionException extends \Exception {}
class ApiTimeoutException extends \Exception {}
```

**Vấn đề**

* Không có quan hệ giữa các exception
* Không thể catch theo nhóm
* Vi phạm DRY (lặp lại logic xử lý)
* Khó mở rộng khi hệ thống lớn

👉 Caller phải catch từng exception riêng lẻ → code rối

## Good Example (Best Practice)

**Base Exception**

```php
class AppException extends \RuntimeException {}
```

👉 Tất cả exception trong app nên extend từ đây

**Nhóm NotFound**

```php
class NotFoundException extends AppException
{
    public function __construct(
        private string $entity,
        private string|int $identifier,
    ) {
        parent::__construct("{$entity} not found: {$identifier}");
    }
}

class UserNotFoundException extends NotFoundException {}
class OrderNotFoundException extends NotFoundException {}
```

👉 Tất cả “not found” dùng chung logic

**Nhóm Validation**

```php
class ValidationException extends AppException
{
    public function __construct(private array $errors = [])
    {
        parent::__construct('Validation failed');
    }

    public function getErrors(): array
    {
        return $this->errors;
    }
}
```

**Nhóm Infrastructure**

```php
class InfrastructureException extends AppException {}
class DatabaseException extends InfrastructureException {}
class ExternalApiException extends InfrastructureException {}
```

👉 Tách rõ domain vs external system

**Caller Handling**

```php
try {
    $service->processOrder($data);
} catch (NotFoundException $e) {
    return response()->json(['error' => $e->getMessage()], 404);
} catch (ValidationException $e) {
    return response()->json(['errors' => $e->getErrors()], 422);
} catch (InfrastructureException $e) {
    $logger->error($e->getMessage());
    return response()->json(['error' => 'Service unavailable'], 503);
}
```

👉 Catch theo layer → cực kỳ clean

## Giải thích sâu

**Layered Catching**

Bạn có thể:

* Catch cụ thể (`UserNotFoundException`)
* Hoặc catch theo nhóm (`NotFoundException`)

👉 Đây là sức mạnh của OOP

**DRY Error Handling**

Tất cả lỗi “not found”:

```php
catch (NotFoundException $e)
```

👉 Không cần viết lại nhiều lần

**Domain Modeling**

Exception hierarchy = domain model

Ví dụ:

* NotFound → Business
* Validation → Input
* Infrastructure → External

👉 Đây là DDD mindset

**Extensibility**

Thêm:

```php
class ProductNotFoundException extends NotFoundException {}
```

👉 Không cần sửa code cũ

**RuntimeException vs Exception**

👉 Luôn extend `RuntimeException` cho:

* Business errors
* External failures

## Tips & Tricks

**Không để exception “flat”**

👉 Luôn có base + phân nhóm

**Phân tách rõ 3 layer**

* Domain Exception
* Application Exception
* Infrastructure Exception

**Logging chỉ ở Infrastructure**

👉 Không log domain error như validation

**Combine với Laravel Handler**

Centralize toàn bộ xử lý exception

**Không over-engineer**

👉 Nhỏ thì không cần hierarchy phức tạp

## Interview Questions

<details>
  <summary>1. Exception Hierarchy là gì và tại sao cần?</summary>

**Summary:**

* Là tổ chức exception theo cây kế thừa
* Giúp catch theo nhiều level

**Deep:**
Exception hierarchy giúp:

* Group các lỗi liên quan
* Tái sử dụng logic
* Clean architecture

👉 Là best practice ở level senior

</details>

<details>
  <summary>2. Flat exception có vấn đề gì?</summary>

**Summary:**

* Không grouping
* Code lặp

**Deep:**
Flat exception khiến:

* Không thể catch theo nhóm
* Code bị duplication
* Khó maintain khi scale

</details>

<details>
  <summary>3. Khi nào nên catch exception ở level cha?</summary>

**Summary:**

* Khi logic xử lý giống nhau

**Deep:**
Ví dụ tất cả NotFound → trả 404

👉 Không cần catch từng loại

</details>

<details>
  <summary>4. Có nên tạo quá nhiều exception không?</summary>

**Summary:**

* Không

**Deep:**

* Tạo khi có logic khác biệt
* Không tạo chỉ vì khác message

</details>

<details>
  <summary>5. Exception hierarchy liên quan gì đến DDD?</summary>

**Summary:**

* Là domain language

**Deep:**
Exception phản ánh business rule → là 1 phần của domain model

</details>

<details>
  <summary>6. Làm sao design exception cho microservice?</summary>

**Summary:**

* Convert sang response

**Deep:**

* Không expose internal exception
* Dùng error code + message chuẩn hóa

</details>

<details>
  <summary>7. Có nên catch Exception tổng không?</summary>

**Summary:**

* Có, nhưng ở boundary

**Deep:**
Chỉ catch `Throwable` ở:

* Controller
* Worker

👉 Không catch deep trong domain

</details>

## Kết luận

👉 Exception Hierarchy giúp:

* Clean code
* Scalable system
* Maintainable architecture

Nếu bạn vẫn đang dùng exception dạng flat → hệ thống sẽ rất khó scale
