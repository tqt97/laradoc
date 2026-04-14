---
title: "HTTP & Web Fundamentals: Nền tảng của Internet (Expanded)"
description: Hệ thống hơn 50 câu hỏi chuyên sâu về HTTP/2, HTTP/3, Security Headers, Web Caching và RESTful API.
date: 2026-04-14
tags: [http, web, rest, security, fundamentals]
image: /prezet/img/ogimages/knowledge-vi-http-web-fundamentals.webp
---

# 📌 Chủ đề: HTTP & Web Fundamentals

Một Senior Backend Engineer không chỉ biết viết code, mà phải là chuyên gia về cách dữ liệu di chuyển trên Internet.

## 🟢 Cấp độ: Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Giao thức HTTP là gì? Giải thích sự khác biệt giữa HTTP và HTTPS.</summary>
  
  **Trả lời:** 
  HTTP (HyperText Transfer Protocol) là ngôn ngữ giao tiếp giữa trình duyệt và máy chủ. HTTPS là HTTP cộng thêm lớp bảo mật SSL/TLS để mã hóa dữ liệu.
</details>

<details>
  <summary>Q2: Phân biệt các phương thức (Methods) phổ biến: GET, POST, PUT, DELETE.</summary>
  
  **Trả lời:** 
  GET (Lấy dữ liệu), POST (Tạo mới), PUT (Cập nhật toàn bộ), DELETE (Xóa).
</details>

<details>
  <summary>Q3: Ý nghĩa của các đầu mã trạng thái (Status Codes) 2xx, 3xx, 4xx, 5xx?</summary>
  
  **Trả lời:** 
  2xx (Thành công), 3xx (Chuyển hướng), 4xx (Lỗi Client), 5xx (Lỗi Server).
</details>

<details>
  <summary>Q4: URL và URI khác nhau như thế nào?</summary>
  
  **Trả lời:** 
  URI (Uniform Resource Identifier) là định danh tài nguyên. URL (Uniform Resource Locator) là một loại URI cung cấp cách để tìm thấy tài nguyên đó (địa chỉ).
</details>

<details>
  <summary>Q5: Header trong HTTP request/response dùng để làm gì?</summary>
  
  **Trả lời:** 
  Dùng để truyền metadata (thông tin bổ sung) như kiểu dữ liệu (Content-Type), thông tin trình duyệt (User-Agent), hoặc cơ chế cache.
</details>

<details>
  <summary>Q6: Query String là gì?</summary>
  
  **Trả lời:** 
  Là phần sau dấu `?` trong URL (ví dụ: `?id=1&name=abc`) dùng để gửi thêm dữ liệu lên server trong request GET.
</details>

<details>
  <summary>Q7: Trình duyệt gửi dữ liệu lên server như thế nào qua form?</summary>
  
  **Trả lời:** 
  Qua `application/x-www-form-urlencoded` (mặc định) hoặc `multipart/form-data` (khi có upload file).
</details>

<details>
  <summary>Q8: Payload trong HTTP request là gì?</summary>
  
  **Trả lời:** 
  Là phần thân (Body) của request chứa dữ liệu thực tế (thường là JSON hoặc XML) gửi lên server.
</details>

<details>
  <summary>Q9: LocalStorage và SessionStorage khác nhau như thế nào?</summary>
  
  **Trả lời:** 
  LocalStorage lưu vĩnh viễn cho đến khi bị xóa. SessionStorage chỉ lưu trong phiên làm việc (tab trình duyệt hiện tại).
</details>

<details>
  <summary>Q10: Cookie là gì và có giới hạn dung lượng không?</summary>
  
  **Trả lời:** 
  Cookie là mẩu dữ liệu nhỏ lưu ở trình duyệt. Giới hạn thường là 4KB và tối đa 20-50 cookie mỗi domain.
</details>

---

## 🟡 Cấp độ: Trung cấp (Intermediate)

<details>
  <summary>Q1: Phân biệt Cookie và Session. Laravel lưu trữ chúng như thế nào?</summary>
  
  **Trả lời:** 
  Cookie lưu ở Client, Session lưu ở Server. Laravel dùng Cookie để lưu Session ID, từ đó map với dữ liệu trên Server (file, Redis, DB).
</details>

<details>
  <summary>Q2: Stateless và Stateful là gì? Tại sao RESTful API lại nên là Stateless?</summary>
  
  **Trả lời:** 
  Stateless giúp hệ thống dễ scale vì Server không cần nhớ trạng thái của Client giữa các request.
</details>

<details>
  <summary>Q3: CORS (Cross-Origin Resource Sharing) là gì?</summary>
  
  **Trả lời:** 
  Cơ chế bảo mật trình duyệt ngăn chặn gọi API khác domain nếu server đó không cho phép qua header `Access-Control-Allow-Origin`.
</details>

<details>
  <summary>Q4: Sự khác biệt giữa PUT và PATCH?</summary>
  
  **Trả lời:** 
  PUT dùng để thay thế hoàn toàn tài nguyên. PATCH dùng để cập nhật một phần tài nguyên.
</details>

<details>
  <summary>Q5: Giải thích khái niệm Idempotency trong HTTP.</summary>
  
  **Trả lời:** 
  Một method là lũy đẳng nếu thực hiện 1 lần hay nhiều lần kết quả vẫn như nhau (GET, PUT, DELETE). POST không lũy đẳng.
</details>

<details>
  <summary>Q6: JWT (JSON Web Token) cấu tạo gồm những phần nào?</summary>
  
  **Trả lời:** 
  3 phần: Header (thuật toán), Payload (dữ liệu), Signature (chữ ký để kiểm tra tính toàn vẹn).
</details>

<details>
  <summary>Q7: Cơ chế Round-robin trong Load Balancing là gì?</summary>
  
  **Trả lời:** 
  Điều phối các request tuần tự tới danh sách các server để chia tải đồng đều.
</details>

<details>
  <summary>Q8: Tại sao dùng mã 301 tốt hơn 302 cho SEO?</summary>
  
  **Trả lời:** 
  301 (Vĩnh viễn) giúp chuyển sức mạnh (link juice) từ URL cũ sang URL mới. 302 (Tạm thời) không làm điều này.
</details>

<details>
  <summary>Q9: Keep-Alive trong HTTP là gì?</summary>
  
  **Trả lời:** 
  Cơ chế giữ cho kết nối TCP luôn mở để gửi nhiều request/response trên cùng một kết nối, giảm overhead tạo kết nối mới.
</details>

<details>
  <summary>Q10: XSS và CSRF là gì? Cách phòng chống cơ bản?</summary>
  
  **Trả lời:** 
  XSS: Chèn script độc hại vào trang web (Fix: escape output). CSRF: Giả mạo request từ người dùng (Fix: dùng CSRF Token).
</details>

---

## 🔴 Cấp độ: Nâng cao (Advanced)

<details>
  <summary>Q1: HTTP/2 khác gì HTTP/1.1? Giải thích về Multiplexing.</summary>
  
  **Trả lời:** 
  HTTP/2 hỗ trợ Multiplexing (gửi nhiều request/response đồng thời trên 1 TCP connection), Header Compression (HPACK) và Server Push.
</details>

<details>
  <summary>Q2: Giải thích cơ chế hoạt động của HTTPS (Handshake SSL/TLS).</summary>
  
  **Trả lời:** 
  Client chào hỏi -> Server gửi Certificate -> Client kiểm tra và gửi Pre-master secret (mã hóa bằng Public Key của Server) -> Cả hai tạo Session Key (Symmetric) để trao đổi dữ liệu sau đó.
</details>

<details>
  <summary>Q3: HTTP/3 và QUIC protocol giải quyết vấn đề gì của TCP?</summary>
  
  **Trả lời:** 
  Giải quyết vấn đề Head-of-line blocking của TCP. QUIC chạy trên UDP, giúp kết nối nhanh hơn và ổn định hơn khi mạng chập chờn.
</details>

<details>
  <summary>Q4: Giải thích các Header bảo mật: HSTS, CSP, X-Frame-Options.</summary>
  
  **Trả lời:** 
  - HSTS: Ép trình duyệt luôn dùng HTTPS.
  - CSP: Quy định những nguồn script/ảnh nào được phép load.
  - X-Frame-Options: Ngăn chặn Clickjacking bằng cách không cho phép site bị nhúng vào `<iframe>`.
</details>

<details>
  <summary>Q5: WebSockets vs Server-Sent Events (SSE) vs Long Polling?</summary>
  
  **Trả lời:** 
  WebSockets: Full-duplex (2 chiều). SSE: 1 chiều từ server -> client. Long Polling: Giả lập realtime bằng cách giữ request mở cho đến khi có dữ liệu.
</details>

<details>
  <summary>Q6: Content Negotiation trong HTTP là gì?</summary>
  
  **Trả lời:** 
  Cơ chế Client và Server thương lượng kiểu dữ liệu (Accept), ngôn ngữ (Accept-Language), hoặc mã hóa (Accept-Encoding) phù hợp nhất.
</details>

<details>
  <summary>Q7: Giải thích cơ chế ETag và If-None-Match trong Caching.</summary>
  
  **Trả lời:** 
  Server gửi ETag (mã hash của nội dung). Lần sau Client gửi lại ETag đó qua `If-None-Match`. Nếu nội dung không đổi, Server trả về 304 Not Modified (không tốn body).
</details>

<details>
  <summary>Q8: Reverse Proxy vs Forward Proxy?</summary>
  
  **Trả lời:** 
  Forward Proxy: Đại diện cho Client (ẩn IP client). Reverse Proxy: Đại diện cho Server (load balancing, caching, security).
</details>

<details>
  <summary>Q9: DNS Lookup hoạt động như thế nào? (Recursive vs Iterative).</summary>
  
  **Trả lời:** 
  Quá trình phân giải domain thành IP qua các cấp: Root -> TLD (.com) -> Authoritative Nameserver.
</details>

<details>
  <summary>Q10: CDNs hoạt động dựa trên cơ chế nào (Anycast)?</summary>
  
  **Trả lời:** 
  CDN dùng Anycast routing để trỏ request của người dùng tới Edge Server gần họ nhất về mặt địa lý/network.
</details>

---

## 🧠 Cấp độ: Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế hệ thống Authentication cho ứng dụng có hàng triệu người dùng, hỗ trợ SSO.</summary>
  
  **Trả lời:** 
  Sử dụng giao thức **OAuth2/OpenID Connect**. Centralized Identity Provider (IDP). Dùng JWT cho stateless auth giữa các microservices. Áp dụng cơ chế Token Revocation bằng Redis.
</details>

<details>
  <summary>Q2: Làm thế nào để xử lý "Thundering Herd Problem" trong Web Caching?</summary>
  
  **Trả lời:** 
  Khi cache hết hạn, hàng vạn request cùng lúc đổ vào DB. 
  **Giải pháp:** Dùng **Mutex Lock** (chỉ cho 1 request đi vào DB để update cache), hoặc **Soft Expiration** (trả về dữ liệu cũ trong lúc 1 request ngầm đang update cache).
</details>

<details>
  <summary>Q3: Phân tích chiến lược Zero-Downtime Deployment (Blue-Green vs Canary).</summary>
  
  **Trả lời:** 
  Blue-Green: 2 môi trường song song, switch router 100%. Canary: Deploy cho 5-10% người dùng trước để test lỗi rồi mới roll out toàn bộ.
</details>

<details>
  <summary>Q4: Tại sao gRPC lại dần thay thế REST trong giao tiếp nội bộ Microservices?</summary>
  
  **Trả lời:** 
  Dùng Protocol Buffers (Binary) nhỏ gọn hơn JSON. Chạy trên HTTP/2 mặc định. Hỗ trợ Strong Typing và Streaming 2 chiều.
</details>

<details>
  <summary>Q5: Thiết kế giải pháp Rate Limiting cho một API Gateway chịu tải cao.</summary>
  
  **Trả lời:** 
  Dùng thuật toán **Token Bucket** hoặc **Leaky Bucket**. Lưu trữ trạng thái trong cụm Redis Cluster để đảm bảo hiệu năng và tính nhất quán.
</details>

<details>
  <summary>Q6: Phân tích rủi ro của việc sử dụng JWT cho Session Management.</summary>
  
  **Trả lời:** 
  Khó thu hồi token (Revocation), kích thước token lớn (tốn bandwidth), rủi ro lộ bí mật payload nếu không mã hóa.
</details>

<details>
  <summary>Q7: Cơ chế Service Discovery trong hệ thống Microservices hoạt động như thế nào?</summary>
  
  **Trả lời:** 
  Các service tự đăng ký IP/Port vào một Registry (Consul, Eureka). Các service khác sẽ query vào Registry để biết địa chỉ cần gọi.
</details>

<details>
  <summary>Q8: Làm thế nào để tối ưu hóa TTFB (Time to First Byte)?</summary>
  
  **Trả lời:** 
  Tối ưu hóa DNS, dùng CDN, tối ưu query DB, sử dụng Opcache, giảm thiểu độ trễ network giữa Web Server và App Server.
</details>

<details>
  <summary>Q9: Thiết kế cơ chế "Circuit Breaker" ở mức Application Layer.</summary>
  
  **Trả lời:** 
  Theo dõi tỷ lệ lỗi của các request tới service bên ngoài. Nếu lỗi vượt ngưỡng, chuyển sang trạng thái "Open" và trả về lỗi ngay lập tức hoặc dùng fallback data.
</details>

<details>
  <summary>Q10: Sự khác biệt giữa Horizontal Scaling và Vertical Scaling trong kiến trúc Web?</summary>
  
  **Trả lời:** 
  Vertical: Tăng RAM/CPU cho 1 máy (có giới hạn). Horizontal: Thêm nhiều máy chạy song song (vô hạn, cần Load Balancer và Stateless app).
</details>

---

## 💻 Practical Scenarios (Thực chiến)

<details>
  <summary>S1: API của bạn bị lỗi 504 Gateway Timeout. Bạn kiểm tra những gì?</summary>
  
  **Xử lý:** Kiểm tra thời gian xử lý của code, query DB chậm, hoặc timeout của Nginx/PHP-FPM. Có thể do service bên thứ 3 mà bạn gọi đang bị treo.
</details>

<details>
  <summary>S2: Khách hàng phàn nàn web load chậm ở nước ngoài dù Server ở Việt Nam rất mạnh. Giải pháp?</summary>
  
  **Xử lý:** Triển khai **CDN** (Cloudflare, AWS CloudFront) để đưa các file tĩnh (CSS, JS, Ảnh) tới các Edge Server gần khách hàng.
</details>

---

## 🚨 MUST-KNOW

* Luồng đi của 1 request từ lúc nhập URL đến khi hiện trang web.
* Cách hoạt động của HTTPS và SSL Certificate.
* Các lỗi 401 vs 403, 500 vs 502 vs 504.

## ⚠️ Pitfalls

* Không cấu hình HSTS dẫn đến rủi ro bị hạ cấp xuống HTTP (SSL Stripping).
* Lưu thông tin nhạy cảm vào JWT Payload mà không mã hóa.

## 🧩 Tips & Tricks

* Dùng `Vary: Accept-Encoding` header để tránh lỗi cache file nén cho trình duyệt không hỗ trợ.
* Sử dụng `Brotli` compression thay cho `Gzip` để đạt tỷ lệ nén tốt hơn 15-20%.

---
*Biên soạn bởi Staff Engineer & Web Specialist.*
