---
title: "Laravel Eloquent & Builder: Chinh phục ORM"
description: Đi sâu vào mã nguồn của Eloquent, cơ chế hoạt động của Query Builder, các kỹ thuật quan hệ phức tạp và tối ưu hóa truy vấn trong Laravel.
date: 2026-02-17
tags: [laravel, eloquent, orm, database, sql, architecture]
image: /prezet/img/ogimages/knowledge-vi-laravel-eloquent-builder.webp
---

> Eloquent không chỉ là một ORM, nó là một ngôn ngữ biểu diễn dữ liệu." Hiểu sâu về Eloquent giúp bạn viết code thanh thoát, ngắn gọn nhưng vẫn đảm bảo hiệu năng tối đa.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Eloquent Model thực chất là gì?</summary>

  **Trả lời:**
  Là một class implement mẫu thiết kế **Active Record**. Mỗi instance của Model đại diện cho một hàng trong table, và class Model chứa các method để thao tác với table đó.
</details>

<details>
  <summary>Q2: Phân biệt `get()` và `all()`.</summary>

  **Trả lời:**
  - `all()`: Là method static, luôn lấy toàn bộ bản ghi.
  - `get()`: Là method của Builder, dùng sau khi đã nối chuỗi các điều kiện (ví dụ: `where(...)->get()`).
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: "Magic Methods" đóng vai trò gì trong Eloquent?</summary>

  **Trả lời:**
  Eloquent dùng `__get` và `__set` để map các thuộc tính của object với các cột trong DB. Khi bạn gọi `$user->name`, Eloquent sẽ tìm trong mảng `$attributes` của model thay vì tìm thuộc tính class thật.
</details>

<details>
  <summary>Q2: Giải thích cơ chế "Local Scopes" và "Global Scopes".</summary>

  **Trả lời:**
  - **Local Scope:** Method bắt đầu bằng `scope`, dùng để gom nhóm các điều kiện query hay dùng (ví dụ: `scopeActive`). Gọi: `User::active()->get()`.
  - **Global Scope:** Tự động áp dụng điều kiện cho MỌI query của model (ví dụ: `SoftDeletes` dùng global scope để ẩn các hàng có `deleted_at`).
</details>

<details>
  <summary>Q3: Quan hệ "Has Many Through" dùng khi nào?</summary>

  **Trả lời:**
  Dùng để truy cập quan hệ từ xa qua một model trung gian. Ví dụ: `Project` -> `Environment` -> `Deployment`. Để lấy tất cả deployments của một project, ta dùng `hasManyThrough`.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Eloquent khởi tạo Query Builder như thế nào? (Internals)</summary>

  **Trả lời:**
  Khi bạn gọi một method static (ví dụ `User::where(...)`), magic method `__callStatic` sẽ được kích hoạt. Nó khởi tạo một instance của model, gọi `newQuery()`, và forward lời gọi tới đối tượng `Eloquent\Builder`.
</details>

<details>
  <summary>Q2: Phân tích hiệu năng của Polymorphic Relationships (Quan hệ đa hình).</summary>

  **Trả lời:**
  Đa hình giúp linh hoạt (1 bảng comment cho cả Post và Video) nhưng gây khó khăn cho việc đánh Index và Referential Integrity (không thể dùng Foreign Key vật lý). Với bảng dữ liệu lớn, đa hình thường chậm hơn so với việc tách bảng riêng.
</details>

<details>
  <summary>Q3: Kỹ thuật "Custom Casts" (PHP 8 Attribute style).</summary>

  **Trả lời:**
  Laravel 9+ cho phép định nghĩa các class Cast riêng. Bạn có thể tự động mã hóa/giải mã dữ liệu, hoặc biến đổi JSON phức tạp thành một Value Object ngay khi truy cập thuộc tính model.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Khi nào nên kế thừa `Eloquent\Builder` để viết Custom Builder?</summary>

  **Trả lời:**
  Khi model có quá nhiều logic query phức tạp làm "phình" file Model. Việc tách ra Custom Builder giúp tuân thủ nguyên lý Single Responsibility và giúp IDE hỗ trợ gợi ý code tốt hơn.
</details>

<details>
  <summary>Q2: Thiết kế hệ thống "Auditing" tự động lưu vết thay đổi model dùng Eloquent Observers.</summary>

  **Trả lời:**
  Tạo một `AuditTrait` sử dụng `bootAuditTrait`. Lắng nghe các event `updated`, `created`, `deleted`. So sánh `$model->getOriginal()` với `$model->getAttributes()` để tìm ra các cột bị thay đổi và lưu vào bảng `audits`.
</details>

## Câu hỏi Phỏng vấn (Interview Style)

<details>
  <summary>Q: Tại sao không nên dùng `Model::count()` bên trong vòng lặp?</summary>

  **Trả lời:**
  Vì mỗi lần gọi là 1 câu query `SELECT COUNT(*)` riêng biệt gửi tới DB. Nếu có 1000 vòng lặp, bạn tốn 1000 query. Giải pháp: Lấy data về trước rồi dùng `$collection->count()` (đếm trên RAM) hoặc dùng `withCount()` để lấy số lượng ngay trong query gốc.
</details>

<details>
  <summary>Q: Làm thế nào để thực hiện query "Subquery select" bằng Eloquent?</summary>

  **Trả lời:**
  Dùng method `addSelect()` truyền vào một closure hoặc một đối tượng Builder khác. Ví dụ: lấy tên bài viết mới nhất ngay trong query danh sách user.
</details>

## Mẹo và thủ thuật

- **`toRawSql()` (Laravel 10+):** Dùng để xem câu query SQL thực tế kèm dữ liệu đã được bind, cực kỳ hữu ích để debug.
- **`preventLazyLoading()`:** Luôn bật trong môi trường Local để ném lỗi ngay lập tức khi bạn quên dùng `with()`.
