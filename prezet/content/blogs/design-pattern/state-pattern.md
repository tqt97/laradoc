---
title: "State Pattern: Quản lý Workflow phức tạp"
excerpt: State Pattern cho phép một đối tượng thay đổi hành vi của mình khi trạng thái bên trong thay đổi. Cực hữu ích cho các hệ thống đơn hàng/workflow.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-state-pattern.webp
tags: [design-patterns, php, laravel, workflow, behavior]
---

## 1. Vấn đề

Đơn hàng (`Order`) có các trạng thái: `Pending`, `Paid`, `Shipped`, `Cancelled`. Mỗi trạng thái có hành vi khác nhau (ví dụ: `Paid` mới cho xuất hàng, `Cancelled` không cho chỉnh sửa). Viết `if/else` theo trạng thái sẽ làm Model bị "phình to" kinh khủng.

## 2. Định nghĩa

State Pattern (Nhóm Behavioral) cho phép một đối tượng thay đổi hành vi của mình khi trạng thái bên trong thay đổi. Đối tượng đó sẽ trông như thể nó thay đổi lớp (class) của mình.

## 3. Cách giải quyết

```php
interface OrderState { public function ship(Order $order); }

class PaidState implements OrderState {
    public function ship(Order $order) { $order->setState(new ShippedState()); }
}
```

## 4. Khi nào áp dụng

- Khi object có quá nhiều trạng thái và hành vi phụ thuộc vào trạng thái đó.
- Tránh `if` hoặc `switch` dài lê thê trong class.

## 5. Câu hỏi phỏng vấn

- **Q: Khác biệt với Strategy?** Strategy là người gọi chọn hành vi. State là đối tượng tự thay đổi hành vi dựa trên trạng thái nội tại.
- **Q: Có cách nào áp dụng đơn giản hơn trong Laravel?** Có, dùng package `spatie/laravel-model-states` – giúp quản lý state bằng class rất chuyên nghiệp.
