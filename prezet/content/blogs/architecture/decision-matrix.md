---
title: "Decision Matrix: Chọn Service, Action, Trait hay Interface?"
excerpt: Cẩm nang đưa ra quyết định thiết kế. Khi nào nên tạo class mới, khi nào dùng interface, và tại sao cần cảnh giác với Trait.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-decision-matrix.webp
tags: [architecture, design-patterns, laravel, best-practices]
---

## 1. Decision Matrix (Bảng quyết định)

| Công cụ | Khi nào dùng? | Cảnh báo |
| :--- | :--- | :--- |
| **Action** | Xử lý 1 nghiệp vụ duy nhất (`__invoke`). | Tránh làm quá nhiều Action cho 1 tính năng. |
| **Service** | Nhóm các nghiệp vụ liên quan (VD: `UserService`). | Dễ thành "God Class" nếu không tách nhỏ. |
| **Trait** | Chia sẻ code thuần (helper, log, date). | KHÔNG dùng cho nghiệp vụ chính (khó trace). |
| **Interface** | Cần thay thế Implementation (Polymorphism). | Chỉ dùng khi thực sự có > 1 implementation. |
| **Abstract** | Có logic chung và muốn ép con phải override. | Gây tight-coupling giữa cha và con. |

## 2. Khi nào tạo Config & Helper?
- **Config:** Dùng cho mọi tham số cần thay đổi giữa `local`, `staging`, `prod` (đừng bao giờ để `env()` trực tiếp trong code).
- **Helper:** Chỉ dùng cho logic cực đơn giản và toàn cục (VD: `money_format()`). Nếu helper có logic phức tạp -> Đưa vào **Service**.

## 3. Câu hỏi nhanh
**Q: Tại sao đừng lạm dụng Interface cho mọi class?**
**A:** "YAGNI" (You Ain't Gonna Need It). Tạo Interface cho class chỉ có 1 implementation duy nhất là "Over-engineering" gây khó đọc code.

**Q: Scope Model (Local Query Scope) dùng khi nào?**
**A:** Khi bạn thấy code `where('status', 'active')` xuất hiện quá 2 lần trong project. Đưa nó vào `scopeActive()`. Đừng viết logic nghiệp vụ (tính toán, send mail) vào Scope.
