---
title: Facade Pattern - Giao diện đơn giản cho hệ thống phức tạp
excerpt: Tìm hiểu Facade Pattern - cách cung cấp một cổng vào đơn giản cho một thư viện đồ sộ, giải mã cơ chế hoạt động của Laravel Facades thần thánh.
category: Design pattern
date: 2026-03-14
order: 7
image: /prezet/img/ogimages/series-design-pattern-facade-pattern.webp
---

> Pattern thuộc nhóm **Structural Pattern (Cấu trúc)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang điều hành một nhà hàng. Khi khách hàng muốn đặt một món ăn, họ chỉ cần gọi tên món.

**Vấn đề:** Để có được món ăn đó, bên trong bếp phải làm rất nhiều việc:

1. Kiểm tra nguyên liệu trong kho.
2. Sơ chế thực phẩm.
3. Chế biến trên bếp.
4. Trình bày ra đĩa.
5. Kiểm tra chất lượng lần cuối.

Nếu khách hàng phải tự làm tất cả những việc này, họ sẽ không bao giờ quay lại.

**Trong lập trình:** Một thư viện (ví dụ xử lý Video) có thể có hàng chục Class và hàng trăm hàm liên quan đến nhau. Nếu lập trình viên phải khởi tạo và gọi đúng thứ tự các Class đó mỗi khi muốn convert một video, code sẽ cực kỳ rắc rối và dễ lỗi.

## 2. Định nghĩa

**Facade Pattern** cung cấp một Interface (giao diện) đơn giản, thống nhất cho một tập hợp các Interface trong một hệ thống con (subsystem). Facade định nghĩa một Interface ở cấp độ cao hơn giúp cho hệ thống con dễ dàng sử dụng hơn.

**Ý tưởng cốt lõi:** Tạo ra một "người đại diện" thông minh để xử lý mọi việc phức tạp bên trong.

## 3. Implementation (PHP Clean Code)

### 3.1 Hệ thống con phức tạp (Subsystems)

```php
class CPU { public function freeze() { /*...*/ } public function execute() { /*...*/ } }
class Memory { public function load($position, $data) { /*...*/ } }
class HardDrive { public function read($lba, $size) { /*...*/ } }
```

### 3.2 Lớp Facade (Người đại diện)

```php
class ComputerFacade {
    protected $cpu;
    protected $memory;
    protected $hardDrive;

    public function __construct() {
        $this->cpu = new CPU();
        $this->memory = new Memory();
        $this->hardDrive = new HardDrive();
    }

    public function start() {
        $this->cpu->freeze();
        $this->memory->load(0, $this->hardDrive->read(0, 1024));
        $this->cpu->execute();
        echo "Máy tính đã sẵn sàng!";
    }
}
```

### 3.3 Sử dụng (Client)

```php
$computer = new ComputerFacade();
$computer->start(); // Chỉ cần gọi 1 hàm duy nhất
```

## 4. Laravel Facades - Bí mật đằng sau "Ma thuật"

Trong Laravel, Facades cho phép bạn truy cập các service trong Service Container theo kiểu **Static**.

**Ví dụ:** `Cache::get('key')` thực chất là:

1. Laravel gọi Facade `Cache`.
2. Facade này trỏ đến một Class thực sự (ví dụ: `Repository`) đã được bind trong Service Container.
3. Nó gọi hàm `get('key')` trên Class đó.

**Lưu ý quan trọng:** Laravel Facade khác với Facade Pattern thuần túy của GoF. Laravel dùng nó như một "Proxy" để truy cập Service Container một cách ngắn gọn.

## 5. Ưu & Nhược điểm

**Ưu điểm:**

* **Dễ sử dụng:** Giảm bớt sự phức tạp cho người dùng cuối (Client).
* **Loose Coupling:** Tách biệt code của Client khỏi sự thay đổi của các hệ thống con bên trong.
* **Tổ chức code:** Giúp cấu trúc hệ thống rõ ràng hơn.

**Nhược điểm:**

* **Rủi ro "God Object":** Facade có thể trở thành một Class quá lớn nếu ôm đồm quá nhiều thứ.
* **Che giấu quá nhiều:** Đôi khi lập trình viên không biết thực sự chuyện gì đang xảy ra bên dưới, dẫn đến khó tối ưu hiệu năng.

## 6. So sánh: Facade vs Singleton

| Đặc điểm | Facade | Singleton |
| :--- | :--- | :--- |
| **Mục tiêu** | Đơn giản hóa Interface | Đảm bảo duy nhất 1 instance |
| **Cấu trúc** | Thường bọc nhiều Class khác | Thường chỉ là 1 Class duy nhất |
| **Sử dụng** | Có thể có nhiều instance Facade | Chỉ có duy nhất 1 instance |

## 7. Câu hỏi phỏng vấn

1. **Tại sao Laravel Facades bị một số người coi là "Bad practice"?** (Vì nó dùng Static call, gây khó khăn cho việc Unit Test nếu không dùng Mocking và làm mờ đi các phụ thuộc thực sự).
2. **Facade Pattern giúp gì cho việc bảo trì code?** (Khi hệ thống con thay đổi, bạn chỉ cần sửa trong Facade, code gọi Facade ở bên ngoài không cần đổi).
3. **Làm thế nào để viết Unit Test cho một Class dùng Facade?** (Sử dụng hàm `Facade::shouldReceive()` để Mock đối tượng).

## Kết luận

Facade Pattern là nghệ thuật của sự đơn giản. Hãy dùng nó khi bạn muốn xây dựng những thư viện, module chuyên sâu nhưng lại muốn cung cấp cho đồng nghiệp một cách sử dụng "mì ăn liền" và tinh tế nhất.
