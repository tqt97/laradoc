---
title: "Laravel Security: Giải mã Encryption & Hashing"
excerpt: Phân tích cơ chế Hashing (bcrypt/argon2) và Encryption (AES-256) trong Laravel. Tại sao bạn nên dùng chúng thay vì tự làm?
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-security-hashing-encryption.webp
tags: [laravel, security, hashing, encryption, cryptography]
---

## 1. Hashing (Một chiều)

- **Cơ chế:** Laravel sử dụng `Bcrypt` hoặc `Argon2id` mặc định.
- **Tại sao không dùng MD5/SHA1?** Hashing là hàm một chiều nhưng MD5/SHA1 quá nhanh, hacker có thể brute-force bằng GPU. Bcrypt/Argon2id có "cost factor" để làm chậm quá trình băm, chống lại tấn công brute-force.
- **Kinh nghiệm:** Luôn dùng `Hash::make()` hoặc `Hash::check()` thay vì so sánh chuỗi thô.

## 2. Encryption (Hai chiều)

- **Cơ chế:** Laravel dùng `AES-256-CBC` (mã hóa đối xứng). Cần `APP_KEY` để encrypt và decrypt.
- **Lưu ý:** Nếu bạn đổi `APP_KEY`, toàn bộ dữ liệu đã encrypt sẽ không thể giải mã. Đừng bao giờ làm điều này trên production!

## 3. Câu hỏi nhanh

**Q: Tại sao phải dùng Hashing cho mật khẩu?**
**A:** Để đảm bảo ngay cả khi Database bị hack (SQL Injection), hacker cũng không lấy được mật khẩu gốc. Chỉ có HASH được lưu.

**Q: Khi nào dùng Encryption thay vì Hashing?**
**A:** Khi bạn cần lấy lại dữ liệu gốc sau này (ví dụ: token thanh toán của khách hàng). Hashing không cho phép lấy lại dữ liệu gốc.
