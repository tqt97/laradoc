---
title: "Tư duy Architect: PHP thuần hay Laravel?"
excerpt: Kinh nghiệm chuyển dịch tư duy từ lập trình thủ tục (Procedural) sang lập trình kiến trúc (Architectural). Những 'Nên' và 'Không nên' khi sử dụng Laravel.
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-php-vs-laravel-architect-mindset.webp
tags: [php, laravel, architecture, best-practices]
---

## 1. PHP thuần: Nơi rèn luyện gốc rễ
- **Nên:** Dùng PHP thuần để hiểu sâu về: Request-Response cycle, memory management, serialization, I/O.
- **Không nên:** Tự viết lại toàn bộ Framework (Auth, Router, DB) cho dự án lớn. Bạn sẽ mất hàng năm để làm lại những thứ mà cộng đồng đã tối ưu hàng thập kỷ.

## 2. Laravel: Khi nào nên, khi nào không?
- **Nên dùng Laravel:** Khi dự án có nghiệp vụ thay đổi nhanh, cần bảo mật cao (chống SQLi, CSRF, XSS tự động), và cần khả năng scale (Queue, Cache, Event).
- **Không nên dùng Laravel:** Khi bạn build một dịch vụ Microservice siêu nhẹ (ví dụ: chỉ nhận request và đẩy vào Kafka), Laravel có thể quá cồng kềnh (Overhead). Hãy cân nhắc dùng **Lumen** hoặc **Slim PHP** hoặc **Vanilla PHP** trong trường hợp đó.

## 3. Những lỗi "chết người" cần tránh
- **Anti-pattern: "Fat Model/Fat Controller":** Đừng để DB query trong Controller. Dùng Repository/Action.
- **Anti-pattern: Lạm dụng Facade:** Facade che giấu dependency. Code của bạn sẽ bị "dính" (tightly coupled) vào Framework. Hãy dùng Dependency Injection (DI) để dễ Test.
- **Anti-pattern: Bỏ qua Database Index:** Laravel làm mọi thứ dễ dàng, dẫn đến dev quên mất SQL Index. Kiểm tra log `slow query` là công việc hàng ngày.

## 4. Tips & Tricks cho Senior
- **Dùng Readonly Property (PHP 8.2+):** Để tạo DTO (Data Transfer Object) bất biến (immutable) - cực kỳ an toàn cho hệ thống lớn.
- **Type-Hint mọi thứ:** `function(User $user): void` giúp PHP IDE đoán được code, ngăn chặn lỗi runtime.
- **Sử dụng Collection:** Đừng lặp mảng bằng `foreach` thủ công. Dùng `collect($items)->map(...)->filter(...)` để code clean và dễ đọc hơn.
