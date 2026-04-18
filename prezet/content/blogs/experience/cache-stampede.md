---
title: "Cache Stampede: Khi Database sập vì Cache hết hạn"
excerpt: Hiện tượng hàng ngàn request cùng đổ xô vào Database khi một key Cache hết hạn. Cách khắc phục bằng 'Locking' hoặc 'Jitter'.
date: 2026-04-18
category: Experience
image: /prezet/img/ogimages/blogs-experience-cache-stampede.webp
tags: [cache, performance, database, redis, architecture]
---

## 1. Bài toán

Hệ thống có một bài viết "Top hot" được cache 1 tiếng. Đúng giây thứ 3600, 10.000 user truy cập cùng lúc. Cache hết hạn, 10.000 request đó đồng loạt quét vào Database -> Server Database "đột tử".

## 2. Giải pháp: Jitter & Locking

- **Jitter (Độ trễ ngẫu nhiên):** Thay vì set TTL cứng là 3600s, hãy set `3600 + rand(0, 300)` giây. Các key sẽ không hết hạn cùng lúc.
- **Locking (Mutex):** Khi cache miss, dùng `Cache::lock()` để chỉ cho 1 request duy nhất vào DB lấy dữ liệu, các request còn lại chờ hoặc trả về dữ liệu cũ.

## 3. Code mẫu (Locking)

```php
$value = Cache::get('key');
if (!$value) {
    $lock = Cache::lock('key_lock', 10);
    if ($lock->get()) {
        $value = DB::table(...)->first(); // DB query
        Cache::put('key', $value, 3600);
        $lock->release();
    } else {
        $value = Cache::get('key'); // Trả về data cũ hoặc chờ
    }
}
```

## 4. Kinh nghiệm

Luôn dự phòng trường hợp "Cache miss". Trong các hệ thống cao tải, Database phải luôn được bảo vệ bằng "thấu kính" (layer) Cache hoặc Rate Limiter.
