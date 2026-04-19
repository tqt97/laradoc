---
title: Eloquent Performance Deep Dive – N+1, Memory, Query Optimization
excerpt: "Phân tích sâu hiệu năng Eloquent trong Laravel: N+1, eager loading, memory usage, chunk, cursor và các trade-off trong production."
date: 2026-04-19
category: Advanced Laravel
image: /prezet/img/ogimages/series-laravel-advanced-eloquent.webp
tags: [laravel, eloquent, performance, optimization, database]
order: 2
---

Trong production, 80% vấn đề performance đến từ:

* Query không tối ưu
* Lạm dụng Eloquent
* Không hiểu cách ORM hoạt động

Và đa số dev chỉ biết mỗi:

> Fix N+1 bằng with()

Nhưng thực tế phức tạp hơn rất nhiều.

## 1. Problem (Thực tế production)

Giả sử bạn có:

* 10,000 users
* Mỗi user có 20 posts

Code:

```php
$users = User::all();

foreach ($users as $user) {
    foreach ($user->posts as $post) {
        echo $post->title;
    }
}
```

Nghe có vẻ bình thường, nhưng hệ thống bắt đầu:

* Chậm dần
* CPU tăng
* DB quá tải

## 2. Naive Solution (Dev thường làm)

"Dùng with() là xong"

```php
$users = User::with('posts')->get();
```

Đúng, nhưng chưa đủ.

## 3. Vấn đề thực sự (Root Cause)

### N+1 Query là gì?

Flow:

```txt
1 query lấy users
+ N query lấy posts
```

Nếu N = 10,000 → 10,001 queries

### Nhưng vấn đề chưa dừng ở đó

Ngay cả khi dùng eager loading:

Bạn vẫn có thể gặp:

* Memory overflow
* Query quá nặng
* Response chậm

## 4. Giải pháp đúng (Deep Dive)

### 4.1 Eager Loading – nhưng đúng cách

```php
User::with('posts')->get();
```

Laravel sẽ:

* Query users
* Query posts bằng WHERE IN

### Problem: Over-fetching

Bạn load:

* 10,000 users
* 200,000 posts

Memory explode 💥

### 4.2 Select Field (cực quan trọng)

```php
User::select('id', 'name')
    ->with(['posts:id,user_id,title'])
    ->get();
```

Giảm:

* Memory
* Network

### 4.3 Chunk – xử lý batch

```php
User::chunk(100, function ($users) {
    foreach ($users as $user) {
        // xử lý
    }
});
```

Ưu điểm:

* Giảm memory

Nhược điểm:

* Không dùng được cho pagination logic phức tạp

### 4.4 Cursor – streaming data

```php
foreach (User::cursor() as $user) {
    // xử lý từng record
}
```

Ưu điểm:

* Memory cực thấp

Nhược điểm:

* Chậm hơn chunk
* Không eager loading tốt

### 4.5 Lazy Eager Loading

```php
$users = User::all();
$users->load('posts');
```

Khi nào dùng?

* Khi bạn conditionally cần relation

## 5. Trade-off (rất quan trọng)

| Technique     | Ưu điểm       | Nhược điểm     |
| ------------- | ------------- | -------------- |
| eager loading | ít query      | tốn memory     |
| chunk         | tiết kiệm RAM | phức tạp logic |
| cursor        | RAM thấp nhất | chậm           |

Không có giải pháp “best”, chỉ có phù hợp.

## 6. Khi nào Eloquent trở thành bottleneck?

### Case 1: Dataset lớn

* 1M records

Eloquent không phù hợp

### Case 2: Query phức tạp

```php
DB::select(...);
```

Raw query nhanh hơn

### Case 3: Bulk insert/update

```php
DB::table('users')->insert([...]);
```

Rule:

> Eloquent = convenience
> Query Builder / Raw = performance

## 7. Failure Case (thực tế rất hay gặp)

### Case 1: Eager loading everything

```php
User::with(['posts', 'comments', 'likes'])->get();
```

API chết

### Case 2: Loop query

```php
foreach ($users as $user) {
    Post::where('user_id', $user->id)->get();
}
```

Classic N+1

### Case 3: Load toàn bộ data

```php
User::all();
```

Không bao giờ làm trong production nếu data lớn

## 8. Tips & Tricks (thực chiến)

### 1. Luôn dùng select

```php
User::select('id')->get();
```

### 2. Limit data

```php
User::limit(100)->get();
```

### 3. Dùng index DB

Không phải Laravel nhưng cực quan trọng

### 4. Debug query

```php
DB::listen(function ($query) {
    logger($query->sql);
});
```

### 5. Dùng pagination

```php
User::paginate(20);
```

## 9. Mindset

Junior:

> Fix N+1 là xong

Senior:

> Phải hiểu trade-off giữa query, memory và latency

## 10. Interview Questions

<details open>
<summary>1. N+1 query là gì?</summary>

Là việc query lặp lại nhiều lần gây performance issue

</details>

<details open>
<summary>2. Eager loading có luôn tốt không?</summary>

Không, có thể gây tốn memory

</details>

<details open>
<summary>3. Chunk vs Cursor khác nhau như thế nào?</summary>

Chunk xử lý theo batch, Cursor xử lý từng record

</details>

<details open>
<summary>4. Khi nào nên dùng raw query?</summary>

Khi cần performance cao hoặc query phức tạp

</details>

<details open>
<summary>5. Làm sao debug performance query?</summary>

Dùng log, debugbar, explain

</details>

## 11. So sánh Eloquent vs Query Builder vs Raw SQL (Benchmark Style)

Trong production, câu hỏi quan trọng không phải là:

> Dùng cái nào đúng?

Mà là:

> Dùng cái nào phù hợp với workload?

### Benchmark Scenario

Giả sử:

* 100,000 users
* Query: lấy danh sách user + count posts

#### 1. Eloquent

```php
$users = User::withCount('posts')->get();
```

Ưu điểm:

* Code sạch
* Readable
* Maintain tốt

Nhược điểm:

* Overhead ORM
* Hydration object tốn CPU + RAM

#### 2. Query Builder

```php
$users = DB::table('users')
    ->leftJoin('posts', 'users.id', '=', 'posts.user_id')
    ->select('users.id', 'users.name', DB::raw('COUNT(posts.id) as post_count'))
    ->groupBy('users.id')
    ->get();
```

Ưu điểm:

* Nhanh hơn Eloquent
* Ít overhead hơn

Nhược điểm:

* Code dài hơn
* Ít abstraction

#### 3. Raw SQL

```php
$users = DB::select("
    SELECT users.id, users.name, COUNT(posts.id) as post_count
    FROM users
    LEFT JOIN posts ON users.id = posts.user_id
    GROUP BY users.id
");
```

Ưu điểm:

* Nhanh nhất
* Full control

Nhược điểm:

* Khó maintain
* Dễ lỗi

### Kết quả (ước lượng thực tế)

| Method        | Time  | Memory | Maintain |
| ------------- | ----- | ------ | -------- |
| Eloquent      | 120ms | High   | ⭐⭐⭐⭐⭐    |
| Query Builder | 80ms  | Medium | ⭐⭐⭐⭐     |
| Raw SQL       | 60ms  | Low    | ⭐⭐       |

Insight:

* Eloquent = DX tốt
* Query Builder = balance
* Raw SQL = performance tối đa

### Rule thực chiến

* CRUD bình thường → Eloquent
* Query phức tạp → Query Builder
* Critical path → Raw SQL

## 12. EXPLAIN Query Analysis

> Nếu bạn không đọc được EXPLAIN → bạn không tối ưu DB được

### Ví dụ query

```sql
EXPLAIN SELECT * FROM users WHERE email = 'test@example.com';
```

### Output (đơn giản hóa)

| type | key  | rows | Extra       |
| ---- | ---- | ---- | ----------- |
| ALL  | NULL | 100k | Using where |

Ý nghĩa:

* type = ALL → full table scan
* key = NULL → không dùng index

### Sau khi thêm index

```sql
CREATE INDEX idx_users_email ON users(email);
```

### EXPLAIN lại

| type | key             | rows | Extra |
| ---- | --------------- | ---- | ----- |
| ref  | idx_users_email | 1    | NULL  |

Improvement:

* rows: 100k → 1
* tốc độ tăng cực mạnh

### Các field quan trọng

* type: ALL → index → ref → const (càng tốt)
* rows: càng nhỏ càng tốt
* key: index đang dùng

### Red flags

* type = ALL
* rows rất lớn
* Using filesort
* Using temporary

## 13. Case Study

**Problem**

API:

```php
GET /api/users
```

Code:

```php
$users = User::with(['posts', 'comments'])->get();
```

**Symptoms**

* Response: 3.2s
* RAM: 512MB
* CPU: cao

**Root Cause**

* Load quá nhiều relation
* Không select field
* Không pagination

**Fix**

```php
$users = User::select('id', 'name')
    ->with(['posts:id,user_id,title'])
    ->paginate(20);
```

### Kết quả

* Response: 3.2s → 300ms (~10x)
* RAM giảm mạnh

### Bài học

* Không bao giờ load toàn bộ data
* Luôn giới hạn field
* Pagination là bắt buộc

## 14. Composite Index (Cực hay bị sai)

### Vấn đề

Rất nhiều dev tạo index kiểu:

```sql
CREATE INDEX idx_users_name_email ON users(name, email);
```

Nhưng query lại là:

```sql
SELECT * FROM users WHERE email = 'a@example.com';
```

Index KHÔNG được dùng

### Quy tắc vàng (Left-most prefix rule)

> Composite index chỉ hoạt động nếu query bắt đầu từ cột bên trái

Index:

```sql
(name, email)
```

#### Dùng được

```sql
WHERE name = 'A'
WHERE name = 'A' AND email = 'a@example.com'
```

#### Không dùng được

```sql
WHERE email = 'a@example.com'
```

### Sai lầm phổ biến

* Đặt thứ tự cột sai
* Index nhưng không match query

### Cách thiết kế đúng

Dựa trên query thực tế, không phải intuition

```sql
CREATE INDEX idx_users_email_name ON users(email, name);
```

### Insight senior

* Column có selectivity cao → đặt trước
* Query filter chính → đặt trước

## 15. Covering Index (rất mạnh)

### Khái niệm

> Query có thể trả kết quả chỉ từ index mà không cần đọc table

### Ví dụ

```sql
CREATE INDEX idx_users_email_name ON users(email, name);
```

Query:

```sql
SELECT email, name FROM users WHERE email = 'a@example.com';
```

DB chỉ đọc index → cực nhanh

### Khi nào xảy ra?

* SELECT chỉ chứa các cột nằm trong index

### Sai lầm

```sql
SELECT * FROM users WHERE email = 'a@example.com';
```

Không dùng covering index

### Best practice

* Tránh SELECT *
* Design index theo query

## 16. Transaction & Deadlock (Production thực tế)

### Transaction là gì?

```php
DB::transaction(function () {
    // nhiều query
});
```

Đảm bảo ACID

### Deadlock là gì?

#### Scenario

Transaction A:

```sql
UPDATE users SET balance = balance - 100 WHERE id = 1;
UPDATE users SET balance = balance + 100 WHERE id = 2;
```

Transaction B:

```sql
UPDATE users SET balance = balance - 50 WHERE id = 2;
UPDATE users SET balance = balance + 50 WHERE id = 1;
```

A lock id=1, B lock id=2 → deadlock 💀

### Cách fix

#### 1. Lock theo thứ tự cố định

```php
DB::transaction(function () {
    User::whereIn('id', [1,2])->lockForUpdate()->get();
});
```

#### 2. Retry transaction

```php
DB::transaction(function () {
    // logic
}, 5);
```

#### 3. Giữ transaction ngắn

Không call API bên trong transaction

### Insight

* Deadlock không tránh được hoàn toàn
* Quan trọng là detect + retry

## 17. Query Plan thực chiến

### Ví dụ query phức tạp

```sql
SELECT * FROM orders
WHERE user_id = 10
AND status = 'completed'
ORDER BY created_at DESC;
```

### EXPLAIN (bad case)

| type | key  | rows | Extra          |
| ---- | ---- | ---- | -------------- |
| ALL  | NULL | 500k | Using filesort |

Full scan + sort → rất chậm

### Fix bằng index

```sql
CREATE INDEX idx_orders_user_status_created
ON orders(user_id, status, created_at);
```

### EXPLAIN (good case)

| type | key                            | rows | Extra |
| ---- | ------------------------------ | ---- | ----- |
| ref  | idx_orders_user_status_created | 50   | NULL  |

Không filesort → nhanh hơn nhiều

### Insight cực quan trọng

* ORDER BY + WHERE → phải nằm cùng index
* Không match → DB phải sort lại

## Kết luận

Eloquent rất mạnh nhưng:

> Dùng sai → hệ thống chết

Hiểu đúng giúp bạn:

* Tăng performance
* Giảm chi phí
* Scale hệ thống
