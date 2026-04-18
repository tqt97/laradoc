---
title: "Refactor: Speculative Generality (Trừu tượng hóa thừa thãi)"
excerpt: Đừng viết code cho những tính năng 'có thể sẽ cần' trong tương lai. Kỹ thuật đơn giản hóa kiến trúc.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-speculative-generality.webp
tags: [refactoring, yagni, design-patterns]
---

## 1. Dấu hiệu (Smell)

- Bạn tạo ra Interface cho một Service mà chắc chắn chỉ có 1 Implementation duy nhất mãi mãi.
- Các tham số (parameter) được truyền vào hàm mà chưa bao giờ được sử dụng (chỉ để "đề phòng" sau này cần).

## 2. Cách xử lý

- **Inline Class/Interface:** Nếu thấy không thực sự cần, hãy xóa bỏ Interface, gọi thẳng Class.
- **YAGNI (You Ain't Gonna Need It):** Chỉ trừu tượng hóa khi bạn có 2 case thực tế khác nhau hoàn toàn.

## 3. Bài học xương máu

Nhiều dev hay mắc lỗi "kỹ sư hóa" (Over-engineering) để thỏa mãn cái tôi kiến trúc. Một kiến trúc tốt là một kiến trúc mà nếu cần thay đổi, bạn có thể dễ dàng refactor, chứ không phải là một kiến trúc đã phức tạp sẵn từ ngày đầu.

## 4. Phỏng vấn

**Q: "Sự khác biệt giữa linh hoạt (Flexibility) và phức tạp (Complexity)?"**
**A:** Linh hoạt là làm cho code dễ đổi. Phức tạp là làm cho code khó đọc mà không mang lại giá trị thực tế. Đừng nhầm lẫn giữa hai điều này.
