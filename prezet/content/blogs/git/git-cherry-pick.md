---
title: "Git Cherry-Pick: Mang tính năng sang nhánh khác"
excerpt: Cách lấy duy nhất 1 commit từ nhánh này sang nhánh kia mà không cần merge cả nhánh.
date: 2026-04-18
category: Git
image: /prezet/img/ogimages/blogs-git-git-cherry-pick.webp
tags: [git, workflow, cherry-pick]
---

## 1. Bài toán

Bạn đã làm một tính năng hoàn hảo trên nhánh `feature-login`, nhưng khách hàng chỉ muốn lấy đúng cái đó vào nhánh `release-1.0` mà không muốn dính các code chưa xong khác trên nhánh `feature-login`.

## 2. Giải pháp: Cherry-Pick

`git cherry-pick <commit_id>` tạo ra một commit mới trên nhánh hiện tại với nội dung y hệt commit đã chọn.

## 3. Workflow thực tế

1. Checkout sang nhánh muốn mang commit đến: `git checkout release-1.0`.
2. Cherry-pick: `git cherry-pick a1b2c3d`.

## 4. Lưu ý & Mẹo

- **Xung đột:** Cherry-pick cũng có thể gây conflict như merge. Giải quyết xong thì `git cherry-pick --continue`.
- **Đừng lạm dụng:** Nếu bạn thường xuyên cherry-pick nhiều commit, hãy xem xét lại quy trình branching.

## 5. Phỏng vấn Senior

**Q: Cherry-pick có thay đổi lịch sử không?**
**A:** Nó tạo ra một commit ID hoàn toàn mới (vì nó có timestamp và parent mới), mặc dù code thay đổi là giống hệt.
**Q: Cách dùng với nhiều commit?**
**A:** `git cherry-pick A..B` (pick tất cả từ A đến B, không bao gồm A).
