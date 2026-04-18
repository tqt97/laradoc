---
title: "Git Reset vs Revert vs Checkout: Làm chủ dòng thời gian"
excerpt: Phân biệt 3 lệnh 'nguy hiểm' nhất trong Git. Khi nào dùng để sửa sai, khi nào dùng để quay đầu.
date: 2026-04-18
category: Git
image: /prezet/img/ogimages/blogs-git-reset-revert-checkout.webp
tags: [git, troubleshooting, workflow]
---

## 1. Bản chất sự khác biệt

- **`git reset --hard <commit>`:** Đập bỏ lịch sử. Quay về commit cũ, mọi commit sau đó bị xóa sạch. **Nguy hiểm**, chỉ dùng trên local.
- **`git revert <commit>`:** Tạo một commit MỚI ngược lại với commit cũ. **An toàn**, dùng được trên nhánh đã push.
- **`git checkout <commit>`:** Chuyển sang trạng thái "của quá khứ" (Detached HEAD). Dùng để xem lại code, không làm thay đổi lịch sử.

## 2. Khi nào áp dụng

- **Code sai, chưa push:** `git reset --hard HEAD~1` (xóa commit đó đi cho sạch).
- **Code sai, đã push:** `git revert <commit_id>` (tạo commit mới đè lên để sửa lỗi mà không làm rối lịch sử chung).
- **Xem lại code cũ:** `git checkout <commit_id>`.

## 3. Phỏng vấn Senior

**Q: Tại sao Revert an toàn hơn Reset?**
**A:** Reset làm mất dữ liệu trên nhánh chung, khiến mọi người khác bị conflict khi pull. Revert chỉ thêm commit mới, lịch sử được bảo toàn.
**Q: Tình huống: Lỡ tay reset --hard xong mới nhận ra mình quên lưu code?**
**A:** Dùng `git reflog` để tìm lại commit ID đã bị xóa khỏi HEAD, sau đó `git reset --hard <id>` để khôi phục. (Git gần như không bao giờ mất dữ liệu thực sự).
