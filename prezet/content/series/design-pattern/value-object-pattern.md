---
title: Value Object - Sức mạnh của sự bất biến
excerpt: Tìm hiểu Value Object Pattern - cách đóng gói dữ liệu nhỏ và logic đi kèm, bí quyết viết code Clean và giàu tính nghiệp vụ trong Laravel.
category: Design pattern
date: 2026-03-31
order: 24
image: /prezet/img/ogimages/series-design-pattern-value-object-pattern.webp
---

> Pattern thuộc nhóm **Structural / Enterprise Pattern**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang quản lý số tiền (Money) trong ứng dụng. Bạn thường dùng kiểu dữ liệu `int` hoặc `float`:

```php
$price = 100000; // 100,000 VNĐ
$discount = 0.1; // 10%
```

**Vấn đề:**

1. **Thiếu ngữ cảnh:** Một con số `100000` đứng một mình không biết là VNĐ, USD hay EUR.
2. **Logic phân tán:** Việc cộng, trừ, nhân chia tiền tệ bị rải rác khắp nơi, dễ sai sót khi làm tròn số.
3. **Dễ bị thay đổi:** Bạn vô tình cộng `100,000 VNĐ` với `5 USD` mà không có lỗi báo trước.

## 2. Định nghĩa

**Value Object** là một đối tượng nhỏ đại diện cho một khái niệm đơn giản mà định danh của nó dựa trên các thuộc tính của nó, chứ không phải một ID duy nhất (khác với Entity).

**3 đặc điểm cốt lõi:**

* **Immutability (Bất biến):** Một khi đã tạo ra, giá trị không bao giờ thay đổi. Nếu muốn đổi, hãy tạo đối tượng mới.
* **Value Equality:** Hai đối tượng bằng nhau nếu các thuộc tính của chúng bằng nhau.
* **Self-validation:** Đối tượng luôn ở trạng thái hợp lệ ngay khi được khởi tạo.

## 3. Implementation (PHP 8.2+ Style)

### 3.1 PHP Thuần

```php
readonly class Money {
    public function __construct(
        public int $amount,
        public string $currency = 'VND'
    ) {
        if ($amount < 0) {
            throw new InvalidArgumentException("Số tiền không thể âm");
        }
    }

    public function add(Money $other): self {
        if ($this->currency !== $other->currency) {
            throw new Exception("Không thể cộng khác loại tiền tệ");
        }
        return new self($this->amount + $other->amount, $this->currency);
    }

    public function equals(Money $other): bool {
        return $this->amount === $other->amount && $this->currency === $other->currency;
    }
}

// Sử dụng
$price = new Money(100000);
$shipping = new Money(20000);
$total = $price->add($shipping);
```

## 4. Liên hệ Laravel

Trong Laravel, Value Object được dùng rất nhiều trong **Domain-Driven Design (DDD)**:

**1. Custom Casts:**
Bạn có thể tự động chuyển một cột trong DB thành Value Object khi truy xuất.

```php
// User Model
protected $casts = [
    'address' => AddressCast::class, // Trả về Address Value Object
];
```

**2. Coordinates (Tọa độ):**
Thay vì dùng `latitude` và `longitude` riêng lẻ, hãy dùng `Location` object.

## 5. Khi nào nên dùng

* Khi có các nhóm dữ liệu luôn đi cùng nhau (Money, Address, DateRange, Color).
* Khi muốn áp đặt các quy tắc validation chặt chẽ (Email, Phone Number).
* Khi muốn code trở nên "giàu tính nghiệp vụ" (Rich Domain Model).

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **An toàn (Safety):** Tính bất biến giúp tránh các lỗi thay đổi dữ liệu ngoài ý muốn.
* **Dễ hiểu:** `Money $price` rõ nghĩa hơn nhiều so với `int $price`.
* **Dễ Test:** Vì là object thuần túy, không phụ thuộc DB.

**Nhược điểm:**

* **Tăng số lượng Object:** Có thể tạo ra nhiều đối tượng trong memory (PHP 8.2 readonly class giúp tối ưu việc này).

## 7. Câu hỏi phỏng vấn

1. **Sự khác biệt giữa Value Object và Entity?** (Entity có ID duy nhất và có vòng đời thay đổi. Value Object không có ID, chỉ quan tâm đến giá trị thuộc tính).
2. **Tại sao Value Object nên là Immutability?** (Để đảm bảo tính nhất quán và tránh side-effects khi đối tượng được dùng chung ở nhiều nơi).
3. **Làm thế nào để so sánh 2 Value Object?** (Sử dụng hàm `equals()` để so sánh các thuộc tính bên trong thay vì dùng toán tử `==` hay `===`).

## Kết luận

Value Object Pattern là chìa khóa để viết code hướng đối tượng thực thụ. Hãy ngừng dùng các kiểu dữ liệu nguyên thủy (Primitive Obsession) và bắt đầu đóng gói chúng vào các Value Object để code của bạn an toàn và chuyên nghiệp hơn.
