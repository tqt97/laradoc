---
title: "Promises & Async/Await: Bất đồng bộ tinh gọn"
excerpt: Giải mã cơ chế bất đồng bộ, từ Promise tới Async/Await. Tránh 'Callback Hell' và hiểu sâu về Event Loop.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-async-promises.webp
tags: [javascript, async, promise, performance]
---

## 1. Bản chất

- **Promise:** Một container chứa một kết quả (thành công hoặc thất bại) sẽ xảy ra trong tương lai.
- **Async/Await:** "Cú pháp đẹp" (syntactic sugar) giúp code bất đồng bộ nhìn giống như code tuần tự, dễ đọc và dễ debug hơn nhiều so với `.then()`.

## 2. Các trạng thái

- **Pending:** Đang chờ.
- **Fulfilled:** Thành công.
- **Rejected:** Thất bại.

## 3. Kinh nghiệm Senior

- **Đừng dùng `forEach` với `await`:** `forEach` không đợi Promise hoàn thành. Hãy dùng `for...of` hoặc `Promise.all()`.
- **`Promise.all` vs `Promise.allSettled`:** Dùng `all` khi cần tất cả phải thành công. Dùng `allSettled` khi muốn đợi tất cả dù thành công hay lỗi (tránh việc 1 lỗi làm fail cả chuỗi).

## 4. Quizz Senior

**Q: Tại sao `async/await` không chạy song song mặc định?**
**A:** Vì bạn thường đặt `await` từng dòng. Để chạy song song, hãy trigger các promise trước, sau đó `await Promise.all([p1, p2])`.
