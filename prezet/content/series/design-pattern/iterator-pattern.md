---
title: Iterator Pattern - Duyệt dữ liệu chuyên nghiệp
excerpt: Tìm hiểu Iterator Pattern - cách duyệt qua các tập hợp dữ liệu phức tạp, giải mã sức mạnh của Laravel Collections và cơ chế Lazy Loading.
category: Design pattern
date: 2026-03-29
order: 22
image: /prezet/img/ogimages/series-design-pattern-iterator-pattern.webp
---

> Pattern thuộc nhóm **Behavioral Pattern (Hành vi)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn có một thư viện sách (`BookShelf`). Sách được lưu trữ theo nhiều cách khác nhau: mảng (array), danh sách liên kết (linked list), hoặc từ một API.

**Vấn đề:** Khi muốn in ra danh sách tất cả các cuốn sách, Client phải biết cấu trúc bên trong của `BookShelf`:

```php
// Nếu là array
foreach ($shelf->books as $book) { ... }

// Nếu là linked list
$current = $shelf->head;
while($current) { ... $current = $current->next; }
```

**Vấn đề thật sự:**

1. **Lộ cấu trúc nội bộ:** Client can thiệp quá sâu vào cách lưu trữ dữ liệu.
2. **Khó thay đổi:** Nếu bạn đổi từ array sang một cấu trúc cây (tree), bạn phải sửa code ở tất cả những nơi đang duyệt sách.
3. **Trùng lặp logic:** Bạn phải viết đi viết lại các vòng lặp ở nhiều nơi.

## 2. Định nghĩa

**Iterator Pattern** cho phép bạn truy cập các phần tử của một đối tượng tập hợp một cách tuần tự mà không cần hiểu rõ các biểu diễn bên dưới của tập hợp đó.

**Ý tưởng cốt lõi:** Tách logic "duyệt" ra khỏi logic "lưu trữ". Một đối tượng Iterator sẽ lo việc theo dõi vị trí hiện tại và cách đi đến phần tử tiếp theo.

## 3. Implementation (PHP Standard Library - SPL)

PHP đã hỗ trợ sẵn các Interface mạnh mẽ để implement pattern này.

### 3.1 Iterator Interface

```php
class BookShelfIterator implements \Iterator {
    private int $position = 0;

    public function __construct(protected array $books) {}

    public function current(): mixed { return $this->books[$this->position]; }
    public function key(): mixed { return $this->position; }
    public function next(): void { $this->position++; }
    public function rewind(): void { $this->position = 0; }
    public function valid(): bool { return isset($this->books[$this->position]); }
}
```

### 3.2 Aggregate (Tập hợp)

```php
class BookShelf implements \IteratorAggregate {
    private array $books = [];

    public function addBook(string $name) { $this->books[] = $name; }

    public function getIterator(): \Traversable {
        return new BookShelfIterator($this->books);
    }
}

// Sử dụng (Cực kỳ đơn giản)
$shelf = new BookShelf();
$shelf->addBook("Design Patterns 101");
$shelf->addBook("Laravel Pro");

foreach ($shelf as $book) {
    echo $book . "\n";
}
```

## 4. Liên hệ Laravel (The Collection Power)

Laravel nâng tầm Iterator Pattern thông qua **Collections**:

**1. Fluent Traversal:**
Thay vì dùng `foreach` thuần, bạn có `map`, `filter`, `reduce`.

```php
collect($users)->filter(fn($u) => $u->active)->each(fn($u) => $u->notify());
```

**2. Lazy Collections (Generators):**
Dùng Iterator để xử lý hàng triệu bản ghi mà không tốn RAM.

```php
User::cursor()->each(function ($user) {
    // Chỉ tải 1 record vào RAM tại một thời điểm
});
```

`cursor()` sử dụng PHP Generators - một dạng Iterator "lười biếng" cực kỳ hiệu quả.

## 5. Khi nào nên dùng

* Khi muốn duyệt qua các cấu trúc dữ liệu phức tạp (Tree, Graph) theo một cách thống nhất.
* Khi muốn ẩn đi sự phức tạp của việc truy xuất dữ liệu (ví dụ lấy từ nhiều trang API).
* Khi cần nhiều cách duyệt khác nhau trên cùng một tập hợp (Duyệt xuôi, duyệt ngược, duyệt theo điều kiện).

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Tính đóng gói:** Client không cần biết mảng hay object bên dưới.
* **Single Responsibility:** Tách biệt logic duyệt và logic chứa dữ liệu.
* **Open/Closed:** Thêm cách duyệt mới mà không cần sửa class tập hợp.

**Nhược điểm:**

* **Overkill:** Với những mảng đơn giản, dùng Iterator sẽ làm code dài dòng hơn.
* **Hiệu năng:** Việc gọi qua object trung gian có thể chậm hơn một chút so với vòng lặp `for` truyền thống (thường không đáng kể).

## 7. Câu hỏi phỏng vấn

1. **Sự khác biệt giữa `Iterator` và `IteratorAggregate` trong PHP?** (`Iterator` là object trực tiếp lo việc duyệt, `IteratorAggregate` là object chứa dữ liệu và trả về một `Iterator`).
2. **Generators trong PHP liên quan gì đến Iterator Pattern?** (Generators là cách cực nhanh và gọn để tạo ra Iterator mà không cần tạo class mới, sử dụng từ khóa `yield`).
3. **Tại sao `User::all()` khác với `User::cursor()`?** (`all()` tải tất cả vào mảng → tốn RAM. `cursor()` dùng Iterator → chỉ tốn RAM cho 1 record).

## Kết luận

Iterator Pattern là "xương sống" của việc xử lý dữ liệu trong Laravel. Hãy tận dụng sức mạnh của Collections và Generators để viết code xử lý tập hợp một cách chuyên nghiệp và tối ưu hiệu suất.
