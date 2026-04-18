---
title: "Code Smells: Dấu hiệu cần refactor ngay"
excerpt: Nhận diện các 'mùi' code (Code Smells) phổ biến trong Laravel như God Object, Long Method, và tight-coupling.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-code-smells.webp
tags: [architecture, clean-code, refactoring]
---

## 1. God Object (God Class)

Một class (thường là Controller hoặc Model) ôm đồm mọi thứ từ xử lý request, validate, lưu DB, gửi mail đến tạo report.

- **Dấu hiệu:** Constructor quá dài, hàm lên tới hàng trăm dòng.

## 2. Tight Coupling (Dính chặt)

Dùng `new Class()` cứng trong code.

- **Tại sao tệ:** Không thể Mock class đó khi viết test, khó thay thế.
- **Giải pháp:** Luôn sử dụng Dependency Injection qua Interface.

## 3. Shotgun Surgery

Chỉ một thay đổi nhỏ (thêm trường dữ liệu) mà bạn phải sửa 5-6 file khác nhau (Model, Request, Controller, Resource, Test...).

- **Giải pháp:** Dùng **Data Transfer Object (DTO)** và **Form Request** để gom nhóm các thay đổi vào 1 nơi duy nhất.

## 4. Câu hỏi nhanh

**Q: "Dấu hiệu nào cho thấy một class cần được tách nhỏ?"**
**A:** Khi bạn cảm thấy khó đặt tên cho nó. Nếu tên class là `OrderManagerService`, nó quá chung chung và chắc chắn đang ôm đồm quá nhiều việc (vi phạm Single Responsibility).
