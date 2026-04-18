---
title: "JS Call, Apply, Bind: Kiểm soát 'this' context"
excerpt: Hiểu cách điều khiển 'this' trong các ngữ cảnh khác nhau và tại sao Bind là chìa khóa cho các ứng dụng OOP-style trong JS.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-call-apply-bind.webp
tags: [javascript, this, scope, callback]
---

## 1. Bài toán

Trong JS, `this` không cố định. Nó phụ thuộc vào việc "hàm được gọi như thế nào". Điều này làm dev phát điên khi dùng Callback.

## 2. Giải pháp: Control 'this'

- **`.call(thisArg, arg1, arg2)`:** Gọi hàm ngay lập tức với `this` là `thisArg` và danh sách tham số rời.
- **`.apply(thisArg, [args])`:** Gọi hàm ngay lập tức, tham số truyền vào dưới dạng **Array**.
- **`.bind(thisArg)`:** Trả về một hàm mới có `this` cố định là `thisArg`. Nó KHÔNG gọi hàm ngay.

## 3. Quizz Senior

**Q: "Khi nào cần bind?"**
**A:** Khi bạn dùng một hàm trong class nhưng passed vào event listener hoặc `setTimeout`. Lúc đó, `this` sẽ mất ngữ cảnh (không còn là class hiện tại nữa). `bind(this)` giúp "đóng đinh" lại ngữ cảnh.

**Q: Arrow Function có `bind` không?**
**A:** Không, Arrow function không có `this` riêng, nó lấy `this` từ scope bao quanh nó (Lexical scoping).
