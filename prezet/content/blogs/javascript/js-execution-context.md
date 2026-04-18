---
title: "Execution Context & Hoisting: Trình tự thực thi của JS"
excerpt: Giải mã Call Stack, Hoisting và tại sao 'var' lại khác biệt hoàn toàn so với 'let/const'.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-execution-context.webp
tags: [javascript, internals, hoisting, scope]
---

## 1. Execution Context (Ngữ cảnh thực thi)

Mỗi khi một hàm được gọi, JS tạo ra một "Execution Context". Nó gồm 2 giai đoạn:

- **Creation Phase:** Setup bộ nhớ (biến, hàm được đưa vào bộ nhớ).
- **Execution Phase:** Thực thi từng dòng code.

## 2. Hoisting (Sự nâng lên)

- **Hàm (`function`):** Được hoisting toàn bộ code, nên bạn có thể gọi hàm trước khi định nghĩa.
- **`var`:** Được hoisting và gán giá trị `undefined`.
- **`let/const`:** Được hoisting nhưng nằm trong **Temporal Dead Zone (TDZ)**. Truy cập trước khi khai báo sẽ gây lỗi `ReferenceError`.

## 3. Tại sao cần quan tâm?

Việc hiểu Hoisting giúp bạn tránh các bug "undefined" kinh điển và viết code có thứ tự, dễ đọc hơn. Luôn khai báo biến trước khi dùng (với `let`/`const`) là tiêu chuẩn của một Senior.

## 4. Quizz Senior

**Q: Tại sao `let/const` lại có TDZ?**
**A:** Để ngăn chặn các lỗi logic khi gọi biến chưa được khởi tạo. Đây là cách JS buộc bạn phải viết code tuân thủ luồng dữ liệu (data flow) từ trên xuống dưới.
