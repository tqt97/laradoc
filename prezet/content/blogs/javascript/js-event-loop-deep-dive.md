---
title: "Event Loop: Cơ chế xử lý bất đồng bộ"
excerpt: Giải mã Microtask, Macrotask và cách Event Loop duy trì hiệu năng mượt mà của JavaScript.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-event-loop-deep-dive.webp
tags: [javascript, performance, event-loop]
---

## 1. Bản chất

JavaScript đơn luồng. Nó xử lý bất đồng bộ thông qua:

- **Call Stack:** Xử lý lệnh đồng bộ.
- **Macrotask Queue:** `setTimeout`, `setInterval`.
- **Microtask Queue:** `Promise.resolve`, `MutationObserver`, `queueMicrotask`.

## 2. Thứ tự thực thi (Quan trọng)

1. Chạy hết Call Stack.
2. Chạy hết toàn bộ **Microtasks** (ưu tiên cao).
3. Chạy một Macrotask.
4. Lặp lại.

## 3. Quizz Senior

**Q: "Nếu có 100 Promise (microtask) và 1 setTimeout (macrotask), cái nào chạy trước?"**
**A:** Microtasks (Promise) sẽ chạy hết sạch rồi mới đến Macrotask (setTimeout). Nếu Promise tiếp tục tạo ra Promise mới, Macrotask có thể bị "bỏ đói" (Starvation).
**Mẹo:** Đừng block Event Loop bằng việc tạo ra quá nhiều Microtasks trong một tick.
