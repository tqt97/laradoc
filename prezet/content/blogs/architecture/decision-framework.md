---
title: "Decision Framework: Khi nào dùng Service, Action, Trait, Interface?"
excerpt: Cẩm nang đưa ra quyết định thiết kế. Hướng dẫn chọn công cụ đúng đắn để đảm bảo code sạch và dễ mở rộng.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-decision-framework.webp
tags: [architecture, design-choices, solid, best-practices]
---

## 1. Bản đồ ra quyết định
| Công cụ | Khi nào dùng? | Cảnh báo |
| :--- | :--- | :--- |
| **Action** | Xử lý 1 nghiệp vụ duy nhất (`__invoke`). | Tránh làm quá nhiều Action cho 1 module. |
| **Service** | Nhóm các nghiệp vụ liên quan (VD: `PaymentService`). | Dễ thành "God Class" nếu logic quá lớn. |
| **Trait** | Chia sẻ code thuần (helper, log, date, trait model). | KHÔNG dùng cho logic chính (gây khó trace). |
| **Interface** | Khi cần thay thế Implementation (Polymorphism). | Chỉ dùng khi thực sự có > 1 implementation. |
| **Abstract** | Khi cần chia sẻ logic chung cho các class con. | Gây tight-coupling giữa cha và con. |

## 2. Decision Tips
- **Scope Model (Local):** Chỉ dùng để lọc dữ liệu (VD: `scopeActive`, `scopePublished`). Đừng bao giờ nhét logic nghiệp vụ (tính tiền, gửi mail) vào Scope.
- **Config vs Helper:**
    - **Config:** Luôn dùng cho các biến môi trường (API Key, Limit). Đừng hardcode.
    - **Helper:** Chỉ cho các hàm định dạng dữ liệu nhỏ, dùng toàn cầu (VD: `formatPrice`). Nếu logic phức tạp -> Đưa vào Service.

## 3. Phỏng vấn Senior
**Q: Tại sao đừng lạm dụng Interface cho mọi class?**
**A:** Nguyên lý YAGNI (You Ain't Gonna Need It). Tạo Interface cho class chỉ có 1 implementation duy nhất là "Over-engineering" làm tăng độ phức tạp không đáng có.

**Q: Khi nào class nên là Abstract Class thay vì Interface?**
**A:** Dùng Interface khi bạn muốn ép "Hợp đồng" (hàm nào phải có). Dùng Abstract Class khi bạn muốn chia sẻ cả code (implementation) cho lớp con.
