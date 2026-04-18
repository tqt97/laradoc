---
title: "QuickSort vs MergeSort: Cuộc chiến của sự chia để trị"
excerpt: Phân tích kỹ thuật sắp xếp 'chia để trị', so sánh hiệu năng, bộ nhớ và trường hợp sử dụng tối ưu trong PHP.
date: 2026-04-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-sorting-quicksort-mergesort.webp
tags: [algorithms, sorting, performance, big-o]
---

## 1. QuickSort (Sắp xếp nhanh)

- **Cơ chế:** Chọn một phần tử làm Pivot, đẩy phần tử nhỏ hơn sang trái, lớn hơn sang phải. Đệ quy cho đến khi hoàn tất.
- **Ưu điểm:** Cực nhanh trong thực tế, không tốn thêm bộ nhớ (in-place).
- **Nhược điểm:** O(n²) trong trường hợp xấu nhất (mảng đã sắp xếp sẵn).

## 2. MergeSort (Sắp xếp trộn)

- **Cơ chế:** Chia mảng làm đôi liên tục, sau đó trộn (merge) các mảng đã sắp xếp lại.
- **Ưu điểm:** Luôn là O(n log n). Stable (giữ nguyên thứ tự phần tử bằng nhau).
- **Nhược điểm:** Tốn thêm RAM để lưu các mảng tạm.

## 3. So sánh

| Tiêu chí | QuickSort | MergeSort |
| :--- | :--- | :--- |
| Độ phức tạp trung bình | O(n log n) | O(n log n) |
| Bộ nhớ | O(1) - Không cần RAM phụ | O(n) - Tốn RAM |
| Stable | Không | Có |

## 4. Ứng dụng thực tế

- Dùng **QuickSort** khi bạn cần tốc độ và bộ nhớ là ưu tiên (sắp xếp mảng trong PHP).
- Dùng **MergeSort** khi dữ liệu quá lớn không vừa RAM (External Sort) hoặc cần sự ổn định tuyệt đối về thứ tự.

## 5. Câu hỏi nhanh

**Q: PHP dùng thuật toán gì trong `sort()`?**
**A:** PHP dùng một biến thể của QuickSort (thường là Dual-pivot Quicksort) vì nó tận dụng cache locality rất tốt, giúp tốc độ nhanh hơn hẳn các thuật toán khác trên cấu trúc dữ liệu mảng.
