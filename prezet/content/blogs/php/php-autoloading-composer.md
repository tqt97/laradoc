---
title: "PHP Autoloading & Composer: Cơ chế tìm file thông minh"
excerpt: Giải mã làm thế nào PHP tìm thấy file chứa class của bạn mà không cần hàng tá lệnh `require`. Tìm hiểu về PSR-4 và classmap.
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-php-autoloading-composer.webp
tags: [php, composer, internals, autoloading, psr-4]
---

Ngày xưa, mỗi khi dùng class, ta phải `require_once 'Path/To/Class.php'`. Nếu có 1000 class, file code của bạn sẽ ngập trong `require`.

## 1. Bản chất Autoloading

PHP cung cấp hàm `spl_autoload_register(callable $callback)`. Khi bạn gọi một class chưa được định nghĩa, PHP sẽ gọi hàm này. Hàm đó nhận vào tên class và bạn phải viết logic để tìm và load file tương ứng.

## 2. Chuẩn PSR-4

Composer không "ma thuật". Nó chỉ đơn giản là chuẩn hóa logic trong `spl_autoload_register`.
Với PSR-4: `App\Models\User` -> mapping tới `app/Models/User.php`. Composer tạo ra một `autoload_psr4.php` chứa map này.

## 3. Câu hỏi nhanh

**Q: Tại sao khi chạy trên Production, bạn nên chạy `composer dump-autoload -o`?**
**A:** Tham số `-o` (Optimize) ép Composer tạo ra một **Class Map**. Thay vì phải tìm kiếm trên ổ đĩa (I/O) để tìm file ứng với namespace, nó tạo ra 1 mảng lớn (Map) trỏ thẳng tên class tới đường dẫn file. Giúp bỏ qua toàn bộ I/O, tăng tốc độ load class lên đáng kể.
