---
title: DRY là gì? Code Extraction trong PHP & Laravel từ cơ bản đến nâng cao
excerpt: Hiểu sâu nguyên lý DRY và kỹ thuật code extraction trong PHP và Laravel, từ ví dụ cơ bản đến kiến trúc hệ thống, best practices và pitfalls.
category: Clean Code Principles
date: 2025-10-02
order: 3
image: /prezet/img/ogimages/series-clean-code-principles-core-dry-extraction.webp
---

**Nguyên tắc cốt lõi:**

> Don't Repeat Yourself — Mỗi "kiến thức" chỉ nên tồn tại **một nơi duy nhất** trong hệ thống.

## Phần 1: Hiểu đúng bản chất DRY (rất nhiều dev hiểu sai)

#### DRY không phải chỉ là "không copy code"

DRY thực chất là:

* Không lặp **logic business**
* Không lặp **rule**
* Không lặp **knowledge**

Ví dụ:

```php
if ($password.length < 8) {}
```

→ Đây không phải là code
→ Đây là **rule business**

## Phần 2: Ví dụ sai (PHP thuần)

```php
class UserService {

    public function create(array $data) {
        // validate email
        if (!isset($data['email'])) {
            throw new Exception('Email required');
        }

        if (!str_contains($data['email'], '@')) {
            throw new Exception('Invalid email');
        }

        // validate password
        if (strlen($data['password']) < 8) {
            throw new Exception('Password too short');
        }
    }

    public function update(array $data) {
        // ❌ duplicate logic
        if (isset($data['email']) && !str_contains($data['email'], '@')) {
            throw new Exception('Invalid email');
        }

        if (isset($data['password']) && strlen($data['password']) < 8) {
            throw new Exception('Password too short');
        }
    }
}
```

#### Vấn đề thực sự

##### 1. Bug duplication

* Fix 1 nơi → quên nơi khác

##### 2. Logic drift

* create vs update validate khác nhau

##### 3. Không test được

* Logic nằm rải rác

## Phần 3: Refactor bằng Code Extraction

#### Step 1: Tách validation thành function

```php
class Validator {

    public static function validateEmail(?string $email, bool $required = false): array {
        $errors = [];

        if (!$email) {
            if ($required) {
                $errors[] = 'Email is required';
            }
            return $errors;
        }

        if (!str_contains($email, '@')) {
            $errors[] = 'Invalid email format';
        }

        if (strlen($email) > 255) {
            $errors[] = 'Email too long';
        }

        return $errors;
    }

    public static function validatePassword(?string $password, bool $required = false): array {
        $errors = [];

        if (!$password) {
            if ($required) {
                $errors[] = 'Password is required';
            }
            return $errors;
        }

        if (strlen($password) < 8) {
            $errors[] = 'Password must be at least 8 characters';
        }

        if (!preg_match('/[A-Z]/', $password)) {
            $errors[] = 'Must contain uppercase';
        }

        return $errors;
    }
}
```

#### Step 2: Sử dụng lại

```php
class UserService {

    public function create(array $data) {
        $errors = array_merge(
            Validator::validateEmail($data['email'] ?? null, true),
            Validator::validatePassword($data['password'] ?? null, true)
        );

        if (!empty($errors)) {
            throw new Exception(json_encode($errors));
        }
    }

    public function update(array $data) {
        $errors = array_merge(
            Validator::validateEmail($data['email'] ?? null),
            Validator::validatePassword($data['password'] ?? null)
        );

        if (!empty($errors)) {
            throw new Exception(json_encode($errors));
        }
    }
}
```

## Phân tích sâu (rất quan trọng)

#### 1. Single Source of Truth

* Rule password nằm 1 chỗ

#### 2. SRP

* Validator chỉ làm validation
* Service chỉ xử lý business

#### 3. Testability

```php
Validator::validateEmail('abc');
```

→ test độc lập

#### 4. Reusability

* Dùng ở API, CLI, Queue

## Phần 4: Nâng cấp lên Strategy (advanced)

```php
interface Rule {
    public function validate($value): array;
}

class EmailRule implements Rule {
    public function validate($value): array {
        if (!str_contains($value, '@')) {
            return ['Invalid email'];
        }
        return [];
    }
}
```

→ composition + DRY

## Phần 5: Mapping sang Laravel

#### 1. Form Request (best practice)

```php
class CreateUserRequest extends FormRequest {
    public function rules() {
        return [
            'email' => 'required|email|max:255',
            'password' => 'required|min:8'
        ];
    }
}
```

→ DRY: rules centralized

#### 2. Custom Rule

```php
class StrongPassword implements Rule {
    public function passes($attribute, $value) {
        return preg_match('/[A-Z]/', $value);
    }
}
```

#### 3. Service Layer

* Không validate trong controller
* Tách ra

#### 4. Reuse trong toàn hệ thống

* API
* Job
* Command

## Phần 6: Khi nào nên extract?

#### Rule of 3

* Lặp 3 lần → extract

#### Khi logic có ý nghĩa

* Business rule

## Khi nào KHÔNG nên DRY?

#### 1. Premature abstraction

* Code mới → chưa rõ pattern

#### 2. Over-generalization

* Function quá generic

## Pitfalls

#### 1. DRY sai level

* Extract sai abstraction

#### 2. Shared code nhưng khác behavior

* → bug logic

## Advanced Insight

#### 1. DRY vs WET vs AHA

* DRY: tránh lặp
* AHA: tránh abstraction sớm

#### 2. DRY trong system design

* Central config
* Shared library

## Câu hỏi phỏng vấn

<details>
  <summary>1. DRY là gì?</summary>

**Summary:**

* Không lặp knowledge

**Deep:**

* Single source of truth
* Giảm bug

</details>

<details>
  <summary>2. Khi nào không nên DRY?</summary>

**Summary:**

* Khi chưa rõ abstraction

**Deep:**

* Premature optimization

</details>

<details>
  <summary>3. Laravel hỗ trợ DRY như thế nào?</summary>

**Summary:**

* FormRequest

**Deep:**

* Rule
* Service
* Validator

</details>

## Kết luận

DRY không phải là giảm số dòng code.

Nó là:

> Giảm số nơi chứa logic.

Nếu 1 rule tồn tại ở 2 nơi → system của bạn đang có bug tiềm ẩn.
