---
title: Abstract Factory - Nhà máy của những nhà máy
excerpt: Tìm hiểu Abstract Factory Pattern - cách tạo ra các họ đối tượng liên quan mà không cần chỉ định class cụ thể, ứng dụng trong thiết kế UI đa nền tảng và Database Drivers.
category: Design pattern
date: 2026-03-19
order: 12
image: /prezet/img/ogimages/series-design-pattern-abstract-factory-pattern.webp
---

> Pattern thuộc nhóm **Creational Pattern (Khởi tạo)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang viết một ứng dụng hỗ trợ đa nền tảng: Windows và macOS. Mỗi hệ điều hành có phong cách giao diện khác nhau cho cùng một thành phần:

* **Windows:** Nút bấm vuông, thanh trượt có viền.
* **macOS:** Nút bấm bo tròn, thanh trượt bóng bẩy.

**Vấn đề:** Trong code của bạn, nếu cứ mỗi lần tạo nút bấm lại phải kiểm tra:

```php
if ($os === 'windows') {
    $button = new WindowsButton();
} else {
    $button = new MacButton();
}
```

→ Code sẽ đầy rẫy các câu lệnh `if/else`, cực kỳ khó bảo trì và dễ sai sót nếu bạn quên kiểm tra ở một nơi nào đó.

## 2. Định nghĩa

**Abstract Factory Pattern** cung cấp một Interface để tạo ra các **họ đối tượng** (families of related objects) có liên quan hoặc phụ thuộc lẫn nhau mà không cần chỉ định class cụ thể của chúng.

**Ý tưởng cốt lõi:** Thay vì yêu cầu từng món đồ rời rạc, bạn yêu cầu một "bộ sưu tập" đồ nội thất theo phong cách cụ thể (ví dụ: Modern hoặc Victorian).

## 3. Implementation (PHP Clean Code)

### 3.1 Bước 1: Các Interface cho từng thành phần

```php
interface Button { public function render(); }
interface Checkbox { public function render(); }
```

### 3.2 Bước 2: Abstract Factory Interface

```php
interface GUIFactory {
    public function createButton(): Button;
    public function createCheckbox(): Checkbox;
}
```

### 3.3 Bước 3: Các Concrete Factory (Nhà máy cụ thể)

```php
class WindowsFactory implements GUIFactory {
    public function createButton(): Button { return new WindowsButton(); }
    public function createCheckbox(): Checkbox { return new WindowsCheckbox(); }
}

class MacFactory implements GUIFactory {
    public function createButton(): Button { return new MacButton(); }
    public function createCheckbox(): Checkbox { return new MacCheckbox(); }
}
```

### 3.4 Bước 4: Sử dụng (Client)

```php
class Application {
    protected $button;

    public function __construct(GUIFactory $factory) {
        $this->button = $factory->createButton();
    }

    public function paint() {
        $this->button->render();
    }
}

// Khởi tạo tùy theo môi trường
$os = 'mac';
$factory = ($os === 'win') ? new WindowsFactory() : new MacFactory();
$app = new Application($factory);
$app->paint();
```

## 4. Liên hệ Laravel

Laravel sử dụng biến thể của Abstract Factory trong hệ thống **Database Drivers**:

* Khi bạn dùng MySQL, Laravel sử dụng `MySqlConnector`, `MySqlGrammar`, `MySqlProcessor`.
* Khi đổi sang Postgres, nó sẽ dùng một "họ" class khác dành cho Postgres.
Bạn không bao giờ phải gọi `new MySqlGrammar()`, Laravel Facade và Manager sẽ lo việc chọn đúng "nhà máy" dựa trên cấu hình `.env` của bạn.

## 5. Khi nào nên dùng

* Khi hệ thống cần độc lập với cách các sản phẩm của nó được tạo ra và sắp xếp.
* Khi hệ thống cần được cấu hình với một trong nhiều họ sản phẩm.
* Khi bạn muốn cung cấp một thư viện các sản phẩm và chỉ muốn lộ ra interface chứ không phải implementation.

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* Đảm bảo các sản phẩm bạn nhận được từ một nhà máy là tương thích với nhau.
* Tránh sự phụ thuộc chặt chẽ (Loose Coupling).
* Tuân thủ Single Responsibility và Open/Closed Principle.

**Nhược điểm:**

* Code trở nên phức tạp hơn mức cần thiết vì phải tạo ra rất nhiều Interface và Class mới.
* Khó khăn khi muốn thêm một loại sản phẩm mới vào "họ" (phải sửa Interface Abstract Factory và tất cả Concrete Factories).

## 7. So sánh: Factory Method vs Abstract Factory

| Đặc điểm | Factory Method | Abstract Factory |
| :--- | :--- | :--- |
| **Mục tiêu** | Tạo 1 sản phẩm cụ thể. | Tạo 1 họ các sản phẩm liên quan. |
| **Cơ chế** | Sử dụng kế thừa (Inheritance). | Sử dụng thành phần (Composition). |
| **Độ phức tạp** | Thấp. | Cao. |

## 8. Câu hỏi phỏng vấn

1. **Abstract Factory giải quyết vấn đề gì mà Factory Method không giải quyết được?** (Abstract Factory giải quyết vấn đề về tính tương thích giữa một nhóm các đối tượng).
2. **Tại sao Abstract Factory lại tuân thủ tốt nguyên tắc Dependency Inversion?** (Vì Client chỉ phụ thuộc vào các Interface trừu tượng, không phụ thuộc vào các class cụ thể).
3. **Nếu muốn thêm một loại sản phẩm thứ 3 vào hệ thống (ví dụ: Linux), bạn cần làm gì?** (Tạo thêm `LinuxFactory` và các implementation tương ứng cho Button, Checkbox... mà không cần sửa code cũ của Windows hay Mac).

## Kết luận

Abstract Factory là "ông trùm" của các nhà máy. Nó giúp bạn xây dựng những hệ thống cực kỳ linh hoạt và nhất quán. Tuy nhiên, hãy cẩn thận đừng để hệ thống của bạn bị "ngộp" trong các lớp trừu tượng nếu nhu cầu thực tế không quá phức tạp.
