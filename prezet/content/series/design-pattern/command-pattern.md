---
title: Command Pattern - Khi hành động trở thành đối tượng
excerpt: Tìm hiểu Command Pattern - cách đóng gói yêu cầu thành object, nền tảng của hệ thống Artisan CLI và Job Queue trong Laravel.
category: Design pattern
date: 2026-03-20
order: 13
image: /prezet/img/ogimages/series-design-pattern-command-pattern.webp
---

> Pattern thuộc nhóm **Behavioral Pattern (Hành vi)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang build một ứng dụng soạn thảo văn bản. Bạn có rất nhiều nút bấm: Save, Copy, Paste, Print.

**Naive Solution:** Mỗi nút bấm chứa trực tiếp logic xử lý.

```php
class SaveButton {
    public function onClick() {
        // Logic lưu file...
    }
}
```

**Vấn đề:**

1. **Trùng lặp:** Phím tắt `Ctrl + S` cũng cần logic lưu file y hệt nút Save. Bạn sẽ copy code?
2. **Khó mở rộng:** Nếu muốn thêm tính năng "Undo" (Hoàn tác), bạn phải lưu lại lịch sử các hành động. Nếu logic nằm rải rác ở các nút bấm, việc này là bất khả thi.

## 2. Định nghĩa

**Command Pattern** chuyển đổi một yêu cầu (request) thành một đối tượng độc lập chứa tất cả thông tin về yêu cầu đó. Việc chuyển đổi này cho phép bạn tham số hóa các phương thức với các yêu cầu khác nhau, trì hoãn hoặc xếp hàng thực hiện một yêu cầu và hỗ trợ các thao tác không thể hoàn tác.

**Ý tưởng cốt lõi:** Tách biệt "người gửi" (Invoker - nút bấm) và "người nhận" (Receiver - logic thực sự) thông qua một "vật trung gian" (Command).

## 3. Implementation (PHP Clean Code)

### 3.1 Bước 1: Command Interface

```php
interface CommandInterface {
    public function execute(): void;
    public function undo(): void;
}
```

### 3.2 Bước 2: Concrete Commands (Hành động cụ thể)

```php
class SaveCommand implements CommandInterface {
    public function __construct(protected Document $document) {}

    public function execute(): void {
        $this->document->save();
    }

    public function undo(): void {
        $this->document->deleteLastSave();
    }
}
```

### 3.3 Bước 3: Invoker (Người gọi - Ví dụ: Menu)

```php
class RemoteControl {
    protected $history = [];

    public function submit(CommandInterface $command) {
        $command->execute();
        $this->history[] = $command;
    }

    public function rollback() {
        if (!empty($this->history)) {
            $command = array_pop($this->history);
            $command->undo();
        }
    }
}
```

## 4. Liên hệ Laravel

Command Pattern là "trái tim" của các tính năng mạnh mẽ nhất trong Laravel:

**1. Artisan Commands:**
Mỗi khi bạn chạy `php artisan make:controller`, bạn đang thực thi một Command object.

```php
class MakeControllerCommand extends Command {
    public function handle() {
        // Logic tạo file nằm gọn trong này
    }
}
```

**2. Job Queues:**
Khi bạn `dispatch(new SendEmailJob($user))`, bạn đang tạo ra một Command (Job) và đẩy vào hàng đợi (Queue) để thực hiện sau.

**3. Bus (Command Bus):**
Laravel cung cấp một hệ thống Bus để quản lý và thực thi các Command một cách tập trung.

## 5. Khi nào nên dùng

* Khi muốn tham số hóa đối tượng theo hành động cần thực hiện.
* Khi muốn xếp hàng (queue), lập lịch (schedule) hoặc thực thi hành động từ xa.
* Khi cần tính năng Undo/Redo.
* Khi muốn log lại lịch sử các thay đổi của hệ thống.

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Single Responsibility:** Tách biệt lớp gọi hành động và lớp thực hiện hành động.
* **Open/Closed Principle:** Thêm command mới mà không cần sửa code cũ.
* **Tính lắp ráp:** Có thể kết hợp nhiều command đơn giản thành một command phức tạp (Macro).

**Nhược điểm:**

* Code trở nên cực kỳ nhiều lớp (Overhead). Mỗi hành động nhỏ cũng phải tạo một class mới.

## 7. Câu hỏi phỏng vấn

1. **Tại sao nên dùng Command thay vì gọi trực tiếp hàm trong Controller?** (Để tách biệt logic, dễ dàng đưa vào Queue xử lý bất đồng bộ và tái sử dụng ở nhiều nơi như CLI, Web, API).
2. **Command Pattern hỗ trợ tính năng Undo như thế nào?** (Bằng cách lưu trữ trạng thái trước khi thực hiện trong object Command hoặc cung cấp phương thức `undo()` đối nghịch với `execute()`).
3. **Sự khác biệt giữa Command và Strategy?** (Command đóng gói một hành động cụ thể. Strategy đóng gói một thuật toán để thực hiện một hành động có sẵn).

## Kết luận

Command Pattern biến "hành động" thành "dữ liệu". Đây là nền tảng để xây dựng những hệ thống có khả năng mở rộng cao, hỗ trợ xử lý nền (Background processing) và giao diện dòng lệnh chuyên nghiệp.
