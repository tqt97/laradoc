---
title: "Refactor: Parallel Inheritance Hierarchies (Kế thừa song song)"
excerpt: Khi việc thêm một class ở nhánh này bắt buộc bạn phải thêm class ở nhánh kia. Cách phá bỏ sự phụ thuộc này.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-parallel-inheritance.webp
tags: [refactoring, inheritance, clean-code, architecture]
---

## 1. Dấu hiệu (Smell)

Mỗi khi tạo `PaymentProcessor` (nhánh 1), bạn lại phải tạo một `PaymentUI` (nhánh 2) tương ứng. Sự thay đổi ở nhánh này luôn kéo theo thay đổi ở nhánh kia.

## 2. Giải pháp

- **Move Method / Move Field:** Gom logic của cả 2 nhánh vào một class duy nhất (nếu có thể).
- **Bridge Pattern:** Tách biệt trừu tượng và hiện thực. Hãy biến cây kế thừa thứ 2 thành một thuộc tính (property) của cây kế thừa thứ 1.

## 3. Lợi ích

- Giảm số lượng class cần quản lý.
- Tránh việc quên tạo class ở một trong hai nhánh dẫn đến lỗi runtime.

## 4. Câu hỏi nhanh

**Q: Tại sao kế thừa (Inheritance) lại có thể là "kẻ thù"?**
**A:** Kế thừa tạo ra mối liên kết cực kỳ chặt chẽ (tight coupling). Nếu bạn kế thừa sai cách, bạn sẽ gặp tình trạng "Explosion of Classes" (nổ tung số lượng class) khi hệ thống lớn dần.
