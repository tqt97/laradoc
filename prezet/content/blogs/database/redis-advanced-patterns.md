---
title: "Redis Advanced: Caching, Distributed Locks và hơn thế nữa"
excerpt: Redis không chỉ để làm cache. Tìm hiểu về Distributed Locks, Pub/Sub, và tối ưu bộ nhớ trong hệ thống phân tán.
date: 2026-04-18
category: Database
image: /prezet/img/ogimages/blogs-database-redis-advanced-patterns.webp
tags: [redis, database, caching, distributed-locks, performance]
---

## 1. Bản chất

Redis là một In-memory Data Structure Store. Nó nhanh vì dữ liệu nằm trong RAM và nó chạy đơn luồng (single-threaded) nên tránh được tranh chấp khóa phức tạp.

## 2. Distributed Locks với Redis

Trong hệ thống phân tán, khi 2 server cùng muốn update 1 đơn hàng, Database Lock là chưa đủ.

- Dùng `SET key value NX PX 10000` (NX: chỉ set nếu chưa có, PX: hết hạn sau 10s).
- **Nguyên tắc:** Luôn có TTL để tránh tình trạng "Deadlock" nếu server sập đột ngột trước khi xóa key.

## 3. Pub/Sub trong kiến trúc Event

Redis Pub/Sub là cách nhanh nhất để các service giao tiếp realtime. Tuy nhiên, nó không bền bỉ (tin nhắn gửi xong sẽ mất nếu không có ai nhận). Dùng `Redis Streams` nếu bạn cần sự bền bỉ.

## 4.Câu hỏi nhanh

**Câu hỏi:** Tại sao Redis dùng đơn luồng mà vẫn nhanh?
**Trả lời:** Vì nó tránh được context switching và locking overhead của đa luồng. I/O là nút thắt chính chứ không phải CPU.
**Câu hỏi mẹo:** Làm sao để tránh "Cache Avalanche" khi dùng Redis?
**Trả lời:** Thêm độ trễ ngẫu nhiên (Jitter) vào thời gian hết hạn (TTL) của cache để các key không cùng lúc "chết" đồng loạt.
