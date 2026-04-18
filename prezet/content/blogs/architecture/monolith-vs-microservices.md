---
title: "Monolith vs Microservices: Khi nào nên 'chia tay' khối thống nhất?"
excerpt: Phân tích sâu ưu và nhược điểm của kiến trúc đơn khối và vi dịch vụ, lộ trình chuyển đổi và những bài học thực tế về việc "vội vàng" áp dụng Microservices.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-monolith-vs-microservices.webp
tags: [architecture, microservices, monolith, scalability, system-design, distributed-systems]
---

"Microservices" là từ khóa thời thượng mà mọi lập trình viên đều muốn đưa vào CV. Tuy nhiên, trong thực tế, Microservices là một giải pháp cực kỳ đắt đỏ về cả hạ tầng lẫn nhân sự. 90% dự án khởi nghiệp thất bại khi cố gắng áp dụng nó quá sớm.

## 1. Monolith: Sức mạnh của sự đơn giản

Kiến trúc đơn khối (Monolith) là nơi toàn bộ ứng dụng nằm chung trong một codebase.

- **Ưu điểm:** Dễ phát triển, dễ deploy, dễ test và hiệu năng cực tốt (vì không tốn chi phí gọi mạng giữa các service). Mọi thứ nằm trong một Transaction duy nhất.
- **Nhược điểm:** Khi team quá lớn (50+ người), việc quản lý code trở thành thảm họa. Một lỗi nhỏ ở module Log có thể làm sập toàn bộ hệ thống thanh toán.

## 2. Microservices: Chia để trị

Chia ứng dụng thành các dịch vụ nhỏ, độc lập, giao tiếp qua API hoặc Message Queue.

- **Ưu điểm:** Scale độc lập từng phần (ví dụ service xử lý ảnh cần nhiều CPU hơn), team làm việc song song không dẫm chân nhau. Cho phép sử dụng nhiều ngôn ngữ lập trình khác nhau.
- **Nhược điểm:** Phức tạp kinh khủng về hạ tầng (Kubernetes, Service Mesh, Tracing). Khó đảm bảo dữ liệu nhất quán (Data Consistency).

## 3. Khi nào nên chuyển đổi?

Đừng bao giờ bắt đầu bằng Microservices. Hãy bắt đầu bằng một **Modular Monolith** (Code tập trung nhưng chia module rõ ràng). Hãy chuyển sang Microservices CHỈ KHI:

1. **Team quá lớn:** Việc phối hợp trên 1 repo trở nên quá chậm chạp.
2. **Nhu cầu Scale đặc thù:** Một phần của hệ thống cần tài nguyên gấp 100 lần các phần khác.
3. **Độ cô lập cao:** Bạn muốn một lỗi ở module này tuyệt đối không được ảnh hưởng đến module kia.

## 4. Quizz cho phỏng vấn Senior

**Câu hỏi:** Làm thế nào để đảm bảo tính nhất quán của dữ liệu (Data Consistency) khi một hành động nghiệp vụ cần cập nhật dữ liệu ở 2 Microservices khác nhau (ví dụ: Trừ tiền ở Service Ví và Tạo đơn ở Service Đơn hàng)?

**Trả lời:**
Trong hệ thống phân tán, chúng ta không thể dùng Database Transaction (ACID) truyền thống. Giải pháp là sử dụng **Saga Pattern**.

- **Saga** chia nghiệp vụ thành một chuỗi các transaction cục bộ.
- Mỗi bước thực hiện xong sẽ bắn Event cho bước tiếp theo.
- Nếu một bước ở giữa bị lỗi, hệ thống phải thực hiện các **Compensating Transactions** (Giao dịch bù) để hoàn tác các bước trước đó.
Điều này giúp hệ thống đạt được trạng thái **Eventual Consistency** (Nhất quán sau cùng). Nếu không có Saga, bạn sẽ gặp tình trạng khách bị trừ tiền nhưng không có đơn hàng.

## 5. Kết luận

Đừng dùng búa tạ để giết kiến. Nếu bạn vừa bắt đầu dự án hoặc team còn nhỏ, hãy trung thành với Monolith. Microservices không phải là mục tiêu, nó là một công cụ để giải quyết vấn đề về quy mô (Scale).
