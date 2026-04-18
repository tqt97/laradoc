---
title: "JS Modules: ESM vs CommonJS"
excerpt: Phân biệt các chuẩn module trong JS, tại sao chúng tồn tại và cách webpack/vite giải quyết sự xung đột này.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-modules-esm-cjs.webp
tags: [javascript, modules, esm, commonjs]
---

## 1. CommonJS (CJS)

- **Đặc trưng:** Dùng `require()` và `module.exports`.
- **Môi trường:** Truyền thống của Node.js.
- **Tính chất:** Đồng bộ (Synchronous).

## 2. ESM (ECMAScript Modules)

- **Đặc trưng:** Dùng `import` và `export`.
- **Môi trường:** Chuẩn của trình duyệt và Node.js hiện đại.
- **Tính chất:** Bất đồng bộ (Asynchronous), hỗ trợ Tree-shaking tốt hơn.

## 3. Tại sao lại xung đột?

JS phát triển mà không có hệ thống module chính thức. CJS ra đời từ cộng đồng Node.js, trong khi ESM là chuẩn ngôn ngữ.

## 4. Quizz Senior

**Q: "Tại sao ESM tốt hơn cho Tree-shaking?"**
**A:** Vì ESM có cấu trúc tĩnh (Static Structure). Công cụ build (Webpack/Vite) có thể phân tích code mà không cần thực thi, từ đó xóa sạch những code không dùng đến. CJS thì phải thực thi code mới biết module đó export cái gì, làm việc tree-shaking trở nên cực khó.
