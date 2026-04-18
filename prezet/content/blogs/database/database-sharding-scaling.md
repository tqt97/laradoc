---
title: "Database Sharding: Chiến lược Scale cho hàng Terabyte dữ liệu"
excerpt: Giải mã Sharding - cách chia nhỏ database để xử lý hàng triệu query mỗi giây và những cạm bẫy 'Hot Shard'.
date: 2026-04-18
category: Database
image: /prezet/img/ogimages/blogs-database-database-sharding-scaling.webp
tags: [database, sharding, scalability, system-design]
---

## 1. Vấn đề

Khi Database của bạn đạt tới giới hạn của một server vật lý (CPU/RAM/Disk), việc tiếp tục upgrade server (Vertical Scaling) trở nên quá đắt đỏ và có giới hạn.

## 2. Định nghĩa Sharding

Sharding là kỹ thuật chia nhỏ dữ liệu của một bảng khổng lồ ra nhiều database instances khác nhau. Mỗi shard chỉ chứa một phần dữ liệu (ví dụ: User có ID 1-1tr ở Shard A, 1tr-2tr ở Shard B).

## 3. Quizz phỏng vấn

**Câu hỏi:** Làm thế nào để giải quyết vấn đề "Cross-shard Query" (query dữ liệu nằm ở nhiều shard)?
**Trả lời:**

- Tốt nhất là thiết kế lại Schema để dữ liệu liên quan nằm cùng Shard (ví dụ: Orders của User A phải cùng Shard với User A).
- Nếu không thể, dùng một lớp **Aggregator** ở tầng Application để chạy query song song ở các shard rồi gộp kết quả lại (chậm và tốn tài nguyên).

**Câu hỏi mẹo:** Thế nào là "Hot Shard"?
**Trả lời:** Là tình trạng một shard nhận được quá nhiều traffic so với các shard còn lại. Nguyên nhân thường do "Sharding Key" không tốt (ví dụ shard theo `region`, nhưng 90% user của bạn lại nằm ở US).
