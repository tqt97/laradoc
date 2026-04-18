---
title: "Refactor: Inappropriate Intimacy (Sự thân mật thái quá)"
excerpt: Dấu hiệu khi hai class biết quá nhiều về dữ liệu của nhau và cách tách biệt chúng để tăng tính đóng gói.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-inappropriate-intimacy.webp
tags: [refactoring, encapsulation, clean-code]
---

## 1. Dấu hiệu (Smell)
Class A liên tục truy cập vào các `protected`/`private` property của class B (hoặc qua các getter lạm dụng). Chúng gắn kết chặt chẽ đến mức thay đổi 1 dòng trong A là B hỏng ngay.

## 2. Giải pháp
- **Move Method / Move Field:** Nếu hàm/biến đó được class A dùng nhiều hơn chính class B, hãy di chuyển nó sang A.
- **Extract Interface:** Thay vì để class A gọi trực tiếp class B, hãy để A gọi qua `BInterface`. A chỉ cần biết các method của Interface đó, không cần biết nội dung của B.

## 3. Bài học xương máu
- **Encapsulation (Đóng gói) là chìa khóa:** Một class tốt là một "hộp đen". Bạn chỉ nên giao tiếp qua API (method) của nó, không nên đào bới xem bên trong nó lưu biến gì.

## 4. Câu hỏi nhanh
**Q: Khi nào sự thân mật giữa 2 class là chấp nhận được?**
**A:** Khi chúng là một phần của cùng một "Domain Entity" hoặc "Aggregate" (trong DDD). Lúc đó, sự thân mật là cần thiết để đảm bảo tính nhất quán (Consistency) của dữ liệu.
