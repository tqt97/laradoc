---
title: "Cơ sở dữ liệu trong Laravel: Eloquent và Hơn thế nữa (Expanded)"
description: Hệ thống hơn 50 câu hỏi về Eloquent ORM, Query Builder, Relationship chuyên sâu và Database Performance.
date: 2026-04-14
tags: [laravel, database, eloquent, orm, performance]
image: /prezet/img/ogimages/knowledge-vi-laravel-database.webp
---

# 📌 Chủ đề: Databases

Dữ liệu là huyết mạch của bất kỳ ứng dụng nào. Eloquent ORM của Laravel rất nổi tiếng, nhưng việc hiểu rõ cơ chế đằng sau nó là điều phân biệt giữa một nhà phát triển giỏi và một nhà phát triển xuất sắc.

## 🟢 Cấp độ: Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: ORM (cụ thể là Eloquent) là gì và tại sao nên sử dụng nó?</summary>
  
  **Trả lời:** 
  ORM là kỹ thuật thao tác DB qua đối tượng OOP. Giúp code dễ đọc, dễ bảo trì và ngăn chặn SQL Injection một cách tự nhiên.
</details>

<details>
  <summary>Q2: Mục đích của Migrations là gì?</summary>
  
  **Trả lời:** 
  Là hệ thống quản lý phiên bản cho database, giúp cả team đồng bộ cấu trúc bảng dễ dàng qua dòng lệnh.
</details>

<details>
  <summary>Q3: Giải thích sự khác biệt giữa `hasOne` và `belongsTo`.</summary>
  
  **Trả lời:** 
  Phụ thuộc vào vị trí Khóa ngoại (Foreign Key). Class nào chứa khóa ngoại thì dùng `belongsTo`. Class không chứa khóa ngoại thì dùng `hasOne`.
</details>

<details>
  <summary>Q4: DB Seeding dùng để làm gì?</summary>
  
  **Trả lời:** 
  Dùng để nạp dữ liệu mẫu (dummy data) vào database, hỗ trợ quá trình phát triển và testing.
</details>

<details>
  <summary>Q5: Query Builder là gì?</summary>
  
  **Trả lời:** 
  Là giao diện lập trình của Laravel giúp xây dựng các câu query SQL phức tạp một cách fluent (chuỗi hóa) mà không cần viết raw SQL.
</details>

<details>
  <summary>Q6: "Mass Assignment" là gì và làm thế nào để bảo vệ nó?</summary>
  
  **Trả lời:** 
  Là lỗ hổng khi user gửi thêm dữ liệu không mong muốn qua form. Bảo vệ bằng cách khai báo `$fillable` hoặc `$guarded` trong Model.
</details>

<details>
  <summary>Q7: Làm thế nào để lấy toàn bộ dữ liệu từ 1 bảng bằng Eloquent?</summary>
  
  **Trả lời:** 
  Dùng phương thức static `ModelName::all()`.
</details>

<details>
  <summary>Q8: Khái niệm "Soft Delete" là gì?</summary>
  
  **Trả lời:** 
  Thay vì xóa vĩnh viễn, Laravel đánh dấu cột `deleted_at`. Dữ liệu vẫn còn trong DB nhưng mặc định sẽ không hiện lên trong các câu query.
</details>

<details>
  <summary>Q9: Eloquent Model đại diện cho cái gì?</summary>
  
  **Trả lời:** 
  Mỗi Model đại diện cho một bảng trong Database. Mỗi instance (object) của Model đại diện cho một hàng (row) trong bảng đó.
</details>

<details>
  <summary>Q10: Sự khác biệt giữa lệnh `save()` và `create()`?</summary>
  
  **Trả lời:** 
  - `save()`: Dùng cho object đã khởi tạo, dùng được cho cả update. 
  - `create()`: Nhận vào 1 mảng dữ liệu, thực hiện mass assignment và tạo mới ngay lập tức.
</details>

---

## 🟡 Cấp độ: Trung cấp (Intermediate)

<details>
  <summary>Q1: Vấn đề "N+1 Query" là gì và bạn khắc phục nó như thế nào?</summary>
  
  **Trả lời:** 
  Lỗi fetch dữ liệu liên quan trong vòng lặp. Khắc phục bằng **Eager Loading** dùng phương thức `with(['relationship'])`.
</details>

<details>
  <summary>Q2: Khi nào bạn nên sử dụng "Query Builder" thay vì "Eloquent"?</summary>
  
  **Trả lời:** 
  Khi cần hiệu năng tối đa (giảm overhead tạo model), khi cần update/delete hàng loạt, hoặc khi viết các báo cáo phức tạp với nhiều phép Join.
</details>

<details>
  <summary>Q3: "Query Scopes" là gì và tại sao chúng quan trọng?</summary>
  
  **Trả lời:** 
  Cho phép đóng gói các điều kiện query hay dùng thành các method dễ đọc (ví dụ: `User::active()->get()`). Giúp code mang tính declarative.
</details>

<details>
  <summary>Q4: Giải thích quan hệ `belongsToMany` (Nhiều - Nhiều) và bảng Pivot.</summary>
  
  **Trả lời:** 
  Dùng bảng trung gian (pivot table) chứa khóa ngoại của cả 2 bảng chính. Ví dụ: `users`, `roles` và bảng pivot `role_user`.
</details>

<details>
  <summary>Q5: "Accessors" và "Mutators" dùng để làm gì?</summary>
  
  **Trả lời:** 
  - Accessors: Định dạng lại dữ liệu khi lấy ra (ví dụ: viết hoa tên). 
  - Mutators: Biến đổi dữ liệu trước khi lưu vào DB (ví dụ: băm mật khẩu).
</details>

<details>
  <summary>Q6: DB Transactions trong Laravel hoạt động như thế nào?</summary>
  
  **Trả lời:** 
  Dùng `DB::transaction(function () { ... })`. Đảm bảo các lệnh bên trong hoặc cùng thành công, hoặc cùng thất bại (rollback).
</details>

<details>
  <summary>Q7: Sự khác biệt giữa `get()`, `first()`, `find()` và `pluck()`?</summary>
  
  **Trả lời:** 
  - `get()`: Trả về 1 collection nhiều hàng. 
  - `first()`: Trả về 1 hàng đầu tiên. 
  - `find(id)`: Tìm theo khóa chính. 
  - `pluck('column')`: Chỉ lấy giá trị của 1 cột dưới dạng mảng.
</details>

<details>
  <summary>Q8: Làm thế nào để thực hiện các phép Join phức tạp bằng Query Builder?</summary>
  
  **Trả lời:** 
  Dùng các method `join()`, `leftJoin()`, `rightJoin()`, kèm theo các closure để định nghĩa các điều kiện ON phức tạp.
</details>

<details>
  <summary>Q9: "Lazy Eager Loading" là gì?</summary>
  
  **Trả lời:** 
  Khi bạn đã có 1 object model rồi mới quyết định load thêm quan hệ của nó bằng method `load()` (ví dụ: `$user->load('posts')`).
</details>

<details>
  <summary>Q10: "Database Factories" giúp ích gì cho quy trình Test?</summary>
  
  **Trả lời:** 
  Định nghĩa cấu trúc dữ liệu mẫu một cách tự động (dùng thư viện Faker). Giúp tạo hàng nghìn bản ghi để test hiệu năng hoặc tính năng cực nhanh.
</details>

---

## 🔴 Cấp độ: Nâng cao (Advanced)

<details>
  <summary>Q1: Cơ chế "Lazy Loading" của Eloquent hoạt động như thế nào bên dưới qua Magic Methods?</summary>
  
  **Trả lời:** 
  Dùng magic method `__get`. Khi truy cập thuộc tính không tồn tại (là tên quan hệ), Laravel tự động gọi method quan hệ tương ứng, execute query và cache kết quả vào `$relations`.
</details>

<details>
  <summary>Q2: Phân tích hiệu năng giữa `chunk()`, `cursor()` và `each()` khi xử lý 1 triệu bản ghi.</summary>
  
  **Trả lời:** 
  - `chunk`: Load từng đoạn dữ liệu (ví dụ 1000 hàng) vào RAM. 
  - `cursor`: Dùng PHP Generators, chỉ load DUY NHẤT 1 hàng vào RAM tại 1 thời điểm. Tối ưu nhất cho bộ nhớ. 
  - `each`: Thường dùng phối hợp với chunk.
</details>

<details>
  <summary>Q3: Giải thích về "Polymorphic Relationships" (Đa hình) và cấu tạo bảng.</summary>
  
  **Trả lời:** 
  1 model trỏ tới nhiều model khác nhau qua 2 cột: `id` và `type` (class name). Ví dụ: `Comment` có thể thuộc về `Post` hoặc `Video`.
</details>

<details>
  <summary>Q4: "Global Scopes" hoạt động như thế nào? Khi nào nó gây nguy hiểm?</summary>
  
  **Trả lời:** 
  Tự động áp dụng điều kiện cho MỌI câu query của model đó. Nguy hiểm: Nếu quên, dev có thể không hiểu tại sao query không ra dữ liệu (ví dụ: scope ẩn các user chưa active).
</details>

<details>
  <summary>Q5: Làm thế nào để tối ưu hóa Eager Loading với các ràng buộc (Constraining Eager Loads)?</summary>
  
  **Trả lời:** 
  Dùng mảng `with(['posts' => function($query) { $query->where('title', 'like', '%...%'); }])`.
</details>

<details>
  <summary>Q6: Eloquent Events (Observer) gồm những sự kiện nào và ứng dụng?</summary>
  
  **Trả lời:** 
  `creating`, `created`, `updating`, `updated`, `deleting`, `deleted`... Ứng dụng: tự động tạo slug, xóa file liên quan khi model bị xóa, ghi log thay đổi.
</details>

<details>
  <summary>Q7: Làm thế nào để thực hiện "Subquery" phức tạp bằng Eloquent?</summary>
  
  **Trả lời:** 
  Dùng phương thức `addSelect()` hoặc truyền một closure vào `where()`. Laravel hỗ trợ rất tốt việc lồng các câu query model vào nhau.
</details>

<details>
  <summary>Q8: Phân tích cơ chế "Casting" trong Eloquent (Json, Encrypted, AsCollection).</summary>
  
  **Trả lời:** 
  Tự động biến đổi kiểu dữ liệu giữa PHP và DB. `json` cast giúp lưu mảng PHP vào cột TEXT/JSON của DB và ngược lại một cách minh bạch.
</details>

<details>
  <summary>Q9: "Upsert" là gì và Laravel hỗ trợ nó như thế nào?</summary>
  
  **Trả lời:** 
  Update if exists, else Insert. Laravel dùng method `upsert()` để thực hiện thao tác này hàng loạt chỉ với 1 câu query SQL duy nhất, cực kỳ hiệu quả.
</details>

<details>
  <summary>Q10: Làm thế nào để log toàn bộ SQL queries đang chạy để debug hiệu năng?</summary>
  
  **Trả lời:** 
  Dùng `DB::enableQueryLog()` và `DB::getQueryLog()`. Hoặc dùng các công cụ như Laravel Debugbar hoặc Telescope.
</details>

---

## 🧠 Cấp độ: Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế hệ thống Database cho ứng dụng SaaS đa quốc gia, hỗ trợ hàng tỷ record.</summary>
  
  **Trả lời:** 
  Kiến trúc **Horizontal Sharding**. Chia dữ liệu theo Tenant ID hoặc khu vực địa lý. Sử dụng mô hình **Write Master - Read Replica**. Kết hợp các giải pháp NoSQL cho dữ liệu phi cấu trúc.
</details>

<details>
  <summary>Q2: Phân tích chiến lược "Database Read/Write Splitting" trong cấu hình Laravel.</summary>
  
  **Trả lời:** 
  Cấu hình trong `config/database.php` với mảng `read` và `write`. Laravel tự động điều hướng: các lệnh SELECT vào Slave, các lệnh còn lại (Insert/Update/Delete) vào Master.
</details>

<details>
  <summary>Q3: Làm thế nào để xử lý "Race Conditions" ở mức Database trong Laravel?</summary>
  
  **Trả lời:** 
  Dùng **Pessimistic Locking** (`sharedLock()` hoặc `lockForUpdate()`) để block các process khác. Hoặc dùng **Optimistic Locking** bằng cách kiểm tra version thủ công.
</details>

<details>
  <summary>Q4: Thiết kế hệ thống "Activity Log" (Audit Trail) cho toàn bộ thay đổi dữ liệu mà không làm chậm hệ thống chính.</summary>
  
  **Trả lời:** 
  Dùng Eloquent Observers bắn Event -> Đẩy vào Queue xử lý bất đồng bộ -> Lưu vào một DB riêng (NoSQL hoặc bảng chuyên dụng) để tránh làm nghẽn Main DB.
</details>

<details>
  <summary>Q5: Phân tích sự đánh đổi khi sử dụng UUID làm khóa chính thay vì Auto-increment Integer.</summary>
  
  **Trả lời:** 
   UUID: Bảo mật hơn (không đoán được ID), tốt cho Microservices. Đánh đổi: Index chậm hơn, tốn bộ nhớ hơn, gây phân mảnh index đĩa cứng do UUID không có tính sắp xếp (nên dùng UUID v7).
</details>

<details>
  <summary>Q6: Thiết kế kiến trúc "Database Archiving" cho dữ liệu lịch sử lâu đời.</summary>
  
  **Trả lời:** 
  Định kỳ chuyển dữ liệu cũ sang các bảng `_history` hoặc đẩy sang các giải pháp Data Warehouse như BigQuery/S3. Dùng middleware hoặc Dynamic Model để truy cập khi cần.
</details>

<details>
  <summary>Q7: Khi nào bạn sẽ quyết định viết Raw SQL thay vì dùng Eloquent hoàn toàn?</summary>
  
  **Trả lời:** 
  Khi gặp các câu query cực kỳ đặc thù của 1 loại DB (như JSON path nâng cao của PostgreSQL), khi cần join quá nhiều bảng (10+), hoặc khi profile thấy Eloquent đang chiếm > 50% thời gian xử lý request.
</details>

<details>
  <summary>Q8: Làm thế nào để đảm bảo "Zero Downtime" khi thực hiện các Migration thay đổi lớn cấu trúc bảng?</summary>
  
  **Trả lời:** 
  Dùng chiến lược 3 bước: 1. Thêm cột mới. 2. Dual-write (ghi cả 2 cột). 3. Background job copy data cũ sang mới. 4. Xóa cột cũ ở bản deploy sau.
</details>

<details>
  <summary>Q9: Phân tích cơ chế "Eloquent Model Caching" (thư viện bên thứ 3 vs tự xây dựng).</summary>
  
  **Trả lời:** 
  Cache theo ID hoặc theo query. Thách thức lớn nhất là **Cache Invalidation** khi dữ liệu thay đổi. Cần sử dụng Events để xóa cache tương ứng ngay lập tức.
</details>

<details>
  <summary>Q10: Tầm nhìn kiến trúc: Tại sao Eloquent lại chọn mẫu thiết kế Active Record thay vì Data Mapper?</summary>
  
  **Trả lời:** 
  Để tối ưu cho sự đơn giản và tốc độ phát triển (Developer Experience). Active Record cực kỳ phù hợp cho các ứng dụng Web thông dụng, nơi Model và Table có quan hệ gần như 1-1.
</details>

---

## 💻 Practical Scenarios (Thực chiến)

<details>
  <summary>S1: Website bị chậm kinh khủng khi số lượng comment của bài viết vượt quá 10,000. Cách tối ưu?</summary>
  
  **Xử lý:** 1. Đánh Index cột `post_id`. 2. Sử dụng Phân trang (Pagination). 3. Dùng Eager Loading cho user của comment. 4. Cân nhắc dùng kiến trúc phân cấp (Nested Sets) nếu là comment đa tầng.
</details>

<details>
  <summary>S2: Bạn cần đồng bộ dữ liệu giữa 2 database khác nhau (MySQL và PostgreSQL) hàng ngày. Giải pháp?</summary>
  
  **Xử lý:** Viết 1 Artisan Command chạy ngầm qua Scheduler. Dùng `DB::connection('mysql')->table(...)->chunk()` và Insert sang PostgreSQL theo từng khối để tránh tràn bộ nhớ.
</details>

---

## 🚨 MUST-KNOW

* Eager Loading vs Lazy Loading.
* Mass Assignment Protection.
* Database Transactions.

## ⚠️ Pitfalls

* Quên không dùng `with()` dẫn đến hàng trăm query thừa.
* Filter dữ liệu bằng Collection (`->filter()`) thay vì bằng Query (`->where()`) - làm chậm app cực lớn vì phải load hết data về PHP.
* Không đánh index cho các cột thường xuyên nằm trong điều kiện WHERE.

## 🧩 Tips & Tricks

* Dùng `toSql()` để xem câu lệnh SQL thực tế mà Eloquent sinh ra.
* Sử dụng `exists()` thay vì `count() > 0` để kiểm tra sự tồn tại (nhanh hơn nhiều).

---
*Biên soạn bởi Senior Backend & Database Specialist.*
