---
title: "Laravel Auth: Giải mã Guards và Providers"
excerpt: Hiểu cách Laravel xác thực user qua Guards và cách nó truy vấn dữ liệu user qua User Providers.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-auth-guards-providers.webp
tags: [laravel, auth, guards, providers, architecture]
---

## 1. Bản chất

- **Guards:** Định nghĩa *cách* người dùng được xác thực trong từng request (ví dụ: `session` cho web, `sanctum/passport` cho api).
- **User Providers:** Định nghĩa *cách* lấy User từ storage (Eloquent, Database, hay thậm chí từ API bên thứ 3).

## 2. Quy trình xác thực

Khi bạn gọi `Auth::user()`:

1. `AuthManager` sẽ lấy `Guard` hiện tại.
2. `Guard` gọi `UserProvider` để load user dựa trên token hoặc session.
3. Sau đó `Guard` thực hiện logic xác thực (check mật khẩu, kiểm tra token).

## 3. Kinh nghiệm Senior

**Q: Tạo Auth riêng cho Admin và User như thế nào?**
**A:** Đừng cố nhét chung vào một bảng. Hãy định nghĩa 2 Guard khác nhau trong `auth.php`, với 2 `Provider` khác nhau trỏ tới 2 bảng `admins` và `users`.

**Q: Khi nào nên tạo Custom Guard?**
**A:** Khi bạn cần xác thực qua các nguồn lạ: hệ thống LDAP, chứng chỉ số (Certificate), hoặc xác thực qua Header tùy chỉnh từ API Gateway.
