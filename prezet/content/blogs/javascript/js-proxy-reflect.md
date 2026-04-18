---
title: "JS Metaprogramming: Proxies & Reflect"
excerpt: Kiểm soát mọi tương tác với Object bằng Proxy. Đây là ma thuật đằng sau hệ thống Reactivity (như Vue.js 3).
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-proxy-reflect.webp
tags: [javascript, metaprogramming, proxy, reactivity]
---

## 1. Bản chất

- **Proxy:** Là một đối tượng bao quanh (wrap) đối tượng khác và "đánh chặn" các thao tác như đọc (`get`), ghi (`set`), hoặc gọi hàm (`apply`).
- **Reflect:** Một bộ API giúp thực hiện các hành vi mặc định của object một cách an toàn và nhất quán.

## 2. Code mẫu (Reactivity cơ bản)

```javascript
const user = { name: 'Tuan' };
const proxy = new Proxy(user, {
    get(target, prop) {
        console.log(`Đang đọc: ${prop}`);
        return Reflect.get(target, prop);
    }
});
console.log(proxy.name); // Log: Đang đọc: name -> "Tuan"
```

## 3. Ứng dụng thực tế

- **Validation:** Kiểm tra giá trị trước khi `set`.
- **Logging/Auditing:** Ghi lại mọi thay đổi của model trong ứng dụng.
- **Frameworks:** Vue.js 3 dùng Proxy để track xem state nào thay đổi để re-render UI.

## 4. Quizz Senior

**Q: Tại sao dùng Reflect thay vì thao tác trực tiếp trên object trong Proxy?**
**A:** `Reflect` đảm bảo việc thực thi diễn ra đúng ngữ cảnh (`this` context), giúp code an toàn và tránh các bug khó đoán khi object có nhiều getter/setter phức tạp.
