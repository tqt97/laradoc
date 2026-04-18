---
title: "Strategy Pattern: Thay thế If-Else bằng tính linh hoạt"
excerpt: Cách thay thế cấu trúc if-else/switch cồng kềnh trong xử lý Payment, Shipping bằng các class chiến lược.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-strategy-pattern.webp
tags: [design-patterns, php, laravel, refactoring]
---

## 1. Bài toán
Hệ thống thanh toán hỗ trợ: CreditCard, Paypal, Stripe. Bạn có hàm `pay()` đầy rẫy `if/else`. Mỗi khi thêm cổng mới, bạn lại phải sửa code cũ (vi phạm Open/Closed Principle).

## 2. Giải pháp
Tách mỗi cổng thanh toán thành 1 class riêng biệt implement cùng một interface `PaymentStrategy`.

## 3. Code mẫu (Laravel)
```php
interface PaymentStrategy { public function pay($amount); }

class StripePayment implements PaymentStrategy { ... }
class PaypalPayment implements PaymentStrategy { ... }

// Trong Service:
public function checkout(PaymentStrategy $gateway) {
    return $gateway->pay($amount);
}
```

## 4. Câu hỏi nhanh
**Q: Sự khác biệt lớn nhất với State Pattern?**
**A:** Strategy là người gọi (Client) quyết định chọn chiến thuật nào. State là đối tượng tự chọn hành vi dựa trên trạng thái nội tại của chính nó.
**Q: Ứng dụng phổ biến trong Laravel?**
**A:** Xử lý Storage Driver (S3, Local, Rackspace), Cache Driver, Notifications (Mail, SMS, Slack).
