---
title: "React Memory Leak: Tại sao phải dọn dẹp useEffect?"
excerpt: Giải mã cơ chế 'Cleanup function' trong useEffect và hậu quả của việc quên removeEventListener.
date: 2026-04-18
category: React
image: /prezet/img/ogimages/blogs-react-memory-leak-useeffect.webp
tags: [react, memory-leak, hooks, performance]
---

## 1. Bài toán

Bạn gắn một sự kiện `window.addEventListener('resize', ...)` trong `useEffect`. Khi component bị unmount, sự kiện đó vẫn còn tồn tại trong bộ nhớ. Sau 100 lần chuyển trang, bạn có 100 hàm xử lý chạy ngầm gây crash trình duyệt.

## 2. Giải pháp: Cleanup Function

Luôn luôn trả về một hàm "dọn dẹp" trong `useEffect`.

```javascript
useEffect(() => {
    const handleResize = () => console.log('resized');
    window.addEventListener('resize', handleResize);
    
    // Cleanup: Chạy khi component unmount hoặc effect chạy lại
    return () => window.removeEventListener('resize', handleResize);
}, []);
```

## 3. Kinh nghiệm thực chiến

- **Không chỉ Event Listener:** Timer (`setTimeout`, `setInterval`), Subscription (RxJS), WebSocket đều cần cleanup.
- **Tư duy:** Nếu bạn khởi tạo cái gì đó "bên ngoài" phạm vi component (như `window`, `document`, `global state`), hãy chắc chắn bạn đã "trả lại" nó khi component chết.

## 4. Quizz Senior

**Q: "Nếu quên cleanup function, điều gì xảy ra?"**
**A:** `Memory Leak` (Rò rỉ bộ nhớ) và các `side-effect` không mong muốn. Hàm đó vẫn chạy và cố gắng `setState` trên một component đã bị unmount, gây ra warning `Can't perform a React state update on an unmounted component`.
