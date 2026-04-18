---
title: "Modular Monolith: Kiến trúc chuyển giao"
excerpt: Cách chia nhỏ hệ thống thành các module biệt lập (Modules) trong cùng 1 codebase để chuẩn bị cho Microservices hoặc giảm độ phức tạp.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-modular-monolith-transition.webp
tags: [architecture, monolith, microservices, refactoring]
---

## 1. Bài toán

Hệ thống quá lớn, mọi thứ đều nằm chung trong `app/`. Bạn sửa tính năng `User` thì vô tình làm hỏng `Payment`. Bạn muốn chia tách nhưng chưa muốn gánh nợ kỹ thuật của Microservices.

## 2. Giải pháp: Modular Monolith

Chia thư mục theo nghiệp vụ, không phải theo loại file.

- **Trước:** `app/Models`, `app/Controllers` (Phẳng lì).
- **Sau:** `app/Modules/User`, `app/Modules/Payment`.
- **Nguyên tắc:** Mỗi Module phải có: `Models`, `Controllers`, `Services`, `Events`. Các Module giao tiếp với nhau qua **Public API** hoặc **Event Bus**.

## 3. Lợi ích

- **Cô lập:** Bug trong module Payment sẽ khó lan sang User.
- **Ready to split:** Nếu cần chuyển sang Microservices, bạn chỉ việc "bê" thư mục module đó ra một project mới.

## 4. Câu hỏi nhanh

**Q: Làm sao để ép các Module không được gọi bậy bạ lẫn nhau?**
**A:** Dùng **Package Architecture**. Mỗi Module là một composer package nội bộ. Bạn có thể quy định `UserModule` chỉ được phép gọi `PaymentModule` qua `ServiceInterface`. Nếu gọi trực tiếp, linter/architect sẽ chặn ngay.
