---
title: Refactor Large Class - Extract Class, Subclass, Interface và Tách GUI - Domain
excerpt: Cách refactor Large Class hiệu quả với Extract Class, Extract Subclass, Extract Interface và tách GUI - Domain, bám sát chuẩn refactoring, có ví dụ before/after dễ hiểu.
category: Refactoring
date: 2026-03-08
order: 6
image: /prezet/img/ogimages/series-refactoring-refactor-large-class.webp
---

> Khi một **Large Class (class quá lớn, ôm nhiều trách nhiệm)** xuất hiện, đó là dấu hiệu bạn cần refactor ngay.

Bài này tập trung vào các kỹ thuật chuẩn:

* Extract Class
* Extract Subclass
* Extract Interface
* Separate GUI và Domain Data

🎯 Mục tiêu: giảm độ phức tạp, dễ đọc, dễ maintain và tránh technical debt.

## 1. Extract Class

**Khi nào dùng**

Extract Class giúp bạn tách một phần behavior của class lớn sang component riêng.

**Vấn đề (Problem)**

Khi một class làm việc của 2 class → code trở nên awkward (khó hiểu, khó maintain)

```php
class User {
    public $name;
    public $email;

    public function save() {
        // save user
    }

    public function sendEmail() {
        // send email
    }
}
```

👉 Vấn đề: User đang làm cả data + email logic

**Giải pháp (Solution)**

Tạo class mới và chuyển các field + method liên quan sang đó.

```php
class User {
    public $name;
    public $email;

    public function save() {
        // save user
    }
}

class UserMailer {
    public function send(User $user) {
        // send email
    }
}
```

✔️ Tách rõ responsibility, dễ mở rộng hơn

## 2. Extract Subclass

**Khi nào dùng**

Extract Subclass phù hợp khi một phần behavior:

* Có nhiều cách implement khác nhau
* Hoặc chỉ dùng trong một số trường hợp hiếm

**Vấn đề (Problem)**

Một class có feature chỉ dùng trong vài case → làm code bị nhiễu

```php
class Payment {
    public function pay($type) {
        if ($type === 'credit') {
            // xử lý credit
        }

        if ($type === 'paypal') {
            // xử lý paypal
        }
    }
}
```

👉 Vấn đề: logic rẽ nhánh nhiều, khó scale

**Giải pháp (Solution)**

Tạo subclass và chỉ dùng khi cần

```php
class Payment {
    public function pay() {}
}

class CreditPayment extends Payment {
    public function pay() {
        // xử lý credit
    }
}

class PaypalPayment extends Payment {
    public function pay() {
        // xử lý paypal
    }
}
```

✔️ Dùng polymorphism, clean hơn, mở rộng dễ hơn

## 3. Extract Interface

**Khi nào dùng**

Extract Interface giúp định nghĩa danh sách các operation mà client có thể sử dụng.

**Vấn đề (Problem)**

* Nhiều client dùng chung 1 phần interface
* Hoặc nhiều class có cùng 1 phần interface giống nhau

```php
class FileLogger {
    public function logInfo() {}
    public function logError() {}
}

class DbLogger {
    public function logInfo() {}
    public function logError() {}
}
```

👉 Vấn đề: duplicated contract

**Giải pháp (Solution)**

Tách phần chung đó thành interface riêng

```php
interface LoggerInterface {
    public function logInfo();
    public function logError();
}

class FileLogger implements LoggerInterface {
    public function logInfo() {}
    public function logError() {}
}

class DbLogger implements LoggerInterface {
    public function logInfo() {}
    public function logError() {}
}
```

✔️ Chuẩn hóa contract, dễ swap implementation

## 4. Separate GUI và Domain Data

**Khi nào dùng**

Khi một class chịu trách nhiệm cả GUI và domain logic

**Vấn đề (Problem)**

Domain data bị lưu trong class GUI → khó maintain

```php
class UserProfilePage {
    public $name;

    public function render() {
        echo "Name: " . $this->name;
    }

    public function calculateDiscount() {
        return 10;
    }
}
```

👉 Vấn đề: trộn UI + business logic

**Giải pháp (Solution)**

Tách domain ra class riêng và đồng bộ dữ liệu nếu cần

```php
class User {
    public $name;

    public function calculateDiscount() {
        return 10;
    }
}

class UserProfilePage {
    public function render(User $user) {
        echo "Name: " . $user->name;
    }
}
```

✔️ Tách biệt rõ GUI và domain

## Tổng kết nhanh

| Technique             | Ý nghĩa                               |
| --------------------- | ------------------------------------- |
| Extract Class         | Tách một phần behavior sang class mới |
| Extract Subclass      | Tách behavior đặc biệt hoặc hiếm      |
| Extract Interface     | Định nghĩa contract dùng chung        |
| Separate GUI & Domain | Tách UI và business logic             |

## Best Practices

* Luôn kiểm tra dấu hiệu **class làm quá nhiều việc**
* Tách theo responsibility, không tách theo cảm tính
* Interface chỉ nên chứa thứ client thực sự cần
* Tránh subclass nếu composition là đủ
* Refactor nhỏ, test liên tục

## Mẹo thực tế

* Class có nhiều nhóm method khác nhau → nghĩ tới Extract Class
* Có logic chỉ chạy 1 số case → Extract Subclass
* Nhiều class giống nhau → Extract Interface
* UI dính business → tách ngay

## Đánh giá

Các kỹ thuật này giúp:

* Giảm độ phức tạp của class
* Tránh duplicate logic
* Dễ maintain và mở rộng

👉 Đây là nền tảng quan trọng để code tiến tới clean architecture.

## Kết luận

Large Class là một trong những code smell phổ biến nhất.

Giải pháp không phải viết lại toàn bộ, mà là:

* Tách đúng phần
* Giữ logic rõ ràng
* Refactor từng bước

Clean code là quá trình liên tục, không phải một lần duy nhất 🚀
