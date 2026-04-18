---
title: "Observer Pattern: Nghệ thuật 'Bắn và Quên' trong kiến trúc sự kiện"
excerpt: Giải mã Observer Pattern, cách Laravel biến nó thành hệ thống Events/Listeners mạnh mẽ và cách sử dụng nó để giảm Coupling trong mã nguồn.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-observer-pattern-laravel-events.webp
tags: [design-patterns, php, laravel, events, clean-code, architecture]
---

Bạn vừa hoàn thành logic thanh toán đơn hàng. Bây giờ bạn cần: Gửi mail cho khách, thông báo cho kho, tích điểm cho user, và bắn tin nhắn Slack cho sếp. Nếu bạn viết tất cả logic này vào `PaymentController`, bạn đang tạo ra một "con quái vật" không thể bảo trì. **Observer Pattern** là chìa khóa để giải thoát bạn.

## 1. Observer Pattern là gì?

Pattern này định nghĩa một mối quan hệ **1-Nhiều**. Khi một đối tượng (Subject) thay đổi trạng thái, tất cả các đối tượng phụ thuộc (Observers) sẽ được thông báo và cập nhật tự động.

## 2. Observer "Thuần" trong PHP

PHP cung cấp sẵn interface `SplSubject` và `SplObserver` để bạn triển khai pattern này một cách chuẩn mực.

```php
class User implements SplSubject {
    private $observers = [];
    public function attach(SplObserver $observer) { $this->observers[] = $observer; }
    public function notify() {
        foreach ($this->observers as $observer) { $observer->update($this); }
    }
}
```

## 3. Laravel Events/Listeners: Observer trên đỉnh cao

Laravel đưa Observer lên một tầm cao mới:

- **Event:** Là cái "Subject" (Ví dụ: `OrderPlaced`).
- **Listener:** Là các "Observers" (Ví dụ: `SendEmail`, `UpdateStock`).
Lợi ích lớn nhất: **Decoupling**. Class xử lý Đơn hàng không hề biết đến sự tồn tại của Class gửi Email.

## 4.Câu hỏi nhanh

**Câu hỏi:** Tại sao việc sử dụng Observer Pattern (Events) lại giúp hệ thống dễ dàng **Scale** hơn?

**Trả lời:**
Vì nó cho phép thực hiện **xử lý bất đồng bộ (Asynchronous Processing)**.
Trong Laravel, bạn chỉ cần thêm `implements ShouldQueue` vào Listener. Khi Event bắn ra, thay vì bắt người dùng đợi gửi mail xong, Laravel sẽ đẩy Listener đó vào Queue (Redis/SQS). Request của người dùng kết thúc ngay lập tức, trong khi các công việc phụ được thực hiện ngầm. Đây là nền tảng để xây dựng các hệ thống chịu tải cao.

**Câu hỏi mẹo:** Phân biệt Eloquent Observers và Laravel Events?
**Trả lời:**

- **Eloquent Observers:** Gắn chặt vào vòng đời của Model (creating, updated, deleted...). Dùng khi bạn muốn tự động hóa các thao tác liên quan trực tiếp đến database.
- **Laravel Events:** Linh hoạt hơn, dùng cho bất kỳ logic nghiệp vụ nào (Business Events) không nhất thiết phải liên quan đến Model.

## 5. Kết luận

Observer Pattern giúp code của bạn tuân thủ nguyên lý **Single Responsibility**. Hãy dùng nó để giữ cho Controller luôn "mỏng" và tập trung duy nhất vào việc điều phối luồng chính.
