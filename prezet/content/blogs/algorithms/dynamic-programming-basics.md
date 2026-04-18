---
title: "Dynamic Programming: Bí mật tối ưu hóa bài toán"
excerpt: Học cách giải quyết các bài toán phức tạp bằng việc chia nhỏ thành các bài toán con và lưu trữ kết quả (Memoization).
date: 2026-04-11
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-dynamic-programming-basics.webp
tags: [algorithms, dynamic-programming, optimization, recursion]
---

## 1. Bản chất

Dynamic Programming (DP) là kỹ thuật giải quyết bài toán lớn bằng cách chia nhỏ thành các bài toán con chồng chéo (overlapping subproblems) và **lưu trữ kết quả** (memoization) để không phải tính toán lại.

## 2. Cách tiếp cận

- **Top-down:** Đệ quy + Lưu cache.
- **Bottom-up:** Dùng vòng lặp, đi từ bài toán con nhỏ nhất lên lớn dần.

## 3. Ứng dụng

- Bài toán cái túi (Knapsack Problem).
- Tìm chuỗi con chung dài nhất (Longest Common Subsequence).
- Tính số Fibonacci (phiên bản tối ưu).

## 4. Câu hỏi nhanh

**Q: Sự khác biệt giữa DP và Chia để trị (Divide and Conquer)?**
**A:** Divide and Conquer chia bài toán thành các phần độc lập. DP chia thành các phần **chồng chéo** (phải tính lại nhiều lần), nên cần lưu cache.

**Q: Tại sao DP được coi là một dạng đánh đổi thời gian - không gian?**
**A:** Bạn hy sinh bộ nhớ (RAM) để lưu cache, đổi lại tốc độ tính toán tăng lên từ O(2ⁿ) xuống O(n²).
