---
title: Large Class – Khi một class “ôm” quá nhiều trách nhiệm
excerpt: Large Class là một code smell xảy ra khi một class chứa quá nhiều thuộc tính (fields), phương thức (methods) hoặc dòng code.
category: Refactoring
date: 2026-03-08
order: 5
image: /prezet/img/ogimages/series-refactoring-large-class.webp
---

> **Large Class** là một code smell xảy ra khi một class chứa quá nhiều thuộc tính (fields), phương thức (methods) hoặc dòng code. Điều này khiến class trở nên khó hiểu, khó maintain và dễ phát sinh bug khi thay đổi.

## Vấn đề (Problem)

Một class trở nên quá lớn khi nó:

* Có quá nhiều methods (logic bị nhồi nhét)
* Có nhiều fields không liên quan chặt chẽ với nhau
* Xử lý nhiều trách nhiệm khác nhau (vi phạm Single Responsibility Principle)
* Khó đọc, khó test và khó reuse

👉 Rule đơn giản:

> Nếu bạn cần scroll nhiều lần để đọc hết một class → có vấn đề.

## Nguyên nhân (Root Causes)

* Ban đầu class nhỏ và đơn giản
* Theo thời gian, feature mới liên tục được thêm vào
* Dev có xu hướng:

  * “Tiện tay” thêm vào class cũ thay vì tạo class mới
  * Ngại refactor vì sợ ảnh hưởng hệ thống
* Thiếu design rõ ràng ngay từ đầu

📌 Giống như **Long Method**, vấn đề này thường bị bỏ qua cho đến khi quá muộn.

## Cách xử lý (Refactoring Strategies)

### 1. Extract Class

Tách một phần logic + dữ liệu sang class mới.

```php
class User {
    public $name;
    public $email;

    public function sendEmail() {}
    public function generateReport() {}
}
```

➡️ Refactor:

```php
class User {
    public $name;
    public $email;
}

class UserMailer {
    public function sendEmail(User $user) {}
}

class UserReport {
    public function generate(User $user) {}
}
```

### 2. Áp dụng SRP (Single Responsibility Principle)

👉 Mỗi class chỉ nên có **1 lý do để thay đổi**

* User → chỉ giữ data user
* Service → xử lý business logic
* Repository → xử lý database

### 3. Tách theo Domain (Domain-driven thinking)

Nếu class đang làm nhiều việc:

* Auth logic → AuthService
* Payment logic → PaymentService
* Notification → NotificationService

### 4. Reduce Field Scope

* Xóa các field không cần thiết
* Di chuyển field sang class phù hợp hơn

## Dấu hiệu nhận biết (Signs)

* Class dài hàng trăm dòng
* Tên class mơ hồ (Manager, Helper, Service)
* Có nhiều method không liên quan nhau
* Khi sửa 1 chỗ → sợ ảnh hưởng nhiều chỗ khác

## Best Practices

* Ưu tiên composition hơn là nhồi nhét
* Luôn tự hỏi: “Logic này có thuộc về class này không?”
* Review code định kỳ
* Kết hợp với:

  * Extract Method
  * Extract Interface
  * Dependency Injection

## Kết luận

**Large Class** là một trong những code smell phổ biến nhất khi hệ thống phát triển lâu dài.

👉 Đừng đợi đến khi class “khổng lồ” mới refactor.
Hãy tách nhỏ ngay khi bạn cảm thấy class bắt đầu mất kiểm soát.
