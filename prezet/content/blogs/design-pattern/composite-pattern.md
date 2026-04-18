---
title: "Composite Pattern: Xử lý cấu trúc cây"
excerpt: Composite Pattern giúp nhóm các đối tượng vào cấu trúc cây để xử lý chúng như một đối tượng đơn lẻ.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-composite-pattern.webp
tags: [design-patterns, php, structural, tree]
---

## 1. Vấn đề

Bạn cần xây dựng một menu đa cấp hoặc hệ thống file/thư mục. Việc phân biệt đối xử giữa "thư mục" (chứa file) và "file" (đơn lẻ) trong code khiến việc lặp (loop) qua toàn bộ cấu trúc trở nên rối rắm.

## 2. Định nghĩa

Composite Pattern (Nhóm Structural) cho phép bạn gom các đối tượng vào cấu trúc cây. Khách hàng sử dụng (Client) có thể gọi method trên một đối tượng đơn lẻ hoặc một nhóm đối tượng một cách đồng nhất.

## 3. Cách giải quyết + Code mẫu

```php
interface Component { public function render(); }

class File implements Component {
    public function render() { echo "File"; }
}

class Folder implements Component {
    protected $children = [];
    public function add(Component $c) { $this->children[] = $c; }
    public function render() {
        foreach($this->children as $c) $c->render();
    }
}
```

## 4. Khi nào áp dụng & Mẹo

- **Áp dụng:** Menu website, danh mục sản phẩm lồng nhau, hệ thống file.
- **Mẹo:** Đảm bảo tất cả component (đơn lẻ và nhóm) cùng implement một interface chung.

## 5. Câu hỏi phỏng vấn

- **Q: Tại sao gọi là cấu trúc cây?** Vì các object nhóm (Composite) có thể chứa các object con, và các object con đó có thể là một Composite khác, tạo ra phân cấp.
- **Q: Composite có vi phạm nguyên lý Single Responsibility?** Không, nếu bạn chỉ coi "render" là hiển thị, nhưng nếu bạn nhồi logic nghiệp vụ vào class Composite thì sẽ bị vi phạm.

## 6. Kết luận

Composite Pattern đơn giản hóa việc tương tác với các hệ thống phân cấp phức tạp.
