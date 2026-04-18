---
title: "Git Internals: Hệ thống lưu trữ DAG và Snapshot"
excerpt: "Giải mã bản chất của Git: Tại sao nó là một đồ thị có hướng không chu trình (DAG). Hiểu sâu để không bao giờ sợ mất code."
date: 2026-04-18
category: Git
image: /prezet/img/ogimages/blogs-git-git-internals-dag.webp
tags: [git, architecture, internals, data-structures]
---

## 1. Bản chất: Git không lưu Diff

Git là một hệ thống quản lý snapshot. Mỗi commit là một nút trong đồ thị, chứa trỏ tới một "Root Tree" (cấu trúc thư mục) và các "Parent Commits".

## 2. Các khái niệm cốt lõi

- **Blob:** Nội dung file thuần túy (không chứa tên file).
- **Tree:** Tương đương với thư mục, chứa danh sách các Blob/Tree con.
- **Commit:** Chứa con trỏ tới Tree, thông tin người commit, và danh sách các cha (parent).
- **Branch:** Chỉ là một "cái tên" trỏ tới một Commit ID.

## 3. Tại sao kiến trúc này quan trọng?

- **Immutability (Tính bất biến):** Commit không bao giờ thay đổi. Khi bạn sửa code, bạn tạo ra một bản snapshot mới. Điều này giúp tính toàn vẹn dữ liệu cực cao.
- **Branching cực rẻ:** Vì chỉ là thay đổi con trỏ, tạo branch chỉ tốn vài bytes.

## 4. Câu hỏi nhanh

**Q: Sự khác biệt giữa `git reset --hard` và `git checkout` một commit cũ?**
**A:** `reset` di chuyển con trỏ nhánh (branch) về commit cũ, ghi đè working tree. `checkout` chỉ di chuyển `HEAD` sang trạng thái "Detached HEAD", không thay đổi lịch sử của nhánh đó.
