---
title: Database Optimization Deep Dive – Index Strategy, Query Rewrite, Deadlock
excerpt: "Phân tích sâu tối ưu database trong Laravel: index strategy, query rewrite, transaction, deadlock và các case production."
date: 2026-04-19
category: Advanced Laravel
image: /prezet/img/ogimages/series-laravel-advanced-database.webp
tags: [laravel, database, performance, index, optimization]
order: 3
---

Nếu bài trước bạn hiểu Eloquent performance,thì bài này sẽ trả lời câu hỏi lớn hơn:

> Tại sao DB vẫn chậm dù code đã tối ưu?

Câu trả lời: **Database design & query execution**

## 1. Problem (Production thật)

API:

```php
GET /api/orders
```

Query:

```sql
SELECT * FROM orders
WHERE user_id = 100
AND status = 'completed'
ORDER BY created_at DESC;
```

### Symptoms

* Response: 2–5s
* CPU DB: cao
* Slow query log xuất hiện liên tục

## 2. Root Cause

90% đến từ:

* Không có index
* Index sai
* Query không tối ưu

## 3. Index Strategy (Deep)

### 3.1 Single Index

```sql
CREATE INDEX idx_user_id ON orders(user_id);
```

Chỉ giúp 1 phần

### 3.2 Composite Index

```sql
CREATE INDEX idx_orders_user_status_created
ON orders(user_id, status, created_at);
```

Match hoàn toàn query

### ⚠️ Sai lầm

```sql
(status, user_id)
```

Sai thứ tự → query chậm

### 3.3 Covering Index

```sql
CREATE INDEX idx_orders_cover
ON orders(user_id, status, created_at, total);
```

SELECT không cần đọc table

### 3.4 Index Selectivity

Column có giá trị unique cao → hiệu quả

❌ status (low selectivity)
✅ user_id (high selectivity)

## 4. Query Rewrite (rất mạnh)

### ❌ Bad query

```sql
SELECT * FROM orders
WHERE DATE(created_at) = '2026-01-01';
```

Không dùng index

### ✅ Good query

```sql
WHERE created_at >= '2026-01-01 00:00:00'
AND created_at < '2026-01-02 00:00:00'
```

Dùng index được

### ❌ Using OR

```sql
WHERE user_id = 1 OR status = 'pending'
```

Khó optimize

### ✅ Rewrite

```sql
UNION ALL
```

## 5. EXPLAIN thực chiến

```sql
EXPLAIN SELECT * FROM orders ...
```

### Field quan trọng

* type
* rows
* key
* Extra

### Red flags

* ALL → full scan
* filesort
* temporary

## 6. Transaction Deep Dive

### ACID

* Atomicity
* Consistency
* Isolation
* Durability

### Isolation Level

* READ COMMITTED
* REPEATABLE READ
* SERIALIZABLE

Laravel mặc định MySQL: REPEATABLE READ

### Phantom Read (advanced)

Query cùng điều kiện nhưng data khác

## 7. Deadlock (Production)

### Scenario thật

* Update nhiều bảng
* Order khác nhau

### Fix

* Lock order
* Retry
* Reduce transaction scope

## 8. Partitioning (Advanced)

### Khi nào cần?

* Table > 10M rows

### Ví dụ

```sql
PARTITION BY RANGE (YEAR(created_at))
```

Query nhanh hơn

## 9. Real Case (x10 performance)

### Before

* Query: 3s
* rows scan: 1M

### Fix

* Add composite index
* Rewrite query

### After

* Query: 200ms
* rows scan: 500

## 10. Tips & Tricks

* Không SELECT *
* Luôn EXPLAIN query
* Log slow query
* Index theo query, không theo cảm giác

## 11. Mindset Senior

Junior:

> "Thêm index là xong"

Senior:

> "Phải hiểu query plan và data distribution"

## 12. Interview Questions

<details open>
<summary>1. Composite index là gì?</summary>

Index nhiều cột

</details>

<details open>
<summary>2. Tại sao index không chạy?</summary>

Sai thứ tự hoặc query không match

</details>

<details open>
<summary>3. EXPLAIN dùng để làm gì?</summary>

Xem query execution plan

</details>

<details open>
<summary>4. Deadlock là gì?</summary>

Transaction chờ nhau

</details>

<details open>
<summary>5. Khi nào cần partition?</summary>

Table rất lớn

</details>

## Kết luận

Database optimization là skill bắt buộc.

> ORM không cứu bạn nếu DB sai.

Hiểu DB = level senior thật sự.
