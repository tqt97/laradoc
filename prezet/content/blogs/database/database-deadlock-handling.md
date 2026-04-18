---
title: "Database Deadlock: Khi hệ thống tự 'khóa' nhau"
excerpt: Phân tích nguyên nhân, cách phát hiện và chiến lược phòng thủ Deadlock trong các giao dịch Eloquent.
date: 2026-04-18
category: Database
image: /prezet/img/ogimages/blogs-database-database-deadlock-handling.webp
tags: [database, sql, deadlock, performance, laravel]
---

## 1. Bài toán
Hai giao dịch A và B cùng cập nhật 2 dòng dữ liệu (ví dụ: chuyển tiền từ tài khoản X sang Y và ngược lại). Giao dịch A khóa X chờ Y, giao dịch B khóa Y chờ X. Hệ thống treo!

## 2. Nguyên lý
Deadlock xảy ra do sự tranh chấp khóa (Locking) theo chu kỳ.
- **Tại sao hay gặp ở Laravel:** Dùng `DB::transaction()` với quá nhiều logic bên trong, hoặc cập nhật quá nhiều bảng cùng lúc.

## 3. Kinh nghiệm thực chiến
- **Thứ tự (Ordering):** Luôn cập nhật theo một thứ tự cố định (ví dụ: luôn cập nhật ID nhỏ trước ID lớn).
- **Transaction nhỏ:** Đừng bao giờ gọi API hoặc xử lý logic tốn thời gian (gửi mail, resize ảnh) trong `DB::transaction`. Chỉ giữ SQL thuần ở đó.
- **Locking:** Dùng `lockForUpdate()` một cách thận trọng.

## 4. Mẹo phỏng vấn
**Q: Làm sao để debug deadlock khi hệ thống đang chạy?**
**A:** Dùng lệnh `SHOW ENGINE INNODB STATUS;`. Nó sẽ hiển thị "LATEST DETECTED DEADLOCK" giúp bạn biết chính xác hai câu SQL nào đang "đá" nhau.
**Mẹo đánh đố:** Luôn thử lại (Retry) transaction trong Laravel bằng `DB::transaction(callback, 3)`. Số 3 nghĩa là Laravel sẽ tự retry 3 lần nếu gặp deadlock.
