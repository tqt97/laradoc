---
title: "Refactor: Long Parameter List (Danh sách tham số dài)"
excerpt: Khi hàm của bạn cần 5-6 tham số trở lên, đó là lúc cần đóng gói dữ liệu vào Parameter Object.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-long-parameter-list.webp
tags: [refactoring, clean-code, design-patterns]
---

## 1. Dấu hiệu (Smell)

Hàm có quá nhiều tham số (VD: `function createOrder($userId, $items, $total, $tax, $shipping, $couponCode, $currency)`) khiến việc gọi hàm trở nên khó khăn và dễ nhầm thứ tự.

## 2. Giải pháp

- **Introduce Parameter Object:** Tạo một class chứa nhóm tham số đó (VD: `OrderRequestDTO`).
- **Preserve Whole Object:** Thay vì truyền từng giá trị của Model, hãy truyền nguyên một `Model` hoặc `Value Object` vào.

## 3. Lợi ích

- **Đọc code:** Hàm chỉ còn 1-2 tham số, cực kỳ dễ đọc.
- **Tính ổn định:** Nếu sau này cần thêm `discount_type`, bạn chỉ cần update DTO, không cần sửa tất cả các chỗ đang gọi hàm.

## 4. Câu hỏi nhanh

**Q: Tại sao truyền `Model` vào service lại tốt hơn truyền từng property của nó?**
**A:** Nó tăng tính linh hoạt (Flexibility). Nếu tương lai hàm đó cần thêm thông tin từ Model, bạn chỉ cần lấy từ object có sẵn, không phải sửa lại toàn bộ signature của hàm.
