---
title: "Git Bisect: Truy vết lỗi thần tốc"
excerpt: Cách dùng Git Bisect để tìm ra commit chính xác đã gây ra lỗi bằng thuật toán tìm kiếm nhị phân.
date: 2026-04-18
category: Git
image: /prezet/img/ogimages/blogs-git-git-bisect-debugging.webp
tags: [git, debugging, performance, automation]
---

## 1. Bài toán

Code hôm nay lỗi, nhưng lỗi này đã xuất hiện từ 2 tuần trước. Bạn không biết chính xác commit nào gây ra lỗi.

## 2. Giải pháp: `git bisect`

Git Bisect sử dụng thuật toán **Binary Search** trên lịch sử commit.

1. `git bisect start`
2. `git bisect bad` (commit hiện tại lỗi)
3. `git bisect good <commit_id>` (commit cách đây 2 tuần ổn)
4. Git sẽ tự động "checkout" một commit ở giữa. Bạn test, nếu lỗi thì `git bisect bad`, nếu ổn thì `git bisect good`.
5. Sau vài bước, Git chỉ đích danh commit gây lỗi.

## 3. Kinh nghiệm

- **Automated Bisect:** Bạn có thể truyền một script test vào: `git bisect run php artisan test`. Git sẽ tự động chạy script này cho mỗi bước kiểm tra. Cực mạnh cho CI/CD.

## 4. Phỏng vấn

**Q: Độ phức tạp của Git Bisect?**
**A:** O(log N) với N là số lượng commit. Rất nhanh so với việc đi check từng commit một (O(N)).
