---
title: "Adapter Pattern: Cầu nối cho các Interface không tương thích"
excerpt: Tìm hiểu cách sử dụng Adapter Pattern để tích hợp nhiều dịch vụ bên thứ ba (như cổng thanh toán) mà không làm bẩn logic nghiệp vụ của bạn.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-adapter-pattern-integration.webp
tags: [design-patterns, php, laravel, refactoring, integration]
---

Trong dự án thực tế, bạn thường phải làm việc với các thư viện bên thứ ba. Mỗi thư viện lại có một bộ hàm và tham số khác nhau. Nếu bạn gọi trực tiếp các hàm này trong Controller, code của bạn sẽ bị dính chặt (tightly coupled) vào thư viện đó. **Adapter Pattern** sinh ra để làm "bộ chuyển đổi" giữa code của bạn và thư viện bên ngoài.

## 1. Bài toán: Tích hợp nhiều cổng thanh toán

Bạn cần hỗ trợ PayPal và VNPay.

- PayPal dùng hàm `sendPayment(amount)`.
- VNPay dùng hàm `execute(vnp_Amount, vnp_TxnRef)`.

Nếu không dùng Adapter, bạn sẽ phải viết `if/else` khắp nơi.

## 2. Giải pháp: Tạo một "Hợp đồng" chung

1. Tạo một Interface `PaymentGateway`: Định nghĩa hàm `pay(int $amount)`.
2. Tạo các class Adapter: `PayPalAdapter` và `VNPayAdapter` cùng implement Interface trên.
3. Bên trong Adapter, bạn mới gọi các hàm đặc thù của thư viện.

```php
class PayPalAdapter implements PaymentGateway {
    public function pay(int $amount) {
        $this->paypalSdk->sendPayment($amount);
    }
}
```

## 3. Lợi ích

- **Tính tráo đổi (Swappability):** Bạn có thể đổi từ PayPal sang Stripe chỉ bằng cách đổi cấu hình trong Service Provider.
- **Dễ Unit Test:** Bạn có thể tạo Mock cho Interface `PaymentGateway` cực kỳ dễ dàng.

## 4.Câu hỏi nhanh

**Câu hỏi:** Adapter Pattern và Strategy Pattern trông rất giống nhau về cấu trúc code. Điểm khác biệt lớn nhất về mặt **ý đồ (Intent)** là gì?

**Trả lời:**

- **Adapter:** Tập trung vào việc **khắc phục sự không tương thích** giữa hai Interface hiện có. Nó giúp những thứ vốn không làm việc được với nhau có thể hợp tác.
- **Strategy:** Tập trung vào việc **cung cấp các thuật toán khác nhau** cho cùng một nhiệm vụ. Nó được thiết kế ngay từ đầu để người dùng có thể lựa chọn hành vi tại runtime.

**Câu hỏi mẹo:** Filesystem của Laravel (`Storage` facade) có phải là Adapter Pattern không?
**Trả lời:** Rất chính xác! Laravel sử dụng thư viện Flysystem bên dưới. Nó cung cấp một Interface duy nhất cho bạn (`get`, `put`, `delete`), nhưng bên dưới nó có các "Adapters" để làm việc với Local disk, Amazon S3, hay FTP mà bạn không cần quan tâm.

## 5. Kết luận

Adapter Pattern là lớp bảo vệ (Anti-corruption Layer) giúp Business Logic của bạn luôn "sạch", không bị ảnh hưởng bởi những thay đổi từ các thư viện bên thứ ba.
