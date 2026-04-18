---
title: "Event Delegation: Tối ưu hàng ngàn sự kiện"
excerpt: Cách sử dụng Event Bubbling để quản lý sự kiện cho hàng nghìn phần tử con chỉ với 1 Event Listener duy nhất.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-js-event-delegation.webp
tags: [javascript, events, performance, dom]
---

## 1. Bài toán

Bạn có danh sách 1.000 sản phẩm trong một bảng. Đừng gắn `addEventListener` cho mỗi sản phẩm (hỏng RAM và gây chậm trình duyệt).

## 2. Giải pháp: Event Delegation

Tận dụng cơ chế **Event Bubbling** (sự kiện nổi lên):
Gắn 1 listener duy nhất vào thẻ cha (`table` hoặc `ul`). Khi người dùng click vào thẻ con (`td`, `li`), sự kiện sẽ "nổi" lên tới cha.

## 3. Code mẫu

```javascript
document.querySelector('ul').addEventListener('click', (e) => {
    if (e.target.tagName === 'LI') {
        console.log('Clicked item:', e.target.textContent);
    }
});
```

## 4. Quizz Senior

**Q: Sự khác biệt giữa `event.target` và `event.currentTarget`?**
**A:** `event.target` là phần tử *thực sự* bị click (thẻ con). `event.currentTarget` là phần tử *đang gắn listener* (thẻ cha). Khi làm delegation, phải dùng `event.target`.
**Q: Lợi ích chính?**
**A:** Tiết kiệm RAM (1 listener thay vì 1000) và tự động xử lý được cả những phần tử thêm mới vào sau này (không cần gắn lại sự kiện).
