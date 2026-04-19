---
title: "Caching trong Laravel – Chiến lược đúng để tăng performance x10"
excerpt: Tìm hiểu caching trong Laravel từ cơ bản đến nâng cao, các chiến lược cache, cache invalidation và cách áp dụng trong production.
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-caching.webp
tags: [laravel, cache, performance, redis, architecture]
order: 6
---

Rất nhiều developer biết dùng cache như sau:

```php
Cache::put('users', $users, 60);
```

Nhưng trong production, cache không chỉ là "lưu dữ liệu".

Nếu dùng sai, bạn sẽ gặp:

* Data sai lệch
* Cache không update
* Bug khó debug

Cache là con dao 2 lưỡi.

## Cache là gì?

Cache là cơ chế:

> Lưu dữ liệu tạm thời để giảm truy vấn database

Mục tiêu:

* Tăng tốc độ
* Giảm load DB

## Laravel hỗ trợ những loại cache nào?

* File
* Database
* Redis
* Memcached

Production thường dùng **Redis**

## Cache hoạt động như thế nào?

Flow cơ bản:

```txt
Request → Check Cache
    ↓
Có → trả về
Không → query DB → lưu cache → trả về
```

## Cache Aside (phổ biến nhất)

```php
$data = Cache::remember('users', 60, function () {
    return User::all();
});
```

Laravel tự:

* Check cache
* Nếu không có → chạy callback

## Cache Invalidation – Phần khó nhất

> "There are only two hard things in Computer Science: cache invalidation and naming things"

### Ví dụ sai

* Update DB nhưng không clear cache

Dẫn đến:

* Data cũ
* Bug production

## Cách xử lý cache đúng

### Clear cache khi update

```php
Cache::forget('users');
```

### Dùng Cache Tag

```php
Cache::tags(['users'])->put('users.list', $data);
```

```php
Cache::tags(['users'])->flush();
```

Clear theo group

### TTL hợp lý

* Không quá dài
* Không quá ngắn

## Chiến lược cache (Senior Level)

### Cache Aside

* Phổ biến
* Dễ implement

### Write Through

* Ghi cache + DB cùng lúc

### 3. Write Behind

* Ghi cache trước, DB sau

Laravel thường dùng Cache Aside

## Real Case Production

### Case: Dashboard

❌ Sai:

* Query nhiều bảng
* Load real-time

✅ Đúng:

```php
Cache::remember('dashboard.stats', 300, function () {
    return [
        'users' => User::count(),
        'orders' => Order::count(),
    ];
});
```

### Case: API

* Cache response
* Reduce DB load

## Anti-pattern

**Cache mọi thứ**: Tốn memory + khó quản lý

**Không clear cache**: Data sai

**TTL không hợp lý**: Cache vô dụng hoặc sai

## Performance Tips

* Cache query nặng
* Cache data ít thay đổi
* Dùng Redis cho production

## Mindset

Junior:

> Cache để nhanh hơn

Senior:

> Cache để giảm load hệ thống và scale

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. Cache là gì và dùng để làm gì?</summary>

Lưu dữ liệu tạm để giảm truy vấn database và tăng performance

</details>

<details open>
<summary>2. Cache Aside là gì?</summary>

Là strategy phổ biến: đọc cache trước, nếu miss thì query DB rồi lưu lại

</details>

<details open>
<summary>3. Cache invalidation là gì?</summary>

Là việc cập nhật hoặc xóa cache khi data thay đổi

</details>

<details open>
<summary>4. Redis dùng để làm gì trong Laravel?</summary>

Dùng làm cache, queue, session storage

</details>

<details open>
<summary>5. Khi nào không nên dùng cache?</summary>

Khi data thay đổi liên tục hoặc không có lợi ích về performance

</details>

## Kết luận

Cache không chỉ là kỹ thuật tăng tốc.

> Nó là chiến lược quan trọng để scale hệ thống.

Dùng đúng:

* App nhanh hơn
* DB nhẹ hơn

Dùng sai:

* Bug khó debug
* Data sai
