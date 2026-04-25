---
title: Adapter Pattern - Bộ chuyển đổi linh hoạt
excerpt: Tìm hiểu Adapter Pattern - giải pháp kết nối các Class không tương thích, cách Laravel sử dụng nó để hỗ trợ đa dạng driver (Storage, Mail, Socialite).
category: Design pattern
date: 2026-03-13
order: 6
image: /prezet/img/ogimages/series-design-pattern-adapter-pattern.webp
---

> Pattern thuộc nhóm **Structural Pattern (Cấu trúc)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang tích hợp hệ thống gửi SMS vào ứng dụng. Bạn bắt đầu với nhà cung cấp **Twilio**.

```php
class TwilioService {
    public function sendSmsTwilio($to, $text) { /* Twilio logic */ }
}
```

Sau một thời gian, sếp yêu cầu đổi sang nhà cung cấp **Zalo** để tiết kiệm chi phí. Nhà cung cấp mới lại có hàm hoàn toàn khác:

```php
class ZaloService {
    public function pushZaloMessage($phone, $content) { /* Zalo logic */ }
}
```

**Vấn đề:** Nếu bạn đã dùng `TwilioService` ở 50 file trong project, việc đổi sang `ZaloService` sẽ là một thảm họa refactor. Code của bạn bị phụ thuộc chặt chẽ vào thư viện bên thứ ba (Third-party library).

## 2. Định nghĩa

**Adapter Pattern** đóng vai trò là một lớp trung gian cho phép các Interface không tương thích có thể làm việc cùng nhau. Nó "bọc" (wrap) một đối tượng có sẵn và cung cấp một Interface mới mà client mong muốn.

**Ý tưởng cốt lõi:** Đừng sửa thư viện bên thứ ba, hãy viết một cái "phích cắm chuyển đổi" cho nó.

## 3. Implementation (PHP Clean Code)

### 3.1 Bước 1: Định nghĩa Interface chung (Phích cắm chuẩn)

```php
interface SmsProviderInterface {
    public function send(string $phone, string $message): void;
}
```

### 3.2 Bước 2: Tạo các Adapter (Bộ chuyển đổi)

```php
class TwilioAdapter implements SmsProviderInterface {
    public function __construct(protected TwilioService $twilio) {}

    public function send(string $phone, string $message): void {
        $this->twilio->sendSmsTwilio($phone, $message);
    }
}

class ZaloAdapter implements SmsProviderInterface {
    public function __construct(protected ZaloService $zalo) {}

    public function send(string $phone, string $message): void {
        $this->zalo->pushZaloMessage($phone, $message);
    }
}
```

### 3.3 Bước 3: Sử dụng (Client)

```php
class NotificationService {
    public function __construct(protected SmsProviderInterface $provider) {}

    public function notify(string $phone, string $msg) {
        $this->provider->send($phone, $msg);
    }
}

// Dễ dàng hoán đổi
$service = new NotificationService(new ZaloAdapter(new ZaloService()));
$service->notify('09123...', 'Hello!');
```

## 4. Liên hệ Laravel (The Driver System)

Laravel sử dụng Adapter Pattern cực kỳ triệt để thông qua hệ thống **Managers & Drivers**:

**1. Filesystem (Storage):**
Bạn gọi `Storage::put()`, nhưng bên dưới Laravel có các Adapter cho:

* Local Disk
* Amazon S3
* FTP, SFTP
* Google Cloud Storage

**2. Socialite:**
Cùng một hàm `Socialite::driver($provider)->user()`, nhưng có các Adapter riêng cho Facebook, Google, GitHub...

## 5. Khi nào nên dùng

* Khi muốn sử dụng một Class có sẵn nhưng Interface của nó không khớp với yêu cầu của bạn.
* Khi muốn tạo một thư viện có thể mở rộng (Plug-and-play) với nhiều nhà cung cấp khác nhau.
* Khi muốn bảo vệ code core khỏi sự thay đổi của các thư viện bên thứ ba.

## 6. So sánh: Adapter vs Proxy vs Facade

| Pattern | Mục tiêu chính |
| :--- | :--- |
| **Adapter** | Chuyển đổi Interface để 2 bên hiểu nhau. |
| **Proxy** | Kiểm soát truy cập vào đối tượng gốc (không đổi Interface). |
| **Facade** | Cung cấp Interface đơn giản cho một hệ thống phức tạp. |

## 7. Câu hỏi phỏng vấn

1. **Sự khác biệt giữa Adapter và Decorator?** (Adapter đổi Interface, Decorator giữ nguyên Interface nhưng thêm hành vi).
2. **Adapter có vi phạm nguyên tắc gì không?** (Thường không, nó hỗ trợ tốt Single Responsibility và Open/Closed).
3. **Tại sao nên dùng Adapter cho các API bên thứ ba?** (Để khi API thay đổi hoặc bạn đổi nhà cung cấp, bạn chỉ cần tạo Adapter mới thay vì sửa toàn bộ logic ứng dụng).

## Kết luận

Adapter Pattern là bí quyết để code của bạn "bất tử" trước sự thay đổi của các thư viện bên ngoài. Hãy luôn thiết kế một Interface chuẩn cho các service của mình và dùng Adapter để bọc các implementation cụ thể.
