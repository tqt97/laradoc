---
title: "Tips & Tricks: Viết code Laravel chuẩn Architect"
excerpt: Những kinh nghiệm thực tế để giữ codebase sạch, dễ bảo trì và dễ scale trong môi trường Laravel lớn.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-laravel-architect-tips.webp
tags: [laravel, architecture, tips, clean-code]
---

## 1. Tips để "Sạch" Codebase
- **Đừng dùng `DB::` trong Controller:** Hãy chuyển nó vào Repository hoặc trực tiếp vào Service/Action. Controller nên "mỏng" nhất có thể.
- **Sử dụng DTO (Data Transfer Object):** Đừng bao giờ truyền một mảng (`array`) từ Controller sang Service. Hãy truyền một DTO để đảm bảo dữ liệu có kiểu rõ ràng (type-safe).
- **Tận dụng Collection:** Thay vì lặp `foreach` thủ công, hãy dùng `map`, `filter`, `reduce` của Collection. Code sẽ trở nên mang tính khai báo (declarative) hơn là mệnh lệnh (imperative).

## 2. Những điều "KHÔNG NÊN"
- **Không dùng `env()` trực tiếp trong code:** Chỉ dùng trong `config/*.php`. Tại sao? Vì khi bạn chạy lệnh `config:cache`, Laravel sẽ cache toàn bộ cấu hình, và `env()` sẽ trả về `null`.
- **Không nhồi nhét logic vào Model:** Model chỉ nên quản lý dữ liệu và quan hệ. Logic nghiệp vụ (ví dụ: gửi mail khi update) nên để vào `Observer` hoặc `Event/Listener`.

## 3. Tư duy "Scale" ngay từ đầu
- **Luôn dùng Queue:** Đừng bắt người dùng đợi để gửi email hoặc gọi API bên thứ 3.
- **Đánh Index sớm:** Ngay khi phát hiện các cột thường xuyên dùng trong `WHERE` hoặc `JOIN`, hãy migrate index ngay lập tức. Đừng đợi tới khi hệ thống chậm mới làm.
