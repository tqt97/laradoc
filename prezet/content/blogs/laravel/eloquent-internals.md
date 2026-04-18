---
title: "Eloquent Internals: Hiểu sâu về Builder, Magic Methods và Life Cycle"
excerpt: Khám phá cách Laravel "phù phép" dữ liệu thông qua Eloquent, cơ chế hoạt động của Builder, giải mã các Magic Methods và quy trình khởi tạo Model từ Database.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-eloquent-internals.webp
tags: [laravel, eloquent, orm, php-internals, architecture]
---

Eloquent là một trong những tính năng mạnh mẽ nhất của Laravel, nhưng cũng là nơi dễ gây hiểu lầm nhất về mặt hiệu năng. Để trở thành một Senior Laravel Developer, bạn không thể chỉ biết dùng `User::all()`, bạn cần hiểu điều gì xảy ra bên dưới.

## 1. Giải mã "Ma thuật" (Magic Methods)

Eloquent dựa dẫm rất nhiều vào các Magic Methods của PHP để tạo ra cú pháp mượt mà (Fluent API).

- **`__get()` và `__set()`:** Khi bạn gọi `$user->name`, Eloquent không tìm thuộc tính `$name` trong class. Thay vào đó, nó gọi `__get('name')`, tìm kiếm trong mảng `$attributes`. Điều này cho phép Laravel thực hiện các logic như **Accessors** và **Mutators** một cách minh bạch.
- **`__call()` và `__callStatic()`:** Đây là cách Eloquent chuyển hướng từ Model sang `Eloquent\Builder`. Ví dụ, khi bạn gọi `User::where(...)`, bản chất là Laravel khởi tạo một Query Builder mới và "ủy quyền" việc thực thi cho nó.

## 2. Vòng đời của một Model (Model Life Cycle)

Mỗi khi bạn truy vấn dữ liệu, Eloquent trải qua các bước:

1. **Query Construction:** Builder xây dựng câu lệnh SQL.
2. **Hydration:** Đây là bước quan trọng nhất. Sau khi nhận kết quả từ DB, Laravel tạo ra các instance Model mới và đổ dữ liệu vào mảng `$attributes`. Event `retrieved` sẽ được bắn ra ở bước này.
3. **Synchronization:** Laravel lưu trữ một bản sao của dữ liệu gốc trong mảng `$original`. Khi bạn gọi `save()`, nó so sánh `$attributes` và `$original` để chỉ cập nhật những cột thực sự thay đổi (Dirty check).

## 3. Builder vs Query Builder: Sự phân hóa trách nhiệm

- **`Illuminate\Database\Query\Builder`:** Là lớp thấp nhất, chịu trách nhiệm tạo ra các câu SQL thuần túy (`select`, `join`, `where`). Nó không biết gì về Model.
- **`Illuminate\Database\Eloquent\Builder`:** Là lớp bao bọc (wrapper). Nó sử dụng Query Builder để lấy dữ liệu, nhưng sau đó thực hiện các nhiệm vụ của ORM như: nạp các quan hệ (Eager Loading), áp dụng Global Scopes, và chuyển đổi kết quả thành các Model object.

## 4. Tối ưu hóa: Eager Loading Internals

Lỗi N+1 xảy ra khi bạn truy cập quan hệ mà không khai báo trước. Cơ chế nạp của Laravel hoạt động như sau:

1. **Lazy Loading:** Mỗi lần bạn gọi `$user->posts`, một câu query mới được bắn vào DB. Nếu có 100 user, bạn có 100 query.
2. **Eager Loading (`with`):** Laravel thu thập tất cả ID của user, sau đó chỉ chạy **duy nhất 1 câu query** với toán tử `WHERE IN (id1, id2, ...)`. Sau đó, nó map kết quả vào từng user object bằng cách duyệt mảng trong PHP. Tốc độ PHP xử lý mảng nhanh hơn hàng nghìn lần so với round-trip tới Database.

## 5.Câu hỏi nhanh

**Câu hỏi:** Tại sao việc sử dụng `update(['status' => 'active'])` trên một Builder (`User::where(...)->update(...)`) lại không kích hoạt các Eloquent Observers như `updated` hay `updating`?

**Trả lời:**
Bởi vì khi bạn gọi `update()` trực tiếp trên Builder, Laravel sẽ thực thi câu lệnh SQL `UPDATE ...` thẳng xuống Database thông qua Query Builder mà **không qua bước Hydration**. Do không có instance Model nào được tạo ra hoặc thay đổi trạng thái trong bộ nhớ PHP, các sự kiện của Model (Observers) sẽ không được kích hoạt.
*Giải pháp:* Nếu cần Observers, bạn phải lấy Model về (`get()`), lặp qua và update từng cái, hoặc sử dụng các giải pháp thay thế như `DB::transaction`.

## 6. Kết luận

Làm chủ Eloquent là làm chủ tư duy về cách dữ liệu di chuyển trong hệ thống. Đừng coi nó là phép thuật, hãy coi nó là một công cụ có cấu trúc và logic rõ ràng.
