---
title: Specification Pattern - Đóng gói quy tắc nghiệp vụ
excerpt: Tìm hiểu Specification Pattern - giải pháp quản lý Business Rules phức tạp, cách xây dựng hệ thống lọc dữ liệu linh hoạt và dễ lắp ghép trong Laravel.
category: Design pattern
date: 2026-03-28
order: 21
image: /prezet/img/ogimages/series-design-pattern-specification-pattern.webp
---

> Pattern thuộc nhóm **Behavioral Pattern (Hành vi)** hoặc **Domain Pattern**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang xây dựng một hệ thống ngân hàng. Bạn có quy tắc để xác định một "Khách hàng ưu tiên":

1. Có số dư trên 1 tỷ VNĐ.
2. Đã sử dụng dịch vụ trên 5 năm.
3. Không có nợ xấu.

**Vấn đề:** Quy tắc này được dùng ở rất nhiều nơi:

* Trong Controller để hiển thị badge "VIP".
* Trong CampaignService để gửi khuyến mãi.
* Trong Database Query để lọc danh sách.

**Naive Solution:** Viết các câu lệnh `if` hoặc `where` rải rác khắp nơi.

```php
// Ở Controller
if ($user->balance > 1000000000 && $user->created_at < now()->subYears(5) ...)

// Ở Query
$vips = User::where('balance', '>', 1000000000)->where(...)
```

**Hệ quả:** Khi sếp đổi quy tắc (ví dụ: số dư chỉ cần 500 triệu) → Bạn phải đi tìm và sửa ở 10 file khác nhau. Rất dễ sót!

## 2. Định nghĩa

**Specification Pattern** cho phép bạn đóng gói một quy tắc nghiệp vụ (Business Rule) vào một đối tượng riêng biệt. Đối tượng này có một phương thức duy nhất (thường là `isSatisfiedBy`) nhận vào một ứng viên và trả về `true` hoặc `false`.

**Ý tưởng cốt lõi:** Biến quy tắc thành **đối tượng có thể lắp ghép** (And, Or, Not).

## 3. Implementation (PHP Clean Code)

### 3.1 Interface cơ bản

```php
interface UserSpecification {
    public function isSatisfiedBy(User $user): bool;
}
```

### 3.2 Các quy tắc cụ thể (Atomic Specifications)

```php
class HighBalanceSpecification implements UserSpecification {
    public function isSatisfiedBy(User $user): bool {
        return $user->balance > 1000000000;
    }
}

class OldCustomerSpecification implements UserSpecification {
    public function isSatisfiedBy(User $user): bool {
        return $user->created_at < now()->subYears(5);
    }
}
```

### 3.3 Specification lắp ghép (Composite)

```php
class AndSpecification implements UserSpecification {
    private array $specs;
    public function __construct(UserSpecification ...$specs) { $this->specs = $specs; }

    public function isSatisfiedBy(User $user): bool {
        foreach ($this->specs as $spec) {
            if (!$spec->isSatisfiedBy($user)) return false;
        }
        return true;
    }
}
```

### 3.4 Sử dụng

```php
$vipRule = new AndSpecification(
    new HighBalanceSpecification(),
    new OldCustomerSpecification()
);

if ($vipRule->isSatisfiedBy($currentUser)) {
    echo "Chào mừng VIP!";
}
```

## 4. Liên hệ Laravel

Trong Laravel, Specification Pattern thường được áp dụng kết hợp với **Eloquent Scopes**:

Thay vì viết rule lồng nhau, bạn chia nhỏ thành các `scope`:

```php
class User extends Model {
    public function scopeIsVip($query) {
        return $query->where('balance', '>', 1000000000)->where('created_at', '<', now()->subYears(5));
    }
}

// Sử dụng cực kỳ Clean
$vips = User::isVip()->get();
```

Ngoài ra, khi dùng **Laravel Policies**, bạn thực chất cũng đang áp dụng một dạng của Specification để kiểm tra quyền hạn.

## 5. Khi nào nên dùng

* Khi các quy tắc nghiệp vụ quan trọng và được tái sử dụng ở nhiều nơi (View, Logic, Query).
* Khi các quy tắc cần được kết hợp với nhau một cách linh hoạt (logic AND, OR, NOT).
* Khi bạn muốn tách biệt "Luật chơi" khỏi "Người chơi".

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Tính tái sử dụng cực cao:** Viết một lần, dùng mọi nơi.
* **Dễ Unit Test:** Test từng quy tắc nhỏ cực kỳ đơn giản.
* **Declarative Code:** Code đọc như ngôn ngữ tự nhiên, tập trung vào "Cái gì" chứ không phải "Làm thế nào".

**Nhược điểm:**

* **Tăng số lượng Class:** Mỗi rule nhỏ là một class.
* **Hiệu năng Query:** Nếu chỉ dùng `isSatisfiedBy` trên Collection thì rất chậm với dữ liệu lớn. Cần giải pháp map Specification sang SQL Query.

## 7. Câu hỏi phỏng vấn

1. **Làm thế nào để áp dụng Specification trực tiếp vào Database Query?** (Sử dụng các thư viện như `happyr/doctrine-specification` hoặc tự viết hàm `applyToQuery` trong Specification class).
2. **Specification vs Policy trong Laravel khác nhau gì?** (Policy tập trung vào Authorization - ai được làm gì. Specification tập trung vào Business Logic - đối tượng thỏa mãn điều kiện gì).
3. **Tại sao Specification lại tốt cho DDD (Domain-Driven Design)?** (Vì nó giúp giữ cho Domain Model sạch sẽ, không bị lẫn lộn các logic kiểm tra phức tạp).

## Kết luận

Specification Pattern là cách tốt nhất để "vật chất hóa" các quy tắc nghiệp vụ trừu tượng. Hãy sử dụng nó để biến hệ thống của bạn trở nên minh bạch, dễ hiểu và "bất biến" trước những thay đổi quy tắc liên tục từ khách hàng.
