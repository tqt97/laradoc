---
title: "BFS vs DFS: Duyệt đồ thị và tư duy phân cấp"
excerpt: Phân tích Breadth-First Search và Depth-First Search. Ứng dụng trong Recommendation System, Social Graph và xử lý Category đa cấp.
date: 2026-02-18
category: Algorithms
image: /prezet/img/ogimages/blogs-algorithms-graph-bfs-dfs.webp
tags: [algorithms, graph, bfs, dfs, recommendation-system, performance]
---

## 1. Bản chất & Nguyên lý

- **BFS (Breadth-First Search - Chiều rộng):** Sử dụng `Queue` (FIFO). Duyệt qua từng "tầng" của đồ thị.
- **DFS (Depth-First Search - Chiều sâu):** Sử dụng `Stack` hoặc đệ quy. Đi sâu tới tận cùng của một nhánh trước khi quay lui.

## 2. Ứng dụng thực tế

- **BFS (Gợi ý bạn bè):** Bạn của bạn là tầng 1, bạn của bạn của bạn là tầng 2. BFS giúp tìm kiếm quan hệ theo khoảng cách/độ ưu tiên.
- **DFS (Phân cấp sản phẩm):** Duyệt danh mục (Category) cha -> con -> cháu. Phù hợp để build lại menu hoặc tìm kiếm đường đi trong mê cung.

## 3. Code mẫu (PHP)

```php
// BFS đơn giản
function bfs($graph, $start) {
    $queue = new SplQueue();
    $queue->enqueue($start);
    $visited = [$start => true];
    while (!$queue->isEmpty()) {
        $u = $queue->dequeue();
        foreach ($graph[$u] as $v) {
            if (!isset($visited[$v])) {
                $visited[$v] = true;
                $queue->enqueue($v);
            }
        }
    }
}
```

## 4. Kinh nghiệm Senior

- **BFS:** Dùng để tìm đường đi ngắn nhất trong đồ thị không trọng số.
- **DFS:** Dùng để phát hiện vòng lặp (Cycle Detection) hoặc duyệt cây phân cấp.
- **Lưu ý:** Đừng bao giờ quên đánh dấu `visited` (các nút đã duyệt), nếu không sẽ bị kẹt trong vòng lặp vô tận.

## 5. Phỏng vấn

**Q: Khi nào chọn BFS thay vì DFS?**
**A:** Khi cần tìm đường đi "gần nhất". DFS có thể đi vào nhánh rất sâu dù đích đến nằm ngay bên cạnh.
**Q: Tại sao DFS dùng đệ quy dễ bị Stack Overflow?**
**A:** Vì mỗi lần gọi đệ quy, PHP tạo một Stack Frame. Đồ thị quá sâu sẽ tràn bộ nhớ Stack. Giải pháp là dùng `SplStack` để chuyển sang dạng vòng lặp (Iterative DFS).
