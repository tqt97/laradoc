---
title: "Clean Code: Quy tắc đặt tên và kỹ năng Debug"
excerpt: Cách đặt tên biến/hàm đạt chuẩn Senior và kỹ năng Trace code, "đọc vị" lỗi trong môi trường phức tạp.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-naming-conventions-skills.webp
tags: [architecture, clean-code, debugging, naming]
---

## 1. Quy tắc đặt tên (Naming)
- **Biến/Hàm:** `camelCase`. Tên hàm phải bắt đầu bằng động từ: `getActiveUsers()`, `calculateTotal()`. 
- **Class:** `PascalCase`. Action class: `RegisterUserAction`. Interface: `UserInterface`.
- **Tránh:** Đặt tên kiểu `data`, `info`, `tmp`. Hãy đặt tên theo ngữ nghĩa: `processedOrders`, `rawInputData`.

## 2. Kỹ năng Trace Code
- **Đừng chỉ nhìn code:** Hãy đặt `dump()` (hoặc `dd()`/`dump()` trong Laravel) ngay tại điểm bạn nghi ngờ.
- **Log: "Dấu vết tội phạm":** Trong hệ thống phân tán, luôn luôn log `Correlation ID`. Nếu không có ID này, bạn đang debug trong bóng tối.
- **Phán đoán lỗi:** Lỗi `500` thường ở server-side (thường là DB/Network/Memory). Lỗi `403/401` là Auth. Luôn check `storage/logs/laravel.log` đầu tiên.

## 3. Kỹ năng mềm & cứng cho Senior
- **Kỹ năng cứng:** Phải biết dùng `xdebug` để step-through code, biết dùng `EXPLAIN` để tối ưu SQL.
- **Kỹ năng mềm:** Khi code review, đừng nói "Code này xấu". Hãy nói "Code này có thể vi phạm nguyên lý X, dẫn tới việc bảo trì khó khăn về sau". Hãy thuyết phục bằng kiến trúc, không phải bằng cảm tính.
- **Tư duy Architect:** "Nếu mai hệ thống tăng gấp 10 lần traffic, chỗ này có sập không?" - luôn đặt câu hỏi về scale trước khi đặt bút viết code.
