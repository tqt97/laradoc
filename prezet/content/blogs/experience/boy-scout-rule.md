---
title: "Quy tắc Boy Scout: Quản lý nợ kỹ thuật"
excerpt: Tư duy 'luôn để lại code sạch hơn lúc mới nhận'. Cách ngăn chặn hệ thống bị 'thối rữa' theo thời gian.
date: 2026-04-18
category: Experience
image: /prezet/img/ogimages/blogs-experience-boy-scout-rule.webp
tags: [experience, technical-debt, clean-code]
---

## 1. Tư duy Boy Scout

"Luôn để lại khu cắm trại sạch hơn lúc bạn đến." Áp dụng vào code: Bất cứ khi nào bạn phải mở một file để sửa lỗi, hãy dành thêm 5-10 phút để refactor nó một chút (tách hàm, đặt lại tên biến).

## 2. Khi nào thì KHÔNG nên refactor?

- Khi bạn đang chạy đua deadline cho một tính năng sống còn.
- Khi module đó quá rủi ro và không có Unit Test bao phủ (bạn cần viết test trước).

## 3. Quản lý Technical Debt

- **Đừng sợ nợ:** Nợ kỹ thuật là một phần của phát triển. Vấn đề là "lãi suất". Nếu code quá bẩn, thời gian dev tính năng mới sẽ chậm dần theo cấp số nhân.
- **Kinh nghiệm:** Dành 20% thời gian mỗi sprint cho việc refactor và giảm nợ. Đây là "lương" của kiến trúc bền vững.

## 4. Quizz

**Q: "Làm sao thuyết phục PM cho thời gian refactor?"**
**A:** Đừng nói về "code sạch". Hãy nói về **tốc độ phát triển trong tương lai**. Giải thích rằng nếu không refactor, việc thêm tính năng mới sẽ chậm lại X lần trong 3 tháng tới.
