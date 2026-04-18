---
title: "Refactor: Dead Code - Kẻ thù thầm lặng"
excerpt: Làm sao để tìm và xóa code không dùng đến một cách an toàn. Tại sao code rác làm giảm vận tốc dev?
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-dead-code.webp
tags: [refactoring, clean-code, maintenance]
---

## 1. Dấu hiệu (Smell)

- Những biến, hàm, class chưa bao giờ được gọi.
- Những cấu trúc `if` mà code bên trong không bao giờ thực thi (ví dụ: checking cho một tính năng cũ đã tắt).
- Code bị comment lại (hãy dùng Git, đừng comment rác).

## 2. Chiến lược xử lý

- **Công cụ:** Dùng `phpstan` hoặc `psalm` để quét "dead code" tự động.
- **Quy trình:** Khi nghi ngờ code không dùng, hãy xóa nó. Nếu trong 1 tuần không ai phàn nàn, bạn đã loại bỏ thành công gánh nặng cho hệ thống.
- **Git:** Đừng comment code lại, hãy xóa nó. Lịch sử commit luôn lưu trữ nếu bạn cần xem lại.

## 3. Bài học xương máu

Code rác làm cho bộ não của đồng nghiệp (hoặc chính bạn) phải mất thời gian phân tích, gây mất tập trung. Loại bỏ nó là tăng tốc độ phát triển cho tương lai.

## 4. Câu hỏi nhanh

**Q: Tại sao đừng để code bị comment (commented-out code)?**
**A:** Nó gây nhiễu, làm khó đọc. Nếu cần code cũ, Git luôn nhớ nó. Code bị comment là biểu hiện của "sự thiếu tự tin" vào hệ thống kiểm soát phiên bản.
