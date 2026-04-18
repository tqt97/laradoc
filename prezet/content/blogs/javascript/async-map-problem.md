---
title: "Async/Await trong .map(): Lỗi phổ biến nhất"
excerpt: Tại sao `.map()` không chờ đợi các 'await' bên trong hàm callback và cách dùng Promise.all để giải quyết.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-async-map-problem.webp
tags: [javascript, async, promise, array]
---

## 1. Bài toán

Bạn có danh sách ID, bạn muốn gọi API cho từng ID và lấy kết quả trả về.

```javascript
// SAI LẦM KINH ĐIỂN
const results = ids.map(async (id) => await fetch(id));
// Kết quả trả về là một mảng các Promise chứ không phải dữ liệu thật.
```

## 2. Giải pháp: Promise.all

`map` chỉ trả về mảng các Promise ngay lập tức. Để chờ tất cả chạy xong:

```javascript
const results = await Promise.all(ids.map(id => fetch(id)));
```

## 3. Tư duy Senior

- **Tại sao lại như vậy?** Vì `.map()` là hàm đồng bộ (synchronous). Nó chỉ khởi tạo các Promise và đưa chúng vào mảng, không có logic chờ đợi bất đồng bộ.
- **Mẹo:** Nếu cần chạy tuần tự (cái này xong mới tới cái kia), dùng `for...of` với `await`. Nếu muốn chạy song song, dùng `Promise.all()`.

## 4. Quizz Senior

**Q: Nếu dùng `for(const id of ids) { await fetch(id); }`, chương trình chạy thế nào?**
**A:** Nó chạy tuần tự (cái này xong mới gọi cái tiếp theo). Cực kỳ chậm nếu bạn gọi 100 API.
**Q: Khi nào thì nên dùng tuần tự thay vì song song?**
**A:** Khi các request phụ thuộc vào nhau hoặc khi server API bị giới hạn Rate Limit cực thấp (nếu gọi 100 cái cùng lúc sẽ bị 429).
