---
title: Proxy Pattern - Người đại diện thông minh
excerpt: Tìm hiểu Proxy Pattern - cách kiểm soát truy cập vào đối tượng gốc, ứng dụng trong Lazy Loading, Caching và bảo mật hệ thống.
category: Design pattern
date: 2026-03-17
order: 10
image: /prezet/img/ogimages/series-design-pattern-proxy-pattern.webp
---

> Pattern thuộc nhóm **Structural Pattern (Cấu trúc)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn có một class `HighResolutionImage` đảm nhận việc tải một tấm ảnh dung lượng cực lớn từ ổ cứng hoặc internet.

```php
class HighResolutionImage {
    public function __construct(string $path) {
        $this->loadFromDisk($path); // Tốn 5 giây và rất nhiều RAM
    }

    public function display() {
        echo "Hiển thị ảnh siêu nét...";
    }
}
```

**Vấn đề:** Nếu bạn có một danh sách 100 bài viết, mỗi bài có một ảnh siêu nét, và bạn khởi tạo tất cả ngay lúc đầu → App của bạn sẽ "chết" vì thiếu bộ nhớ và người dùng phải chờ rất lâu, mặc dù họ chưa chắc đã cuộn xuống để xem hết 100 cái ảnh đó.

## 2. Định nghĩa

**Proxy Pattern** cung cấp một đối tượng đại diện (placeholder) cho một đối tượng khác để kiểm soát việc truy cập vào nó.

**Ý tưởng cốt lõi:** Đừng gọi trực tiếp đối tượng "nặng nề", hãy gọi một "người đại diện" gọn nhẹ hơn. Người đại diện này chỉ khởi tạo đối tượng thực sự khi nào **thực sự cần thiết**.

## 3. Implementation (PHP Clean Code)

### 3.1 Interface chung

```php
interface ImageInterface {
    public function display(): void;
}
```

### 3.2 Real Subject (Đối tượng thực sự - Nặng)

```php
class RealImage implements ImageInterface {
    public function __construct(protected string $filename) {
        $this->loadFromDisk();
    }

    private function loadFromDisk() {
        echo "Đang tải ảnh nặng từ đĩa: {$this->filename}...\n";
    }

    public function display(): void {
        echo "Hiển thị ảnh: {$this->filename}\n";
    }
}
```

### 3.3 Proxy (Người đại diện - Nhẹ)

```php
class ProxyImage implements ImageInterface {
    private ?RealImage $realImage = null;

    public function __construct(protected string $filename) {}

    public function display(): void {
        // Chỉ khởi tạo RealImage khi hàm display() được gọi
        if ($this->realImage === null) {
            $this->realImage = new RealImage($this->filename);
        }
        $this->realImage->display();
    }
}

// Sử dụng (Lazy Loading)
$image = new ProxyImage("wallpaper.hd");
// Lúc này chưa có gì xảy ra, app vẫn chạy rất nhanh.

$image->display(); // Bây giờ ảnh mới thực sự được tải
```

## 4. Các loại Proxy phổ biến

1. **Virtual Proxy (Lazy Loading):** Như ví dụ trên, trì hoãn việc khởi tạo đối tượng nặng.
2. **Protection Proxy:** Kiểm tra quyền truy cập của người dùng trước khi cho phép gọi đối tượng thực sự.
3. **Caching Proxy:** Lưu kết quả của các thao tác tốn kém để trả về ngay cho lần gọi sau.
4. **Remote Proxy:** Đại diện cho một đối tượng nằm ở một máy chủ khác (RPC, SOAP).

## 5. Liên hệ Laravel

Laravel sử dụng Proxy trong rất nhiều trường hợp tinh tế:

**1. Eloquent Lazy Loading:**
Khi bạn gọi `$user->posts`, Laravel không tải tất cả bài viết ngay. Nó sử dụng một cơ chế giống Proxy để chỉ thực hiện câu lệnh SQL khi bạn bắt đầu duyệt qua danh sách posts.

**2. Auth Middleware:**
Đóng vai trò như một **Protection Proxy**, ngăn chặn request vào Controller nếu chưa đăng nhập.

**3. Cache Layer:**
Khi bạn dùng `Cache::remember()`, bạn đang tạo ra một **Caching Proxy** bọc quanh logic lấy dữ liệu gốc.

## 6. Khi nào nên dùng

* Khi đối tượng gốc quá nặng (tốn tài nguyên).
* Khi cần kiểm soát quyền hạn truy cập.
* Khi cần thêm logic bổ trợ (logging, cache) mà không muốn làm dơ class gốc.

## 7. Ưu & Nhược điểm

**Ưu điểm:**

* Tiết kiệm tài nguyên hệ thống (Lazy Loading).
* Tăng tính bảo mật.
* Client không cần quan tâm đối tượng thực sự ở đâu hay nặng thế nào.

**Nhược điểm:**

* Code trở nên phức tạp hơn do thêm một tầng trung gian.
* Phản hồi có thể bị chậm đi một chút do phải đi qua lớp Proxy.

## 8. So sánh: Proxy vs Decorator vs Facade

| Pattern | Khác biệt cốt lõi |
| :--- | :--- |
| **Proxy** | Kiểm soát truy cập, giữ nguyên Interface. |
| **Decorator** | Thêm tính năng mới, giữ nguyên Interface. |
| **Facade** | Đơn giản hóa Interface phức tạp. |

## 9. Câu hỏi phỏng vấn

1. **Sự khác biệt lớn nhất giữa Proxy và Decorator?** (Proxy quản lý vòng đời của đối tượng gốc - thường là tạo ra nó, còn Decorator nhận đối tượng gốc từ bên ngoài vào để thêm tính năng).
2. **Làm thế nào để implement một Protection Proxy trong PHP?** (Trong hàm của Proxy, kiểm tra một điều kiện như `if (!Auth::check())`, nếu không thỏa mãn thì không gọi hàm tương ứng của Real Subject).
3. **Proxy có giúp tăng hiệu năng không?** (Có, thông qua Lazy Loading và Caching).

## Kết luận

Proxy Pattern là "người gác cổng" tận tụy của hệ thống. Nó giúp ứng dụng của bạn chạy mượt mà hơn bằng cách trì hoãn những việc chưa cần thiết và bảo vệ những tài nguyên quý giá khỏi những truy cập không hợp lệ.
