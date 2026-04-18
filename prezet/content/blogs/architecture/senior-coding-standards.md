---
title: "Senior Standards: Đặt tên, Trace Code & Tư duy phán đoán"
excerpt: Cách đặt tên chuẩn ngữ nghĩa, kỹ năng phán đoán lỗi dựa trên dấu vết (trace) và tư duy logic của một Senior.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-senior-coding-standards.webp
tags: [architecture, clean-code, debugging, mindset]
---

## 1. Quy tắc đặt tên (Bất thành văn)
- **Hàm/Phương thức:** Luôn bắt đầu bằng Động từ + Danh từ. (VD: `calculateTax()`, `findUserById()`). Đừng đặt `getTax()` nếu nó có thực hiện logic tính toán nặng.
- **Biến:** `camelCase` nhưng phải rõ nghĩa. Đừng đặt `$data`, `$res`. Hãy đặt `$orderData`, `$userCollection`.
- **Interface:** Tên bắt đầu bằng tính từ (VD: `AuthenticatableInterface`, `RepositoryInterface`).

## 2. Tư duy Trace Code & Phán đoán (Debugging)
- **Quy tắc 3 giây:** Khi gặp lỗi, đừng sửa ngay. Đọc kỹ Stack Trace. 80% lỗi nằm ở dữ liệu đầu vào hoặc Logic của Service mà bạn vừa gọi.
- **Trace bằng log:** Đừng chỉ nhìn console. Hãy tạo một log channel riêng cho tính năng đó. `Log::channel('payment')->info(...)` giúp bạn lọc log nhanh gấp 10 lần log chung.
- **Phán đoán "Mùi code":** Nếu thấy 1 hàm gọi quá nhiều dependency (constructor injection > 5 class), đó là lúc cần tách ra các Service/Action nhỏ hơn.

## 3. Kỹ năng mềm & Cứng
- **Cứng:** Sử dụng `EXPLAIN` trên SQL để tối ưu query. Biết dùng `php artisan debug:bar` (trên local) để kiểm tra memory/SQL queries.
- **Mềm:** Luôn hỏi "Tại sao lại cần tính năng này?" trước khi đặt bút code. Đôi khi không code lại là giải pháp tối ưu nhất cho business.
- **Tư duy Architect:** "Hệ thống này sẽ làm gì khi user tăng 100 lần?". Luôn đặt câu hỏi về khả năng mở rộng (Scale).
