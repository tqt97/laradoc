---
title: "Garbage Collection trong PHP: Cơ chế dọn rác giúp server 'sống sót'"
excerpt: Tìm hiểu sâu về Reference Counting, Cyclic References và cách Garbage Collector của PHP giải phóng bộ nhớ để ngăn chặn lỗi Memory Limit Exceeded.
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-garbage-collection-deep-dive.webp
tags: [php, internals, zend-engine, memory-management, performance]
---

Bạn đã bao giờ gặp lỗi `Allowed memory size exhausted`? Nguyên nhân thường là do biến của bạn chiếm dụng quá nhiều RAM và không được giải phóng kịp thời. Hiểu về **Garbage Collection (GC)** giúp bạn viết code tiết kiệm tài nguyên đến từng byte.

## 1. Cơ chế chính: Reference Counting (Bộ đếm tham chiếu)

Trong PHP, mỗi biến (`zval`) có một bộ đếm gọi là `refcount`.

- Khi bạn gán `$a = $b`, `refcount` của vùng nhớ đó tăng lên 1.
- Khi bạn gọi `unset($a)`, `refcount` giảm đi 1.
- **Quan trọng:** Khi `refcount` về bằng 0, PHP sẽ giải phóng vùng nhớ đó ngay lập tức.

## 2. Vấn đề: Cyclic References (Tham chiếu vòng)

Đây là "kẻ thù" của bộ đếm tham chiếu. Hãy tưởng tượng:

- Object A chứa tham chiếu tới Object B.
- Object B lại chứa tham chiếu tới Object A.
Ngay cả khi bạn `unset` cả A và B từ ngoài, `refcount` của chúng vẫn bằng 1 (vì chúng tự trỏ nhau). PHP sẽ không bao giờ giải phóng được vùng nhớ này nếu chỉ dựa vào bộ đếm.

## 3. Garbage Collector (Dọn rác theo chu kỳ)

Để giải quyết tham chiếu vòng, PHP có một bộ dọn rác chuyên dụng:

1. Nó gom các biến "nghi ngờ" (thường là Object hoặc Array lớn) vào một buffer (mặc định 10.000 phần tử).
2. Khi buffer đầy, thuật toán **Mark-and-Sweep** sẽ được kích hoạt.
3. Nó thử giả định giảm `refcount` của các biến nội bộ. Nếu sau khi giảm, một biến có `refcount = 0`, nó biết chắc chắn đây là rác và tiến hành dọn dẹp.

## 4.Câu hỏi nhanh

**Câu hỏi:** Tại sao việc tắt Garbage Collection (`gc_disable()`) đôi khi lại làm code chạy **nhanh hơn**?

**Trả lời:**
Vì quá trình dọn rác (Mark-and-Sweep) tốn CPU để duyệt qua các mảng và object phức tạp. Trong các script chạy ngắn (như một request web thông thường), việc dọn rác vòng đôi khi không cần thiết vì toàn bộ bộ nhớ sẽ được giải phóng khi request kết thúc. Tắt GC giúp giảm bớt overhead xử lý, tăng tốc độ thực thi cho các tác vụ tốn ít RAM.
*Lưu ý:* Tuyệt đối không tắt GC trong các script chạy lâu (như Queue Worker hoặc Artisan Commands chạy daemon) vì sẽ gây tràn bộ nhớ.

**Câu hỏi mẹo:** Làm thế nào để "ép" PHP dọn rác ngay lập tức?
**Trả lời:** Sử dụng hàm `gc_collect_cycles()`. Hàm này sẽ trả về số lượng tham chiếu vòng đã được giải phóng.

## 5. Kết luận

Hãy luôn nhớ quy tắc vàng: **"Dùng xong hãy Unset"**. Đặc biệt với các mảng dữ liệu khổng lồ hoặc các object chứa nhiều phụ thuộc. Hiểu về GC sẽ giúp bạn tự tin vận hành các hệ thống xử lý dữ liệu lớn (Big Data) bằng PHP.
