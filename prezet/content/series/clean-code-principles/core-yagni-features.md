---
title: YAGNI - Features là gì? Tránh speculative features, ship nhanh và thiết kế đúng chuẩn Senior/Architect
excerpt: "Hiểu sâu YAGNI khi xây dựng feature: tránh speculative features, tối ưu delivery, giảm technical debt, áp dụng trong PHP và Laravel với mindset Senior/Architect, kèm case study thực tế và interview questions"
tags: [YAGNI, premature-abstraction, simplicity]
date: 2025-10-11
order: 11
image: /prezet/img/ogimages/series-clean-code-principles-core-yagni-features.webp
---

## YAGNI Principle - Features

> **You Aren't Gonna Need It** — Đừng xây dựng feature cho đến khi nó thực sự cần thiết.

Trong thực tế production, phần lớn thời gian bị lãng phí không phải vì code dở, mà vì **xây thứ không ai cần**.

## 1. Bản chất của YAGNI ở level Feature

#### 1.1 “Speculative Feature” là gì?

Là những feature được xây dựa trên:

* "Có thể sau này sẽ cần"
* "Sản phẩm lớn thường có"
* "Best practice nói vậy"

Nhưng không có:

* Requirement rõ ràng
* User thật sự cần
* Business validate

#### 1.2 Định nghĩa chuẩn

YAGNI trong feature nghĩa là:

* Chỉ build khi có requirement rõ ràng
* Không build cho tương lai tưởng tượng
* Ưu tiên shipping hơn perfection

## 2. Anti-pattern: Over-building Product

Ví dụ bạn đưa là điển hình:

* 2FA
* API Key
* Subscription
* Referral
* Loyalty

👉 Nhưng product chỉ cần:

> "Đăng ký user"

#### 2.1 Hệ quả thực tế

* Chậm release
* Code khó đọc
* Tăng bug surface
* Tăng chi phí maintain

> 50%+ speculative features KHÔNG BAO GIỜ được dùng

## 3. Tư duy đúng: Build → Measure → Learn

Đây là tư duy Lean / Startup / Product-driven

#### 3.1 Flow chuẩn

1. Build feature nhỏ nhất (MVP)
2. Ship nhanh
3. Lấy feedback
4. Iterate

#### 3.2 Sai lầm phổ biến của dev

* Nghĩ mình là product owner
* Dự đoán tương lai thay vì validate
* Optimize trước khi cần

## 4. Ví dụ PHP thực tế

#### Sai (over-feature)

```php
class UserService
{
    public function enableTwoFactor() {}
    public function generateApiKey() {}
    public function manageSessions() {}
    public function upgradeSubscription() {}
}
```

#### Đúng (focus)

```php
class UserService
{
    public function register(string $email, string $password): User
    {
        // validate
        // hash password
        // save
        // send email
    }
}
```

## 5. Áp dụng trong Laravel

#### 5.1 Sai lầm phổ biến

Migration ngay từ đầu:

```php
$table->string('phone')->nullable();
$table->json('preferences')->nullable();
$table->boolean('two_factor_enabled');
$table->string('referral_code');
```

👉 Nhưng chưa có feature nào dùng

#### 5.2 Đúng theo YAGNI

```php
$table->id();
$table->string('email');
$table->string('password');
```

#### 5.3 Khi feature xuất hiện

* Add migration sau
* Refactor domain
* Không đoán trước

## 6. Evolutionary Design (thiết kế tiến hóa)

#### 6.1 Step by step

###### Step 1

User basic

###### Step 2

Add email verification

###### Step 3

Add 2FA

👉 Mỗi step đều có context thật

#### 6.2 Ưu điểm

* Code fit requirement
* Ít bug
* Dễ refactor

## 7. Trade-off (Senior mindset)

#### 7.1 YAGNI KHÔNG phải luôn đúng 100%

Có trường hợp nên prepare trước:

###### ✔ Regulatory

* Audit log
* Security

###### ✔ High-cost change

* Database schema khó migrate

###### ✔ Known roadmap (confirmed)

#### 7.2 Quy tắc

> Prepare when cost of change is HIGH and probability is HIGH

## 8. Real-world case study

#### 8.1 Startup chết vì overbuild

* Build full subscription system
* Không có user

=> Waste toàn bộ effort

#### 8.2 Product thành công

* Start với 1 feature
* Iterate liên tục

=> Scale tự nhiên

## 9. Checklist trước khi build feature

* Có requirement rõ chưa?
* Có user cần chưa?
* Có business validate chưa?
* Có metric đo không?

👉 Nếu không → chưa build

## 10. Tips & Tricks

#### 10.1 Feature toggle

Build nhưng ẩn

#### 10.2 Spike trước

Test idea nhỏ

#### 10.3 Vertical slice

Build end-to-end nhỏ nhất

#### 10.4 Avoid config overkill

Không tạo config cho feature chưa có

## 11. Interview Questions

<details>
  <summary>1. YAGNI là gì?</summary>

**Summary:**

* Không build feature chưa cần

**Deep:**

* Tránh speculative development
* Tối ưu delivery

</details>

<details>
  <summary>2. Speculative feature là gì?</summary>

**Summary:**

* Feature dự đoán

**Deep:**

* Không có requirement
* Không có user

</details>

<details>
  <summary>3. Tại sao không nên build trước?</summary>

**Summary:**

* Waste time

**Deep:**

* Không dùng
* Tăng complexity

</details>

<details>
  <summary>4. Khi nào nên build trước?</summary>

**Summary:**

* Khi cost change cao

**Deep:**

* Regulatory
* Known roadmap

</details>

<details>
  <summary>5. YAGNI vs Agile?</summary>

**Summary:**

* Rất liên quan

**Deep:**

* Agile = iterative
* YAGNI = không overbuild

</details>

## 12. Kết luận

YAGNI trong feature giúp bạn:

* Ship nhanh hơn
* Code gọn hơn
* Ít bug hơn
* Product fit hơn

Đây là mindset quan trọng để chuyển từ dev sang product-minded engineer.
