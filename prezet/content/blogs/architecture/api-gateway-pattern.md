---
title: "API Gateway Pattern: Cổng vào cho Microservices"
excerpt: Giải mã API Gateway, cách nó đảm nhận Authentication, Rate Limiting, Logging và Aggregation trong kiến trúc Microservices.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-api-gateway-pattern.webp
tags: [architecture, microservices, api-gateway, system-design]
---

## 1. Bài toán
Trong Microservices, client không nên gọi trực tiếp hàng chục service con. Việc quản lý auth, rate limit, logging ở mỗi service riêng lẻ là "cơn ác mộng".

## 2. Định nghĩa
API Gateway đóng vai trò là "người gác cổng" duy nhất, là Reverse Proxy nằm giữa Client và tập hợp Microservices.

## 3. Cách giải quyết
- **Routing:** Trỏ request tới service phù hợp.
- **Authentication:** Kiểm tra JWT tập trung tại đây, tránh việc service nào cũng phải check auth.
- **Rate Limiting:** Chặn các client spam API ngay từ cửa.
- **Aggregation:** Nhận 1 request từ Client -> Gọi 3-4 service con -> Gom dữ liệu lại và trả về 1 response duy nhất (giảm số lần request cho mobile app).

## 4. Quizz phỏng vấn
**Q: Tại sao API Gateway có thể trở thành "Single Point of Failure" (SPOF)?**
**A:** Vì nó đứng đầu mọi request. Nếu nó sập, cả hệ thống sập.
**Giải pháp:** Triển khai Gateway theo cụm (cluster), chạy nhiều node sau Load Balancer và monitoring chặt chẽ.

## 5. Kết luận
API Gateway giúp client đơn giản hóa giao tiếp và giúp hệ thống phía sau (Microservices) ẩn mình, dễ bảo mật và quản lý hơn.
