---
title: "Git Workflow: Commit chuẩn & Quy trình chuyên nghiệp"
excerpt: Cách đặt tên commit theo chuẩn Conventional Commits, chiến lược branching và cách tránh 'Git Hell'.
date: 2026-04-18
category: Git
image: /prezet/img/ogimages/blogs-git-git-workflow-best-practices.webp
tags: [git, devops, workflow, best-practices]
---

## 1. Conventional Commits (Chuẩn hóa lịch sử)

Đừng viết `fixed bug` hay `update code`. Hãy tuân thủ: `<type>(<scope>): <subject>`

- **type:** `feat` (tính năng mới), `fix` (sửa lỗi), `docs`, `refactor`, `perf`.
- **VD:** `feat(auth): add email verification support`

## 2. Chiến lược Branching (GitFlow vs Trunk-based)

- **GitFlow:** Phù hợp dự án lớn, nhiều team (có `master`, `develop`, `feature/*`, `hotfix/*`).
- **Trunk-based:** Dành cho đội ngũ Senior, đẩy trực tiếp vào `main`, dùng `Feature Flags` để ẩn tính năng chưa xong. *Đây là xu hướng của DevOps hiện đại.*

## 3. Mẹo xử lý "Git Hell"

- **Interactive Rebase:** Dùng `git rebase -i` để gộp (squash) các commit nhảm trước khi PR.
- **Git Hook:** Dùng `husky` (npm) hoặc `pre-commit` (python) để ép buộc chạy Linter/Test trước khi commit.

## 4. Câu hỏi nhanh

**Q: Tại sao không nên dùng `git merge` cho feature branch?**
**A:** `merge` tạo ra các commit "merge" thừa thãi làm lịch sử rối mù. Hãy dùng `rebase` để di chuyển feature branch của bạn lên trên đỉnh của `main`, giúp lịch sử là một đường thẳng sạch sẽ.

**Q: Khi nào thì `force push`?**
**A:** Chỉ khi bạn rebase trên branch cá nhân của bạn. **CẤM** force push lên `main` hoặc `develop` nếu không muốn cả team chửi bới.
