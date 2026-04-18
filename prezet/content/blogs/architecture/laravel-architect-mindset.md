---
title: "Laravel Architect Mindset: Khi nào nên 'Break the rules'?"
excerpt: Những bài học xương máu về việc cân bằng giữa sự tiện lợi của Laravel và sự bền vững của kiến trúc hệ thống.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-laravel-architect-mindset.webp
tags: [architecture, laravel, mindset, best-practices]
---

## 1. "Đừng phục vụ Framework, hãy để Framework phục vụ bạn"
Nhiều dev lạm dụng Facade và Eloquent ở khắp nơi, khiến code "dính" chặt vào framework. 
- **Kinh nghiệm:** Hãy tách Logic nghiệp vụ ra các `Action` hoặc `Domain Service` thuần PHP. Nếu một ngày bạn muốn chuyển từ Laravel sang Symfony hay Node.js, bạn chỉ cần viết lại tầng HTTP và giữ nguyên Core Logic.

## 2. Quy tắc 80/20 trong Laravel
- **80% dự án:** Dùng thẳng Model, Facade, Eloquent là đủ. Hãy giữ nó đơn giản (KISS).
- **20% trọng yếu:** Đối với các phần liên quan đến thanh toán, xử lý dữ liệu phức tạp, hãy áp dụng SOLID, Interface, Repository. 
*Đừng áp dụng kiến trúc phức tạp cho một tính năng CRUD đơn giản.*

## 3. Bài học xương máu: Database là trung tâm
- **Đừng tin vào Eloquent 100%:** Eloquent rất tiện, nhưng SQL là thứ đứng vững sau 20 năm. Hãy học cách debug SQL log (`DB::enableQueryLog()`).
- **N+1 không bao giờ ngủ:** Một query chậm trong vòng lặp có thể làm sập toàn bộ hệ thống khi đạt tới hàng vạn request. Luôn dùng `with()` hoặc `->lazy()`.

## 4. Tips & Tricks cho Senior
- **Sử dụng `Value Objects`:** Thay vì truyền string/int vào hàm, hãy truyền một `Amount` object hay `Email` object để đảm bảo dữ liệu luôn hợp lệ ngay tại thời điểm khởi tạo.
- **Dùng `Strict Typing`:** Hãy `declare(strict_types=1);` ở mọi file PHP. Nó ngăn chặn các lỗi ngớ ngẩn do ép kiểu dữ liệu của PHP.
