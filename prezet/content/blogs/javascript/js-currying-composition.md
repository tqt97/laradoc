---
title: "Currying & Composition: Tư duy lập trình hàm trong JS"
excerpt: Biến các hàm phức tạp thành các hàm nhỏ, linh hoạt bằng Currying và kết hợp chúng bằng Composition.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-currying-composition.webp
tags: [javascript, functional-programming, composition, currying]
---

## 1. Currying

Biến hàm `f(a, b)` thành `f(a)(b)`.

- **Tác dụng:** Cấu hình hàm trước, thực thi sau. Cực mạnh cho các Validator hoặc Middleware.

```javascript
const add = (a) => (b) => a + b;
const add5 = add(5); // Cấu hình trước
console.log(add5(10)); // Thực thi sau
```

## 2. Composition (Kết hợp hàm)

Đưa kết quả hàm A làm đầu vào hàm B (`f(g(x))`).

```javascript
const compose = (f, g) => (x) => f(g(x));
const shout = compose(exclaim, upper);
```

## 3. Tại sao cần cho Architect?

Khi hệ thống lớn, logic thường bị "dính chặt" vào nhau. Currying và Composition ép buộc bạn tách code thành các **hàm nguyên tử (atomic functions)**. Những hàm này cực dễ test và có thể ráp vào bất kỳ đâu như lắp ghép LEGO.

## 4. Quizz Senior

**Q: "So sánh Currying với Dependency Injection?"**
**A:** Currying là DI ở mức độ hàm (Functional). Cả hai đều cho phép bạn "inject" các cấu hình vào hàm mà không làm nó phụ thuộc vào dữ liệu toàn cục.
