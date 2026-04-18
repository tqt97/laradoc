---
title: "Refactor: Middle Man (Sự trung gian thừa thãi)"
excerpt: Khi class chỉ làm mỗi việc ủy quyền gọi hàm cho class khác. Tại sao nên xóa bỏ nó?
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-middle-man.webp
tags: [refactoring, clean-code, architecture]
---

## 1. Dấu hiệu (Smell)

Bạn thấy một class có 10 phương thức, và cả 10 đều chỉ gọi đến `class B`. Class này đang đóng vai trò "người trung gian" vô nghĩa.

## 2. Giải pháp

- **Remove Middle Man:** Hãy để client gọi trực tiếp class B.
- **Tại sao?** Mỗi lớp trung gian đều tốn bộ nhớ, tốn thời gian maintain, và làm rối luồng code.

## 3. Khi nào ĐƯỢC PHÉP giữ?

Khi Middle Man đóng vai trò là một **Facade** (đơn giản hóa giao diện phức tạp) hoặc là một **Proxy** (kiểm soát quyền truy cập). Nếu nó chỉ gọi `return $b->method()`, hãy xóa nó đi.

## 4. Câu hỏi nhanh

**Q: Sự khác biệt giữa Facade và Middle Man là gì?**
**A:** Facade đơn giản hóa một giao diện phức tạp thành một thứ dễ dùng. Middle Man là sự lười biếng trong thiết kế khi ủy quyền vô nghĩa cho một lớp không có tính năng bổ sung nào.
