---
title: "Eloquent Hydration: Hành trình từ một mảng SQL thô đến một Model quyền năng"
excerpt: Khám phá cơ chế Hydration của Laravel - quá trình biến kết quả truy vấn Database thành các instance Model và cách tối ưu hóa nó cho các bảng dữ liệu lớn.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-eloquent-hydration-process.webp
tags: [laravel, eloquent, internals, database, performance, architecture]
---

Khi bạn chạy lệnh `User::all()`, Laravel không chỉ đơn giản là trả về dữ liệu từ Database. Có một quá trình phức tạp diễn ra ngầm gọi là **Hydration**. Hiểu rõ quá trình này sẽ giúp bạn giải thích tại sao Eloquent đôi khi lại "ngốn" RAM và làm thế nào để tối ưu hóa nó.

## 1. Hydration là gì?

"Hydrate" (nghĩa đen là làm cho đủ nước) trong lập trình là quá trình đổ dữ liệu từ một nguồn lưu trữ (như kết quả SQL thô) vào một đối tượng (Object) trong bộ nhớ.
Với Laravel, đó là khi Framework lấy một mảng các giá trị từ PDO và tạo ra các instance của class `User`, gán các giá trị đó vào mảng `$attributes` nội bộ của Model.

## 2. Quy trình 4 bước của Hydration

1. **Query Execution:** Query Builder thực thi câu lệnh SQL qua PDO và nhận về một mảng các `stdClass` hoặc mảng thô.
2. **Instance Creation:** Với mỗi hàng dữ liệu, Laravel khởi tạo một object Model mới (ví dụ: `new User`).
3. **Attribute Filling:** Laravel đổ dữ liệu thô vào mảng `$attributes` và đồng thời lưu một bản sao vào mảng `$original` (để phục vụ việc kiểm tra thay đổi sau này).
4. **Booting & Events:** Laravel gọi phương thức `boot()` của Model và bắn ra event `retrieved`.

## 3. Tại sao Hydration lại đắt đỏ?

Nếu bạn lấy ra 10.000 hàng dữ liệu:

- Laravel phải khởi tạo 10.000 object.
- Mỗi object lại tốn bộ nhớ cho các mảng `$attributes`, `$original`, `$relations`, `$casts`...
Đây chính là lý do tại sao dùng `User::all()` trên một bảng lớn thường gây lỗi **Out of Memory**.

## 4.Câu hỏi nhanh

**Câu hỏi:** Làm thế nào để bỏ qua bước Hydration khi bạn cần xử lý hàng triệu bản ghi trong Laravel?

**Trả lời:**
Sử dụng **Query Builder** thay vì **Eloquent**.
Thay vì: `User::all()`, hãy dùng `DB::table('users')->get()`.

- **Query Builder** chỉ trả về các mảng thô hoặc `stdClass` đơn giản. Nó không tốn chi phí khởi tạo Model, không có Observers, không có Accessors/Mutators. Hiệu năng sẽ nhanh hơn gấp nhiều lần và tiết kiệm RAM đáng kể.

**Câu hỏi mẹo:** Accessors (`getFooAttribute`) được thực thi ở giai đoạn nào của Hydration?
**Trả lời:** Không phải ở giai đoạn Hydration. Accessors chỉ được thực thi **tại runtime** khi bạn thực sự truy cập vào thuộc tính đó (ví dụ: `$user->full_name`). Dữ liệu thô trong `$attributes` vẫn được giữ nguyên bản.

## 5. Kết luận

Eloquent cực kỳ mạnh mẽ nhờ Hydration, nhưng cái giá phải trả là hiệu năng. Một Senior Developer giỏi là người biết khi nào nên tận dụng sự tiện lợi của Eloquent và khi nào nên quay về với Query Builder thuần túy để bảo vệ tài nguyên hệ thống.
