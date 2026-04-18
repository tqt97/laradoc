---
title: "Gate & Policy: Hệ thống Authorization tinh gọn"
excerpt: Phân tích cơ chế kiểm tra quyền truy cập của Laravel và cách tối ưu chúng cho hệ thống RBAC phức tạp.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-gate-policy-internals.webp
tags: [laravel, auth, gate, policy, rbac]
---

## 1. Bản chất

- **Gate:** Dùng cho các logic đơn giản, không gắn liền với Model (VD: `Gate::define('access-dashboard', ...)`).
- **Policy:** Gắn liền với một Model (VD: `PostPolicy` cho `Post` Model).

## 2. Cách hoạt động

Laravel sử dụng `Illuminate\Auth\Access\Gate`. Khi bạn gọi `can()`, Gate sẽ tự động map class Model với Policy tương ứng thông qua **Policy Mapping**.

## 3. Câu hỏi nhanh

**Q: Tại sao nên ưu tiên dùng Policy hơn Gate?**
**A:** Policy tổ chức code tốt hơn (S/O trong SOLID). Mỗi model có 1 file Policy riêng, tránh làm phình to `AuthServiceProvider`.

**Q: Làm sao để kiểm tra quyền mà không throw ra Exception?**
**A:** Sử dụng `Gate::allows()` hoặc `Gate::check()` thay vì `$user->can()`. `can()` sẽ ném `AuthorizationException` nếu quyền không được cấp.
