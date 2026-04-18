---
title: "PHP Serialization: Bí mật của Job & Queue"
excerpt: Giải mã cơ chế serialize/unserialize của PHP. Tại sao Laravel Jobs có thể đẩy xuống Queue và rủi ro PHP Object Injection.
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-php-serialization-internals.webp
tags: [php, internals, serialization, security]
---

## 1. Bài toán

Khi bạn đẩy một Job vào Queue trong Laravel, class đó cần được "đóng gói" (serialize) thành chuỗi để đẩy vào Redis/Database, rồi sau đó "mở gói" (unserialize) ở Worker.

## 2. Bản chất

- `serialize()`: Biến object thành chuỗi, lưu trữ state và class name.
- `unserialize()`: Khôi phục object từ chuỗi. PHP tự động tìm class tương ứng và tạo lại instance.

## 3. Các Magic Methods cần biết

- `__sleep()`: Dọn dẹp object trước khi đóng gói (vd: đóng kết nối DB để không serialize connection resource).
- `__wakeup()`: Thiết lập lại kết nối/resource ngay khi object được khôi phục.

## 4. Rủi ro bảo mật: PHP Object Injection

Nếu bạn `unserialize()` một chuỗi từ phía user (ví dụ từ cookie hoặc input), hacker có thể truyền vào một chuỗi đại diện cho một class khác trong hệ thống. Khi PHP "mở gói", nó tự động gọi các method như `__destruct` của class đó -> **Remote Code Execution (RCE)**.
*Bài học:* Tuyệt đối không bao giờ dùng `unserialize()` trên dữ liệu do người dùng nhập vào.

## 5. Ứng dụng trong Laravel

Laravel giải quyết vấn đề serialize model bằng **`SerializesModels` Trait**. Nó chỉ serialize `ID` của model thay vì serialize toàn bộ object Model nặng nề. Khi worker chạy, nó sẽ dùng `ID` để fetch lại dữ liệu mới nhất từ DB.
