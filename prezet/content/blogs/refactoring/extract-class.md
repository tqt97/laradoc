---
title: "Refactor: Extract Class để giải cứu Controller/Model"
excerpt: Kỹ thuật tách logic từ một class ôm đồm (God Object) sang các class chuyên biệt để đạt chuẩn Single Responsibility.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-extract-class.webp
tags: [refactoring, solid, clean-code]
---

## 1. Dấu hiệu cần làm

- Class của bạn có hơn 300 dòng code.
- Class có tên chung chung: `OrderManager`, `AppService`, `Processor`.
- Bạn thấy mình phải sửa file này trong hầu hết mọi ticket (Shotgun Surgery).

## 2. Quy trình

1. Tạo class mới với tên cụ thể (ví dụ: `InvoiceCalculator`).
2. Di chuyển các hàm/biến liên quan sang.
3. Cập nhật constructor để inject class mới vào class cũ.

## 3. Bài học xương máu

- **Đừng tách quá nhỏ:** Nếu 2 class luôn luôn đi đôi với nhau, có thể chúng không cần tách.
- **Tách bằng logic:** Tách theo "lý do thay đổi". (VD: Logic gửi mail thay đổi thường xuyên -> Tách `EmailService`).

## 4. Phỏng vấn

**Q: Làm sao để tách Class mà không làm hỏng code hiện tại?**
**A:** Dùng **Unit Test**. Bao phủ toàn bộ hành vi của class cũ bằng test. Sau đó tách class, nếu test vẫn Pass, bạn an toàn.
