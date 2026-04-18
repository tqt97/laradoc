---
title: "Git Internals: Tại sao Git là một Snapshot Machine?"
excerpt: Bản chất Git không lưu trữ 'diff' mà lưu trữ 'snapshot'. Hiểu về Git Objects để quản lý branch hiệu quả.
date: 2026-04-18
category: Git
image: /prezet/img/ogimages/blogs-git-git-internals-snapshots.webp
tags: [git, internals, architecture]
---

## 1. Bản chất: Git Objects

Git không lưu diff (thay đổi). Mỗi khi bạn commit, Git chụp một tấm ảnh toàn bộ project (Snapshot).

- **Blob:** Nội dung file.
- **Tree:** Cấu trúc thư mục (liên kết các Blob).
- **Commit:** Pointer trỏ tới Root Tree, chứa thông tin tác giả, thời gian và Pointer đến commit trước đó (Parent).

## 2. Tại sao Architect cần hiểu?

Vì Git thực chất là một **Directed Acyclic Graph (DAG)**. Mỗi nhánh chỉ là một "cái tên" (Label) trỏ đến một Commit ID cụ thể. Hiểu điều này giúp bạn làm chủ `rebase`, `reset`, `cherry-pick` mà không sợ mất dữ liệu.

## 3. Câu hỏi nhanh

**Q: `git branch` thực chất làm gì?**
**A:** Nó chỉ tạo ra một file text nhỏ trong `.git/refs/heads/` chứa chuỗi 40 ký tự (Commit Hash). Đó là lý do tạo branch cực kỳ nhanh.
**Q: `git checkout` vs `git switch`?**
**A:** `switch` được sinh ra để tách biệt mục đích: Switch branch chỉ là đổi nhánh, Checkout dùng cho cả branch và restore file.
