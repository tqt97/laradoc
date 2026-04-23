---
title: Separation of Concerns là gì? Giải thích từ cơ bản đến Architect + áp dụng Laravel
excerpt: "Hiểu sâu Separation of Concerns (SoC): cách tách lớp, giảm coupling, tăng testability, áp dụng chuẩn trong PHP và Laravel theo tư duy Senior/Architect, kèm ví dụ thực tế và anti-pattern phổ biến."
tags: [law-of-demeter, coupling, encapsulation, laravel]
date: 2025-10-10
order: 9
image: /prezet/img/ogimages/series-clean-code-principles-core-separation-concerns.webp
---

**Separation of Concerns (SoC)** là nguyên lý nền tảng trong thiết kế phần mềm:

> Các mối quan tâm (concerns) khác nhau trong hệ thống phải được tách biệt và xử lý ở các thành phần khác nhau.

Một “concern” có thể là:

* Business logic
* Validation
* Database access
* Authentication
* Logging
* Notification
* HTTP handling

## 1. Bản chất của SoC (hiểu đúng từ gốc)

SoC không chỉ là “chia nhỏ class”.

**Sai lầm phổ biến:**

* Nghĩ rằng tách file là đủ
* Nghĩ rằng dùng nhiều class là đúng SoC

**Bản chất thật:**

* Mỗi phần của hệ thống chỉ nên chịu trách nhiệm cho **một loại thay đổi**
* Mỗi concern nên có **boundary rõ ràng**
* Không để logic của concern này “leak” sang concern khác

## 2. Anti-pattern: God Object / Mixed Concerns

Class xử lý quá nhiều concern sẽ trở thành điểm nghẽn:

| Concern      | Mô tả        |
| ------------ | ------------ |
| HTTP         | đọc header   |
| Auth         | verify token |
| Validation   | check input  |
| DB           | query        |
| Business     | xử lý logic  |
| Payment      | gọi API      |
| Notification | gửi mail     |
| Logging      | log          |

👉 Đây là **vi phạm SoC nghiêm trọng**

## 3. Refactor theo đúng SoC

#### 3.1 Nguyên tắc tách

| Layer            | Responsibility  |
| ---------------- | --------------- |
| Controller       | HTTP            |
| Middleware       | Auth            |
| Validator        | Input           |
| Service          | Business logic  |
| Repository       | Data access     |
| External Service | Payment / Email |
| Domain           | Entity / Rule   |

## 4. Ví dụ PHP thuần

#### Sai

```php
class OrderService
{
    public function create($request)
    {
        if (empty($request['items'])) {
            throw new Exception('Invalid');
        }

        $db = new PDO(...);

        $total = 0;
        foreach ($request['items'] as $item) {
            $stmt = $db->query("SELECT price FROM products WHERE id = {$item['id']}");
            $price = $stmt->fetch()['price'];
            $total += $price * $item['qty'];
        }

        $this->charge($total);
        mail(...);
    }
}
```

#### Đúng

```php
class OrderService
{
    public function __construct(
        private PricingService $pricing,
        private InventoryService $inventory,
        private PaymentService $payment,
        private OrderRepository $orders
    ) {}

    public function create(array $data): Order
    {
        $this->inventory->check($data['items']);

        $total = $this->pricing->calculate($data['items']);

        $order = $this->orders->create($data, $total);

        $this->payment->charge($order);

        return $order;
    }
}
```

## 5. Áp dụng trong Laravel

#### Sai

```php
class OrderController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([...]);

        $total = 0;
        foreach ($request->items as $item) {
            $product = Product::find($item['id']);
            $total += $product->price;
        }

        $order = Order::create([...]);

        Mail::to(...)->send(...);

        return response()->json($order);
    }
}
```

#### Đúng

```php
class OrderController extends Controller
{
    public function store(CreateOrderRequest $request, OrderService $service)
    {
        $order = $service->create(
            $request->user()->id,
            $request->validated()
        );

        return OrderResource::make($order);
    }
}
```

## 6. SoC vs SRP vs Law of Demeter

| Principle | Focus              |
| --------- | ------------------ |
| SoC       | Tách concern       |
| SRP       | 1 reason to change |
| LoD       | Giảm coupling      |

## 7. Lợi ích

* Code dễ hiểu
* Test dễ
* Scale team tốt
* Maintain lâu dài

## 8. Tips

* Đặt tên theo đúng concern
* Không để Model chứa business logic
* Tách rõ layer

## 9. Interview Questions

<details>
  <summary>1. Separation of Concerns là gì?</summary>

**Summary:**

* Tách các concern

**Deep:**

* Giảm coupling, tăng maintainability

</details>

<details>
  <summary>2. SoC khác gì SRP?</summary>

**Summary:**

* SoC là kiến trúc, SRP là class

**Deep:**

* SRP là implementation của SoC

</details>

## 10. Kết luận

SoC là nền tảng của mọi hệ thống lớn, giúp code sạch, dễ mở rộng và dễ bảo trì.
