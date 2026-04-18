---
title: "Event-Driven Architecture với Kafka: Hệ thần kinh của Microservices"
excerpt: Hiểu cách Kafka hoạt động như một backbone cho hệ thống event-driven, cơ chế Partitioning, Consumer Groups và đảm bảo tính nhất quán.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-event-driven-kafka-concepts.webp
tags: [architecture, kafka, event-driven, messaging, microservices]
---

Trong hệ thống Microservices, nếu các service gọi nhau trực tiếp qua HTTP, bạn sẽ tạo ra một mạng lưới phụ thuộc chằng chịt. **Event-Driven Architecture** với **Kafka** là cách để gỡ rối.

## 1. Bản chất

Kafka là một Log-based Message Broker. Thay vì xóa tin nhắn khi đã gửi, nó lưu tất cả vào "Commit Log" và cho phép các Consumer đọc lại bất cứ lúc nào.

## 2. Các thành phần quan trọng

- **Topics:** Danh mục tin nhắn.
- **Partitions:** Cách chia nhỏ Topic để scale ngang.
- **Consumer Groups:** Giúp nhiều worker cùng xử lý 1 topic mà không bị trùng lặp.

## 3. Quizz phỏng vấn

**Câu hỏi:** Làm sao Kafka đảm bảo thứ tự tin nhắn?
**Trả lời:** Kafka chỉ đảm bảo thứ tự trong cùng **một Partition**. Các Producer cần sử dụng cùng một `Key` để đảm bảo các tin nhắn liên quan (ví dụ: các sự kiện của cùng 1 Order) luôn rơi vào cùng 1 Partition.

**Câu hỏi mẹo:** Phân biệt RabbitMQ và Kafka?
**Trả lời:** RabbitMQ giống như một "bưu điện" chuyển phát nhanh (xử lý xong là xóa), phù hợp cho tác vụ đơn lẻ. Kafka giống như "băng ghi âm" lưu trữ (dữ liệu có thể replay), phù hợp cho hệ thống cần audit hoặc processing luồng dữ liệu khổng lồ.
