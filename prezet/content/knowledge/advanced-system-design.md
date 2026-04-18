---
title: "Advanced System Design: Thiết kế hệ thống chịu tải cao"
description: Hệ thống câu hỏi về Sharding, Partitioning, Load Balancing tầng 4/7, và kiến trúc High Availability cho Senior Engineer.
date: 2026-04-18
tags: [system-design, high-availability, database, scalability, architect]
image: /prezet/img/ogimages/knowledge-advanced-system-design.webp
---

## Trình độ Chuyên gia (Senior/Architect)

<details>
  <summary>Q1: Phân biệt Database Sharding và Database Partitioning.</summary>

  **Trả lời:**
  - **Partitioning (Phân vùng):** Chia nhỏ một bảng khổng lồ thành các phần nhỏ hơn nhưng vẫn nằm trong **cùng một database instance**. (Ví dụ: chia theo năm). Giúp query nhanh hơn nhưng không giải quyết được vấn đề quá tải tài nguyên của 1 server.
  - **Sharding (Phân mảnh):** Chia dữ liệu ra nhiều **server vật lý khác nhau**. Mỗi server (shard) chứa một phần dữ liệu. Đây là giải pháp scale ngang (Horizontal Scaling) thực sự cho dữ liệu hàng Terabyte.

</details>

<details>
  <summary>Q2: Load Balancer tầng 4 (L4) và tầng 7 (L7) khác nhau như thế nào?</summary>

  **Trả lời:**
  - **L4 (Transport Layer):** Điều hướng dựa trên địa chỉ IP và Port. Nó không đọc nội dung gói tin (như Header, Cookie). Cực nhanh, hiệu năng cao (ví dụ: HAProxy, AWS NLB).
  - **L7 (Application Layer):** Điều hướng dựa trên nội dung HTTP (URL path, Header, Cookie). Chậm hơn L4 một chút vì phải parse gói tin nhưng linh hoạt hơn (ví dụ: Nginx, AWS ALB).

</details>

<details>
  <summary>Q3: Giải thích hiện tượng 'Thundering Herd' khi sử dụng Cache.</summary>

  **Trả lời:**
  Xảy ra khi một Key cực kỳ "hot" bị hết hạn (expire). Hàng vạn request cùng lúc thấy Cache Miss và đồng loạt đổ bộ vào Database để nạp lại dữ liệu. Kết quả: Database bị sập ngay lập tức.
  **Giải pháp:** Sử dụng **Mutex Lock** (chỉ cho 1 request đi vào DB nạp cache) hoặc **Soft Expiration** (trả về dữ liệu cũ trong lúc 1 process ngầm nạp lại dữ liệu mới).

</details>

<details>
  <summary>Q4: CAP Theorem và sự đánh đổi giữa Consistency (C) và Availability (A)?</summary>

  **Trả lời:**
  CAP nói rằng trong một hệ thống phân tán có rủi ro đứt mạng (P - Partition Tolerance), bạn chỉ được chọn C hoặc A.
  - **CP (Ưu tiên nhất quán):** Nếu mạng lỗi, hệ thống thà báo lỗi cho người dùng chứ không trả về dữ liệu sai (ví dụ: Ngân hàng).
  - **AP (Ưu tiên sẵn sàng):** Nếu mạng lỗi, hệ thống trả về bất cứ dữ liệu gì nó có, dù có thể cũ (ví dụ: Facebook Feed).

</details>

<details>
  <summary>Q5: Thiết kế hệ thống 'Distributed ID Generator' (như Snowflake của Twitter).</summary>

  **Trả lời:**
  Trong hệ thống phân tán, dùng Auto-increment ID là thảm họa vì gây tranh chấp. Snowflake ID gồm 64 bit:
  - 1 bit dự phòng.
  - 41 bit Timestamp (ms).
  - 10 bit Machine ID (phân biệt các server).
  - 12 bit Sequence (số thứ tự sinh ra trong cùng 1 ms).
  Kết quả: ID duy nhất, không trùng lặp, có tính sắp xếp theo thời gian và sinh ra cực nhanh tại chỗ mà không cần gọi DB.

</details>

## Tình huống phỏng vấn thực tế

**S1: Hệ thống của bạn đang bị DDOS ở tầng ứng dụng (L7). Bạn xử lý thế nào?**
**Xử lý:**
1. Bật **Rate Limiting** gắt gao theo IP và UserID.
2. Sử dụng WAF (Cloudflare/AWS WAF) để chặn các pattern request bất thường.
3. Chuyển các trang tĩnh sang CDN hoàn toàn.
4. Implement cơ chế **Proof-of-Work** (như CAPTCHA) để làm nản lòng botnet.

**S2: Làm thế nào để thực hiện chuyển đổi Database từ MySQL sang PostgreSQL mà không làm gián đoạn hệ thống (Zero Downtime)?**
**Xử lý:**
1. Thiết lập **Dual-Write**: Code ghi dữ liệu vào cả 2 DB cùng lúc.
2. Chạy script **Backfill**: Copy dữ liệu cũ từ MySQL sang PostgreSQL ngầm.
3. So sánh dữ liệu (Data Verification) để đảm bảo khớp 100%.
4. Chuyển hướng Đọc (Read) sang PostgreSQL.
5. Ngắt kết nối MySQL.
