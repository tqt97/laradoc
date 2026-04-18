---
title: "Refactor: Data Class (Class 'bù nhìn')"
excerpt: Dấu hiệu khi class chỉ chứa getter/setter và cách 'bơm' logic vào đúng chỗ.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-data-class.webp
tags: [refactoring, clean-code, encapsulation]
---

## 1. Dấu hiệu (Smell)

Class chỉ có các biến (`public` hoặc `private` + getter/setter). Mọi logic tính toán, xử lý đều nằm ở class khác.

## 2. Giải pháp: Move Behavior

- **Move Method:** Nếu Service class luôn lấy data từ Data Class này để tính toán, hãy chuyển logic đó vào chính Data Class (Encapsulation).
- **Lưu ý:** Nếu class đó là `DTO` (chỉ để truyền dữ liệu), thì nó không phải là Data Class "bù nhìn" – nó đang làm đúng nhiệm vụ của nó.

## 3. Câu hỏi nhanh

**Q: Sự khác biệt giữa Data Class và DTO?**
**A:** Data Class thường ám chỉ sự "thiếu logic" nơi đáng lẽ cần có. DTO (Data Transfer Object) là một design pattern có mục đích rõ ràng: truyền tải data giữa các hệ thống/layer. Đừng nhầm lẫn giữa chúng.
**Q: Nguyên tắc cốt lõi của OOP?**
**A:** "Don't ask, tell!" (Đừng hỏi object, hãy bảo object làm). Thay vì lấy data rồi tính toán ở ngoài (ask), hãy bắt đối tượng tự tính toán giá trị của nó (tell).
