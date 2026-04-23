---
title: Design Pattern - Repository là gì? Áp dụng chuẩn Architect trong PHP & Laravel
excerpt: Phân tích chuyên sâu Repository Pattern từ bản chất đến kiến trúc hệ thống, anti-pattern, trade-off, cách áp dụng đúng trong Laravel và khi nào KHÔNG nên dùng. Kèm ví dụ production-level và interview questions.
tags: [pattern-repository]
date: 2025-10-12
order: 12
image: /prezet/img/ogimages/series-clean-code-principles-pattern-repository.webp
---

## Repository Pattern

> Repository Pattern là một abstraction layer nằm giữa **domain/business logic** và **data source (DB, API, cache)**.

Mục tiêu:

* Tách business logic khỏi persistence
* Tạo boundary rõ ràng
* Giúp test dễ dàng
* Cho phép thay đổi data source mà không ảnh hưởng logic

## 1. Bản chất thật sự của Repository

#### 1.1 Repository KHÔNG phải là "class query DB"

Sai lầm phổ biến:

```php
class UserRepository {
    public function getAllUsers() {
        return DB::table('users')->get();
    }
}
```

👉 Đây chỉ là wrapper, không phải repository đúng nghĩa.

#### 1.2 Định nghĩa đúng

Repository là:

> Một abstraction cung cấp interface giống collection cho domain object

Ví dụ:

```php
$order = $orderRepository->find($id);
$orderRepository->save($order);
```

👉 Domain không biết DB là MySQL hay Redis

## 2. Vai trò trong kiến trúc (Clean Architecture)

#### 2.1 Layering

* Controller → Interface
* Service → Application
* Repository → Infrastructure
* Entity → Domain

👉 Repository nằm ở boundary giữa Application và Infrastructure

#### 2.2 Dependency Inversion

Service phụ thuộc vào abstraction:

```php
class OrderService {
    public function __construct(OrderRepository $repo) {}
}
```

👉 Không phụ thuộc MySQL / Mongo / API

## 3. Ví dụ PHP thuần (chuẩn domain-driven)

#### Entity

```php
class Order {
    public function __construct(
        public ?int $id,
        public int $userId,
        public float $total,
        public string $status
    ) {}

    public function cancel(): void {
        if ($this->status !== 'pending') {
            throw new Exception('Cannot cancel');
        }
        $this->status = 'cancelled';
    }
}
```

#### Repository Interface

```php
interface OrderRepository {
    public function find(int $id): ?Order;
    public function save(Order $order): Order;
}
```

#### Implementation (MySQL)

```php
class MysqlOrderRepository implements OrderRepository {
    public function find(int $id): ?Order {
        $row = DB::table('orders')->find($id);
        if (!$row) return null;

        return new Order($row->id, $row->user_id, $row->total, $row->status);
    }

    public function save(Order $order): Order {
        if ($order->id) {
            DB::table('orders')->where('id', $order->id)->update([
                'total' => $order->total,
                'status' => $order->status
            ]);
        } else {
            $order->id = DB::table('orders')->insertGetId([
                'user_id' => $order->userId,
                'total' => $order->total,
                'status' => $order->status
            ]);
        }

        return $order;
    }
}
```

#### Service

```php
class OrderService {
    public function __construct(private OrderRepository $repo) {}

    public function cancel(int $id): Order {
        $order = $this->repo->find($id);

        if (!$order) throw new Exception('Not found');

        $order->cancel();

        return $this->repo->save($order);
    }
}
```

## 4. Áp dụng trong Laravel (thực tế)

#### 4.1 Sai lầm phổ biến

```php
interface UserRepositoryInterface {}
class UserRepository implements UserRepositoryInterface {}
```

👉 Không có nhiều implementation → useless abstraction

#### 4.2 Laravel đã có Eloquent

Eloquent chính là:

* Active Record
* Data Mapper hybrid

👉 Nhiều trường hợp KHÔNG cần Repository

#### 4.3 Khi nào nên dùng Repository trong Laravel

✔ Multi data source
✔ Complex query logic
✔ Domain isolation
✔ Testing phức tạp

#### 4.4 Ví dụ chuẩn

```php
interface OrderRepository {
    public function find(int $id): ?Order;
}

class EloquentOrderRepository implements OrderRepository {
    public function find(int $id): ?Order {
        return OrderModel::find($id)?->toDomain();
    }
}
```

## 5. Advanced Patterns kết hợp

#### 5.1 Repository + Unit of Work

* Track changes
* Commit 1 lần

#### 5.2 Repository + Specification

* Query reusable

#### 5.3 Repository + Cache

```php
class CachedOrderRepository implements OrderRepository {
    public function __construct(private OrderRepository $repo) {}
}
```

## 6. Anti-pattern cực nguy hiểm

#### 6.1 Generic Repository overuse

```php
interface Repository<T>
```

👉 Mất domain meaning

#### 6.2 Anemic repository

Chỉ CRUD → không có value

#### 6.3 Repository chứa business logic

Sai boundary

## 7. Trade-off (rất quan trọng)

#### Ưu điểm

* Testable
* Flexible
* Clean architecture

#### Nhược điểm

* Boilerplate
* Over-engineering
* Performance overhead

## 8. Khi nào KHÔNG nên dùng Repository

* CRUD đơn giản
* Dự án nhỏ
* Không cần abstraction

## 9. Tips & Tricks

* Repository nên return domain object
* Không return raw array
* Không expose query builder
* Naming rõ ràng (OrderRepository)

## 10. Interview Questions

<details>
  <summary>Repository Pattern là gì?</summary>

**Summary:**

* Abstraction data access

**Deep:**

* Tách domain khỏi persistence

</details>

<details>
  <summary>Khi nào nên dùng Repository?</summary>

**Summary:**

* Khi complexity cao

**Deep:**

* Multi source
* Domain isolation

</details>

<details>
  <summary>Tại sao Laravel không luôn cần Repository?</summary>

**Summary:**

* Vì Eloquent đủ dùng

**Deep:**

* Active Record đã handle nhiều case

</details>

## 11. Kết luận

Repository Pattern là công cụ mạnh nhưng dễ bị lạm dụng.

Dùng đúng:

* Code clean
* Dễ test
* Scale tốt

Dùng sai:

* Over-engineering
* Tăng complexity

👉 Senior biết dùng
👉 Architect biết khi KHÔNG dùng
