---
title: "Laravel Facade: Ma thuật tĩnh (Static) đằng sau Service Container"
excerpt: Giải mã cách Laravel biến các phương thức tĩnh thành lời gọi đến các object thực sự trong Service Container thông qua `__callStatic`.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-facade-internals.webp
tags: [laravel, internals, facades, magic-methods]
---

## 1. Facade là gì?

Facade cung cấp một giao diện tĩnh (static) cho các dịch vụ bên trong Service Container. Thay vì phải làm `app('log')->info(...)`, bạn chỉ cần gọi `Log::info(...)`.

## 2. Bản chất kiến trúc

Mọi Facade đều kế thừa từ `Illuminate\Support\Facades\Facade`.

- **`getFacadeAccessor()`:** Trả về "key" để lấy service từ Container (ví dụ: `log`, `cache`, `db`).
- **`__callStatic()`:** Khi bạn gọi một method tĩnh không tồn tại trên class Facade, Laravel bắt sự kiện này, lấy đối tượng thực từ Container, và gọi method tương ứng lên đối tượng đó.

## 3. Tại sao không nên lạm dụng?

- **Khó test:** Facade tạo ra "Hidden dependencies", việc mock chúng đòi hỏi cú pháp đặc thù như `Log::shouldReceive(...)`.
- **Che giấu API:** Bạn không biết class thực sự đứng sau là gì, gây khó khăn khi muốn xem source code.

## 4. Quizz phỏng vấn

**Câu hỏi:** Làm thế nào để tạo Facade cho service của riêng bạn?
**Trả lời:**

1. Tạo class thực thi logic.
2. Bind class đó vào Service Container.
3. Tạo class Facade kế thừa `Illuminate\Support\Facades\Facade` và định nghĩa `getFacadeAccessor()`.
