---
title: "Characterization Testing: Đóng băng hành vi trước khi Refactor"
excerpt: Kỹ thuật giúp bạn refactor code cũ (Legacy) mà không lo làm hỏng tính năng cũ bằng cách tạo lưới an toàn.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-characterization-testing.webp
tags: [testing, legacy-code, refactoring]
---

## 1. Bài toán

Bạn cần refactor một hàm tính giá cực kỳ phức tạp (300 dòng, không test). Bạn sửa một chỗ, tính năng khác lại lỗi.

## 2. Giải pháp: Characterization Test

Đừng cố test xem hàm đó chạy "đúng" hay không (vì bạn còn chưa biết đúng là gì). Hãy viết test để ghi lại xem hiện tại nó chạy "thế nào" (Input gì -> Output đó).

- **Quy trình:**
    1. Chạy hàm với các bộ Input đa dạng.
    2. Lưu kết quả Output vào file JSON.
    3. Viết test so sánh kết quả refactor với file JSON đó.

## 3. Lợi ích

- **Đóng băng hành vi:** Đảm bảo sau khi refactor, kết quả vẫn y hệt như cũ.
- **Tự tin:** Bạn có thể đổi cấu trúc code hoàn toàn mà không sợ sai lệch nghiệp vụ.

## 4. Câu hỏi nhanh

**Q: Khi nào nên xóa các test này?**
**A:** Sau khi bạn đã hiểu hoàn toàn logic nghiệp vụ và viết lại bộ test mới (Unit Test) dựa trên logic thực tế (thay vì dựa trên hành vi cũ).
