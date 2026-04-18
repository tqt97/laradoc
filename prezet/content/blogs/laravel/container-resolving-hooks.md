---
title: "Service Container Hooks: Can thiệp vào 'Birth' của Object"
excerpt: Cách sử dụng 'resolving' và 'afterResolving' hook để tiêm cấu hình vào class bên thứ 3 ngay khi chúng được khởi tạo.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-container-resolving-hooks.webp
tags: [laravel, internals, service-container, ioc]
---

## 1. Vấn đề

Đôi khi bạn cần cấu hình một class bên thứ 3 (ví dụ `GuzzleHttp\Client`) ngay khi Laravel vừa khởi tạo nó. Nếu bạn không muốn sửa source code của nó, bạn làm thế nào?

## 2. Định nghĩa: Hooks

Laravel Container cung cấp "hooks" để bạn bắt lấy đối tượng ngay thời điểm nó vừa chào đời:

- **`resolving()`:** Chạy NGAY khi đối tượng được tạo, trước khi nó được trả về nơi yêu cầu.
- **`afterResolving()`:** Chạy SAU khi đối tượng đã sẵn sàng.

## 3. Ví dụ thực tế

Tự động thêm API Key cho mọi instance của `GuzzleClient` được tạo ra:

```php
$this->app->resolving(\GuzzleHttp\Client::class, function ($client, $app) {
    $client->setConfig(['headers' => ['Authorization' => 'Bearer ...']]);
});
```

## 4. Ứng dụng & Mẹo

- **Ứng dụng:** Global config cho các thư viện SDK, logging runtime cho class cụ thể.
- **Mẹo:** Dùng hook này để thực hiện "Aspect-Oriented Programming" (AOP) kiểu Laravel: thêm logging/cấu hình mà không cần sửa code class gốc.
