---
title: Null Object Pattern - Nghệ thuật loại bỏ If-Null
excerpt: Tìm hiểu Null Object Pattern - cách sử dụng đối tượng "rỗng" thay vì giá trị null, giải pháp giúp code mượt mà và tránh lỗi Fatal Error trong PHP.
category: Design pattern
date: 2026-04-09
order: 33
image: /prezet/img/ogimages/series-design-pattern-null-object-pattern.webp
---

> Pattern thuộc nhóm **Behavioral Pattern (Hành vi)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn có một hệ thống ghi log (`Logger`). Một số môi trường bạn muốn ghi log, một số khác thì không.

**Naive Solution: Dùng giá trị null**

```php
class OrderService {
    public function __construct(protected ?LoggerInterface $logger = null) {}

    public function process() {
        // Mỗi lần dùng logger lại phải check null
        if ($this->logger) {
            $this->logger->info("Đang xử lý đơn hàng...");
        }
        // ... logic nghiệp vụ
        if ($this->logger) {
            $this->logger->info("Xử lý xong!");
        }
    }
}
```

**Vấn đề:**

1. **Code rác:** Câu lệnh `if ($this->logger)` xuất hiện lặp đi lặp lại ở khắp mọi nơi.
2. **Dễ quên:** Chỉ cần quên check null ở một chỗ, app của bạn sẽ văng lỗi `Call to a member function info() on null` và chết ngay lập tức.

## 2. Định nghĩa

**Null Object Pattern** cung cấp một đối tượng đại diện cho giá trị "không có gì" (null). Đối tượng này implement cùng một Interface với đối tượng thực sự nhưng các phương thức của nó không làm gì cả (hoặc trả về giá trị mặc định an toàn).

**Ý tưởng cốt lõi:** Đừng trả về `null`, hãy trả về một **"đối tượng rỗng"** có thể gọi hàm bình thường.

## 3. Implementation (PHP Clean Code)

### 3.1 Interface chung

```php
interface LoggerInterface {
    public function info(string $msg): void;
}
```

### 3.2 Real Object (Đối tượng thực sự)

```php
class FileLogger implements LoggerInterface {
    public function info(string $msg): void {
        file_put_contents('app.log', $msg, FILE_APPEND);
    }
}
```

### 3.3 Null Object (Đối tượng rỗng)

```php
class NullLogger implements LoggerInterface {
    public function info(string $msg): void {
        // Im lặng là vàng - Không làm gì cả
    }
}
```

### 3.4 Sử dụng (Mượt mà vô cùng)

```php
class OrderService {
    // Luôn đảm bảo có logger, mặc định là NullLogger
    public function __construct(protected LoggerInterface $logger) {}

    public function process() {
        // Không cần check null nữa!
        $this->logger->info("Đang xử lý...");
        // ... logic
        $this->logger->info("Xong!");
    }
}

// Khi không muốn log
$service = new OrderService(new NullLogger());
$service->process(); // Chạy mượt mà, không lỗi, không log.
```

## 4. Liên hệ Laravel

Laravel sử dụng tư duy Null Object ở nhiều nơi tinh tế:

**1. Optional Helper:**
Hàm `optional($user)->address` giúp bạn truy cập thuộc tính mà không sợ lỗi null, nó hoạt động tương tự như một Null Object bọc quanh đối tượng.

**2. Null Driver trong Cache/Mail/Log:**
Trong file `.env`, bạn có thể thiết lập:

* `CACHE_STORE=null`
* `MAIL_MAILER=log` (ghi log thay vì gửi mail thật)
* `LOG_CHANNEL=null`
Đây chính là cách Laravel dùng các Null Implementation để hệ thống vẫn chạy mà không cần sửa code logic khi bạn muốn tắt một tính năng.

## 5. Khi nào nên dùng

* Khi bạn có một phụ thuộc (dependency) không bắt buộc.
* Khi bạn muốn đơn giản hóa code xử lý, loại bỏ các câu lệnh rẽ nhánh `if/else` dư thừa.
* Khi bạn muốn thiết kế hệ thống theo phong cách "Tell, Don't Ask" (Ra lệnh cho đối tượng làm việc, đừng hỏi xem nó có tồn tại không).

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* Code sạch sẽ, dễ đọc và tập trung vào nghiệp vụ chính.
* Tránh lỗi runtime kinh điển của mọi ngôn ngữ: Null Pointer Exception.
* Unit Test dễ dàng hơn vì không phải lo lắng về trạng thái null.

**Nhược điểm:**

* Có thể che giấu các lỗi thực sự nếu bạn sử dụng Null Object ở những nơi lẽ ra dữ liệu bắt buộc phải tồn tại.
* Làm tăng số lượng class trong hệ thống.

## 7. Câu hỏi phỏng vấn

1. **Sự khác biệt giữa Null Object và giá trị `null`?** (`null` là một giá trị đặc biệt không có hành vi. Null Object là một đối tượng thực sự có hành vi - hành vi đó là không làm gì cả).
2. **Null Object Pattern có vi phạm nguyên tắc gì không?** (Thường là không, nó hỗ trợ tốt tính đa hình - Polymorphism).
3. **Làm thế nào để khởi tạo một Null Object tự động trong Laravel?** (Sử dụng Service Container để bind một implementation mặc định là Null Object nếu không có driver nào được chọn).

## Kết luận

Null Object Pattern là minh chứng cho câu nói "Đỉnh cao của sự phức tạp là sự đơn giản". Hãy dùng nó để giải phóng code của bạn khỏi những bóng ma `null`, giúp ứng dụng của bạn trở nên an toàn và thanh thoát hơn.
