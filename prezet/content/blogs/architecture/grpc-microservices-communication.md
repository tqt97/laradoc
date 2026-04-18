---
title: "gRPC: Tương lai của giao tiếp giữa các Microservices"
excerpt: "gRPC vs REST: Khi nào nên đổi? Hiểu về Protocol Buffers, HTTP/2 và sức mạnh của Strong Typing trong hệ thống phân tán."
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-grpc-microservices-communication.webp
tags: [architecture, microservices, grpc, http2, performance]
---

Trong Microservices, nếu các service nói chuyện bằng JSON qua HTTP/1.1, bạn sẽ tốn rất nhiều tài nguyên cho việc parse string và overhead của header HTTP. **gRPC** là giải pháp tối ưu.

## 1. Tại sao gRPC?

- **Protocol Buffers (Protobuf):** Dữ liệu dạng nhị phân (binary), cực nhỏ và cực nhanh so với JSON.
- **HTTP/2:** Hỗ trợ Multiplexing (gửi nhiều request trên 1 connection), giảm độ trễ đáng kể.
- **Strong Typing:** Định nghĩa Service qua file `.proto`, giúp các service tự sinh ra code client/server, loại bỏ lỗi runtime sai format.

## 2. Khi nào dùng?

Dùng gRPC cho giao tiếp **Nội bộ (Inter-service)** vì nó cực nhanh và an toàn. Vẫn dùng REST/GraphQL cho **Frontend** vì trình duyệt chưa hỗ trợ hoàn hảo gRPC.

## 3. Câu hỏi nhanh

**Câu hỏi:** gRPC giải quyết lỗi Head-of-line blocking thế nào?
**Trả lời:** Nhờ HTTP/2 Multiplexing. Một kết nối TCP có thể xử lý hàng chục request/response song song mà không phải đợi cái cũ xong.
