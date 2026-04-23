---
title: Law of Demeter là gì? Giải thích chi tiết + áp dụng Laravel
excerpt: "Tìm hiểu Law of Demeter (LoD) từ cơ bản đến nâng cao: giảm coupling, tối ưu thiết kế, tránh N+1 trong Laravel, kèm ví dụ PHP thực tế và cách refactor chuẩn Senior/Architect."
tags: [law-of-demeter, coupling, encapsulation, laravel]
date: 2025-10-09
order: 8
image: /prezet/img/ogimages/series-clean-code-principles-core-law-demeter.webp
---

# Law of Demeter (Nguyên lý Demeter) - Chuyên sâu

## 1. Bản chất thật sự của Law of Demeter

Định nghĩa cơ bản:

> Chỉ nói chuyện với những đối tượng trực tiếp (immediate friends), không nói chuyện với người lạ.

Nhưng ở level Senior/Staff, cần hiểu sâu hơn:

**"Một module chỉ nên phụ thuộc vào những gì nó trực tiếp sở hữu hoặc được inject vào."**

## 2. Vấn đề thực sự mà LoD giải quyết

Nếu không áp dụng LoD, bạn sẽ gặp:

### Structural Coupling (coupling cấu trúc)

Code phụ thuộc vào cấu trúc object bên trong

### Temporal Coupling (phụ thuộc thứ tự gọi)

Gọi sai thứ tự → bug

### Ripple Effect (hiệu ứng dây chuyền)

```txt
Order → Customer → Address → Country → TaxRules
```

Chỉ cần đổi `TaxRules` → toàn bộ hệ thống có thể vỡ

## 3. Chi phí ẩn khi vi phạm LoD

### 3.1 Code cực kỳ dễ vỡ

```php
$order->customer->address->country->taxRules->vatRate;
```

Chỉ cần:

* đổi tên field
* đổi quan hệ
* đổi logic

vỡ hàng loạt

### 3.2 Không thể refactor

Bạn KHÔNG thể:

* đổi structure
* tối ưu performance
* thay implementation

vì quá nhiều nơi phụ thuộc sâu

### 3.3 Performance issue trong Laravel

```php
$order->customer->address->country;
```

Có thể gây **N+1 query** mà bạn không nhận ra

Đây là lỗi rất phổ biến ở dev mid-level

## 4. Ví dụ PHP thuần (phân tích chi tiết)

### Sai (vi phạm LoD)

```php
class Order
{
    public function calculateTax(): float
    {
        return $this->customer
            ->getAddress()
            ->getCountry()
            ->getTaxRules()
            ->calculate($this->getTotal());
    }
}
```

### Phân tích từng dòng

```php
$this->customer
```

OK (dependency trực tiếp)

```php
->getAddress()
```

bắt đầu lộ structure

```php
->getCountry()
```

coupling sâu hơn

```php
->getTaxRules()
```

Order biết luôn business logic 😬

Đây là dấu hiệu design kém

## 5. Cách đúng (Encapsulation + LoD)

```php
class Customer
{
    private Address $address;

    public function calculateTax(float $amount): float
    {
        return $this->address->calculateTax($amount);
    }
}
```

```php
class Address
{
    private Country $country;

    public function calculateTax(float $amount): float
    {
        return $this->country->calculateTax($amount);
    }
}
```

```php
class Order
{
    private Customer $customer;

    public function calculateTax(): float
    {
        return $this->customer->calculateTax($this->getTotal());
    }
}
```

### Insight quan trọng

* Order chỉ biết Customer
* Customer che Address
* Address che Country

Đây chính là encapsulation đúng nghĩa

## 6. Nguyên lý nền tảng liên quan

### 6.1 Encapsulation (cốt lõi)

LoD = hệ quả trực tiếp của encapsulation

### 6.2 SRP (Single Responsibility)

* Order → xử lý order
* Customer → logic khách hàng
* Address → địa chỉ

LoD giúp enforce SRP tự nhiên

### 6.3 Tell, Don’t Ask

❌ Ask:

```php
if ($customer->getWallet()->getBalance() > 100)
```

✅ Tell:

```php
if ($customer->canAfford(100))
```

Đây là mindset cực kỳ quan trọng

## 7. Laravel Deep Dive

### Anti-pattern phổ biến

```php
$order->user->profile->company->address->country;
```

### Vấn đề

1. Hidden query
2. Coupling mạnh
3. Dễ vỡ khi thay đổi relationship

## 8. Cách đúng trong Laravel

### Step 1: Đóng gói trong Model

```php
class User extends Model
{
    public function getCountryName(): string
    {
        return $this->profile
            ->company
            ->address
            ->country
            ->name;
    }
}
```

### Step 2: Sử dụng

```php
$order->user->getCountryName();
```

Controller không biết structure bên trong

## 9. Level cao hơn (Senior/Architect)

Tách sang Domain Service

```php
class TaxService
{
    public function calculateForUser(User $user, float $amount): float
    {
        $country = $user->getCountry();

        return $this->getTaxRate($country) * $amount;
    }

    private function getTaxRate(string $country): float
    {
        return match ($country) {
            'US' => 0.1,
            'VN' => 0.08,
            default => 0.05,
        };
    }
}
```

Tách rõ:

* User = data
* TaxService = business logic

## 10. LoD vs Eloquent (thực tế)

Laravel cho phép:

```php
$user->posts->first()->comments;
```

technically sai LoD

Nhưng chấp nhận khi:

* đọc dữ liệu
* đơn giản

### Quy tắc thực tế

| Context        | Áp dụng LoD  |
| -------------- | ------------ |
| Business logic | BẮT BUỘC     |
| Controller     | Cân nhắc     |
| Blade view     | Có thể relax |

## 11. Refactor thực chiến

### Bước 1: Detect smell

```txt
->()->()->()
```

> > 2 level → cảnh báo

### Bước 2: Đưa behavior vào trong

```php
$order->user->wallet->balance;
```

->

```php
$order->user->getBalance();
```

### Bước 3: Đẩy logic xuống sâu hơn

```php
$order->user->canAfford($amount);
```

### Bước 4: Tách service

```php
$paymentService->charge($user, $amount);
```

## 12. Khi KHÔNG cần áp dụng quá chặt

### 12.1 DTO

```php
$response->data->user->name;
```

OK

### 12.2 Query read-only

```php
User::with('profile.company')->get();
```

OK

### 12.3 Performance tuning

Join trực tiếp đôi khi tốt hơn

## 13. Câu hỏi phỏng vấn (Senior)

### Q1

Law of Demeter là gì?

giảm coupling, tăng encapsulation

### Q2

Eloquent chain có vi phạm không?

Có, nhưng chấp nhận trong read

### Q3

LoD ảnh hưởng performance thế nào?

N+1 query

### Q4

Tell Don’t Ask liên quan gì?

Là cách áp dụng LoD trong behavior

## 14. Tổng kết

* LoD = kiểm soát dependency
* Tránh chain sâu trong business logic
* Đẩy behavior vào object

Mindset Senior:

**"Object nên expose behavior, không expose structure."**
