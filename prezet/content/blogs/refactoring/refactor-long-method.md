---
title: "Refactor: Xử lý Long Method (Hàm quá dài)"
excerpt: Dấu hiệu nhận biết và cách tách nhỏ các hàm quá tải, vi phạm nguyên lý Single Responsibility.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-refactor-long-method.webp
tags: [refactoring, clean-code, solid]
---

## 1. Dấu hiệu (Smell)

- Hàm dài trên 30-50 dòng.
- Hàm chứa quá nhiều logic: validate, gọi DB, xử lý business, format response.
- Khó đặt tên (tên hàm phải có từ "and" hoặc mô tả quá chung chung).

## 2. Chiến lược refactor

- **Extract Method:** Chia nhỏ các khối logic con thành các hàm `private` hoặc `protected` có tên mang tính mô tả cao.
- **Extract Class (Action):** Nếu một đoạn logic con có thể tái sử dụng hoặc quá phức tạp, hãy di chuyển nó sang một `Action Class` mới.
- **Tư duy:** Mỗi hàm chỉ nên làm **một việc duy nhất**.

## 3. Câu hỏi nhanh

**Q: "Hàm thế nào là quá dài?"**
**A:** Không có con số chính xác. Hãy dùng quy tắc: **Nếu bạn cần comment để giải thích "hàm này làm gì" ở giữa hàm**, thì đó là dấu hiệu nó cần được tách thành các hàm con với tên gọi tự giải thích.

**Q: Khi tách hàm, biến nào nên là tham số?**
**A:** Chỉ truyền vào những gì hàm đó thực sự cần. Đừng bao giờ truyền cả object `$request` vào một hàm con nếu chỉ cần 1 trường dữ liệu. Điều này làm tăng sự phụ thuộc (Tight Coupling).
