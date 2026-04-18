---
title: "Kiến trúc Laravel: Khi nào dùng Service, Action, Trait, Interface?"
excerpt: "Hướng dẫn tư duy đưa ra quyết định thiết kế: Chọn công cụ nào để đảm bảo code dễ bảo trì (Maintainable) và dễ mở rộng (Scalable)."
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-laravel-design-choices.webp
tags: [architecture, design-choices, solid, best-practices]
---

## 1. Bản đồ ra quyết định
- **Trait:** Chỉ dùng để chia sẻ code nhỏ (như `HasApiTokens`, `SoftDeletes`). Đừng dùng Trait để chứa business logic, nó gây "Diamond Problem" và khó debug.
- **Service Class:** Dùng cho logic nghiệp vụ nhóm (VD: `PaymentService` chứa `charge()`, `refund()`, `cancel()`).
- **Action Class:** Nếu chỉ có 1 phương thức duy nhất (`__invoke` hoặc `execute`), hãy dùng Action. Nó tuân thủ S trong SOLID tuyệt đối.
- **Interface/Abstract Class:** Chỉ dùng khi bạn cần **Polymorphism** (tính đa hình). Ví dụ: Bạn cần 3 cách gửi email khác nhau, hãy tạo `MailInterface`.
- **Config:** Dùng khi giá trị cần thay đổi theo môi trường (`.env`). Đừng hardcode.
- **Helper:** Chỉ dùng cho hàm Utility cực kỳ phổ biến (ví dụ: format tiền tệ). Hạn chế vì khó Unit Test.

## 2. Kinh nghiệm thực chiến
- **Scope Model (Local):** Dùng để lọc dữ liệu thường xuyên (ví dụ: `active()`, `published()`). Đừng viết logic nghiệp vụ phức tạp ở đây.
- **Nên hay không nên:**
    - *Nên:* Tách biệt logic ra khỏi Controller.
    - *Không nên:* Over-engineering. Dự án nhỏ đừng tạo 100 cái Interface chỉ để "trông có vẻ chuyên nghiệp".

## 3. Phỏng vấn Senior
**Q: Khi nào class nên là Abstract Class thay vì Interface?**
**A:** Khi bạn có logic chung muốn chia sẻ cho các class con (Code Reuse), dùng Abstract. Khi bạn chỉ muốn áp đặt "hợp đồng" (hàm nào phải có) mà không muốn ép buộc quan hệ kế thừa, dùng Interface.
**Q: Mẹo đánh đố:** "Tại sao không nên dùng Trait cho Business Logic?"
**A:** Vì Trait làm class "phình to" một cách mù quáng. Nó ẩn giấu dependency, làm IDE khó tra cứu source code và gây xung đột tên phương thức.
