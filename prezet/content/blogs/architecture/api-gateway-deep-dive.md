---
title: "API Gateway Pattern: Cổng vào cho Microservices"
excerpt: Giải mã API Gateway, cách nó đảm nhận Authentication, Rate Limiting và Aggregation trong kiến trúc Microservices.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-api-gateway-deep-dive.webp
tags: [architecture, microservices, api-gateway, system-design]
---

## 1. Vấn đề

Trong Microservices, client gọi trực tiếp hàng chục service con làm tăng độ phức tạp phía client (phải quản lý nhiều endpoint, handle auth ở mọi service).

## 2. Định nghĩa

API Gateway là Reverse Proxy đứng trước tập hợp các Microservices. Mọi traffic phải đi qua Gateway này.

## 3. Vai trò chính

- **Authentication/Authorization:** Kiểm tra token tập trung.
- **Rate Limiting:** Chặn spam, bảo vệ service con.
- **Aggregation:** Nhận 1 request, gọi song song 3-4 service con, gộp data trả về 1 cục (giảm round-trip cho mobile).

## 4. Câu hỏi nhanh

**Q: API Gateway có gây Single Point of Failure (SPOF) không?**
**A:** Có. Giải pháp: Chạy Gateway theo cụm (cluster), deploy nhiều instance sau 1 load balancer và monitor chặt chẽ.

**Q: Tại sao gọi là "BFF" (Backend For Frontend)?**
**A:** Là một loại API Gateway chuyên biệt cho từng loại Client (Web/Mobile). BFF giúp tối ưu payload (Mobile chỉ lấy field cần thiết) thay vì dùng chung 1 Gateway lớn cho mọi platform.
