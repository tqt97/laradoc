---
title: Generators – Xử lý dữ liệu lớn không tốn RAM
excerpt: Tìm hiểu Generators trong PHP (yield) để xử lý file lớn, dataset lớn với memory constant. Kèm ví dụ thực tế, best practices và interview questions.
category: PHP Best Practices
date: 2025-09-26
order: 8
image: /prezet/img/ogimages/series-php-best-practices-perf-generators.webp
---

## Generator là gì?

Generator là một cách để **trả về từng phần dữ liệu (lazy)** thay vì toàn bộ array.

👉 Dùng `yield` thay vì `return`

## Bad Example (Anti-pattern)

```php
function getAllUsers(PDO $pdo): array
{
    return $pdo->query('SELECT * FROM users')->fetchAll();
}
```

**Vấn đề**

* Load toàn bộ data vào RAM
* Dataset lớn → crash
* Không scalable

## Good Example (Best Practice)

### 1. File processing

```php
function readLines(string $path): \Generator
{
    $handle = fopen($path, 'r');

    try {
        while (($line = fgets($handle)) !== false) {
            yield trim($line);
        }
    } finally {
        fclose($handle);
    }
}
```

👉 Đọc từng dòng → memory constant

### 2. Database chunking

```php
function getAllUsers(PDO $pdo, int $chunk = 1000): \Generator
{
    $offset = 0;

    do {
        $stmt = $pdo->prepare('SELECT * FROM users LIMIT :l OFFSET :o');
        $stmt->bindValue(':l', $chunk, PDO::PARAM_INT);
        $stmt->bindValue(':o', $offset, PDO::PARAM_INT);
        $stmt->execute();

        $rows = $stmt->fetchAll();

        foreach ($rows as $row) {
            yield User::fromArray($row);
        }

        $offset += $chunk;
    } while (count($rows) === $chunk);
}
```

### 3. Lazy range

```php
function lazyRange(int $start, int $end): \Generator
{
    for ($i = $start; $i <= $end; $i++) {
        yield $i;
    }
}
```

### 4. Chain generator

```php
function activeUsers(PDO $pdo): \Generator
{
    foreach (getAllUsers($pdo) as $user) {
        if ($user->isActive()) {
            yield $user;
        }
    }
}
```

## Giải thích sâu

### 1. Lazy evaluation

Generator chỉ tạo giá trị khi cần

👉 Không compute trước

### 2. Memory model

* Array → O(n)
* Generator → O(1)

👉 Khác biệt cực lớn với big data

### 3. Streaming mindset

Generator = stream data

👉 Phù hợp:

* File lớn
* API stream
* Queue processing

### 4. yield vs return

* `return`: kết thúc function
* `yield`: pause và resume

👉 Function trở thành iterator

### 5. yield from

```php
yield from anotherGenerator();
```

👉 Compose dễ dàng

## Tips & Tricks (Senior level)

### 1. Rule

👉 Dataset lớn → dùng generator

### 2. Laravel

* `cursor()` thay cho `get()`

```php
User::cursor()->each(fn($u) => ...);
```

### 3. Không dùng cho mọi case

👉 Small dataset → array vẫn ok

### 4. Debug khó hơn

👉 Vì lazy → không thấy data ngay

### 5. Kết hợp pipeline

Generator + filter + map → giống stream processing

## Interview Questions

<details>
  <summary>1. Generator là gì?</summary>

**Summary:**

* Trả dữ liệu từng phần

**Deep:**
Dùng yield → không load toàn bộ vào memory

</details>

<details>
  <summary>2. Generator vs array?</summary>

**Summary:**

* Generator tiết kiệm RAM

**Deep:**
Array load toàn bộ, generator lazy load

</details>

<details>
  <summary>3. Khi nào nên dùng generator?</summary>

**Summary:**

* Dataset lớn

**Deep:**
File lớn, DB lớn, streaming

</details>

<details>
  <summary>4. yield from là gì?</summary>

**Summary:**

* Chain generator

**Deep:**
Delegate iteration cho generator khác

</details>

<details>
  <summary>5. Nhược điểm của generator?</summary>

**Summary:**

* Debug khó

**Deep:**
Lazy → không thấy data ngay, khó trace

</details>

## Kết luận

👉 Generator giúp:

* Tiết kiệm memory
* Scale với dataset lớn
* Code theo kiểu stream

> Nếu bạn xử lý data lớn mà vẫn dùng array → sớm muộn cũng crash
