---
title: "Senior Standard: Đặt tên, Debug & Tư duy Architect"
excerpt: Quy tắc đặt tên chuẩn, kỹ năng trace lỗi chuyên sâu và tư duy "đánh đổi" (trade-off) của một Senior.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-senior-standards.webp
tags: [architecture, clean-code, debugging, mindset]
---

## 1. Quy tắc đặt tên

- **Hàm:** `camelCase`, bắt đầu bằng động từ + đối tượng (VD: `calculateTax`, `sendWelcomeEmail`).
- **Biến:** Tránh viết tắt (`$data`, `$res`). Hãy dùng `$orderData`, `$responseData`.
- **Interface:** Bắt đầu bằng tính từ (VD: `AuthenticatableInterface`).
- **Boolean:** `isActive`, `hasPermission`, `canAccess`.

## 2. Debugging & Traceability

- **Trace lỗi:** Nếu hệ thống phân tán, bắt buộc phải có `Correlation ID` truyền qua các Request.
- **Phán đoán:**
  - Lỗi 500: Thường là DB/Network/Logic crash. Check `storage/logs/laravel.log` ngay.
  - Lỗi 403: Auth/Policy. Check `Gate`.
  - Lỗi hiệu năng: Dùng `php artisan debug:bar` (local) hoặc `Blackfire` (prod).

## 3. Mindset & Kỹ năng

- **Kỹ năng cứng:** Phải biết dùng `EXPLAIN` trong SQL để xem query đã dùng Index chưa.
- **Kỹ năng mềm:** Khi review code, đừng nói "Code này xấu". Hãy nói "Code này vi phạm nguyên lý X, dẫn tới việc bảo trì khó khăn về sau".
- **Tư duy:** Mọi dòng code bạn viết ra đều là một món nợ (Technical Debt). Hãy hỏi: "Mình có thực sự cần tính năng này ngay bây giờ không?" (YAGNI).

## 4. Mẹo phỏng vấn hóc búa

**Q: "Làm thế nào để optimize 1 API chậm?"**
**A:** (1) Đo đạc (Blackfire/Debugbar). (2) Kiểm tra N+1 (Lazy loading). (3) Tối ưu query (Index, SQL query). (4) Cache dữ liệu lâu thay đổi (Redis). (5) Chuyển tác vụ nặng sang Queue.
