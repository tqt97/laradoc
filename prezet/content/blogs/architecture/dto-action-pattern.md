---
title: "DTO & Action Pattern: Khi Controller trở nên 'mỏng tang'"
excerpt: Cách xây dựng ứng dụng Laravel dễ bảo trì bằng cách tách Business Logic khỏi Controller vào các Action Class và truyền dữ liệu qua DTO.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-dto-action-pattern.webp
tags: [architecture, clean-code, laravel, action-pattern, dto]
---

## 1. Vấn đề

Controller là nơi chứa quá nhiều thứ: Validation, Business Logic, DB Query, Response. Điều này làm code khó test và "hôi" (Code Smell).

## 2. Giải pháp: Action & DTO

- **DTO (Data Transfer Object):** Chỉ là class giữ dữ liệu (không logic), giúp type-hint dữ liệu đầu vào.
- **Action Class:** Mỗi Action chỉ thực hiện DUY NHẤT một hành động (VD: `RegisterUserAction`). Controller chỉ việc gọi `action->execute($dto)`.

## 3. Code mẫu

```php
// DTO
readonly class UserData {
    public function __construct(public string $email, public string $password) {}
}

// Action
class RegisterUserAction {
    public function execute(UserData $data) {
        return User::create([...]);
    }
}
```

## 4. Câu hỏi nhanh

**Q: Action Class khác gì Service Class?**
**A:** Service Class thường chứa nhiều hàm liên quan tới 1 domain (gộp lại). Action Class chỉ chứa 1 hàm duy nhất (Single Responsibility) – rất dễ đọc và test.

## 5. Kết luận

Tách biệt Controller và Business Logic là bước đầu tiên để hệ thống của bạn có thể tồn tại qua nhiều năm bảo trì.
