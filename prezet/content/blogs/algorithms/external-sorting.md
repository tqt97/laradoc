---
title: "External Sorting: Khi dữ liệu lớn không vừa RAM"
excerpt: Giải pháp sắp xếp tập dữ liệu khổng lồ (vượt quá RAM) bằng kỹ thuật chia nhỏ và merge, thường dùng trong xử lý logs/Big Data.
date: 2026-04-15
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-external-sorting.webp
tags: [algorithms, sorting, big-data, performance]
---

## 1. Bài toán

Bạn cần sắp xếp một file log 50GB, nhưng RAM server chỉ có 2GB. Thuật toán sort thông thường (QuickSort, MergeSort in-memory) sẽ gây lỗi OOM ngay lập tức.

## 2. Giải pháp: External Merge Sort

Quy trình "chia để trị" cấp độ đĩa cứng:

1. **Chia:** Đọc từng phần 1GB của file, sort trong RAM, lưu thành file tạm (`chunk_1.tmp`, `chunk_2.tmp`...).
2. **Trộn (Merge):** Dùng Priority Queue (Min-Heap) để đọc lần lượt từng dòng từ các file tạm, so sánh và ghi dòng nhỏ nhất vào file kết quả cuối cùng.

## 3. Code mẫu (Logic Merge)

```php
// Dùng SplPriorityQueue để merge các file đã sort
$heap = new SplPriorityQueue();
foreach ($fileHandles as $handle) {
    $line = fgets($handle);
    $heap->insert($line, $line); // Priority là giá trị dòng
}
// Vòng lặp lấy min từ heap và nạp tiếp từ file tương ứng...
```

## 4. Câu hỏi nhanh

**Q: Tại sao phải dùng Priority Queue trong bước Merge?**
**A:** Để luôn tìm ra phần tử nhỏ nhất từ K file tạm với độ phức tạp O(log K). Nếu quét thủ công qua K file thì sẽ là O(K) cho mỗi bước, rất chậm.

**Q: Khi nào ứng dụng thực tế?**
**A:** Export báo cáo hàng triệu dòng, xử lý log để tạo trend, xây dựng index cho tìm kiếm toàn văn.
