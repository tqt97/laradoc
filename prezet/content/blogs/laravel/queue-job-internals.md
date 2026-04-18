---
title: "Laravel Queue & Jobs: Cơ chế xử lý bất đồng bộ"
excerpt: Giải mã cơ chế Serialize Models, quy trình đẩy Job vào Queue và cách quản lý Worker hiệu quả.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-queue-job-internals.webp
tags: [laravel, queue, jobs, internals, performance]
---

## 1. Bản chất: SerializeModels Trait

Khi bạn đẩy một Eloquent Model vào Queue, Laravel không serialize toàn bộ Object (gây tốn bộ nhớ). Nó chỉ serialize `ID` của Model. Khi Worker xử lý, nó dùng ID đó để `fetch` lại bản ghi mới nhất từ Database.

- **Rủi ro:** Nếu Model bị xóa trong DB trước khi Worker xử lý, nó sẽ ném `ModelNotFoundException`.

## 2. Queue Driver & Workflow

- **Sync:** Chạy ngay lập tức (không queue). Dùng cho môi trường Local/Test.
- **Async (Redis/Database):** Job được đẩy vào một hàng đợi (Queue). Worker chạy loop (thường là `php artisan queue:work`) để lấy job ra và thực thi.

## 3. Câu hỏi nhanh

**Q: Tại sao Worker lại tốn bộ nhớ sau khi xử lý hàng ngàn job?**
**A:** Do các biến static hoặc các cache nội bộ không được giải phóng. Đó là lý do Laravel cung cấp cơ chế `max-jobs` hoặc `max-time` để restart worker định kỳ.

**Q: Làm sao để retry job thông minh?**
**A:** Sử dụng phương thức `backoff()` để tăng dần thời gian chờ giữa các lần retry, tránh việc retry liên tục gây áp lực lên hệ thống khi service bên ngoài đang sập.
