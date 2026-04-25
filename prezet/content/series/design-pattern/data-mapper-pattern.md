---
title: Data Mapper - Tách biệt hoàn toàn dữ liệu và nghiệp vụ
excerpt: Tìm hiểu Data Mapper Pattern - cách giữ cho Model thuần khiết không phụ thuộc vào Database, so sánh sự khác biệt cốt lõi với Active Record (Eloquent).
category: Design pattern
date: 2026-04-06
order: 30
image: /prezet/img/ogimages/series-design-pattern-data-mapper-pattern.webp
---

> Pattern thuộc nhóm **Structural / Enterprise Pattern**

## 1. Problem & Motivation

Trong Laravel, bạn đã quen thuộc với Eloquent (Active Record):

```php
class User extends Model {}
$user = User::find(1);
$user->name = "Tuấn";
$user->save(); // Model tự biết cách lưu chính nó
```

**Vấn đề:**

1. **Model quá "nặng":** Class `User` vừa chứa logic nghiệp vụ, vừa chứa logic kết nối DB, vừa chứa thông tin cấu hình bảng.
2. **Khó Unit Test:** Model luôn dính chặt với Database.
3. **Cấu trúc DB áp đặt lên Code:** Nếu bảng trong DB có cột `usr_first_nm`, thì thuộc tính class cũng phải là `$user->usr_first_nm`.

## 2. Định nghĩa

**Data Mapper** là một tầng trung gian thực hiện việc chuyển đổi dữ liệu giữa các đối tượng trong code (Objects) và Database (hoặc các nguồn lưu trữ khác) mà vẫn giữ cho chúng độc lập với nhau.

**Ý tưởng cốt lõi:** Đối tượng nghiệp vụ (Entity) không hề biết gì về Database. Có một "người vận chuyển" (Mapper) riêng biệt lo việc kéo và đẩy dữ liệu.

## 3. Implementation (PHP Clean Code)

### 3.1 Entity (Đối tượng nghiệp vụ thuần túy - POPO)

```php
class User {
    // Không kế thừa từ bất kỳ class "Model" nào
    public function __construct(
        private ?int $id,
        private string $name,
        private string $email
    ) {}

    public function getId() { return $this->id; }
    public function getName() { return $this->name; }
    public function setName($name) { $this->name = $name; }
}
```

### 3.2 Data Mapper (Người vận chuyển)

```php
class UserMapper {
    public function find(int $id): User {
        // 1. Thực hiện câu lệnh SQL: SELECT * FROM users WHERE id = ?
        // 2. Lấy kết quả mảng dữ liệu
        // 3. Khởi tạo đối tượng User thuần túy từ mảng đó
        return new User($data['id'], $data['name'], $data['email']);
    }

    public function save(User $user) {
        // Đẩy dữ liệu từ đối tượng User vào Database
        $sql = "UPDATE users SET name = '{$user->getName()}' ...";
    }
}
```

## 4. So sánh: Data Mapper vs Active Record (Eloquent)

| Đặc điểm | Active Record | Data Mapper |
| :--- | :--- | :--- |
| **Model** | Biết về DB, chứa logic lưu trữ. | Không biết về DB, chỉ chứa nghiệp vụ. |
| **Sự đơn giản** | Rất cao, phát triển cực nhanh. | Thấp, phải viết nhiều class hơn. |
| **Tính linh hoạt** | DB áp đặt cấu trúc Model. | Model và DB có thể khác nhau hoàn toàn. |
| **Thư viện nổi tiếng** | Eloquent (Laravel) | Doctrine (Symfony) |

## 5. Khi nào nên dùng

* **Hệ thống lớn, phức tạp:** Nơi logic nghiệp vụ rất nặng và cần tách biệt hoàn toàn khỏi hạ tầng.
* **Database Legacy:** Nơi cấu trúc bảng rất xấu và bạn không muốn nó làm bẩn code nghiệp vụ của mình.
* **Unit Testing:** Khi bạn muốn test các quy tắc nghiệp vụ mà không cần cài đặt Database giả.

## 6. Liên hệ Laravel

Mặc dù Laravel dùng Eloquent là mặc định, nhưng bạn vẫn có thể áp dụng tư duy Data Mapper:

1. **Sử dụng DTO:** Chuyển dữ liệu từ Request vào DTO, Service xử lý trên DTO, rồi mới đổ vào Model để lưu.
2. **Sử dụng Repository:** Như đã học ở bài trước, Repository thường đóng vai trò như một phần của Data Mapper.

## 7. Câu hỏi phỏng vấn

1. **Tại sao Data Mapper lại tuân thủ Single Responsibility tốt hơn Active Record?** (Vì Active Record vi phạm SRP khi Model vừa lo nghiệp vụ vừa lo lưu trữ dữ liệu. Data Mapper tách hai việc này ra hai class riêng).
2. **Doctrine (Data Mapper) và Eloquent (Active Record), cái nào chạy nhanh hơn?** (Eloquent thường nhanh hơn ở các tác vụ đơn giản. Doctrine mạnh về quản lý các quan hệ phức tạp và tối ưu hóa câu lệnh SQL qua Unit of Work).

## Kết luận

Data Mapper là đỉnh cao của sự tách biệt phụ thuộc trong tầng dữ liệu. Nếu bạn đang build một hệ thống Core cho ngân hàng hoặc bảo hiểm, nơi logic cực kỳ khắt khe, hãy cân nhắc dùng Data Mapper để giữ cho code của bạn luôn sạch sẽ và dễ kiểm soát.
