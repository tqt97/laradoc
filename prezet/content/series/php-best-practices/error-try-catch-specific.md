---
title: Catch Specific Exceptions (Bắt exception đúng loại)
excerpt: Tìm hiểu cách catch exception đúng cách trong PHP để tránh swallow lỗi, improve debugging và thiết kế hệ thống ổn định.
category: PHP Best Practices
date: 2025-09-23
order: 5
image: /prezet/img/ogimages/series-php-best-practices-error-try-catch-specific.webp
---

## Nguyên tắc cốt lõi

👉 Chỉ catch những exception bạn hiểu và có thể xử lý

👉 Không bao giờ catch `\Exception` hoặc `\Throwable` trừ khi ở boundary (top-level)

## Bad Example (Anti-pattern)

```php
try {
    $user = $repository->find($id);
    $mailer->sendWelcome($user);
} catch (\Exception $e) {
    return null; // Nuốt toàn bộ lỗi
}
```

### Vấn đề

* Không biết lỗi gì xảy ra
* Bug bị che giấu
* Debug cực khó

```php
try {
    $result = $service->process($data);
} catch (\Throwable $e) {
    return 'Something went wrong';
}
```

### Nguy hiểm

* Catch luôn cả `Error` (TypeError, OOM...)
* Che mất lỗi nghiêm trọng của hệ thống

## Good Example (Best Practice)

### 1. Catch cụ thể

```php
try {
    $user = $repository->find($id);
    $mailer->sendWelcome($user);
} catch (UserNotFoundException $e) {
    $logger->warning('User not found', ['id' => $id]);
    return null;
} catch (MailerException $e) {
    $logger->error('Email failed', ['error' => $e->getMessage()]);
}
```

### 2. Multi-catch (PHP 8+)

```php
try {
    $data = $api->fetch($endpoint);
} catch (ConnectionException | TimeoutException $e) {
    throw new ServiceUnavailableException('External down', previous: $e);
}
```

👉 Gộp các exception có cùng cách xử lý

### 3. Top-level boundary

```php
try {
    $response = $kernel->handle($request);
} catch (\Throwable $e) {
    $logger->critical('Unhandled exception', [
        'message' => $e->getMessage(),
    ]);

    return new Response('Internal Server Error', 500);
}
```

👉 Đây là nơi DUY NHẤT nên catch rộng

## Giải thích sâu (Senior mindset)

### 1. Swallowing Exception = Bug

Nếu bạn catch mà không:

* log
* rethrow

👉 bạn đang **che bug**

### 2. Exception Flow Design

Flow chuẩn:

* Domain throw exception
* Application decide xử lý
* Infrastructure log
* Boundary trả response

### 3. Khi nào KHÔNG nên catch?

👉 Khi bạn không biết xử lý

→ để exception bubble up

### 4. previous exception (rất quan trọng)

```php
throw new ServiceException('API fail', previous: $e);
```

👉 Giữ full trace chain

### 5. Error vs Exception

* Exception: business / logic
* Error: system (TypeError, Memory)

👉 Không nên catch Error trừ khi ở boundary

## Tips & Tricks

### 1. Rule đơn giản

👉 “Can I handle it?”

* Yes → catch
* No → throw

### 2. Always log khi catch

```php
$logger->error(...);
```

### 3. Không return silent

```php
catch (...) {
    return null;
}
```

### 4. Laravel best practice

* Không catch trong service nếu không cần
* Dùng global handler

#### 5. Retry strategy

Chỉ retry với:

* Timeout
* Connection

Không retry với:

* Validation

## Interview Questions

<details>
  <summary>1. Tại sao không nên catch Exception chung?</summary>

**Summary:**

* Che bug

**Deep:**
Không biết lỗi gì xảy ra → khó debug, sai logic xử lý

</details>

<details>
  <summary>2. Khi nào nên catch Throwable?</summary>

**Summary:**

* Ở top-level

**Deep:**
Controller, middleware, worker → để tránh crash toàn hệ thống

</details>

<details>
  <summary>3. Multi-catch là gì?</summary>

**Summary:**

* Bắt nhiều exception cùng lúc

**Deep:**
PHP 8 hỗ trợ `catch (A | B $e)` → giảm duplicate code

</details>

<details>
  <summary>4. previous exception dùng để làm gì?</summary>

**Summary:**

* Giữ trace

**Deep:**
Giúp debug chain exception đầy đủ

</details>

<details>
  <summary>5. Khi nào nên để exception bubble up?</summary>

**Summary:**

* Khi không xử lý được

**Deep:**
Để tầng trên handle đúng context

</details>

## Kết luận

* Catch sai = bug ẩn
* Catch đúng = hệ thống rõ ràng, dễ debug, production-ready
