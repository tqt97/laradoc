---
title: "Circuit Breaker Pattern: Bảo vệ hệ thống trước sự cố dây chuyền"
excerpt: Giải thích cơ chế bảo vệ hệ thống khi service phụ thuộc bị lỗi bằng Circuit Breaker Pattern.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-circuit-breaker-pattern.webp
tags: [architecture, distributed-systems, reliability, microservices]
---

Khi Service A gọi Service B, nhưng Service B bị treo. Request của A sẽ timeout, tốn tài nguyên và có thể làm A sập theo. **Circuit Breaker** (Cầu chì) là giải pháp chặn đứng sự cố này.

## 1. 3 Trạng thái của Cầu chì

- **Closed (Đóng):** Mọi thứ bình thường. Request được gửi đi.
- **Open (Mở):** Service B lỗi liên tục. Cầu chì tự ngắt. Mọi request tới B bị chặn ngay tại A và trả về lỗi mặc định (Fallback).
- **Half-Open (Nửa đóng):** Sau một thời gian, cầu chì cho thử nghiệm một vài request. Nếu thành công, đóng cầu chì lại. Nếu lỗi, mở lại.

## 2. Tại sao Senior cần nó?

Trong hệ thống phân tán, mạng là không tin cậy. Circuit Breaker giúp hệ thống có khả năng tự phục hồi (Self-healing).

## 3. Kết luận

Đừng để lỗi của một service làm sập cả hệ thống. Hãy sử dụng Circuit Breaker (như Guzzle middleware hoặc thư viện riêng) để bảo vệ dịch vụ của bạn.
