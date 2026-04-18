---
title: "Debounce & Throttle: Tối ưu các sự kiện tần suất cao"
excerpt: Giải quyết vấn đề 'bùng nổ' sự kiện bằng cách kiểm soát tần suất thực thi hàm.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-debounce-throttle.webp
tags: [javascript, performance, optimization, event-handling]
---

## 1. Bài toán

Sự kiện `scroll` hoặc `input` bắn ra hàng chục lần mỗi giây. Nếu gọi API hoặc tính toán nặng trong đó, trình duyệt sẽ bị "lag" nặng nề.

## 2. Giải pháp

- **Debounce:** Chỉ chạy sau khi người dùng dừng hành động trong một khoảng thời gian (VD: Chỉ gọi API tìm kiếm khi user ngừng gõ 300ms).
- **Throttle:** Giới hạn tần suất tối đa (VD: Chỉ cho phép tính toán scroll mỗi 200ms).

## 3. Code mẫu (Debounce)

```javascript
function debounce(func, delay) {
    let timer;
    return (...args) => {
        clearTimeout(timer);
        timer = setTimeout(() => func(...args), delay);
    };
}
```

## 4. Quizz Senior

**Q: Khi nào dùng cái nào?**
**A:** Dùng **Debounce** cho Search/Input (chờ gõ xong). Dùng **Throttle** cho Scroll/Resize/Game loop (cần phản hồi liên tục nhưng giới hạn tần suất).
**Q: Ứng dụng trong React?**
**A:** Luôn dùng `useMemo` hoặc `useCallback` để tạo ra các hàm debounce/throttle ổn định, tránh tạo mới ở mỗi render.
