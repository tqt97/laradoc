---
title: Factory Pattern là gì?
excerpt: Tìm hiểu Factory Pattern từ lý thuyết chi tiết, bản chất vấn đề, cách hoạt động và ví dụ PHP dễ hiểu, áp dụng thực tế trong Laravel
category: Design pattern
date: 2026-03-10
order: 3
image:

---

> Pattern thuộc nhóm **Creational Pattern (Khởi tạo)**

* Tập trung vào cách tạo object
* Giấu logic khởi tạo
* Giúp code linh hoạt hơn

## 1. Problem nó giải quyết (Cực kỳ quan trọng)

Trong PHP, bạn thường viết:

```php
$user = new AdminUser();
```

Nghe có vẻ bình thường… nhưng về kiến trúc:

**Vấn đề thật sự**

* Code bị **hard-code dependency**
* Không thể thay đổi object dễ dàng
* Vi phạm **Dependency Inversion Principle**
* Không test mock được

Ví dụ:

```php
class UserService {
    public function create() {
        return new AdminUser();
    }
}
```

Bây giờ muốn đổi sang `CustomerUser`?
→ Phải sửa code

## 2. Ý tưởng chính (Core concept)

Factory Pattern nói:

> "Đừng tạo object trực tiếp bằng new → hãy dùng 1 nơi chuyên tạo"

### Tư duy đơn giản

Thay vì:

```php
new Something()
```

Ta làm:

```php
Factory::make()
```

### Tư duy Architect

* Tách **object creation** khỏi **business logic**
* Giảm coupling
* Tăng flexibility

## 3. UML

```
        [UserFactory]
             ↓
   ----------------------
   |                    |
[AdminUser]     [CustomerUser]
```

## 4. Code PHP chuẩn clean (dễ hiểu nhất)

### 4.1 Interface

```php
interface User {}
```

### 4.2 Concrete classes

```php
class AdminUser implements User {}
class CustomerUser implements User {}
```

### 4.3 Factory

```php
class UserFactory {
    public static function make(string $type): User {
        return match ($type) {
            'admin' => new AdminUser(),
            'customer' => new CustomerUser(),
            default => throw new Exception('Invalid type')
        };
    }
}
```

### 4.4 Sử dụng

```php
$user = UserFactory::make('admin');
```

Code sạch hơn, không phụ thuộc class cụ thể

### Bản chất sâu hơn

Factory giải quyết 3 thứ:

**Encapsulation (đóng gói)**

* Giấu logic tạo object

**Decoupling (giảm phụ thuộc)**

* Không cần biết class cụ thể

**Single Responsibility**

* Mỗi class chỉ làm 1 việc

### Các loại Factory

**Simple Factory**

* 1 class tạo nhiều object

Chính là ví dụ trên

**Factory Method (chuẩn GoF)**

Mỗi class con quyết định tạo object

**Abstract Factory**

Tạo ra **family object** liên quan

Với PHP backend:

* 80% dùng **Simple Factory + DI** là đủ

### Liên hệ Laravel

**Service Container**

```php
$this->app->bind(User::class, function () {
    return new AdminUser();
});
```

Đây chính là Factory ngầm

**Model Factory**

```php
User::factory()->create();
```

Laravel built-in Factory Pattern

## 5. So sánh với pattern khác

| Pattern  | Mục tiêu            |
| -------- | ------------------- |
| Factory  | Tạo object          |
| Strategy | Sử dụng object      |
| Builder  | Tạo object phức tạp |

## 6. Khi nào nên / không nên dùng

### Nên dùng

* Tạo object phức tạp
* Có nhiều loại object
* Muốn ẩn logic khởi tạo
* Dùng DI container

### Không nên

* Object đơn giản
* Không cần abstraction

Tránh over-engineering

## 7. Anti-pattern liên quan

### new rải rác khắp nơi

```php
new A();
new B();
new C();
```

Khó maintain

### Switch/if tạo object khắp nơi

## 8. Advanced note (Senior mindset)

* Factory thường đi cùng Strategy
* Factory + DI = scalable system
* Container (Laravel) = Factory nâng cấp

## Kết luận

**Factory Pattern giúp bạn:**

* Kiểm soát việc tạo object
* Giảm coupling
* Viết code clean hơn

Đây là nền tảng để hiểu DI Container
