---
title: "Git Architect Handbook: Khái niệm, Lệnh & Phỏng vấn"
excerpt: Tổng hợp toàn diện Git từ cơ chế DAG, các lệnh thực chiến đến tư duy giải quyết conflict và phỏng vấn cấp cao.
date: 2026-04-18
category: Git
image: /prezet/img/ogimages/blogs-git-git-architect-handbook.webp
tags: [git, architecture, debugging, interview]
---

## 1. Khái niệm cốt lõi (Tư duy của Architect)

- **Snapshot, not Diff:** Git lưu trữ trạng thái của toàn bộ project tại mỗi commit.
- **DAG (Directed Acyclic Graph):** Lịch sử Git là một đồ thị. Commit là node, parent pointer là cạnh.
- **HEAD:** Một con trỏ (pointer) trỏ tới commit hiện tại bạn đang làm việc.
- **Detached HEAD:** Khi HEAD trỏ tới một commit cụ thể thay vì một nhánh. Nếu bạn commit ở đây, commit sẽ bị "mồ côi" nếu không tạo nhánh mới.

## 2. Lệnh & Tình huống thực chiến

| Lệnh | Tình huống áp dụng | Mẹo thực chiến |
| :--- | :--- | :--- |
| `git stash` | Đang code dở, cần hotfix gấp. | Dùng `git stash pop --index` để giữ trạng thái stage. |
| `git reset --soft` | Commit nhầm, muốn sửa lại message hoặc add thêm file. | Cực an toàn, không mất file thay đổi. |
| `git rebase -i` | Gộp commit trước khi PR cho sạch đẹp. | Dùng `squash` để gộp, `reword` để đổi message. |
| `git cherry-pick` | Mang tính năng từ nhánh `develop` sang `hotfix`. | Cẩn thận conflict nếu logic phụ thuộc commit trước. |
| `git bisect` | Tìm commit gây lỗi trong 100 commit. | Dùng `git bisect run php artisan test` để tự động hóa. |

## 3. Câu hỏi phỏng vấn hóc búa

**Q: Sự khác biệt giữa `Reset` và `Revert`?**

- **Reset:** Xóa lịch sử (rewrite). Dùng trên nhánh cá nhân.
- **Revert:** Tạo commit mới để đảo ngược. Dùng trên nhánh chung (an toàn, giữ được tính minh bạch).

**Q: Git Bisect hoạt động thế nào?**

- **A:** Sử dụng thuật toán tìm kiếm nhị phân (Binary Search) trên cây commit. Độ phức tạp O(log N).

**Q: Làm sao để tìm commit đã bị mất sau khi reset?**

- **A:** `git reflog`. Đây là bảng ghi lại mọi hành động của HEAD. Bạn luôn có thể tìm thấy hash của commit cũ ở đây.

## 4. Tư duy & Kinh nghiệm (Senior Mindset)

- **Atomic Commits:** Mỗi commit phải là một đơn vị logic hoàn chỉnh. Đừng commit 10 file làm 10 việc khác nhau.
- **Đọc Log:** `git log --graph --oneline --all` là bạn thân của một Architect. Hãy biến nó thành alias `git lg`.
- **Đánh đổi (Trade-off):** Luôn ưu tiên `rebase` để lịch sử sạch sẽ trên nhánh feature, nhưng ưu tiên `merge` trên nhánh chính (main) để lưu dấu vết lịch sử rẽ nhánh.
