---
title: "Bảo mật Web & Ethical Hacking: Tư duy Phòng thủ"
description: Đi sâu vào các lỗ hổng bảo mật web, cách hacker khai thác và các kỹ thuật bảo mật thực chiến để bảo vệ ứng dụng PHP/Laravel.
date: 2026-02-18
tags: [security, hacking, cyber-security, laravel, xss, sql-injection, owasp]
image: /prezet/img/ogimages/knowledge-vi-web-security-hacking.webp
---

> Muốn phòng thủ giỏi, bạn phải hiểu cách tấn công." Bảo mật không phải là một đích đến, mà là một hành trình liên tục của sự cảnh giác.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: 3 nguyên tắc cơ bản của Bảo mật thông tin là gì?</summary>

  **Trả lời:**
  Mô hình **CIA**:
  1. **Confidentiality (Tính bảo mật):** Chỉ người có quyền mới được xem dữ liệu.
  2. **Integrity (Tính toàn vẹn):** Dữ liệu không bị chỉnh sửa trái phép.
  3. **Availability (Tính sẵn sàng):** Hệ thống luôn hoạt động khi cần.
</details>

<details>
  <summary>Q2: Lỗ hổng SQL Injection (SQLi) là gì?</summary>

  **Trả lời:**
  Là lỗi khi ứng dụng ghép trực tiếp input của người dùng vào câu lệnh SQL. Hacker có thể nhập các đoạn mã SQL độc hại để xem, xóa hoặc sửa đổi toàn bộ database.
</details>

<details>
  <summary>Q3: Tại sao cần HTTPS?</summary>

  **Trả lời:**
  HTTPS mã hóa dữ liệu truyền giữa trình duyệt và server, ngăn chặn kẻ tấn công nghe lén (Sniffing) hoặc giả mạo dữ liệu trên đường truyền (Man-in-the-middle attack).
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: XSS (Cross-Site Scripting) hoạt động như thế nào? Phân biệt Stored và Reflected XSS.</summary>

  **Trả lời:**
  Hacker chèn mã Javascript độc hại vào trang web.
  - **Reflected XSS:** Mã độc nằm trong URL (ví dụ `?search=<script>...`).
  - **Stored XSS:** Mã độc được lưu vào DB (ví dụ trong comment) và hiện ra cho mọi người xem.
  **Hậu quả:** Hacker có thể đánh cắp Cookie/Session của người dùng.
</details>

<details>
  <summary>Q2: Giải thích cơ chế tấn công CSRF (Cross-Site Request Forgery).</summary>

  **Trả lời:**
  Lừa người dùng đã login vào site A nhấn vào 1 link/nút ở site B độc hại. Link này gửi 1 request tới site A (ví dụ đổi mật khẩu). Vì trình duyệt tự đính kèm Cookie của site A, server A tin rằng đây là yêu cầu thật từ user.
</details>

<details>
  <summary>Q3: Lỗ hổng "Broken Access Control" là gì?</summary>

  **Trả lời:**
  Xảy ra khi user có thể truy cập dữ liệu của người khác chỉ bằng cách đổi ID trên URL (IDOR). Ví dụ: user 1 sửa URL từ `/profile/1` thành `/profile/2` và xem được thông tin user 2.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Tấn công RCE (Remote Code Execution) qua Unserialization nguy hiểm như thế nào?</summary>

  **Trả lời:**
  Nếu bạn dùng hàm `unserialize()` trên dữ liệu do user cung cấp, hacker có thể tạo ra các "Object lạ" kích hoạt các Magic Methods của PHP (`__destruct`, `__wakeup`) để thực thi mã PHP tùy ý trên server của bạn.
</details>

<details>
  <summary>Q2: Giải thích về "SSRF" (Server-Side Request Forgery).</summary>

  **Trả lời:**
  Hacker lừa server thực hiện một request tới một địa chỉ nội bộ mà hacker không thể truy cập trực tiếp (ví dụ: gọi tới `http://localhost:8080/admin` hoặc AWS metadata server).
</details>

<details>
  <summary>Q3: Kỹ thuật "SQL Injection blind" là gì?</summary>

  **Trả lời:**
  Khi server không hiện lỗi SQL ra màn hình, hacker hỏi các câu hỏi Yes/No qua SQL (ví dụ: `IF(substr(password,1,1)='a', sleep(5), 1)`). Nếu server phản hồi chậm 5s, hacker biết ký tự đầu là 'a'.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế kiến trúc "Defense in Depth" (Phòng thủ đa tầng).</summary>

  **Trả lời:**
  Không tin tưởng vào 1 lớp bảo vệ duy nhất. 
  1. **Tầng mạng:** WAF, Firewall. 
  2. **Tầng App:** Filter input, Escape output, Token CSRF. 
  3. **Tầng Data:** Encrypt dữ liệu nhạy cảm, dùng Prepared Statements. 
  4. **Tầng OS:** Giới hạn quyền user chạy PHP, dùng SELinux/AppArmor.
</details>

<details>
  <summary>Q2: Làm thế nào để lưu trữ mật khẩu an toàn tuyệt đối?</summary>

  **Trả lời:**
  Dùng thuật toán băm mạnh (Argon2id hoặc Bcrypt). Luôn kèm theo **Salt** (chuỗi ngẫu nhiên cho từng user) và **Pepper** (chuỗi bí mật chung lưu ở file config/environment).
</details>

## Câu hỏi Phỏng vấn (Interview Style)

<details>
  <summary>Q: JWT có an toàn hơn Session không?</summary>

  **Trả lời:**
  Không hẳn. JWT giúp Stateless (dễ scale) nhưng khó thu hồi (revoke) hơn Session. Nếu lộ Secret Key, toàn bộ hệ thống sụp đổ. JWT thường bị lỗi cấu hình `alg: none` cho phép hacker giả mạo chữ ký.
</details>

<details>
  <summary>Q: Bạn sẽ làm gì nếu database bị lộ (Data Breach)?</summary>

  **Xử lý:** 
  1. Cô lập và chặn lỗ hổng ngay lập tức. 
  2. Đổi toàn bộ Secret Keys, API Keys. 
  3. Thông báo cho người dùng và yêu cầu đổi mật khẩu. 
  4. Thực hiện audit lại toàn bộ hệ thống để tìm vết chân hacker.
</details>

## Mẹo và thủ thuật bảo mật

- **Content Security Policy (CSP):** Header cực mạnh giúp chặn đứng 90% các vụ tấn công XSS.
- **Strict-Transport-Security (HSTS):** Ép trình duyệt luôn dùng HTTPS.
- **HttpOnly & Secure Flags:** Luôn bật cho Cookie để ngăn JS đánh cắp token.
