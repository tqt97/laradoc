---
title: Mediator Pattern - Nhạc trưởng của hệ thống
excerpt: Tìm hiểu Mediator Pattern - cách giảm sự phụ thuộc giữa các đối tượng bằng một trung gian điều phối.
category: Design pattern
date: 2026-04-13
order: 37
image: /prezet/img/ogimages/series-design-pattern-mediator-pattern.webp
---

> Pattern thuộc nhóm **Behavioral Pattern (Hành vi)**

## 1. Problem & Motivation
Các đối tượng tương tác trực tiếp (nhiều-nhiều) gây rối rắm. Khi thay đổi một class, bạn phải sửa hàng loạt class khác.

## 2. Định nghĩa
**Mediator Pattern** thay thế các kết nối trực tiếp bằng một đối tượng trung gian (Mediator) chịu trách nhiệm điều phối.

## 3. Implementation
```php
class ChatRoom implements ChatMediator {
    public function sendMessage(string $msg, User $user) {
        // Điều phối thông tin giữa các User
    }
}
```

## 4. Liên hệ Laravel
`Event Dispatcher` chính là một Mediator. Class `Order` không cần biết ai nghe sự kiện `OrderPlaced`, nó chỉ bắn event, Dispatcher điều phối đến các Listeners.

## 5. Kết luận
Dùng Mediator khi bạn muốn giảm Coupling giữa các đối tượng trong một hệ thống phức tạp.
