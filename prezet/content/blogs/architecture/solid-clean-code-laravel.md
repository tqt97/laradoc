---
title: "SOLID & Clean Code trong Laravel: Từ Thợ code đến Kiến trúc sư"
excerpt: Áp dụng các nguyên lý thiết kế kinh điển vào Laravel để xây dựng hệ thống bền vững, dễ bảo trì.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-solid-clean-code-laravel.webp
tags: [architecture, solid, clean-code, laravel]
---

## 1. Nguyên lý cốt lõi

- **S (Single Responsibility):** Controller chỉ làm nhiệm vụ tiếp nhận request. Action class xử lý nghiệp vụ.
- **O (Open/Closed):** Dùng Interface/Strategy để thêm tính năng mới mà không sửa code cũ.
- **L (Liskov Substitution):** Mọi class con của Repository phải dùng thay thế được cho lớp cha.
- **I (Interface Segregation):** Chia nhỏ interface (ví dụ `UserSearchableInterface`, `UserAuthenticatableInterface`).
- **D (Dependency Inversion):** Inject Interface vào Controller, không inject Class cụ thể.

## 2. Áp dụng DRY (Don't Repeat Yourself)

- Đưa code trùng lặp vào `Trait` (cho Model) hoặc `Service/Action` (cho Business Logic).
- Đừng lạm dụng Trait, nó dễ gây ra "Diamond Problem" nếu không cẩn thận.

## 3. Phỏng vấn Senior

**Q: "Fat Model" (Model béo) có tốt không?**
**A:** Model béo tốt hơn "Fat Controller", nhưng Model quá béo (lưu cả logic gửi mail, logic nghiệp vụ phức tạp) sẽ khó quản lý. Hãy tách sang **Action Class** hoặc **Service Layer** khi logic vượt quá 100 dòng.

**Q: Tại sao phải Dependency Inversion?**
**A:** Để Unit Test! Bạn không thể mock một `StripeGateway` cứng trong controller, nhưng bạn có thể mock `PaymentGatewayInterface`.
