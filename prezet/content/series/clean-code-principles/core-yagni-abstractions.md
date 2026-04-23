---
title: YAGNI trong Abstraction là gì? Tránh over-engineering và thiết kế đúng chuẩn Senior/Architect
excerpt: "Hiểu sâu YAGNI khi thiết kế abstraction: tránh over-engineering, áp dụng Rule of Three, refactor đúng thời điểm trong PHP và Laravel, kèm ví dụ thực tế và kinh nghiệm production."
tags: [YAGNI, premature-abstraction, simplicity]
date: 2025-10-10
order: 10
image: /prezet/img/ogimages/series-clean-code-principles-core-yagni-abstractions.webp
---

## YAGNI Principle - Abstractions

> **YAGNI (You Aren’t Gonna Need It)** trong context abstraction nghĩa là:
> **Đừng tạo abstraction khi bạn chưa thực sự cần nó.**

Đây là một trong những nguyên lý bị hiểu sai nhiều nhất và là nguyên nhân chính dẫn đến over-engineering trong các hệ thống thực tế.

## 1. Bản chất của YAGNI trong Abstraction

#### 1.1 Hiểu sai phổ biến

* Viết interface trước cho "chuẩn"
* Thiết kế cho tương lai
* Code reusable ngay từ đầu

Thực tế:

> Phần lớn abstraction sớm là sai abstraction

#### 1.2 Định nghĩa chuẩn

* Không abstract khi chưa có pattern rõ ràng
* Không design cho “có thể sẽ cần”
* Chỉ abstract khi có duplication và variation thực tế

## 2. Premature Abstraction

#### 2.1 Nguy hiểm

* Không hiểu domain
* Khó refactor
* Tăng complexity

> Sai abstraction tệ hơn duplication

## 3. Rule of Three

> Chỉ abstract khi có ít nhất 3 implementation thực tế

* 2 → có thể trùng hợp
* 3 → pattern rõ ràng

## 4. Ví dụ PHP thực tế

#### Sai

```php
interface PaymentGatewayInterface {}
interface PaymentStrategyInterface {}
```

#### Đúng

```php
class StripePaymentService {
    public function charge(int $amount): void {}
}
```

## 5. Áp dụng trong Laravel

#### Sai lầm phổ biến

```php
interface UserRepositoryInterface {}
class UserRepository implements UserRepositoryInterface {}
```

Không có nhiều implementation → abstraction dư thừa

#### Khi nào nên dùng

* Multiple data source
* Complex domain
* Cần test isolation

## 6. Tips

* Delay abstraction
* Refactor thay vì design upfront
* Tránh naming generic
* Ưu tiên duplication nhỏ

## 7. Interview Questions

<details>
  <summary>YAGNI là gì?</summary>

**Summary:**

* Không build thứ chưa cần

**Deep:**

* Tránh speculative design

</details>

<details>
  <summary>Rule of Three là gì?</summary>

**Summary:**

* 3 lần mới abstract

**Deep:**

* Giảm risk sai abstraction

</details>

## 8. Kết luận

YAGNI giúp hệ thống giữ được sự đơn giản, tránh over-engineering và cho phép design tiến hóa theo nhu cầu thực tế.
