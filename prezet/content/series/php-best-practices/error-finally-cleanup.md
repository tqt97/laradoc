---
title: Finally – Đảm bảo cleanup tài nguyên chuẩn production
excerpt: Học cách dùng finally trong PHP để đảm bảo đóng file, release lock, rollback transaction đúng cách. Tránh memory leak, deadlock và bug khó debug.
category: PHP Best Practices
date: 2025-09-22
order: 4
image: /prezet/img/ogimages/series-php-best-practices-error-finally-cleanup.webp
---

## Finally là gì?

`finally` là block luôn được thực thi **sau try/catch**, bất kể:

* Code chạy thành công
* Có exception xảy ra
* Exception bị catch hay tiếp tục throw

👉 Mục tiêu: **cleanup tài nguyên & restore state một cách an toàn**

## Bad Example (Anti-pattern)

```php
function processFile(string $path): array
{
    $handle = fopen($path, 'r');

    try {
        $data = parseContents($handle);
        fclose($handle); // Bị skip nếu parseContents throw
        return $data;
    } catch (ParseException $e) {
        fclose($handle); // Duplicate cleanup
        throw $e;
    }
    // Nếu exception khác xảy ra → KHÔNG đóng file
}

function updateInventory(int $productId, int $quantity): void
{
    $lock = Cache::lock("product:{$productId}", 10);
    $lock->get();

    $product = Product::find($productId);
    $product->stock -= $quantity;
    $product->save();

    $lock->release(); // Có thể không bao giờ chạy → deadlock
}
```

### Vấn đề

* Cleanup bị lặp lại (DRY violation)
* Có case không được cleanup
* Rủi ro: **file handle leak, lock không release, transaction treo**

## Good Example (Best Practice)

### 1. File handle

```php
function processFile(string $path): array
{
    $handle = fopen($path, 'r');

    try {
        return parseContents($handle);
    } finally {
        fclose($handle); // Luôn chạy
    }
}
```

### 2. Distributed lock

```php
function updateInventory(int $productId, int $quantity): void
{
    $lock = Cache::lock("product:{$productId}", 10);
    $lock->get();

    try {
        $product = Product::find($productId);
        $product->stock -= $quantity;
        $product->save();
    } finally {
        $lock->release(); // Luôn release
    }
}
```

### 3. Transaction

```php
function transferFunds(Account $from, Account $to, float $amount): void
{
    $pdo = getConnection();
    $pdo->beginTransaction();

    try {
        $from->debit($amount);
        $to->credit($amount);
        $pdo->commit();
    } catch (\Throwable $e) {
        $pdo->rollBack();
        throw $e;
    }
}
```

👉 Lưu ý: transaction thường dùng `catch` thay vì `finally` vì cần phân biệt commit/rollback

#### 4. Restore state tạm thời

```php
function withLocale(string $locale, callable $callback): mixed
{
    $original = setlocale(LC_ALL, '0');

    try {
        setlocale(LC_ALL, $locale);
        return $callback();
    } finally {
        setlocale(LC_ALL, $original); // Luôn restore
    }
}
```

## Giải thích sâu

**finally chạy khi nào?**

`finally` chạy trong mọi trường hợp:

* try thành công
* catch xử lý
* exception bị throw ra ngoài

👉 Đây là **guarantee mạnh nhất** trong flow control

**Resource Safety**

Các resource cần cleanup:

* File handle
* DB connection / transaction
* Lock (Redis, cache)
* Socket / stream

👉 Không cleanup = bug production cực khó debug

**Không dùng finally để business logic**

```php
finally {
    sendEmail();
}
```

👉 finally chỉ dành cho **cleanup / restore state**

**finally vs destructor**

* `finally`: control flow rõ ràng
* `__destruct()`: không predictable (GC timing)

👉 Production code nên dùng `finally`

**Exception trong finally?**

👉 Nếu throw trong finally → có thể **che mất exception gốc**

*Best practice:*

* Tránh throw trong finally
* Nếu cần → log + swallow hoặc wrap cẩn thận

## Tips & Tricks

### 1. Luôn nghĩ: "có cần cleanup không?"

Mỗi khi mở resource → nghĩ tới finally

### 2. Wrap helper pattern

```php
function withLock($key, callable $callback) {
    $lock = Cache::lock($key);
    $lock->get();

    try {
        return $callback();
    } finally {
        $lock->release();
    }
}
```

👉 Reusable, clean

### 3. Laravel alternative

* `DB::transaction()` đã handle commit/rollback
* `Cache::lock()->block()` có auto release

👉 Không phải lúc nào cũng cần tự viết finally

### 4. Kết hợp logging

```php
finally {
    $logger->info('cleanup done');
}
```

## Interview Questions

<details>
  <summary>1. finally là gì và khi nào chạy?</summary>

**Summary:**

* Luôn chạy sau try/catch

**Deep:**
Chạy trong mọi trường hợp → đảm bảo cleanup

</details>

<details>
  <summary>2. finally khác gì catch?</summary>

**Summary:**

* catch xử lý lỗi
* finally cleanup

**Deep:**
catch chỉ chạy khi có exception, finally luôn chạy

</details>

<details>
  <summary>3. Khi nào nên dùng finally?</summary>

**Summary:**

* Khi có resource cần cleanup

**Deep:**
File, lock, connection, state

</details>

<details>
  <summary>4. Có nên throw exception trong finally không?</summary>

**Summary:**

* Không nên

**Deep:**
Có thể che mất exception gốc → debug khó

</details>

<details>
  <summary>5. finally có thay thế transaction rollback được không?</summary>

**Summary:**

* Không hoàn toàn

**Deep:**
Transaction cần logic riêng (commit vs rollback)

</details>

## Kết luận

👉 finally là công cụ cực kỳ quan trọng để:

* Tránh resource leak
* Tránh deadlock
* Đảm bảo hệ thống ổn định

> Nếu bạn không dùng finally đúng cách → bug production sẽ rất khó trace
