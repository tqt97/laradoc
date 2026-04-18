---
title: "HOC vs Hooks: Cuộc chiến của sự đóng gói"
excerpt: Phân tích tại sao Hooks đã thay thế HOC và cách thiết kế logic tái sử dụng trong ứng dụng React hiện đại.
date: 2026-04-18
category: React
image: /prezet/img/ogimages/blogs-react-hoc-vs-hooks.webp
tags: [react, hooks, hoc, design-patterns, clean-code]
---

## 1. HOC (Higher-Order Component)
- **Bản chất:** Một function nhận vào Component và trả về một Component mới (giống Decorator Pattern trong OOP).
- **Vấn đề:** Gây "Wrapper Hell" (lồng nhau quá nhiều lớp trong DevTools), khó track nguồn gốc của props.

## 2. Hooks (Sự thay đổi cuộc chơi)
- **Bản chất:** Hàm chia sẻ logic stateful.
- **Lợi ích:** Code phẳng, không bị wrapper hell, logic tách biệt hoàn toàn với UI.

## 3. Khi nào vẫn nên dùng HOC?
Trong các trường hợp cần can thiệp cực sâu vào vòng đời Component (như `ErrorBoundary`) hoặc khi cần wrap toàn bộ component bằng các logic bảo mật/logging mà không muốn sửa code bên trong.

## 4. Quizz Senior
**Q: "Tại sao không được gọi Hook trong conditional (if)?"**
**A:** Vì React dùng danh sách liên kết (linked list) để ghi nhớ thứ tự các hook. Nếu gọi trong `if`, thứ tự sẽ bị thay đổi giữa các lần render -> React sẽ bị "lú" và cập nhật sai state.
