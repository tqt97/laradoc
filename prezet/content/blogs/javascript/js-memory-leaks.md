---
title: "JavaScript Memory Leaks: Tìm và diệt"
excerpt: Các nguyên nhân gây leak bộ nhớ phổ biến (Global variables, Closure, Event Listeners) và công cụ debug trên trình duyệt.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-memory-leaks.webp
tags: [javascript, memory-management, debugging, performance]
---

## 1. Nguyên nhân

- **Global Variables:** Biến toàn cục không bao giờ bị dọn dẹp.
- **Closures:** Giữ tham chiếu tới scope cha vô tình khiến object không được giải phóng.
- **Event Listeners/Timers:** Dùng `addEventListener` hoặc `setInterval` trong React nhưng quên `remove` khi component unmount.

## 2. Công cụ Debug

- **Chrome DevTools (Memory Tab):** Chụp *Heap Snapshot*. So sánh 2 snapshot trước và sau khi thực hiện thao tác để xem đối tượng nào không được giải phóng.
- **Detached DOM Nodes:** Kiểm tra nếu bạn đã xóa DOM khỏi trang nhưng vẫn còn biến JS trỏ tới node đó, Browser vẫn giữ node đó trong RAM.

## 3. Quizz Senior

**Q: "Làm sao để tránh leak khi dùng Event Listener?"**
**A:** Luôn lưu reference của hàm xử lý và gọi `removeEventListener`. Hoặc dùng `AbortController` (đây là kỹ thuật modern và sạch nhất hiện nay).
