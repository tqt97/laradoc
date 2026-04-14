---
title: Strategy Pattern là gì?
excerpt: Tìm hiểu Strategy Pattern từ A-Z. Cách hoạt động, ví dụ PHP clean code, so sánh với Factory, ứng dụng thực tế trong Laravel và khi nào nên dùng
category: Design pattern
date: 2026-03-10
order: 2
image: /prezet/img/ogimages/series-design-pattern-strategy-pattern.webp
---

> **Pattern thuộc nhóm Behavioral Pattern (Hành vi)**

* Tập trung vào cách object giao tiếp
* Tập trung vào việc thay đổi hành vi runtime

## 1. Vấn đề nó giải quyết

Giả sử bạn build hệ thống e-commerce:

```php
class ShippingService {
    public function calculate(string $type, int $distance): int {
        if ($type === 'bike') {
            return $distance * 5;
        } elseif ($type === 'car') {
            return $distance * 10;
        } elseif ($type === 'truck') {
            return $distance * 20;
        }

        throw new Exception('Invalid type');
    }
}
```

**Vấn đề kiến trúc**

* Vi phạm **Open/Closed Principle**
* Mỗi lần thêm logic → sửa class
* Không test riêng từng loại được
* Không reuse được logic
* Coupling chặt

Đây là dấu hiệu cơ bản: **logic thay đổi nhưng bị hard-code**

## 2. Ý tưởng chính (Core concept)

**Strategy Pattern:**

* Tách mỗi thuật toán thành 1 class riêng
* Các class này implement cùng 1 interface
* Inject vào context để sử dụng

**Nói kiểu Architect:**

> Encapsulate behavior and make it interchangeable

**Nói kiểu dễ hiểu:**

> Mỗi cách làm = 1 object

## 3. UML

```
            [ShippingStrategy]
                    ↑
      -----------------------------
      |             |            |
 [BikeShipping] [CarShipping] [TruckShipping]

                    ↓
            [ShippingService]
```

## 4. Code PHP chuẩn clean

### 4.1 Interface

```php
interface ShippingStrategy {
    public function calculate(int $distance): int;
}
```

### 4.2 Concrete Strategies

```php
class BikeShipping implements ShippingStrategy {
    public function calculate(int $distance): int {
        return $distance * 5;
    }
}

class CarShipping implements ShippingStrategy {
    public function calculate(int $distance): int {
        return $distance * 10;
    }
}

class TruckShipping implements ShippingStrategy {
    public function calculate(int $distance): int {
        return $distance * 20;
    }
}
```

### 4.3 Context

```php
class ShippingService {
    public function __construct(
        private ShippingStrategy $strategy
    ) {}

    public function calculate(int $distance): int {
        return $this->strategy->calculate($distance);
    }
}
```

### 4.4 Sử dụng

```php
$strategy = new BikeShipping();
$service = new ShippingService($strategy);

echo $service->calculate(10);
```

### Dynamic Strategy

```php
class StrategyResolver {
    public static function resolve(string $type): ShippingStrategy {
        return match ($type) {
            'bike' => new BikeShipping(),
            'car' => new CarShipping(),
            'truck' => new TruckShipping(),
            default => throw new Exception('Invalid strategy')
        };
    }
}
```

### Trong Laravel

#### Service Container binding

```php
$this->app->bind(ShippingStrategy::class, function ($app) {
    return match (request('type')) {
        'bike' => new BikeShipping(),
        'car' => new CarShipping(),
        default => new TruckShipping(),
    };
});
```

#### Controller

```php
class ShippingController {
    public function __construct(
        private ShippingStrategy $strategy
    ) {}

    public function calculate() {
        return $this->strategy->calculate(request('distance'));
    }
}
```

Đây chính là cách Laravel scale cực tốt

### Ví dụ đời thường

Bạn đi ăn:

* Ăn tại chỗ
* Ship
* Mang về

> Cùng 1 hành động "order" nhưng cách xử lý khác nhau

## 5. So sánh với pattern tương tự

| Pattern  | Bản chất            |
| -------- | ------------------- |
| Strategy | Thay đổi hành vi    |
| Factory  | Tạo object          |
| State    | Có state transition |

> **Chú ý:**

* **Strategy** = "cách làm"
* **Factory** = "cách tạo"

## 6. Khi nào nên / không nên dùng

### Nên dùng

* Có nhiều cách xử lý cùng 1 logic
* Logic thay đổi runtime
* Cần mở rộng liên tục
* Muốn test riêng từng logic

### Không nên

* Logic đơn giản (1-2 case)
* Project nhỏ
* Không có khả năng scale

## 7. Anti-pattern liên quan

### If-else hell

```php
if (...) {}
elseif (...) {}
elseif (...) {}
```

### God class

1 class xử lý tất cả logic

## 8. Advanced note (Senior mindset)

* Strategy thường đi chung với Factory
* Strategy + DI = scalable system
* Strategy giúp implement polymorphism đúng nghĩa

## Kết luận

Strategy Pattern là nền tảng để:

* Viết code mở rộng
* Áp dụng SOLID
* Thiết kế hệ thống linh hoạt

👉 Đây là pattern quan trọng nhất cho backend developer
