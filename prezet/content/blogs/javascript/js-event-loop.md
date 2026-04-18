---
title: "JavaScript Event Loop: Tại sao JS là đơn luồng nhưng vẫn cực nhanh?"
excerpt: Giải mã Call Stack, Web APIs, Task Queue và cách JS xử lý hàng ngàn tác vụ bất đồng bộ mà không block UI.
date: 2026-04-18
category: Javascript
image: /prezet/img/ogimages/blogs-javascript-js-event-loop.webp
tags: [javascript, event-loop, asynchronous, performance]
---

## 1. Cơ chế hoạt động

JavaScript là đơn luồng (single-threaded).

- **Call Stack:** Nơi các hàm được thực thi theo thứ tự.
- **Web APIs:** Browser hỗ trợ xử lý ngầm (setTimeout, fetch, click event).
- **Callback Queue:** Nơi chứa các kết quả từ Web APIs chờ để được vào Call Stack.
- **Event Loop:** Luôn kiểm tra: "Call Stack trống chưa?". Nếu trống, lấy cái đầu tiên từ Queue đẩy vào Stack.

## 2. Microtasks vs Macrotasks

- **Macrotasks:** `setTimeout`, `setInterval`.
- **Microtasks:** `Promise`, `queueMicrotask`.
*Tư duy:* Microtasks luôn được ưu tiên chạy hết trước khi Event Loop tiếp tục xử lý Macrotasks.

## 3. Kinh nghiệm

- Đừng bao giờ làm các tác vụ tính toán nặng (data processing 100k items) trực tiếp trên Main Thread. Hãy dùng `Web Workers`.
- Hiểu `async/await` bản chất là cú pháp "đẹp" hơn của Promise, không phải là đa luồng.

## 4. Quizz Senior

**Q: Tại sao `setTimeout(..., 0)` không chạy ngay lập tức?**
**A:** Vì nó bị đẩy vào Macrotask Queue. Nó phải chờ Call Stack rỗng và các Microtasks chạy xong thì Event Loop mới "nhấc" nó vào Stack.
