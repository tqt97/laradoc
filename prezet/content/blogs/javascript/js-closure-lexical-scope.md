---
title: "Closure & Lexical Scope: Bí mật của hàm JS"
excerpt: Hiểu cách hàm nhớ được môi trường xung quanh nó. Ứng dụng trong việc tạo biến private và quản lý state.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-closure-lexical-scope.webp
tags: [javascript, closure, scope, functional-programming]
---

## 1. Bản chất

- **Lexical Scope:** Hàm "nhớ" được phạm vi nơi nó được định nghĩa, chứ không phải nơi nó được gọi.
- **Closure:** Một function kết hợp với môi trường lexical của nó. Nó cho phép hàm truy cập biến bên ngoài ngay cả khi hàm cha đã thực thi xong.

## 2. Ứng dụng thực tế: Data Privacy

```javascript
function createCounter() {
    let count = 0; // Private biến
    return () => ++count;
}
const counter = createCounter(); // count không thể truy cập từ ngoài
```

## 3. Phỏng vấn Senior

**Q: "Tại sao closure hay gây ra memory leak trong React?"**
**A:** Vì closure giữ tham chiếu đến biến của scope cha. Nếu closure đó được gán vào một sự kiện (event listener) lâu dài mà không clean up, các object lớn ở scope cha sẽ không bao giờ được Garbage Collector dọn dẹp.
**Mẹo:** Luôn `null` các biến hoặc `removeEventListener` khi component unmount.
