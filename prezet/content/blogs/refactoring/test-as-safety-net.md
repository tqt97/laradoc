---
title: "Testing: Lưới an toàn khi Refactor"
excerpt: Viết Characterization Tests để 'đóng băng' hành vi của code cũ, cho phép bạn tự tin sửa đổi hệ thống.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-test-as-safety-net.webp
tags: [testing, refactoring, best-practices]
---

## 1. Bài toán

Bạn cần sửa một class cực kỳ cũ, không ai nhớ logic bên trong là gì, không có test.

## 2. Giải pháp: Characterization Testing

- **Bước 1:** Ghi lại mọi output của class đó với các đầu vào khác nhau.
- **Bước 2:** Viết test dựa trên output đó (dù output có thể là sai, cứ ghi lại).
- **Bước 3:** Bây giờ bạn đã có "lưới an toàn". Khi refactor, nếu kết quả thay đổi -> Test sẽ fail -> Bạn biết ngay đã làm sai ở đâu.

## 3. Lời khuyên của Senior

- Đừng cố gắng hiểu 100% code cũ trước khi sửa. Chỉ cần đảm bảo **Input A thì Output B không đổi**.
- Khi refactor xong, hãy viết lại test cho đúng với logic mong muốn (sau khi đã hiểu).

## 4. Câu hỏi nhanh

**Q: "Nếu viết test mất nhiều thời gian hơn cả viết code?"**
**A:** Đó là đầu tư cho tương lai. Code không có test là **"nợ kỹ thuật"** (technical debt). Code có test là **"tài sản"**. Khi bạn refactor sau 6 tháng, bạn sẽ cảm ơn chính mình ngày hôm nay.
