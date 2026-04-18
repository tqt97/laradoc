---
title: "Refactoring: Chiến lược 'Baby Steps' an toàn"
excerpt: Làm sao để refactor những class 'God Object' ngàn dòng mà không gây sập hệ thống? Quy trình từng bước một.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-refactor-strategy.webp
tags: [refactoring, clean-code, testing, best-practices]
---

## 1. Bản chất: "Red - Green - Refactor"

Đừng bao giờ refactor code mà không có Unit Test bao quanh.

- **Bước 1 (Safety Net):** Viết Integration/Unit test bao phủ luồng hiện tại (dù code đang bẩn, test này đảm bảo hành vi không đổi).
- **Bước 2 (Refactor):** Thay đổi cấu trúc code (tách hàm, tách class).
- **Bước 3 (Verify):** Chạy lại test. Nếu fail -> Rollback ngay lập tức.

## 2. Các kỹ thuật kinh điển

- **Extract Method:** Hàm quá dài -> Tách các phần logic con thành hàm riêng.
- **Extract Class:** Class ôm đồm quá nhiều trách nhiệm (VD: Vừa lưu DB, vừa gửi mail) -> Tách thành `Repository` và `Service`.
- **Replace Conditional with Polymorphism:** Thay `if/else` bằng các class `Strategy`.

## 3. Kinh nghiệm Senior

- **Đừng refactor quá đà (Over-engineering):** Nếu một hàm chỉ dùng 1 lần, đừng cố làm cho nó quá trừu tượng (abstract).
- **Quy tắc Scout (Quy tắc hướng đạo sinh):** Luôn để lại module sạch sẽ hơn lúc bạn mới bước vào. Một chút mỗi ngày sẽ ngăn chặn nợ kỹ thuật (Technical Debt) tích tụ.

## 4. Câu hỏi nhanh

**Q: "Nếu code không có test, làm sao refactor an toàn?"**
**A:** Viết "Characterization Tests" trước. Chạy thử code hiện tại, ghi nhận đầu vào và đầu ra, dùng kết quả đó làm "test case" tạm thời để bao phủ hành vi hiện tại (thay vì mong muốn).
