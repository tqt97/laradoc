---
title: "JWT Security: Những lỗ hổng 'chết người' và cách phòng chống"
excerpt: "Token-based authentication rất phổ biến, nhưng nếu cấu hình sai, bạn đang mở toang cửa cho hacker. Tìm hiểu về 'alg: none', lộ Secret Key và chiến lược Refresh Token"
date: 2026-04-18
category: Security
image: /prezet/img/ogimages/blogs-security-jwt-security-pitfalls.webp
tags: [security, jwt, authentication, laravel, web-security]
---

JSON Web Token (JWT) là tiêu chuẩn cho các ứng dụng SPA và Mobile hiện đại. Tuy nhiên, sự tiện lợi của tính "Stateless" đi kèm với những rủi ro bảo mật cực lớn nếu lập trình viên không hiểu rõ bản chất.

## 1. Lỗ hổng kinh điển: "alg: none"

JWT Header chứa tham số `alg` để báo cho server biết thuật toán dùng để ký (ví dụ HS256, RS256).

- **Tấn công:** Hacker thay đổi Header thành `{"alg": "none"}` và xóa phần chữ ký (signature).
- **Hậu quả:** Nếu thư viện JWT của bạn không kiểm tra kỹ, nó sẽ coi token này là hợp lệ và cho phép hacker giả mạo bất kỳ User ID nào.
- **Giải pháp:** Luôn ép buộc (enforce) thuật toán ký ở phía server.

## 2. Rò rỉ Secret Key

Nếu bạn dùng thuật toán đối xứng (Symmetric) như HS256, cả server và client (hoặc các service khác) đều dùng chung một chìa khóa. Nếu key này bị lộ, hacker có thể tự sinh ra token vô hạn.

- **Giải pháp:** Sử dụng thuật toán bất đối xứng (Asymmetric) như **RS256** (Cặp khóa Public/Private). Server chỉ giữ Private Key để ký, các service khác dùng Public Key để kiểm tra.

## 3. Thách thức: Token Revocation (Thu hồi token)

Vì JWT là stateless, server không cần check DB để biết token còn hạn không. Vậy nếu user bị mất máy, làm sao để vô hiệu hóa token đó ngay lập tức?

- **Giải pháp:**
  1. **Blacklisting:** Lưu các token bị hủy vào Redis với thời gian hết hạn bằng đúng thời hạn của token.
  2. **Short-lived Access Token:** Để Access Token có hạn cực ngắn (5-15 phút) và dùng **Refresh Token** (lưu ở DB) để cấp mới.

## 4.Câu hỏi nhanh

**Câu hỏi:** Tại sao không bao giờ được lưu thông tin nhạy cảm (như mật khẩu, số điện thoại) vào JWT Payload?

**Trả lời:**
Vì JWT Payload chỉ được mã hóa dưới dạng **Base64Url**, không phải là mã hóa bí mật (Encryption). Bất kỳ ai có token đều có thể dùng các công cụ online để decode và xem toàn bộ nội dung Payload một cách dễ dàng. JWT chỉ đảm bảo tính **Toàn vẹn** (Integrity) - tức là dữ liệu không bị sửa đổi - chứ không đảm bảo tính **Bí mật** (Confidentiality).

**Câu hỏi mẹo:** Phân biệt `exp` và `iat` trong JWT claim?
**Trả lời:**

- `iat` (Issued At): Thời điểm token được tạo ra.
- `exp` (Expiration Time): Thời điểm token hết hạn.
Server cần kiểm tra `exp` để từ chối các token cũ và có thể dùng `iat` để đảm bảo token không được tạo ra từ "tương lai" (do lệch múi giờ server).

## 5. Kết luận

JWT không phải là "viên đạn bạc". Với các ứng dụng web thông thường trên cùng domain, **Session Cookie** truyền thống thường an toàn và dễ quản lý hơn. Chỉ dùng JWT khi bạn thực sự cần kiến trúc Stateless cho Microservices hoặc Mobile App.
