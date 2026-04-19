---
title: Caching Strategy Advanced – Cache Aside, Stampede, Distributed Cache
excerpt: "Phân tích sâu các chiến lược cache trong Laravel: cache aside, write-through, stampede, consistency và distributed cache với Redis."
date: 2026-04-19
category: Advanced Laravel
image: /prezet/img/ogimages/series-laravel-advanced-caching.webp
tags: [laravel, cache, redis, performance, distributed]
order: 4
---

> Nếu database là trái tim,thì cache là “turbo” của hệ thống.

Nhưng cache cũng là thứ:

* Dễ làm sai nhất
* Gây bug khó debug nhất

## 1. Problem (Production thật)

API:

```php
GET /api/products
```

Traffic tăng:

* 1k → 50k request/min

DB bắt đầu:

* CPU 100%
* Query chậm

## 2. Naive Solution

```php
Cache::remember('products', 60, function () {
    return Product::all();
});
```

Nghe ổn… nhưng chưa đủ.

## 3. Các chiến lược cache (Deep)

### 3.1 Cache Aside (Lazy Loading)

```php
$data = Cache::get($key);

if (!$data) {
    $data = DB::query(...);
    Cache::put($key, $data, 60);
}
```

Ưu điểm:

* Đơn giản
* Phổ biến nhất

Nhược điểm:

* Cache miss → DB hit

### 3.2 Write Through

```php
Cache::put($key, $data);
DB::save($data);
```

Ưu điểm:

* Data luôn fresh

Nhược điểm:

* Write chậm hơn

### 3.3 Write Behind (Advanced)

```php
Cache::put($key, $data);
Queue::push(save_to_db);
```

Ưu điểm:

* Write cực nhanh

Nhược điểm:

* Risk mất data

## 4. Cache Stampede (cực nguy hiểm)

### Scenario

* Cache hết hạn
* 1000 request cùng lúc

Tất cả query DB

### Fix

#### 1. Cache Lock

```php
Cache::lock('key', 10)->block(5, function () {
    return DB::query(...);
});
```

#### 2. Stale-While-Revalidate

Trả data cũ, update async

#### 3. Random TTL

```php
Cache::put($key, $data, rand(50, 70));
```

## 5. Cache Consistency (khó nhất)

### Problem

```php
Cache::remember('user:1', ...);
User::update(...);
```

Cache stale ❌

### Fix

#### Cache Invalidation

```php
Cache::forget('user:1');
```

### Hard Problem

> “There are only two hard things in Computer Science:
> cache invalidation and naming things”

## 6. Distributed Cache (Redis)

### Vấn đề

* Multiple servers
* Cache phải shared

### Giải pháp

* Redis cluster

### Use case

* Session
* Rate limiting
* Queue

## 7. Key Design (rất quan trọng)

### Bad

```txt
user1
```

### Good

```txt
user:{id}
```

### Rule

* Có namespace
* Có version

## 8. Real Case (x10 performance)

### Before

* API: 2s
* DB overload

### Fix

* Cache aside
* Redis

### After

* API: 100ms

## 9. Anti-pattern

* **Cache everything**: Memory explode

* **Không invalidate**: Data sai

* **TTL quá dài**: Data stale

## 10. Tips & Tricks

* Cache theo key nhỏ
* TTL hợp lý
* Log cache hit/miss

## 11. Mindset Senior

Junior:

> “Thêm cache cho nhanh”

Senior:

> “Phải hiểu consistency và trade-off”

## 12. Interview Questions

<details open>
<summary>1. Cache aside là gì?</summary>

Load từ cache, miss thì query DB

</details>

<details open>
<summary>2. Cache stampede là gì?</summary>

Nhiều request hit DB cùng lúc khi cache miss

</details>

<details open>
<summary>3. Write-through vs write-behind?</summary>

Sync vs async write

</details>

<details open>
<summary>4. Làm sao tránh stale data?</summary>

Cache invalidation

</details>

<details open>
<summary>5. Khi nào không nên dùng cache?</summary>

Data cần real-time consistency

</details>

## Kết luận

Cache giúp system scale mạnh.

> Nhưng dùng sai → bug khó debug nhất hệ thống

Hiểu cache = hiểu distributed system
