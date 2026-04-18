---
title: "PHP Fiber & Concurrency: Kỷ nguyên lập trình bất đồng bộ mới"
excerpt: Tìm hiểu sâu về Fiber trong PHP 8.1, cách nó thay đổi tư duy lập trình tuần tự và so sánh với Coroutines trong Go hay Event Loop của Node.js.
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-php-fiber-concurrency.webp
tags: [php, fiber, concurrency, asynchronous, internals]
---

Trước PHP 8.1, lập trình bất đồng bộ (Async) trong PHP thường dựa trên các extension như Swoole hoặc thư viện như ReactPHP/Amp với cú pháp Callback hoặc Promise khá cồng kềnh. **Fiber** xuất hiện như một "low-level primitive" giúp quản lý các luồng thực thi (concurrency) một cách tự nhiên hơn.

## 1. Fiber là gì?

Fiber là các "luồng" nhẹ (lightweight threads) cho phép bạn tạm dừng (suspend) một hàm và tiếp tục (resume) nó tại chính thời điểm đó. Khác với luồng (Thread) của hệ điều hành, Fiber được quản lý hoàn toàn bởi PHP Engine (Zend Engine), giúp tiết kiệm tài nguyên cực lớn.

## 2. Bản chất: "Cooperative Multitasking"

Fiber không chạy song song (parallel) thực sự như đa nhân CPU. Nó hoạt động theo cơ chế "hợp tác": Một Fiber phải chủ động nhường quyền điều khiển thì Fiber khác mới được chạy. Điều này giúp tránh hoàn toàn lỗi **Race Condition** mà các ngôn ngữ đa luồng như Java thường gặp phải.

## 3. Tại sao Fiber lại quan trọng?

Nó cho phép các Framework (như Laravel Octane hoặc ReactPHP) xử lý hàng nghìn kết nối I/O (gọi DB, gọi API) mà không làm "block" toàn bộ server.

## 4.Câu hỏi nhanh

**Câu hỏi:** Phân biệt sự khác biệt về mặt kiến trúc giữa **Fiber** của PHP và **Goroutine** của Go?

**Trả lời:**

- **Go (Preemptive):** Goroutine được điều phối bởi Scheduler của Go. Runtime có thể ngắt một Goroutine bất cứ lúc nào để ưu tiên luồng khác. Nó có thể chạy song song thực sự trên nhiều nhân CPU.
- **PHP Fiber (Cooperative):** PHP Fiber chỉ dừng lại khi bạn gọi `Fiber::suspend()`. Nó chạy trên một luồng duy nhất của tiến trình PHP. Nó tập trung vào việc tối ưu hóa I/O chờ đợi hơn là tính toán song song.

**Câu hỏi mẹo:** Fiber có giúp xử lý mảng 10 triệu phần tử nhanh hơn không?
**Trả lời:** Không. Fiber giải quyết bài toán "đợi" (I/O Bound). Với bài toán tính toán (CPU Bound), Fiber thậm chí còn làm chậm hơn một chút do chi phí chuyển đổi ngữ cảnh (Context Switching).

## 5. Kết luận

Fiber không dành cho tất cả mọi người, nhưng nếu bạn đang xây dựng các hệ thống cần throughput cao, hiểu về Fiber là chìa khóa để làm chủ hiệu năng PHP hiện đại.
