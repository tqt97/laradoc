---
title: Visitor Pattern - Tách biệt thuật toán khỏi dữ liệu
excerpt: Tìm hiểu Visitor Pattern - cách thêm hành vi mới vào cấu trúc đối tượng có sẵn mà không cần sửa code class gốc, giải mã cơ chế Double Dispatch.
category: Design pattern
date: 2026-04-03
order: 27
image: /prezet/img/ogimages/series-design-pattern-visitor-pattern.webp
---

> Pattern thuộc nhóm **Behavioral Pattern (Hành vi)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang quản lý một hệ thống các loại bài viết khác nhau: `BlogPost`, `SeriesPost`, `KnowledgePost`. Bạn đã viết xong code cho chúng và hệ thống đang chạy ổn định.

Bây giờ, sếp yêu cầu thêm các tính năng:

1. Xuất toàn bộ nội dung sang định dạng **Markdown**.
2. Tính toán **SEO Score** cho từng loại bài.
3. Kiểm tra **Broken Links** (link hỏng).

**Naive Solution:** Thêm các hàm `exportToMarkdown()`, `calculateSeo()`, `checkLinks()` vào thẳng các class Post gốc.
**Vấn đề:**

* **Vi phạm Open/Closed Principle:** Bạn phải sửa đổi code của các class đang chạy ổn định.
* **Làm dơ Class:** Các class Post vốn chỉ nên lo về dữ liệu bài viết, nay lại phải ôm thêm logic export, SEO... (Vi phạm SRP).
* **Khó bảo trì:** Mỗi lần thêm tính năng mới, bạn lại phải đi sửa một loạt các class.

## 2. Định nghĩa

**Visitor Pattern** cho phép bạn định nghĩa một thao tác mới mà không làm thay đổi các lớp của các đối tượng mà nó thao tác.

**Ý tưởng cốt lõi:** Thay vì để đối tượng tự thực hiện thuật toán, hãy gửi một **"Vị khách" (Visitor)** đến thăm đối tượng đó. Vị khách này sẽ chứa thuật toán và thực hiện nó dựa trên dữ liệu của đối tượng.

## 3. Implementation (PHP Clean Code)

### 3.1 Element Interface

```php
interface PostElement {
    public function accept(PostVisitor $visitor): void;
}
```

### 3.2 Concrete Elements

```php
class BlogPost implements PostElement {
    public function accept(PostVisitor $visitor): void {
        $visitor->visitBlogPost($this);
    }
}

class SnippetPost implements PostElement {
    public function accept(PostVisitor $visitor): void {
        $visitor->visitSnippetPost($this);
    }
}
```

### 3.3 Visitor Interface (Danh sách các loại đối tượng muốn thăm)

```php
interface PostVisitor {
    public function visitBlogPost(BlogPost $post): void;
    public function visitSnippetPost(SnippetPost $post): void;
}
```

### 3.4 Concrete Visitor (Thuật toán cụ thể)

```php
class MarkdownExportVisitor implements PostVisitor {
    public function visitBlogPost(BlogPost $post): void {
        echo "Xuất bài Blog sang Markdown...\n";
    }

    public function visitSnippetPost(SnippetPost $post): void {
        echo "Xuất mã Snippet sang Markdown...\n";
    }
}
```

### 3.5 Sử dụng

```php
$posts = [new BlogPost(), new SnippetPost()];
$markdownVisitor = new MarkdownExportVisitor();

foreach ($posts as $post) {
    $post->accept($markdownVisitor);
}
```

## 4. Liên hệ Laravel

Trong thế giới Laravel/PHP, Visitor Pattern thường xuất hiện trong các thư viện xử lý code (Static Analysis) hoặc các bộ Parser:

**1. PHP-Parser (Thư viện Laravel dùng bên dưới):**
Khi Laravel parse các file Blade hoặc code PHP để phân tích, nó dùng Visitor để duyệt qua cây cú pháp (Abstract Syntax Tree - AST). Mỗi "Vị khách" sẽ lo một việc: tìm class, đổi tên biến, hoặc kiểm tra lỗi bảo mật.

**2. File System Crawler:**
Khi bạn dùng `File::allFiles()`, bạn có thể kết hợp với Visitor để thực hiện các thao tác khác nhau trên từng file (nén ảnh, xóa file rác, đổi định dạng) mà không cần viết loop lồng nhau phức tạp.

## 5. Khi nào nên dùng

* Khi bạn có một cấu trúc đối tượng phức tạp (ví dụ: cây thư mục, AST) và muốn thực hiện nhiều thao tác khác nhau trên đó.
* Khi bạn muốn giữ cho các class dữ liệu sạch sẽ, chỉ tập trung vào nghiệp vụ cốt lõi.
* Khi các thao tác trên đối tượng thường xuyên thay đổi hoặc được thêm mới, nhưng cấu trúc class thì ít thay đổi.

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Open/Closed Principle:** Thêm thuật toán mới cực kỳ dễ dàng bằng cách tạo Visitor mới.
* **Single Responsibility:** Tách biệt thuật toán khỏi đối tượng dữ liệu.
* **Gom nhóm logic:** Các xử lý liên quan đến cùng một tính năng được gom vào một class Visitor.

**Nhược điểm:**

* **Khó thay đổi cấu trúc:** Nếu bạn thêm một loại Post mới, bạn phải sửa tất cả các class Visitor hiện có để thêm hàm `visit` mới.
* **Lộ bí mật:** Visitor cần truy cập vào các dữ liệu bên trong của đối tượng để xử lý, đôi khi buộc bạn phải để các thuộc tính là `public`.

## 7. Câu hỏi phỏng vấn

1. **Double Dispatch là gì?** (Là cơ chế Visitor: đầu tiên gọi hàm `accept(visitor)` trên element, sau đó element gọi lại hàm `visit(this)` trên visitor. Kết quả cuối cùng phụ thuộc vào kiểu của cả Element và Visitor).
2. **Visitor vs Strategy khác nhau thế nào?** (Strategy thay đổi logic của chính đối tượng đó. Visitor thêm logic hoàn toàn mới từ bên ngoài vào một nhóm đối tượng).
3. **Tại sao Visitor lại bị coi là pattern "phức tạp"?** (Vì nó tạo ra sự phụ thuộc ngược: Visitor biết về Element và Element cũng biết về Visitor interface).

## Kết luận

Visitor Pattern là giải pháp tối thượng cho bài toán mở rộng tính năng mà không muốn làm "nát" code cũ. Hãy sử dụng nó khi bạn bắt đầu thấy các class của mình bị "phình to" bởi những hàm tiện ích không liên quan trực tiếp đến nghiệp vụ chính.
