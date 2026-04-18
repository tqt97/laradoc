---
title: "Race Conditions: Bài toán 'kẻ đến sau' trong Async"
excerpt: Giải quyết vấn đề khi các request bất đồng bộ trả về kết quả không theo thứ tự mong muốn trong JavaScript.
date: 2026-04-18
category: JavaScript
image: /prezet/img/ogimages/blogs-javascript-race-conditions.webp
tags: [javascript, async, race-condition, debugging]
---

## 1. Bài toán

User tìm kiếm "React" -> request gửi đi. Sau đó nhanh tay gõ tiếp "PHP" -> request gửi đi. Nếu request "React" chậm hơn và trả về sau "PHP", UI sẽ hiển thị kết quả của "React" trong khi thanh tìm kiếm ghi là "PHP".

## 2. Giải pháp: AbortController

Trong JS hiện đại, `AbortController` là tiêu chuẩn để hủy các request cũ.

```javascript
let controller;
async function search(query) {
    if (controller) controller.abort(); // Hủy request cũ
    controller = new AbortController();
    
    try {
        const res = await fetch(`/api/search?q=${query}`, { signal: controller.signal });
        const data = await res.json();
    } catch (e) {
        if (e.name !== 'AbortError') throw e; // Bỏ qua lỗi hủy
    }
}
```

## 3. Quizz Senior

**Q: "Tại sao `Promise.race` không giải quyết được vấn đề này?"**
**A:** `Promise.race` chỉ lấy kết quả nhanh nhất, nhưng không hủy (abort) request chậm. Request chậm vẫn tốn băng thông và tài nguyên server một cách vô ích.

**Q: Kinh nghiệm thực chiến?**
**A:** Luôn dùng `AbortController` cho mọi request liên quan đến UI Search/Filter để tiết kiệm tài nguyên và đảm bảo tính nhất quán (Consistency).
