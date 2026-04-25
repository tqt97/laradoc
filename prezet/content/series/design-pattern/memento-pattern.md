---
title: Memento Pattern - Cỗ máy thời gian của dữ liệu
excerpt: Tìm hiểu Memento Pattern - giải pháp sao lưu và khôi phục trạng thái đối tượng, bí quyết xây dựng tính năng Undo/Redo và Revisions chuyên nghiệp.
category: Design pattern
date: 2026-04-02
order: 26
image: /prezet/img/ogimages/series-design-pattern-memento-pattern.webp
---

> Pattern thuộc nhóm **Behavioral Pattern (Hành vi)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang xây dựng một trình soạn thảo văn bản (Editor). Người dùng viết code, xóa code, rồi bỗng nhiên họ nhấn nhầm xóa sạch mọi thứ. Họ cuống cuồng nhấn `Ctrl + Z`.

**Vấn đề:** Làm thế nào để khôi phục lại nội dung chính xác như 5 giây trước?

* Bạn có thể lưu toàn bộ trạng thái vào một mảng bên ngoài.
* Nhưng nếu Class `Editor` có các thuộc tính `private` (bí mật), mảng bên ngoài sẽ không thể truy cập và lưu lại được.
* Nếu class `Editor` thay đổi cấu trúc, bạn phải đi sửa code ở tất cả những nơi lưu trữ trạng thái đó.

**Naive Solution:** Cho phép mọi class khác truy cập vào thuộc tính private của Editor để copy dữ liệu.
**Hệ quả:** Vi phạm nghiêm trọng tính đóng gói (Encapsulation).

## 2. Định nghĩa

**Memento Pattern** cho phép lưu lại và khôi phục trạng thái nội bộ của một đối tượng mà không vi phạm tính đóng gói.

**3 thành phần chính:**

1. **Originator (Chủ thể):** Đối tượng cần được lưu lại trạng thái (ví dụ class `Editor`). Nó tự tạo ra Memento và tự khôi phục từ Memento.
2. **Memento (Bản sao lưu):** Một đối tượng tĩnh chứa trạng thái của Originator tại một thời điểm.
3. **Caretaker (Người quản lý):** Chịu trách nhiệm lưu trữ danh sách các Memento (lịch sử), nhưng không bao giờ can thiệp vào nội dung bên trong Memento.

## 3. Implementation (PHP Clean Code)

### 3.1 Memento (Bản sao lưu)

```php
readonly class EditorMemento {
    public function __construct(
        private string $content
    ) {}

    public function getContent(): string {
        return $this->content;
    }
}
```

### 3.2 Originator (Chủ thể - Editor)

```php
class Editor {
    private string $content = "";

    public function type(string $text) {
        $this->content .= $text;
    }

    public function save(): EditorMemento {
        return new EditorMemento($this->content);
    }

    public function restore(EditorMemento $memento) {
        $this->content = $memento->getContent();
    }

    public function getContent() { return $this->content; }
}
```

### 3.3 Caretaker (Lịch sử)

```php
class History {
    private array $states = [];

    public function push(EditorMemento $memento) {
        $this->states[] = $memento;
    }

    public function pop(): ?EditorMemento {
        return array_pop($this->states);
    }
}

// Sử dụng
$editor = new Editor();
$history = new History();

$editor->type("Hello ");
$history->push($editor->save()); // Lưu bước 1

$editor->type("World!");
echo $editor->getContent(); // Hello World!

$editor->restore($history->pop()); // Hoàn tác
echo $editor->getContent(); // Hello 
```

## 4. Liên hệ Laravel

Trong Laravel, Memento Pattern xuất hiện dưới các hình thức:

**1. Model Revisions:**
Khi bạn sử dụng các package như `spatie/laravel-activitylog` hoặc tự xây dựng hệ thống lưu lịch sử thay đổi Model. Mỗi version được lưu lại chính là một Memento.

**2. Database Transactions:**
Mặc dù ở level DB, nhưng tư duy `commit` (lưu memento) và `rollback` (khôi phục từ memento) chính là tinh thần của pattern này.

## 5. Khi nào nên dùng

* Khi cần tính năng Undo/Redo.
* Khi muốn lưu lại "ảnh chụp" (snapshot) của đối tượng để khôi phục sau khi có lỗi xảy ra.
* Khi việc lưu trạng thái trực tiếp từ bên ngoài làm lộ các chi tiết triển khai bí mật của đối tượng.

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* Bảo vệ tính đóng gói: Chỉ Originator mới biết cách đọc dữ liệu của chính mình.
* Đơn giản hóa Originator: Việc quản lý lịch sử được đẩy sang cho Caretaker.

**Nhược điểm:**

* **Tốn bộ nhớ:** Nếu đối tượng quá lớn và bạn lưu hàng nghìn bước Undo, RAM sẽ bị cạn kiệt rất nhanh.
* **Chi phí lưu trữ:** Việc tạo object Memento liên tục có thể ảnh hưởng đến hiệu năng nếu không tối ưu.

## 7. Câu hỏi phỏng vấn

1. **Tại sao Memento lại tốt hơn việc copy object sang một mảng?** (Vì nó giữ được tính đóng gói, mảng bên ngoài không thể và không nên biết về các thuộc tính private của object).
2. **Làm thế nào để tối ưu bộ nhớ khi dùng Memento?** (Giới hạn số bước Undo tối đa, hoặc chỉ lưu những "sai khác" - diff - giữa các trạng thái thay vì lưu toàn bộ).
3. **Caretaker có quyền chỉnh sửa nội dung Memento không?** (Tuyệt đối không, Caretaker chỉ được phép lưu và trả lại nguyên vẹn Memento cho Originator).

## Kết luận

Memento Pattern là "bảo hiểm" cho dữ liệu của bạn. Hãy sử dụng nó để xây dựng những trải nghiệm người dùng tuyệt vời với khả năng quay ngược thời gian, sửa sai và khám phá các phiên bản dữ liệu một cách an toàn.
