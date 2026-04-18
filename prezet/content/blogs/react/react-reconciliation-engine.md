---
title: "React Reconciliation: 'Bộ não' đằng sau tốc độ của React"
excerpt: Giải mã thuật toán Diffing và cơ chế React Fiber engine. Hiểu tại sao React render nhanh và cách tối ưu hóa re-render.
date: 2026-04-18
category: React
image: /prezet/img/ogimages/blogs-react-react-reconciliation-engine.webp
tags: [react, javascript, frontend, internals, performance]
---

## 1. Virtual DOM và Thuật toán Diffing

React tạo ra một bản sao (Virtual DOM) để so sánh với bản cũ thay vì tác động trực tiếp vào DOM thật (thao tác chậm nhất trong Browser).

- **Type khác nhau:** React hủy toàn bộ cây cũ và tạo mới.
- **Type giống nhau:** React chỉ cập nhật các thuộc tính (props) thay đổi.
- **Keys:** Là chìa khóa định danh, giúp React biết phần tử nào được thêm/xóa/dịch chuyển.

## 2. React Fiber: Cuộc cách mạng (từ v16)

Trước Fiber, quá trình render là đồng bộ. Nếu UI phức tạp, nó sẽ làm "đơ" trình duyệt (Main Thread).
**Fiber** biến quá trình render thành các khối nhỏ (units of work) có thể:

- Tạm dừng.
- Ưu tiên (Priority).
- Thực thi lại.

## 3. Mẹo tối ưu (Senior level)

- **Đừng lạm dụng `index` làm key:** Nếu mảng thay đổi thứ tự, React sẽ bị nhầm lẫn state. Luôn dùng ID duy nhất.
- **`useMemo` & `useCallback`:** Đừng dùng tràn lan! Chỉ dùng khi Component con cực kỳ nặng hoặc phụ thuộc vào `React.memo`. Việc lạm dụng chúng cũng tốn chi phí bộ nhớ để so sánh dependencies.

## 4. Quizz Senior

**Q: "Tại sao React cần 'Key'?"**
**A:** Để định danh. Nếu không có key, khi bạn lọc/xóa phần tử trong danh sách, React sẽ cố "tái sử dụng" component cũ cho phần tử mới, gây lỗi UI hiển thị sai dữ liệu.
