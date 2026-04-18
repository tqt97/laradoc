---
title: "JS Prototype: Bản chất của Kế thừa (Inheritance)"
excerpt: Giải mã Prototype Chain, cơ chế __proto__ và tại sao class trong JS chỉ là 'cú pháp đẹp' (syntactic sugar).
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-prototype-inheritance.webp
tags: [javascript, oop, prototype, internals]
---

## 1. Bản chất

JS không có class thực sự như Java/PHP. Nó dùng **Prototypal Inheritance**. Mỗi object có một thuộc tính ẩn `[[Prototype]]` (hay `__proto__`) trỏ tới object khác. Nếu bạn tìm một property không thấy ở object hiện tại, JS sẽ tìm ngược lên `__proto__` cho đến khi gặp `null`.

## 2. Code mẫu

```javascript
const animal = { eat: true };
const dog = Object.create(animal);
console.log(dog.eat); // true (lấy từ prototype)
```

## 3. Quizz Senior

**Q: Tại sao dùng `class` trong JS vẫn có thể bị coi là "sai"?**
**A:** Nếu bạn dùng `class` nhưng không hiểu bản chất Prototype, bạn sẽ lạm dụng kế thừa quá sâu (Deep Inheritance Tree). Hãy ưu tiên **Composition** (gộp object lại) thay vì kế thừa nhiều tầng.

**Q: Sự khác biệt giữa `__proto__` và `prototype`?**
**A:** `__proto__` là property của một *object* (instance). `prototype` là property của một *function* (class), nó xác định `__proto__` của object sẽ được tạo ra sau này.
