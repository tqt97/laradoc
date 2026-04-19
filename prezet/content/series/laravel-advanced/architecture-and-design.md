---
title: Kiến trúc & Design Patterns Trong Laravel
excerpt: "Bài viết chuyên sâu về kiến trúc trong Laravel dành cho Senior Developer: từ Service Layer, Repository, DDD đến Clean Architecture, kèm ví dụ code thực tế, kinh nghiệm triển khai và bộ câu hỏi interview chi tiết."
category: Laravel
date: 2026-03-08
image: /prezet/img/ogimages/series-laravel-advanced-architecture-and-design.webp
order: 14
---

Ở level junior/middle, Laravel thường được dùng theo kiểu "Controller → Model → View". Nhưng khi hệ thống lớn dần, cách tiếp cận này sẽ dẫn đến:

* Code khó maintain
* Logic bị dồn vào controller/model (fat controller, fat model)
* Khó test
* Khó scale

Vì vậy, kiến trúc là bước chuyển quan trọng nhất để lên Senior.

## I. Vấn đề thực tế

**Fat Controller + Hidden Coupling**

```php
class OrderController extends Controller
{
    public function store(Request $request)
    {
        DB::beginTransaction();

        try {
            $user = auth()->user();

            $order = Order::create([
                'user_id' => $user->id,
                'total' => 0
            ]);

            $total = 0;

            foreach ($request->items as $item) {
                $product = Product::lockForUpdate()->findOrFail($item['id']);

                if ($product->stock < $item['qty']) {
                    throw new \Exception('Out of stock');
                }

                $product->decrement('stock', $item['qty']);

                $total += $product->price * $item['qty'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $item['qty']
                ]);
            }

            $order->update(['total' => $total]);

            DB::commit();

            return response()->json($order);
        } catch (\Throwable $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
```

#### Vấn đề nâng cao

* Transaction logic nằm sai layer
* Concurrency handling bị lộ
* Business rule không reusable
* Vi phạm SRP + DIP

## II. Service Layer Pattern

**Refactor + Transaction + Domain logic**

```php
class OrderService
{
    public function __construct(private ProductService $productService) {}

    public function createOrder(User $user, array $items): Order
    {
        return DB::transaction(function () use ($user, $items) {
            $order = Order::create([
                'user_id' => $user->id,
                'total' => 0
            ]);

            $total = 0;

            foreach ($items as $item) {
                $product = $this->productService->getForUpdate($item['id']);

                $this->productService->decreaseStock($product, $item['qty']);

                $total += $product->price * $item['qty'];

                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $product->id,
                    'qty' => $item['qty']
                ]);
            }

            $order->update(['total' => $total]);

            return $order;
        });
    }
}
```

**Best practices**

* Transaction nằm ở Service
* Tách logic stock riêng
* Có thể reuse / test độc lập

## III. Repository Pattern

**Khi nào nên dùng?**

* Multiple data source (DB + API)
* Query phức tạp
* Cần mock khi test

**Khi KHÔNG nên dùng**

* CRUD đơn giản
* Chỉ dùng Eloquent

**Advanced pitfall**

* Double abstraction (Repository + Service)
* Mất lợi thế của Eloquent ORM

## IV. Action Pattern

```php
class CreateOrderAction
{
    public function execute(User $user, array $items): Order
    {
        // chỉ 1 use case duy nhất
    }
}
```

**So sánh Service vs Action**

| Tiêu chí | Service         | Action          |
| -------- | --------------- | --------------- |
| Scope    | Business domain | Single use case |
| Test     | Medium          | Easy            |
| Scale    | OK              | Very high       |

Thực tế: kết hợp cả 2

## V. DDD (Domain-Driven Design)

**Concept nâng cao**

* Entity
* Value Object
* Aggregate Root
* Domain Service

**Ví dụ Value Object**

```php
class Money
{
    public function __construct(public int $amount) {}

    public function add(Money $money): self
    {
        return new self($this->amount + $money->amount);
    }
}
```

**Khi dùng DDD?**

* Domain phức tạp
* Nhiều rule
* Team lớn

## VI. Clean Architecture (Laravel context)

**Dependency Rule**

* Controller → UseCase → Domain
* Infrastructure không ảnh hưởng Domain

**Ví dụ interface**

```php
interface PaymentGateway
{
    public function charge(int $amount): bool;
}
```

## VII. Kinh nghiệm thực chiến

* 70–80% project: Service + Eloquent là đủ
* Action pattern rất hợp micro logic
* Repository chỉ dùng khi cần abstraction thật sự
* DDD = chi phí cao → chỉ dùng khi đáng
* Clean Architecture giúp test cực tốt

## VIII. Interview Questions

<details open>
<summary>1. Service Layer là gì?</summary>

**Summary:** Tách business logic khỏi controller

**Detail:**

* Giảm coupling
* Dễ test
* Dễ maintain
* Đặt transaction đúng nơi

</details>

<details open>
<summary>2. Khi nào KHÔNG nên dùng Repository?</summary>

**Summary:** Khi Eloquent đã đủ

**Detail:**

* CRUD đơn giản
* Không cần abstraction
* Tránh over-engineering

</details>

<details open>
<summary>3. So sánh Service vs Action?</summary>

**Summary:** Service = nhiều logic, Action = 1 use case

**Detail:**

* Action dễ test hơn
* Service phù hợp orchestration
* Kết hợp là tối ưu nhất

</details>

<details open>
<summary>4. DDD có cần thiết không?</summary>

**Summary:** Không phải lúc nào cũng cần

**Detail:**

* Small project → không cần
* Complex domain → rất cần

</details>

<details open>
<summary>5. Clean Architecture khác gì MVC?</summary>

**Summary:** MVC = structure, Clean = rule dependency

**Detail:**

* MVC không enforce dependency
* Clean kiểm soát direction dependency

</details>

## IX. Tổng kết

* Biết khi nào dùng pattern
* Tránh over-engineering
* Hiểu trade-off
* Thiết kế dựa trên context

Kiến trúc tốt = hệ thống sống lâu + scale được + dễ maintain
