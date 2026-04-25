---
title: DTO (Data Transfer Object) - Chuẩn hóa luồng dữ liệu
excerpt: Tìm hiểu DTO Pattern - cách đóng gói dữ liệu để truyền tải giữa các tầng ứng dụng, giải pháp loại bỏ "Array lộn xộn" trong Laravel.
category: Design pattern
date: 2026-03-26
order: 19
image: /prezet/img/ogimages/series-design-pattern-dto-pattern.webp
---

> Pattern thuộc nhóm **Enterprise Pattern (Mẫu ứng dụng doanh nghiệp)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn có một hàm tạo User trong `UserService`. Bạn thường truyền dữ liệu qua mảng (array):

```php
public function createUser(array $data) {
    // Bạn không biết trong $data có gì? 'name' hay 'username'? 'email' hay 'user_email'?
    // Bạn phải dùng: $data['name'] ?? null
    return User::create($data);
}
```

**Vấn đề của việc dùng mảng (Associative Arrays):**

1. **Không có tính cấu trúc:** Bạn không biết mảng đó chứa những key nào mà không phải đọc toàn bộ code.
2. **Dễ sai sót:** Gõ nhầm `$data['emial']` thay vì `'email'` sẽ không có lỗi thông báo, chỉ khi chạy mới biết.
3. **Thiếu hỗ trợ IDE:** IDE (VS Code, PHPStorm) không thể gợi ý code (Auto-completion).
4. **Vi phạm tính đóng gói:** Dữ liệu bị rò rỉ và không được kiểm soát chặt chẽ.

## 2. Định nghĩa

**DTO (Data Transfer Object)** là một đối tượng chứa dữ liệu để truyền tải giữa các tiến trình hoặc các tầng trong ứng dụng (ví dụ từ Controller sang Service). DTO không chứa bất kỳ logic nghiệp vụ nào, nó chỉ đơn thuần là một "hộp chứa" dữ liệu có cấu trúc.

**Ý tưởng cốt lõi:** Thay vì dùng mảng "vô danh", hãy dùng một **Class** có các thuộc tính được định nghĩa rõ ràng.

## 3. Implementation (PHP 8.2+ Style)

### 3.1 PHP Thuần (Sử dụng Readonly Class)

```php
readonly class UserDTO {
    public function __construct(
        public string $name,
        public string $email,
        public ?int $age = null,
    ) {}

    public static function fromRequest(array $data): self {
        return new self(
            name: $data['name'],
            email: $data['email'],
            age: $data['age'] ?? null
        );
    }
}
```

### 3.2 Sử dụng (Client)

```php
class UserService {
    public function create(UserDTO $userDTO) {
        // IDE gợi ý $userDTO->name, $userDTO->email cực chuẩn
        return User::create([
            'name' => $userDTO->name,
            'email' => $userDTO->email,
            'age' => $userDTO->age
        ]);
    }
}
```

## 4. Liên hệ Laravel

Trong Laravel, DTO đang trở thành tiêu chuẩn vàng cho các dự án Clean Architecture:

**1. Kết hợp với Form Request:**
Controller nhận Request, validate xong thì đổ vào DTO rồi mới truyền vào Service.

```php
public function store(StoreUserRequest $request, UserService $service) {
    $dto = UserDTO::fromRequest($request->validated());
    $service->create($dto);
}
```

**2. Thư viện mạnh mẽ:**
Cộng đồng Laravel thường dùng các gói như `spatie/laravel-data`. Nó biến DTO thành một "siêu vũ khí" vừa validate, vừa cast type, vừa chuyển đổi dữ liệu cực nhanh.

## 5. Khi nào nên dùng

* Khi ứng dụng có quy mô từ vừa đến lớn.
* Khi bạn có tầng Service tách biệt khỏi Controller.
* Khi bạn muốn code của mình có tính "Self-documenting" (đọc code hiểu ngay cấu trúc dữ liệu).
* Khi làm việc trong team (giúp đồng nghiệp không phải đoán key của mảng).

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Type Safety:** Đảm bảo dữ liệu luôn đúng kiểu (string, int...).
* **Dễ Refactor:** Nếu đổi tên trường, IDE sẽ tìm và đổi cho bạn ở mọi nơi.
* **Auto-completion:** Tăng tốc độ gõ code đáng kể.
* **Tách biệt dữ liệu:** Dễ dàng kiểm soát dữ liệu nào được phép đi vào hệ thống.

**Nhược điểm:**

* **Boilerplate code:** Bạn phải viết thêm nhiều class.
* **Tốn thời gian ban đầu:** Đối với các dự án siêu nhỏ, DTO có thể làm chậm tốc độ phát triển.

## 7. Câu hỏi phỏng vấn

1. **Tại sao nên dùng DTO thay vì Array?** (Để có Type Safety, hỗ trợ IDE và tránh lỗi runtime do gõ sai key).
2. **DTO có nên chứa logic xử lý không?** (Không, DTO chỉ nên chứa dữ liệu và các hàm khởi tạo từ nguồn khác nhau - ví dụ `fromArray`, `fromRequest`).
3. **Sự khác biệt giữa DTO và Model?** (Model đại diện cho dữ liệu trong Database và chứa logic nghiệp vụ/quan hệ. DTO đại diện cho dữ liệu đang được di chuyển giữa các tầng).

## Kết luận

DTO Pattern là bước chuyển mình từ "code chạy được" sang "code chuyên nghiệp". Nếu bạn muốn xây dựng những hệ thống Laravel bền vững và dễ bảo trì, hãy bắt đầu sử dụng DTO thay cho những mảng Associative rắc rối.
