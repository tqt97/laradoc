---
title: "Refactor: Temporary Field (Biến tạm bất thường)"
excerpt: Khi biến tạm chỉ cần dùng trong 1 hàm nhưng lại được khai báo là thuộc tính class (property). Cách xử lý và tại sao nó nguy hiểm.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-temporary-field.webp
tags: [refactoring, clean-code, state]
---

## 1. Dấu hiệu (Smell)

Class khai báo nhiều property (`private $tempData`, `$currentProcessId`) chỉ để dùng trong đúng 1 hàm. Code nhìn như class đó có "state" (trạng thái) rất phức tạp, nhưng thực tế không phải vậy.

## 2. Giải pháp

- **Introduce Local Variable:** Chuyển property đó thành biến cục bộ (local variable) bên trong hàm.
- **Extract Method:** Nếu logic dùng các biến này quá dài, hãy tách nó ra một hàm riêng và truyền các giá trị này vào như tham số.

## 3. Tại sao nguy hiểm?

Nó đánh lừa lập trình viên (và cả máy tính) rằng class này có trạng thái (state). Khi chạy code đa luồng (hoặc các service chạy dài hạn trong Laravel Worker), các giá trị tạm này có thể bị gán đè lẫn nhau, gây lỗi không thể truy vết (race condition).

## 4. Câu hỏi nhanh

**Q: "Biến nào nên là property của class?"**
**A:** Chỉ khi nó đại diện cho "trạng thái" của đối tượng (VD: `$user->isVerified`, `$order->total`). Nếu nó chỉ là dữ liệu trung gian để tính toán, hãy dùng biến cục bộ (local variable).
