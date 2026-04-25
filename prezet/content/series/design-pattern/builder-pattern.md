---
title: Builder Pattern - Nghệ thuật lắp ráp đối tượng phức tạp
excerpt: Tìm hiểu Builder Pattern - cách khởi tạo đối tượng qua từng bước linh hoạt, giải mã cơ chế Method Chaining trong Laravel Query Builder và Eloquent.
category: Design pattern
date: 2026-03-15
order: 8
image: /prezet/img/ogimages/series-design-pattern-builder-pattern.webp
---

> Pattern thuộc nhóm **Creational Pattern (Khởi tạo)**

## 1. Problem & Motivation

Giả sử bạn cần khởi tạo một đối tượng `User` với rất nhiều thông tin tùy chọn: tên, email, tuổi, địa chỉ, số điện thoại, giới tính, nghề nghiệp...

**Naive Solution 1: Constructor quá dài (Telescoping Constructor)**

```php
$user = new User('Tuan', 'tuan@example.com', 25, 'Hanoi', '0912...', 'Male', 'Dev');
```

**Vấn đề:** Rất khó nhớ thứ tự tham số. Nếu chỉ muốn truyền tên và nghề nghiệp, bạn vẫn phải truyền các giá trị null ở giữa.

**Naive Solution 2: Quá nhiều hàm Setter**

```php
$user = new User();
$user->setName('Tuan');
$user->setJob('Dev');
// ... gọi thêm 10 hàm nữa
```

**Vấn đề:** Đối tượng có thể ở trạng thái "nửa vời" (inconsistent) nếu bạn quên gọi một số setter bắt buộc trước khi sử dụng.

## 2. Định nghĩa

**Builder Pattern** tách biệt quá trình xây dựng một đối tượng phức tạp khỏi biểu diễn của nó, sao cho cùng một quá trình xây dựng có thể tạo ra các biểu diễn khác nhau.

**Ý tưởng cốt lõi:** Thay vì tạo đối tượng trong một lần, ta xây dựng nó **từng bước một**.

## 3. Implementation (PHP Clean Code)

### 3.1 PHP Thuần (Fluent Interface)

```php
class UserBuilder {
    protected $user;

    public function __construct() {
        $this->user = new stdClass();
    }

    public function setName($name) {
        $this->user->name = $name;
        return $this; // Trả về chính nó để nối chuỗi (Chaining)
    }

    public function setEmail($email) {
        $this->user->email = $email;
        return $this;
    }

    public function setAge($age) {
        $this->user->age = $age;
        return $this;
    }

    public function build() {
        return $this->user;
    }
}

// Sử dụng (Cực kỳ sạch sẽ)
$user = (new UserBuilder())
            ->setName('Tuan')
            ->setEmail('tuan@example.com')
            ->setAge(25)
            ->build();
```

## 4. Liên hệ Laravel (The Builder DNA)

Builder Pattern là linh hồn của Laravel. Bạn sử dụng nó hàng ngày mà có thể không nhận ra:

**1. Query Builder:**

```php
$users = DB::table('users')
            ->where('active', true)
            ->orderBy('name')
            ->limit(10)
            ->get(); // Hàm build() thực sự nằm ở đây
```

**2. Eloquent Builder:**

```php
User::where('age', '>', 18)
    ->with('posts')
    ->latest()
    ->paginate(15);
```

**3. Manager Pattern:**
Khi bạn cấu hình Mail, Notification, hay Filesystem, Laravel cũng dùng các Builder để "lắp ráp" cấu hình.

## 5. Khi nào nên dùng

* Khi đối tượng cần tạo có quá nhiều thuộc tính (đặc biệt là thuộc tính tùy chọn).
* Khi quá trình tạo đối tượng bao gồm nhiều bước phức tạp.
* Khi bạn muốn tạo ra các "phiên bản" khác nhau của cùng một loại đối tượng từ một bộ khung dựng sẵn.

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Tính đọc hiểu (Readability):** Code trông giống như ngôn ngữ tự nhiên.
* **Tính linh hoạt:** Dễ dàng thay đổi cấu trúc đối tượng mà không ảnh hưởng đến client.
* **Tránh "Constructor Pollution":** Không còn những constructor dài dằng dặc.

**Nhược điểm:**

* **Tăng số lượng Class:** Phải tạo thêm một Class Builder riêng cho mỗi đối tượng.
* **Over-engineering:** Nếu đối tượng đơn giản (2-3 thuộc tính), dùng Builder sẽ làm phức tạp hóa vấn đề.

## 7. Câu hỏi phỏng vấn

1. **Sự khác biệt giữa Builder và Abstract Factory?** (Builder tập trung vào việc tạo đối tượng phức tạp theo từng bước. Abstract Factory tập trung vào việc tạo ra các họ đối tượng liên quan).
2. **Tại sao Query Builder trong Laravel lại trả về `$this` trong mỗi hàm?** (Để thực hiện Method Chaining, cho phép gọi liên tiếp các điều kiện truy vấn).
3. **Làm thế nào để đảm bảo tính Immutable (bất biến) khi dùng Builder?** (Hàm `build()` nên trả về một đối tượng mới hoàn toàn và các thuộc tính của đối tượng đó không thể thay đổi sau khi tạo).

## Kết luận

Builder Pattern là "vũ khí" hạng nặng để xử lý sự phức tạp trong khởi tạo. Nếu bạn thấy mình đang viết những constructor quá dài hoặc gọi quá nhiều setter rải rác, đó là lúc nên nghĩ đến việc xây dựng một Builder.
