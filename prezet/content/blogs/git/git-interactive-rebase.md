---
title: "Git Interactive Rebase: Nghệ thuật làm sạch lịch sử"
excerpt: Cách sử dụng 'rebase -i' để gộp commit, chỉnh sửa message và cấu trúc lại lịch sử trước khi merge vào nhánh chính.
date: 2026-04-18
category: Git
image: /prezet/img/ogimages/blogs-git-git-interactive-rebase.webp
tags: [git, refactoring, workflow, best-practices]
---

## 1. Bản chất

`git rebase -i` (Interactive) cho phép bạn thay đổi lịch sử commit của chính mình (chưa push) trước khi chia sẻ với đồng đội.

## 2. Khi nào áp dụng

- **Squash:** Gộp các commit nhỏ (`fix typo`, `wip`) thành 1 commit ý nghĩa trước khi PR.
- **Reword:** Sửa lại message commit nếu sai chính tả hoặc không đúng chuẩn.
- **Drop:** Loại bỏ các commit thừa, không liên quan.

## 3. Lệnh & Ví dụ

```bash
# Rebase 3 commit gần nhất
git rebase -i HEAD~3
```

*Giao diện mở ra:*

```text
pick a1b2c3d Fix auth bug
pick e4f5g6h WIP
pick h7i8j9k Cleanup
```

*Sửa thành:*

```text
pick a1b2c3d Fix auth bug
squash e4f5g6h WIP
squash h7i8j9k Cleanup
```

## 4. Kinh nghiệm & Lưu ý

- **Quy tắc vàng:** Không bao giờ rebase các commit đã bị người khác `git pull` về. Nó sẽ làm gãy lịch sử của đồng đội.
- **Khi bị xung đột:** Resolve conflict -> `git add .` -> `git rebase --continue`.

## 5. Phỏng vấn Senior

**Q: Sự khác biệt giữa `squash` và `fixup` trong Rebase?**
**A:** `squash` giữ message cũ để bạn sửa lại. `fixup` tự động hủy message của commit đó và gộp vào commit trước (dùng cho các commit sửa lỗi nhỏ).
**Q: Git Rebase vs Merge?**
**A:** Rebase tạo lịch sử tuyến tính (tốt cho tính dễ đọc), Merge lưu lại chính xác thời điểm rẽ nhánh (tốt cho audit/tranh chấp).
