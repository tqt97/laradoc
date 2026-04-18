---
title: Thiết kế Database Chuẩn hóa & Kinh nghiệm Thực chiến
description: Hướng dẫn thiết kế cấu trúc dữ liệu từ cơ bản đến nâng cao, các dạng chuẩn hóa (Normalization), chiến lược Indexing và các pattern thiết kế database trong thực tế.
date: 2026-03-02
tags: [database, sql, design, indexing, normalization, performance]
image: /prezet/img/ogimages/knowledge-database-design-practice.webp
---

> Một database tồi có thể làm hỏng cả một ứng dụng tốt." Thiết kế database là việc xây dựng nền móng cho ngôi nhà. Nền móng yếu thì nhà không thể cao.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Dạng chuẩn 1 (1NF) là gì?</summary>

  **Trả lời:**
  1. Mỗi ô (cell) chỉ chứa một giá trị nguyên tố (Atomic). Không được chứa danh sách (ví dụ: cột `tags` không nên chứa "php,laravel").
  2. Mỗi hàng phải là duy nhất (có Khóa chính).
</details>

<details>
  <summary>Q2: Khóa chính (Primary Key) vs Khóa ngoại (Foreign Key).</summary>

  **Trả lời:**
  - **Primary Key:** Định danh duy nhất một hàng trong bảng (không được null).
  - **Foreign Key:** Cột trỏ tới Primary Key của bảng khác, dùng để tạo mối quan hệ và đảm bảo tính toàn vẹn (Referential Integrity).
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Phân biệt Dạng chuẩn 2 (2NF) và Dạng chuẩn 3 (3NF).</summary>

  **Trả lời:**
  - **2NF:** Đã là 1NF và mọi cột không phải khóa phải phụ thuộc hoàn toàn vào Khóa chính (loại bỏ phụ thuộc một phần).
  - **3NF:** Đã là 2NF và mọi cột không phải khóa phải phụ thuộc TRỰC TIẾP vào Khóa chính (loại bỏ phụ thuộc bắc cầu qua cột khác).
</details>

<details>
  <summary>Q2: Khi nào thì nên dùng UUID thay vì Auto-increment ID?</summary>

  **Trả lời:**
  - **UUID:** Khi dùng Microservices (không lo trùng ID giữa các node), bảo mật hơn (không đoán được tổng số record), dễ dàng gộp data.
  - **Auto-increment:** Khi cần hiệu năng Index cao nhất, tốn ít dung lượng ổ cứng, dễ debug và sắp xếp theo thời gian.
</details>

<details>
  <summary>Q3: "Denormalization" (Phản chuẩn hóa) là gì? Tại sao lại dùng nó?</summary>

  **Trả lời:**
  Là việc cố tình vi phạm các dạng chuẩn (ví dụ: copy tên user vào bảng orders) để tăng tốc độ Đọc (SELECT) bằng cách giảm bớt các phép JOIN tốn kém. Đánh đổi: tốn thêm dung lượng và khó khăn khi cập nhật dữ liệu (Update).
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Chiến lược đánh Index hiệu quả cho bảng có 100 triệu record.</summary>

  **Trả lời:**
  1. Chỉ đánh Index cho các cột thường xuyên nằm trong `WHERE`, `JOIN`, `ORDER BY`.
  2. Ưu tiên **Composite Index** (Index đa cột) theo thứ tự từ cột có độ chọn lọc (Cardinality) cao nhất đến thấp nhất.
  3. Tránh đánh Index cho các cột có quá ít giá trị (ví dụ: cột giới tính).
  4. Sử dụng **Partial Index** (nếu DB hỗ trợ) để chỉ index các hàng active.
</details>

<details>
  <summary>Q2: Giải thích về "Full-text Search" trong Database.</summary>

  **Trả lời:**
  Sử dụng cấu trúc **Inverted Index** để tìm kiếm từ khóa bên trong các đoạn văn bản dài. Nhanh hơn hàng nghìn lần so với lệnh `LIKE '%keyword%'`.
</details>

<details>
  <summary>Q3: Database Sharding hoạt động như thế nào?</summary>

  **Trả lời:**
  Chia 1 bảng khổng lồ thành nhiều bảng nhỏ nằm trên các server vật lý khác nhau dựa trên một **Shard Key** (ví dụ: `user_id`). Server 1 lưu user 1-1tr, Server 2 lưu user 1tr-2tr.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế Database cho hệ thống E-commerce đa quốc gia, đa tiền tệ.</summary>

  **Trả lời:**
  1. Dùng **ISO codes** cho quốc gia (VN, US) và tiền tệ (VND, USD).
  2. Lưu mọi số tiền dưới dạng con số nguyên (Integer) đơn vị nhỏ nhất (ví dụ: lưu 100 cent thay vì 1.00 USD) để tránh sai số dấu phẩy động.
  3. Sử dụng múi giờ UTC cho mọi cột timestamp.
</details>

<details>
  <summary>Q2: Phân tích sự đánh đổi giữa SQL và NoSQL trong thực tế.</summary>

  **Trả lời:**
  - **SQL (ACID):** Ưu tiên tính nhất quán dữ liệu, phù hợp cho tài chính, giao dịch.
  - **NoSQL (BASE):** Ưu tiên tính sẵn sàng và khả năng scale ngang, phù hợp cho log, feed, dữ liệu không cấu định.
  Architect thường chọn giải pháp **Polyglot Persistence**: dùng cả 2 trong 1 hệ thống.
</details>

## Câu hỏi Phỏng vấn (Interview Style)

<details>
  <summary>Q: Làm thế nào để thực hiện Zero-downtime Migration khi thay đổi cấu trúc bảng lớn?</summary>

  **Chiến lược:** 
  1. Tạo bảng mới với cấu trúc mới. 
  2. Dùng Trigger hoặc Dual-write để ghi data vào cả 2 bảng. 
  3. Chạy background job để copy data cũ sang mới. 
  4. Chuyển code sang đọc bảng mới. 
  5. Xóa bảng cũ.
</details>

<details>
  <summary>Q: "N+1 Problem" xử lý ở tầng Database như thế nào?</summary>

  **Trả lời:**
  Sử dụng phép `JOIN` hoặc toán tử `IN` để lấy toàn bộ data liên quan trong 1 lần gọi duy nhất. Tuy nhiên, nếu JOIN quá nhiều bảng sẽ gây chậm, lúc đó nên tách thành 2-3 query đơn giản dùng `IN`.
</details>

## Kinh nghiệm thực chiến

- **Soft Delete:** Luôn đánh index cho cột `deleted_at`.
- **JSON Column:** Chỉ dùng khi dữ liệu thực sự không có cấu trúc cố định. Đừng lạm dụng để tránh biến SQL thành NoSQL nửa vời.
- **Constraints:** Luôn dùng Foreign Key và Check Constraints ở mức Database. Code có thể sai, nhưng DB phải là chốt chặn cuối cùng bảo vệ dữ liệu.
