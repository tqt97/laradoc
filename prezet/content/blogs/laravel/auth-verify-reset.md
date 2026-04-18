---
title: "Laravel Auth: Email Verification & Password Reset Internals"
excerpt: Phân tích cơ chế ký (signing) URL, Signed Route và cách Laravel quản lý luồng khôi phục mật khẩu.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-auth-verify-reset.webp
tags: [laravel, auth, security, email, password-reset]
---

## 1. Signed Routes (Bí mật của URL Verification)

Khi bạn nhấn link xác thực email, Laravel kiểm tra `Signature` cuối URL.

- **Cách nó hoạt động:** Nó tạo một `HMAC` hash dựa trên URL và `APP_KEY`. Khi user click, Laravel tính lại hash và so sánh. Nếu hacker đổi 1 ký tự, hash sẽ sai và Laravel từ chối truy cập.

## 2. Password Reset Flow

1. User request -> Laravel tạo Token, băm (Hash) token đó rồi lưu vào bảng `password_reset_tokens`.
2. Gửi link chứa token thô cho user.
3. Khi user nhập mật khẩu mới, Laravel lấy token thô, băm nó và so sánh với hash trong DB.
*Mẹo:* Đây là lý do bạn không bao giờ được lộ `APP_KEY`, vì token reset mật khẩu dựa vào đó để xác thực.

## 3. Câu hỏi nhanh

**Q: Tại sao phải sử dụng Signed Routes cho Email Verification?**
**A:** Để tránh việc user tự ý thay đổi email trong URL để kích hoạt tài khoản của người khác.

**Q: Tại sao token reset password được lưu dạng Hash trong DB?**
**A:** Để tránh trường hợp nếu database bị rò rỉ, hacker cũng không thể dùng các token đó để reset mật khẩu của toàn bộ người dùng.
