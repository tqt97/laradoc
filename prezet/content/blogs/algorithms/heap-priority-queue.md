---
title: "Heaps & Priority Queues: Sắp xếp ưu tiên trong thời gian thực"
excerpt: Ứng dụng Min-Heap/Max-Heap để giải quyết bài toán Top-K phần tử và xây dựng hệ thống xử lý tác vụ ưu tiên.
date: 2026-01-02
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-heap-priority-queue.webp
tags: [algorithms, heap, priority-queue, performance, optimization]
---

## 1. Bản chất

Heap là cây nhị phân gần như hoàn chỉnh:

- **Min-Heap:** Gốc là giá trị nhỏ nhất.
- **Max-Heap:** Gốc là giá trị lớn nhất.

## 2. Ứng dụng thực tế: Xử lý Queue ưu tiên

Trong Laravel Queue, nếu bạn muốn các job "quan trọng" (ví dụ: gửi mail xác thực nạp tiền) chạy trước job "thông thường" (gửi newsletter), hệ thống ngầm dùng cấu trúc dữ liệu tương tự Heap/Priority Queue để lấy job có độ ưu tiên cao nhất ra trước.

## 3. Câu hỏi nhanh

**Q: Độ phức tạp của việc lấy phần tử gốc trong Heap?**
**A:** O(1). Việc chèn hoặc xóa phần tử tốn O(log n).

**Q: Tại sao dùng Heap để tìm Top 10 trong 1 triệu phần tử lại tốt hơn Sort?**
**A:** Sort tốn O(n log n) và cần copy mảng. Dùng Min-Heap size 10 chỉ tốn O(n log 10) và chỉ lưu đúng 10 phần tử trong RAM.
