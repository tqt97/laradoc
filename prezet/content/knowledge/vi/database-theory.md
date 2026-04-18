---
title: "Lý thuyết Cơ sở dữ liệu: Nền tảng của Sự bền vững"
description: Hệ thống hơn 50 câu hỏi về ACID, Indexing chuyên sâu, Transaction Isolation, Query Optimization và Scaling Database.
date: 2026-04-14
tags: [database, sql, acid, indexing, theory]
image: /prezet/img/ogimages/knowledge-vi-database-theory.webp
---

> Dữ liệu là tài sản quý giá nhất. Hiểu cách lưu trữ và truy xuất hiệu quả là kỹ năng bắt buộc của một Backend Engineer.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Hệ quản trị CSDL quan hệ (RDBMS) là gì?</summary>
  
  **Trả lời:**
  Là hệ thống quản lý dữ liệu dựa trên mô hình quan hệ (bảng). Dữ liệu được tổ chức thành các bảng có hàng và cột, liên kết với nhau qua Khóa ngoại.
</details>

<details>
  <summary>Q2: Khóa chính (Primary Key) và Khóa ngoại (Foreign Key) là gì?</summary>
  
  **Trả lời:**

- Khóa chính: Định danh duy nhất một hàng trong bảng.
- Khóa ngoại: Cột dùng để liên kết với khóa chính của bảng khác.

</details>

<details>
  <summary>Q3: SQL là gì?</summary>
  
  **Trả lời:**
  Structured Query Language. Ngôn ngữ tiêu chuẩn để tương tác với RDBMS (truy vấn, thêm, sửa, xóa dữ liệu).
</details>

<details>
  <summary>Q4: Phân biệt lệnh `DELETE` và `TRUNCATE`.</summary>
  
  **Trả lời:**

- `DELETE`: Xóa từng hàng (có thể dùng WHERE), chậm hơn, có thể rollback.
- `TRUNCATE`: Xóa toàn bộ dữ liệu trong bảng, cực nhanh, không thể rollback từng hàng.

</details>

<details>
  <summary>Q5: Giá trị `NULL` trong Database nghĩa là gì?</summary>
  
  **Trả lời:**
  Nghĩa là "không có giá trị" hoặc "dữ liệu chưa xác định". Khác hoàn toàn với số 0 hoặc chuỗi rỗng.
</details>

<details>
  <summary>Q6: Câu lệnh `JOIN` dùng để làm gì?</summary>
  
  **Trả lời:**
  Dùng để kết hợp dữ liệu từ hai hoặc nhiều bảng dựa trên một cột chung (thường là khóa ngoại).
</details>

<details>
  <summary>Q7: Ràng buộc (Constraint) trong DB là gì?</summary>
  
  **Trả lời:**
  Quy tắc áp dụng cho cột dữ liệu để đảm bảo tính toàn vẹn (ví dụ: NOT NULL, UNIQUE, CHECK).
</details>

<details>
  <summary>Q8: Tại sao cần phải chuẩn hóa (Normalize) database?</summary>
  
  **Trả lời:**
  Để giảm thiểu dư thừa dữ liệu và tránh các lỗi logic khi thêm/sửa/xóa dữ liệu.
</details>

<details>
  <summary>Q9: Database Schema là gì?</summary>
  
  **Trả lời:**
  Là bản vẽ thiết kế cấu trúc của toàn bộ cơ sở dữ liệu, bao gồm các bảng, cột, kiểu dữ liệu và mối quan hệ.
</details>

<details>
  <summary>Q10: Ý nghĩa của câu lệnh `GROUP BY`?</summary>
  
  **Trả lời:**
  Dùng để nhóm các hàng có cùng giá trị lại với nhau để thực hiện các hàm tính toán (như SUM, COUNT, AVG).
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Tính chất ACID trong Database là gì?</summary>
  
  **Trả lời:**
  4 tính chất của Transaction: Atomicity (Nguyên tử), Consistency (Nhất quán), Isolation (Cô lập), Durability (Bền vững).
</details>

<details>
  <summary>Q2: Indexing (Đánh chỉ mục) là gì? Tại sao nó giúp tăng tốc tìm kiếm?</summary>
  
  **Trả lời:**
  Giống mục lục sách. DB dùng cấu trúc B-Tree để tìm dữ liệu theo O(log n) thay vì quét toàn bộ bảng O(n).
</details>

<details>
  <summary>Q3: Phân biệt INNER JOIN, LEFT JOIN, và RIGHT JOIN.</summary>
  
  **Trả lời:**

- INNER: Chỉ lấy các bản ghi có ở cả 2 bảng.
- LEFT: Lấy tất cả bảng bên trái + bản ghi khớp ở bảng phải (không khớp thì NULL).
- RIGHT: Ngược lại với LEFT.

</details>

<details>
  <summary>Q4: Database Transaction là gì? Khi nào cần dùng?</summary>
  
  **Trả lời:**
  Là một đơn vị công việc gồm nhiều câu lệnh. Cần dùng khi muốn đảm bảo hoặc tất cả thành công, hoặc không có gì thay đổi (ví dụ: chuyển tiền ngân hàng).
</details>

<details>
  <summary>Q5: Composite Index là gì? Cần lưu ý gì về thứ tự các cột?</summary>
  
  **Trả lời:**
  Index trên nhiều cột. Thứ tự cột cực kỳ quan trọng (nguyên tắc Left-to-Right). Index (A, B) hỗ trợ search (A) hoặc (A, B) nhưng KHÔNG hỗ trợ search (B) đơn lẻ.
</details>

<details>
  <summary>Q6: Stored Procedure và Function khác nhau như thế nào?</summary>
  
  **Trả lời:**
  Procedure có thể trả về nhiều giá trị hoặc không, dùng cho logic nghiệp vụ phức tạp. Function luôn trả về 1 giá trị và có thể dùng trực tiếp trong câu lệnh SELECT.
</details>

<details>
  <summary>Q7: Database Trigger là gì?</summary>
  
  **Trả lời:**
  Đoạn code tự động thực thi khi có sự kiện Insert, Update hoặc Delete xảy ra trên một bảng cụ thể.
</details>

<details>
  <summary>Q8: Giải thích dạng chuẩn 1NF, 2NF, 3NF.</summary>
  
  **Trả lời:**

- 1NF: Cột nguyên tố (atomic).
- 2NF: 1NF + mọi cột phụ thuộc vào toàn bộ khóa chính.
- 3NF: 2NF + không có sự phụ thuộc bắc cầu giữa các cột.

</details>

<details>
  <summary>Q9: Phân biệt `WHERE` và `HAVING`.</summary>
  
  **Trả lời:**
  `WHERE` lọc dữ liệu trước khi nhóm (group). `HAVING` lọc dữ liệu sau khi đã nhóm và tính toán hàm aggregate.
</details>

<details>
  <summary>Q10: "Database View" là gì? Lợi ích của nó?</summary>
  
  **Trả lời:**
  Là một bảng ảo dựa trên kết quả của một câu lệnh SELECT. Giúp bảo mật (che giấu cột nhạy cảm) và đơn giản hóa các truy vấn phức tạp.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Giải thích về Locking: Pessimistic Lock vs Optimistic Lock.</summary>
  
  **Trả lời:**
  Pessimistic: Khóa ngay khi đọc (dùng SELECT FOR UPDATE). Optimistic: Không khóa, check phiên bản lúc ghi (dùng version/updated_at).
</details>

<details>
  <summary>Q2: Database Isolation Levels là gì? (MySQL mặc định là cái nào?)</summary>
  
  **Trả lời:**
  Quy định mức độ cô lập giữa các transaction. MySQL mặc định là **Repeatable Read**. Các mức khác: Read Uncommitted, Read Committed, Serializable.
</details>

<details>
  <summary>Q3: Giải thích hiện tượng "Dirty Read", "Non-repeatable Read" và "Phantom Read".</summary>
  
  **Trả lời:**

- Dirty: Đọc dữ liệu chưa commit của người khác.
- Non-repeatable: Cùng 1 hàng, 2 lần đọc ra kết quả khác nhau.
- Phantom: Câu lệnh SELECT 2 lần ra số lượng hàng khác nhau (do người khác insert thêm).

</details>

<details>
  <summary>Q4: B-Tree Index và Hash Index khác nhau như thế nào về bản chất?</summary>
  
  **Trả lời:**
  B-Tree: Sắp xếp theo thứ tự, hỗ trợ tìm theo khoảng (`>`, `<`). Hash: Chỉ tìm chính xác (`=`), cực nhanh O(1) nhưng không sắp xếp được.
</details>

<details>
  <summary>Q5: Kỹ thuật "Query Execution Plan" (EXPLAIN) dùng để làm gì?</summary>
  
  **Trả lời:**
  Giúp dev biết DB xử lý câu query như thế nào: có dùng index không, quét bao nhiêu hàng, join theo kiểu nào. Từ đó biết cách tối ưu.
</details>

<details>
  <summary>Q6: "Deadlock" là gì? Cách hệ quản trị DB xử lý nó?</summary>
  
  **Trả lời:**
  Khi 2 transaction đợi nhau giải phóng khóa mãi mãi. DB thường tự phát hiện và "hy sinh" 1 transaction (rollback) để bên kia tiếp tục.
</details>

<details>
  <summary>Q7: Full-text Search index khác gì với B-Tree index?</summary>
  
  **Trả lời:**
  Full-text dùng Inverted Index để tìm kiếm từ khóa bên trong các đoạn văn bản dài, hỗ trợ tìm kiếm mờ (fuzzy search), điều mà B-Tree làm rất kém (`LIKE %...%`).
</details>

<details>
  <summary>Q8: Giải thích cơ chế MVCC (Multi-Version Concurrency Control).</summary>
  
  **Trả lời:**
  DB giữ lại các phiên bản cũ của dữ liệu. Giúp các lệnh Đọc không bị block bởi các lệnh Ghi và ngược lại, tăng hiệu năng đồng thời cực lớn.
</details>

<details>
  <summary>Q9: Phân biệt "Clustered Index" và "Non-clustered Index".</summary>
  
  **Trả lời:**
  Clustered: Dữ liệu thực tế được sắp xếp vật lý theo index này (thường là Primary Key). Non-clustered: Chỉ chứa con trỏ trỏ tới vị trí dữ liệu thực tế.
</details>

<details>
  <summary>Q10: "N+1 Problem" ở mức Database thuần túy xử lý như thế nào?</summary>
  
  **Trả lời:**
  Dùng JOIN hoặc sử dụng toán tử `IN` để lấy toàn bộ dữ liệu liên quan trong 1 lần truy vấn thay vì lặp lại nhiều lần.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế giải pháp cho Database khi bảng log đạt tới 1 tỷ hàng.</summary>
  
  **Trả lời:**

  1. **Partitioning:** Chia bảng theo thời gian (tháng/năm). 2. **Archiving:** Đẩy dữ liệu cũ sang Cold Storage (S3). 3. **Sharding:** Chia dữ liệu sang nhiều server vật lý khác nhau.

</details>

<details>
  <summary>Q2: Khi nào bạn chọn NoSQL thay vì RDBMS? Phân tích CAP theorem.</summary>
  
  **Trả lời:**
  CAP: Consistency, Availability, Partition Tolerance. Một hệ thống phân tán chỉ có thể chọn 2 trong 3. Chọn NoSQL khi cần Availability cao và Schema linh hoạt (Big Data).
</details>

<details>
  <summary>Q3: Giải thích cơ chế Replication (Master-Slave) và ứng dụng.</summary>
  
  **Trả lời:**
  Master xử lý Ghi, tự động đồng bộ dữ liệu sang các Slave để xử lý Đọc. Giúp tăng throughput và khả năng dự phòng (High Availability).
</details>

<details>
  <summary>Q4: Thiết kế hệ thống đánh ID toàn cầu (Distributed ID Generator) như Snowflake.</summary>
  
  **Trả lời:**
  Đảm bảo ID duy nhất, có tính sắp xếp theo thời gian và không phụ thuộc vào 1 server duy nhất. Snowflake dùng: Timestamp + Worker ID + Sequence.
</details>

<details>
  <summary>Q5: "Database Sharding" - Làm thế nào để chọn Sharding Key hiệu quả?</summary>
  
  **Trả lời:**
  Key phải giúp dữ liệu phân bổ đều giữa các shard, tránh "Hot Shard" (1 shard quá tải). Thường dùng `user_id` hoặc băm (hash) một trường định danh.
</details>

<details>
  <summary>Q6: Phân tích chiến lược "Database Migration" trong hệ thống Microservices.</summary>
  
  **Trả lời:**
  Mỗi service có database riêng. Dùng "Expand and Contract" pattern để thay đổi schema mà không làm sập các service phụ thuộc.
</details>

<details>
  <summary>Q7: Giải thích về "Write-Ahead Logging" (WAL).</summary>
  
  **Trả lời:**
  Mọi thay đổi phải được ghi vào log trước khi ghi vào file dữ liệu chính. Đảm bảo tính Durability: nếu server sập, DB có thể dùng log để khôi phục lại trạng thái đúng.
</details>

<details>
  <summary>Q8: Thiết kế giải pháp "Soft Delete" ở quy mô lớn để không ảnh hưởng hiệu năng query.</summary>
  
  **Trả lời:**
  Dùng cột `deleted_at`. Tạo partial index (chỉ index các hàng có `deleted_at IS NULL`). Hoặc định kỳ move dữ liệu đã xóa sang một bảng `_archive` riêng.
</details>

<details>
  <summary>Q9: Làm thế nào để đảm bảo tính nhất quán dữ liệu giữa các Microservices (Saga Pattern)?</summary>
  
  **Trả lời:**
  Thay vì dùng 2PC (Two-Phase Commit) chậm chạp, dùng Saga: một chuỗi các transaction cục bộ. Nếu 1 bước lỗi, bắn event để thực hiện "Compensating transactions" để hoàn tác các bước trước.
</details>

<details>
  <summary>Q10: Sự khác biệt giữa OLTP và OLAP trong kiến trúc dữ liệu.</summary>
  
  **Trả lời:**
  OLTP (Online Transactional Processing): Tối ưu cho việc ghi/đọc nhanh, nhiều transaction nhỏ (MySQL). OLAP (Online Analytical Processing): Tối ưu cho việc phân tích, báo cáo trên tập dữ liệu khổng lồ (ClickHouse, BigQuery).
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Câu query chạy 10 giây trên Production nhưng chạy 0.1 giây trên Local. Tại sao?</summary>
  
  **Xử lý:** Khác biệt về lượng dữ liệu (Data volume), cấu hình server, hoặc do index trên Prod bị phân mảnh. Cần chạy `EXPLAIN` trực tiếp trên Prod.
</details>

<details>
  <summary>S2: Bạn vô tình xóa nhầm 1 bảng quan trọng trên Prod. Các bước khôi phục?</summary>
  
  **Xử lý:** 1. Ngừng các tiến trình ghi. 2. Tìm bản backup gần nhất. 3. Sử dụng Binlog (MySQL) để "replay" các dữ liệu từ thời điểm backup đến trước thời điểm xóa nhầm (Point-in-time recovery).
</details>

## Nên biết

- ACID là gì.
- Cách hoạt động của Index.
- Sự khác biệt giữa SQL và NoSQL.

## Lưu ý

- Đánh index quá nhiều (làm chậm lệnh Insert/Update).
- Sử dụng `SELECT *` trong code (tốn bandwidth và RAM).
- Quên không đóng kết nối database (gây lỗi "Too many connections").

## Mẹo và thủ thuật

- Luôn sử dụng `EXPLAIN` cho mọi câu query quan trọng.
- Sử dụng `Integer` làm khóa chính thay vì `String` (UUID) nếu có thể để tối ưu index.
