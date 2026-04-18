---
title: "Saga Pattern: Giải quyết bài toán Transaction trong Microservices"
excerpt: Làm thế nào để đảm bảo tính nhất quán dữ liệu khi một giao dịch kéo dài qua nhiều service độc lập? Tìm hiểu về Saga Pattern, Orchestration và Choreography.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-saga-pattern-microservices.webp
tags: [architecture, microservices, saga-pattern, distributed-systems, transactions]
---

Trong kiến trúc Monolith, chúng ta có thể dễ dàng dùng Database Transaction (ACID) để đảm bảo: hoặc là mọi thứ thành công, hoặc là không có gì thay đổi. Nhưng trong thế giới **Microservices**, mỗi service có Database riêng. Làm sao để "Rollback" tiền của khách hàng khi service Đơn hàng bị lỗi nhưng service Thanh toán đã trừ tiền xong?

## 1. Saga Pattern là gì?

Saga là một chuỗi các giao dịch cục bộ (local transactions). Mỗi giao dịch cập nhật database trong một service và bắn ra một thông điệp (event/message) để kích hoạt giao dịch tiếp theo trong service kế tiếp.

## 2. Hai cách triển khai Saga

### 2.1 Choreography (Điều phối phân tán)

Các service giao tiếp với nhau qua các Event. Service A làm xong -> bắn Event -> Service B nghe thấy Event đó -> làm việc của mình -> bắn Event tiếp theo.

- **Ưu điểm:** Đơn giản, không có điểm nghẽn trung tâm.
- **Nhược điểm:** Khó theo dõi luồng dữ liệu (Spaghetti flow) khi hệ thống lớn.

### 2.2 Orchestration (Điều phối tập trung)

Có một service trung tâm (Orchestrator) đóng vai trò là "nhạc trưởng". Nó ra lệnh cho Service A, chờ phản hồi, rồi ra lệnh tiếp cho Service B.

- **Ưu điểm:** Luồng nghiệp vụ tập trung, dễ quản lý trạng thái.
- **Nhược điểm:** Orchestrator có thể trở thành "God Object" hoặc điểm lỗi duy nhất (SPOF).

## 3. "Rollback" trong Saga: Compensating Transactions

Vì không có lệnh `ROLLBACK` toàn cục, chúng ta phải viết các hàm **Bù đắp (Compensating)**. Nếu bước 3 lỗi, Orchestrator sẽ gọi ngược lại bước 2 và bước 1 để thực hiện logic đảo ngược (ví dụ: cộng lại tiền vào ví, hủy đơn hàng).

## 4.Câu hỏi nhanh

**Câu hỏi:** Saga Pattern giải quyết vấn đề về tính nhất quán theo mô hình nào? ACID hay BASE?

**Trả lời:**
Saga giải quyết theo mô hình **BASE** (Basically Available, Soft state, Eventual consistency). Nó chấp nhận rằng hệ thống sẽ có một khoảng thời gian dữ liệu chưa đồng nhất (Soft state) nhưng cuối cùng sẽ đạt được trạng thái nhất quán (Eventual Consistency). Nó không thể đạt được tính **Isolation (I)** của ACID vì các giao dịch khác có thể nhìn thấy dữ liệu trung gian của một Saga đang chạy.

**Câu hỏi mẹo:** Làm thế nào để xử lý nếu hàm Bù đắp (Compensating Transaction) cũng bị lỗi?
**Trả lời:** Hệ thống phải có cơ chế **Retry** vĩnh viễn cho hàm bù đắp hoặc đẩy vào **Dead Letter Queue (DLQ)** để kỹ thuật can thiệp thủ công. Hàm bù đắp bắt buộc phải có tính **Idempotent** (thực hiện nhiều lần kết quả không đổi).

## 5. Kết luận

Saga là một mẫu thiết kế phức tạp nhưng không thể thiếu trong hệ thống phân tán. Hãy chỉ dùng nó khi bạn thực sự cần sự tách biệt giữa các service.
