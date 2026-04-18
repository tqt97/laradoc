---
title: "DRY & SOLID: Khi lý thuyết gặp thực tế"
excerpt: Cách áp dụng các nguyên lý SOLID vào Laravel mà không gây 'quá tải' kiến trúc (over-engineering).
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-dry-solid-real-world.webp
tags: [architecture, solid, dry, clean-code]
---

## 1. DRY (Don't Repeat Yourself)
- **Đừng chỉ copy-paste code:** Nếu bạn thấy code logic giống nhau ở 2 controller, hãy tách thành `Action Class` hoặc `Service`.
- **Nhưng đừng lạm dụng:** Đôi khi việc cố tình DRY một logic khác biệt (nhưng tình cờ giống nhau) sẽ tạo ra sự phụ thuộc không cần thiết (coupling).

## 2. SOLID: Cân bằng giữa sự sạch sẽ và tốc độ
- **Single Responsibility (S):** Một class chỉ nên làm 1 việc (Ví dụ: `RegisterUser` chỉ làm việc đăng ký).
- **Dependency Inversion (D):** Đây là nguyên lý quan trọng nhất. Luôn inject Interface. Nếu controller gọi `StripePayment`, khi sếp bảo đổi qua `VNPay`, bạn sẽ phải sửa toàn bộ code. Nếu gọi `PaymentInterface`, bạn chỉ việc tạo class mới và update ServiceProvider.

## 3. Kinh nghiệm thực chiến (KISS - Keep It Simple, Stupid)
- Đừng áp dụng Repository cho mọi bảng trong DB (như user, roles...). Eloquent đã là một Repository tuyệt vời rồi. Chỉ dùng Repository khi DB trở nên cực kỳ phức tạp (dùng nhiều DB, nhiều view/stored procedures).
- **Over-engineering:** Nếu project nhỏ, đừng chia quá nhiều lớp (Layered Architecture). Hãy bắt đầu với *Action/Service Layer* và nâng cấp dần.

## 4. Phỏng vấn
**Q: Khi nào SOLID trở nên thừa thãi?**
**A:** Trong các dự án nhỏ, prototype hoặc khi thời gian là yếu tố sống còn (Time-to-market). Hãy chọn sự cân bằng.

**Q: Làm sao để biết code của mình đã đủ tốt?**
**A:** Hãy thử viết unit test. Nếu bạn thấy việc viết test cho một class quá khó, nghĩa là code đó đang vi phạm SOLID (cần phải mock quá nhiều thứ).
