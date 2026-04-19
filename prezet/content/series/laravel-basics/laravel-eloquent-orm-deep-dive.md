---
title: Eloquent ORM Deep Dive – Tránh N+1, tối ưu query và hiểu đúng để scale
excerpt: Tìm hiểu sâu Eloquent ORM trong Laravel, cách hoạt động, N+1 problem, eager loading và các kỹ thuật tối ưu query trong production.
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/series-laravel-basics-laravel-eloquent-orm-deep-dive.webp
tags: [laravel, eloquent, orm, performance, n+1]
order: 5
---

Rất nhiều developer dùng Eloquent như sau:

```php
$users = User::all();
```

Và nghĩ rằng như vậy là “đúng”.

Nhưng trong production, Eloquent có thể:

* Gây N+1 query
* Làm chậm hệ thống
* Tốn memory

Nếu bạn không hiểu sâu.

## Eloquent ORM là gì?

Eloquent là ORM (Object Relational Mapping) của Laravel.

> Nó giúp bạn làm việc với database bằng object thay vì SQL.

Ví dụ:

```php
$user = User::find(1);
```

Thay vì:

```sql
SELECT * FROM users WHERE id = 1;
```

## Cách Eloquent hoạt động (bản chất)

Eloquent không “magic”, nó chỉ:

1. Build query
2. Execute SQL
3. Map result → object

Hiểu điều này cực kỳ quan trọng để optimize.

## N+1 Problem – Lỗi phổ biến nhất

### Ví dụ sai

```php
$users = User::all();

foreach ($users as $user) {
    echo $user->posts;
}
```

Query thực tế:

* 1 query lấy users
* N query lấy posts

Tổng: N+1 queries

## Cách giải: Eager Loading

```php
$users = User::with('posts')->get();
```

Query:

* 1 query users
* 1 query posts

Tổng: 2 queries

## Eager vs Lazy vs Lazy Eager

### 1. Lazy Loading

```php
$user->posts;
```

Query khi truy cập

### 2. Eager Loading

```php
User::with('posts')->get();
```

Load trước

### 3. Lazy Eager Loading

```php
$users->load('posts');
```

Load sau khi query

## Select Fields – Tránh load thừa

Sai:

```php
User::all();
```

Đúng:

```php
User::select('id', 'name')->get();
```

Giảm memory + tăng tốc

## Chunking – Xử lý dữ liệu lớn

```php
User::chunk(100, function ($users) {
    foreach ($users as $user) {
        // xử lý
    }
});
```

Tránh load toàn bộ vào RAM

## Index & Query Optimization

Nếu query chậm:

* Check index
* Dùng EXPLAIN

Ví dụ:

```sql
EXPLAIN SELECT * FROM users WHERE email = 'test@example.com';
```

## Relationship Optimization

### Chỉ load field cần thiết

```php
User::with(['posts:id,user_id,title'])->get();
```

### Count thay vì load full

```php
User::withCount('posts')->get();
```

Tối ưu hơn nhiều

## Real Case Production

### Case: Dashboard

**Sai:**

* Load toàn bộ data
* Loop nhiều lần

**Đúng:**

* Dùng aggregate
* Dùng withCount
* Cache result

## Anti-pattern

### Dùng Eloquent cho mọi thứ

* Query phức tạp → nên dùng Query Builder

### Không dùng eager loading

* Gây N+1

### Load quá nhiều data

* Không select field

## Performance Tips

* Luôn nghĩ: query này chạy bao nhiêu lần?
* Log query trong dev
* Dùng debugbar hoặc telescope

## Mindset Senior

Junior:

> Code chạy là được

Senior:

> Query này có scale được không?

## Câu hỏi thường gặp (Interview)

### 1. N+1 problem là gì?

Là việc query lặp lại nhiều lần không cần thiết

### 2. Eager loading dùng khi nào?

Khi cần load relationship trước

### 3. Lazy vs Eager khác gì?

Lazy load khi dùng, eager load trước

### 4. Khi nào không nên dùng Eloquent?

Khi query quá phức tạp hoặc cần performance cao

### 5. Làm sao debug query trong Laravel?

Dùng log, debugbar, telescope

## Kết luận

Eloquent rất mạnh, nhưng:

> Dùng sai = performance tệ

Hiểu sâu giúp bạn:

* Tránh N+1
* Tối ưu query
* Scale hệ thống
