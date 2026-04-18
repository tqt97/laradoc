---
title: "Event-Driven trong Laravel: Decoupling hệ thống"
excerpt: Cách sử dụng Events/Listeners và Queues để xây dựng hệ thống bất đồng bộ, chịu tải cao.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-event-driven-laravel.webp
tags: [laravel, event-driven, queues, architecture, decoupling]
---

## 1. Bài toán

Khi user đăng ký, bạn cần: Gửi Email, tạo profile, sync sang CRM, thông báo cho marketing. Controller sẽ phình to nếu bạn viết hết vào đó.

## 2. Định nghĩa

Event-Driven Architecture (EDA) tách biệt "Người gây ra sự kiện" (Event Producer) và "Người xử lý sự kiện" (Event Consumer/Listener).

## 3. Cách giải quyết

```php
// Dispatch sự kiện
event(new UserRegistered($user));

// Listener xử lý ngầm (đẩy vào queue)
class SendWelcomeEmail implements ShouldQueue {
    public function handle(UserRegistered $event) { ... }
}
```

## 4. Ứng dụng & Mẹo

- **Ứng dụng:** Mọi tác vụ tốn thời gian, các luồng nghiệp vụ cần sự độc lập.
- **Mẹo:** Dùng **Queue Monitor** hoặc **Laravel Horizon** để giám sát xem các listeners này có đang bị "kẹt" không.

## 5. Câu hỏi phỏng vấn

- **Q: Thế nào là "Eventual Consistency"?** Là hệ thống cam kết dữ liệu sẽ đồng nhất "sau một khoảng thời gian ngắn" chứ không phải ngay lập tức. Đây là đặc sản của kiến trúc sự kiện.
- **Q: Khi nào KHÔNG nên dùng Event?** Khi bạn cần kết quả trả về ngay lập tức để phản hồi cho user (ví dụ: cần tính số dư để hiển thị).

## 6. Kết luận

Event-Driven giúp hệ thống linh hoạt (Decoupled). Nếu service gửi email chết, hệ thống đặt hàng của bạn vẫn sống khỏe mạnh.
