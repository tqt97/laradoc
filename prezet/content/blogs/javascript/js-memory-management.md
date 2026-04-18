---
title: "JavaScript Memory: Leak & Dọn rác"
excerpt: Hiểu cách bộ dọn rác (Garbage Collector) của V8 hoạt động và cách tránh memory leaks trong SPA.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-memory-management.webp
tags: [javascript, memory-management, v8, debugging]
---

## 1. Bản chất (Garbage Collector)

V8 engine dùng thuật toán **Mark-and-Sweep**. Nó tìm các đối tượng "không thể chạm tới" (unreachable) từ `root` (window/global) để giải phóng.

## 2. Nguyên nhân gây Leak

- **Dangling Listeners:** Gắn sự kiện vào `window` hoặc `document` nhưng quên `remove` khi Component unmount.
- **Closures bất tận:** Giữ tham chiếu tới các object khổng lồ trong một Closure tồn tại lâu dài.
- **Detached DOM:** Xóa phần tử khỏi DOM nhưng vẫn giữ tham chiếu trong biến JS (cái biến đó ngăn không cho GC dọn phần tử DOM).

## 3. Công cụ Debug

- **Chrome Heap Snapshot:** So sánh 2 lần snapshot. Tìm đối tượng nào không được giải phóng.
- **Performance Monitor:** Theo dõi biểu đồ RAM, nếu sau khi GC (nút trash icon) mà RAM không giảm xuống mức nền, tức là có Leak.

## 4. Quizz Senior

**Q: "Làm sao tránh leak ở các thư viện bên thứ 3?"**
**A:** Luôn check tài liệu để xem thư viện có cung cấp hàm `destroy()` hoặc `dispose()` hay không. Hãy gọi nó trong `useEffect` cleanup function hoặc `componentWillUnmount`.
