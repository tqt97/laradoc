---
title: "Saga Pattern: Giải quyết giao dịch phân tán"
excerpt: Giải pháp thay thế cho 2PC (Two-Phase Commit) trong Microservices. Cách thực hiện Saga bằng Events/Orchestrator trong Laravel.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-saga-distributed-transactions.webp
tags: [architecture, microservices, saga, distributed-systems]
---

## 1. Bài toán
Trong Microservices, nếu bạn thực hiện `Update Stock` ở Service A, nhưng `Charge Credit` ở Service B thất bại, làm sao rollback Service A? Không thể dùng DB Transaction thông thường (XA) vì mỗi service dùng 1 DB riêng.

## 2. Giải pháp: Saga Pattern
Saga là một chuỗi các local transaction. Nếu một bước thất bại, Saga sẽ trigger một chuỗi **Compensating Transaction** (Giao dịch bù trừ) để hoàn tác các bước trước đó.

## 3. Kiến trúc
- **Choreography:** Các service nói chuyện qua Event. Service A hoàn tất -> bắn Event -> Service B tự nghe.
- **Orchestration:** Có một "Người điều phối" (Orchestrator) ra lệnh cho từng service làm gì, nếu lỗi thì ra lệnh rollback.

## 4. Câu hỏi nhanh
**Q: Sự khác biệt lớn nhất giữa Saga và 2PC?**
**A:** 2PC khóa dữ liệu (Blocking), rất chậm và dễ gây deadlock. Saga không khóa, nó dùng Compensation để duy trì "Eventual Consistency".
**Q: Khi nào dùng Orchestrator?**
**A:** Khi workflow quá phức tạp, việc để các service tự truyền event (Choreography) sẽ gây khó khăn trong việc debug luồng đi.
