---
title: "React: Stale State trong Closure"
excerpt: Tại sao 'setInterval' hay 'useEffect' lại dùng mãi giá trị cũ của state? Cách giải quyết bằng Functional Update.
date: 2026-04-18
category: React
image: /prezet/img/ogimages/blogs-react-stale-state-closure.webp
tags: [react, closure, state, bug-fixing]
---

## 1. Bài toán

Trong một component, bạn set interval để cộng dồn state: `setInterval(() => setCount(count + 1), 1000)`. Dù bạn làm gì, `count` vẫn mãi là 0 hoặc 1.

## 2. Bản chất

Closure của `setInterval` chỉ "chụp ảnh" giá trị của `count` tại thời điểm component render lần đầu tiên. Nó không bao giờ biết được giá trị mới của `count`.

## 3. Giải pháp: Functional Update

Luôn dùng callback để nhận state mới nhất:

```javascript
// Thay vì setCount(count + 1)
setCount(prevCount => prevCount + 1);
```

## 4. Quizz Senior

**Q: Tại sao Functional Update là "chìa khóa"?**
**A:** Vì React sẽ đảm bảo cung cấp giá trị mới nhất (up-to-date state) cho hàm của bạn ngay tại thời điểm thực thi `setState`, bỏ qua việc phụ thuộc vào giá trị cũ trong closure của component.
**Mẹo:** Với `useEffect` có dependency phức tạp, hãy cân nhắc dùng `useReducer` để đưa logic update state ra ngoài, giúp code dễ quản lý hơn.
