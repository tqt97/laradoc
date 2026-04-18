---
title: "Git Workflow: Tối ưu hóa luồng làm việc & Conflict"
excerpt: "Các kỹ thuật nâng cao: Rebase, Cherry-pick, Bisect và cách xử lý conflict 'chết người'."
date: 2026-04-18
category: Git
image: /prezet/img/ogimages/blogs-git-advanced-workflow.webp
tags: [git, workflow, debugging, best-practices]
---

## 1. Các kỹ thuật quan trọng

- **Rebase vs Merge:**
  - `Rebase`: "Viết lại lịch sử", biến nhánh feature thành phần mở rộng của main. Luôn sạch, nhưng cấm dùng trên nhánh đã public.
  - `Merge`: "Ghi lại sự thật", giữ nguyên dấu vết rẽ nhánh. Dùng cho Pull Request để audit.
- **Cherry-pick:** "Nhặt" commit. Cực hữu ích khi cần hotfix từ nhánh develop mà không muốn lấy toàn bộ tính năng chưa xong.

## 2. Xử lý Conflict như một Architect

- **Nguyên lý:** Đừng bao giờ giải quyết conflict bằng cách "đoán". Hãy mở IDE, xem lại commit log xem tại sao code lại đổi ở dòng đó (dùng `git blame`).
- **Git Bisect:** Nếu không biết commit nào gây bug, hãy dùng `git bisect`. Nó chạy binary search qua lịch sử commit để tìm đúng commit lỗi.

## 3. Câu hỏi nhanh

**Q: Làm sao khi đã push lên server rồi mà lại phát hiện ra commit nhầm file mật khẩu?**
**A:** Không dùng `reset --hard` đơn thuần. Phải `rebase -i` (để sửa lại lịch sử) sau đó `git push --force-with-lease`. `force-with-lease` an toàn hơn `force` vì nó kiểm tra xem bạn có đè lên commit của ai khác vừa push vào không.
