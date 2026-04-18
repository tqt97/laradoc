---
title: "Index trong MySQL: Khi nào là 'thuốc bổ', khi nào là 'thuốc độc'?"
excerpt: Tìm hiểu sâu về các loại Index, cơ chế B-Tree, quy tắc Leftmost Prefix và cách đánh Index thông minh để tối ưu hóa tốc độ truy vấn cho hệ thống hàng triệu record.
date: 2026-04-18
category: Database
image: /prezet/img/ogimages/blogs-database-indexing-than-chu.webp
tags: [database, mysql, performance, sql-optimization, b-tree]
---

Đánh Index cho mọi cột và kỳ vọng hệ thống chạy nhanh là sai lầm phổ biến nhất của các Web Developer. Index giống như một "con dao hai lưỡi": nếu dùng đúng, nó cứu rỗi hệ thống; nếu dùng sai, nó bóp nghẹt hiệu năng Ghi (Write) của bạn.

## 1. Cơ chế B-Tree: Tại sao Index lại nhanh?

Hầu hết Index trong MySQL (InnoDB) sử dụng cấu trúc **B+Tree**. Hãy tưởng tượng bạn đang tìm một từ trong cuốn từ điển 1000 trang:

- **Full Table Scan (O(n)):** Bạn lật từng trang một từ đầu đến cuối.
- **Index Scan (O(log n)):** Bạn sử dụng mục lục để nhảy thẳng đến trang chứa chữ cái đầu tiên của từ cần tìm.

Trong B+Tree, các giá trị được sắp xếp và lưu trữ trong các Node. Việc tìm kiếm chỉ tốn vài bước nhảy từ Root node xuống Leaf node, giúp giảm số lần đọc ổ cứng (Disk I/O) – "kẻ thù" số 1 của tốc độ.

## 2. Quy tắc "Trái qua Phải" (Leftmost Prefix Rule)

Đây là kiến thức quan trọng nhất khi làm việc với **Composite Index** (Index đa cột).
Giả sử bạn có Index trên 3 cột: `(city, district, street)`.

- **Query 1:** `WHERE city = 'HN'` → **Dùng được Index.**
- **Query 2:** `WHERE city = 'HN' AND district = 'CG'` → **Dùng được Index (Cực tốt).**
- **Query 3:** `WHERE district = 'CG' AND street = 'Xuan Thuy'` → **KHÔNG dùng được Index.** Vì bạn đã "nhảy cóc" qua cột `city`. MySQL không biết bắt đầu tìm từ đâu trên cây B-Tree.

## 3. Covering Index: Cảnh giới tối thượng của Tuning

Một câu query được coi là "hoàn hảo" khi nó là một **Index-only scan**.
Ví dụ: Bạn có Index `(email, status)`.
Câu lệnh: `SELECT status FROM users WHERE email = 'abc@gmail.com';`
MySQL sẽ lấy được giá trị `status` ngay từ trong cây Index và trả về luôn cho bạn mà **không cần nạp dữ liệu từ file Data** (thao tác này gọi là nạp hàng - Row Lookup). Thao tác này cực kỳ nhanh.

## 4. Khi nào Index là "thuốc độc"?

Đừng bao giờ đánh Index cho các cột:

- **Có độ chọn lọc thấp (Low Cardinality):** Ví dụ cột `gender` (chỉ có Nam/Nữ). MySQL thường sẽ bỏ qua Index này và quét toàn bộ bảng vì việc dùng Index còn tốn thời gian hơn.
- **Bảng thường xuyên Ghi (Heavy Write):** Mỗi khi bạn `INSERT` hoặc `UPDATE`, MySQL phải cập nhật lại tất cả các cây B-Tree liên quan. Quá nhiều Index sẽ làm chậm lệnh Ghi một cách khủng khiếp.

## 5. Quizz cho phỏng vấn Senior

**Câu hỏi:** Tại sao một câu query có `WHERE column LIKE '%abc%'` lại không thể sử dụng Index, trong khi `WHERE column LIKE 'abc%'` lại có thể?

**Trả lời:**
Bản chất B-Tree sắp xếp dữ liệu theo thứ tự từ trái qua phải.

- Với `abc%`, MySQL biết chắc chắn phải tìm ở vùng các từ bắt đầu bằng 'a', sau đó đến 'b'... nên nó có thể "nhảy" trên cây Index.
- Với `%abc%`, ký tự đầu tiên có thể là bất cứ thứ gì. MySQL buộc phải quét toàn bộ Index (hoặc bảng) để tìm kiếm chuỗi 'abc' nằm ở bất kỳ đâu.

## 6. Kết luận

- Luôn dùng `EXPLAIN` trước khi kết luận một câu query chạy nhanh hay chậm.
- Ưu tiên Composite Index cho các cặp cột luôn đi kèm nhau.
- Đừng lạm dụng Index, hãy đánh Index dựa trên thực tế các câu query thường xuyên nhất.
