---
title: "Pipeline Pattern trong Laravel: Bí mật đằng sau Middleware và hơn thế nữa"
excerpt: Khám phá sức mạnh của mẫu thiết kế Pipeline, cách Laravel sử dụng nó để xử lý request và cách bạn có thể tự áp dụng nó vào code nghiệp vụ để giảm độ phức tạp.
date: 2026-04-18
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-pipeline-pattern.webp
tags: [laravel, pipeline, design-patterns, middleware, refactoring]
---

Bạn đã bao giờ tự hỏi làm thế nào một Request trong Laravel lại có thể đi qua hàng chục lớp Middleware (kiểm tra Auth, check CSRF, log dữ liệu...) một cách trơn tru trước khi đến được Controller? Bí mật nằm ở **Pipeline Pattern**.

## 1. Pipeline Pattern là gì?

Pipeline là một mẫu thiết kế cho phép bạn chuyển một dữ liệu đầu vào qua một chuỗi các "đoạn ống" (pipes). Mỗi đoạn ống sẽ thực hiện một nhiệm vụ cụ thể, thay đổi dữ liệu đó hoặc kiểm tra điều kiện, rồi chuyển nó cho đoạn ống tiếp theo.

Hãy tưởng tượng nó như một dây chuyền lắp ráp ô tô:

- Stage 1: Lắp khung.
- Stage 2: Lắp động cơ.
- Stage 3: Sơn màu.
- Output: Một chiếc xe hoàn chỉnh.

## 2. Cách Laravel sử dụng Pipeline

Mọi người đều biết Middleware, nhưng ít ai biết chúng được điều phối bởi class `Illuminate\Pipeline\Pipeline`. Logic cốt lõi của nó là hàm `array_reduce` của PHP.

```php
// Một cách trừu tượng, Laravel xử lý request như sau:
return app(Pipeline::class)
    ->send($request)
    ->through($middleware)
    ->then(function ($request) {
        return $this->dispatchToRouter($request);
    });
```

## 3. Tự ứng dụng Pipeline vào Code nghiệp vụ

Đừng chỉ dùng Pipeline cho Middleware. Hãy tưởng tượng bạn có logic xử lý đơn hàng cực kỳ phức tạp với nhiều bước:

1. Tính thuế.
2. Áp dụng khuyến mãi.
3. Kiểm tra kho.
4. Tính phí vận chuyển.

Thay vì viết một hàm `processOrder()` dài 500 dòng với hàng chục câu `if/else`, hãy dùng Pipeline:

```php
use Illuminate\Pipeline\Pipeline;

$order = app(Pipeline::class)
    ->send($order)
    ->through([
        \App\Pipelines\Orders\CalculateTax::class,
        \App\Pipelines\Orders\ApplyDiscount::class,
        \App\Pipelines\Orders\CheckInventory::class,
        \App\Pipelines\Orders\CalculateShipping::class,
    ])
    ->thenReturn();
```

Mỗi class pipe sẽ có một hàm `handle`:

```php
public function handle($order, $next)
{
    // Logic của bạn ở đây...
    $order->total += 100;

    return $next($order); // Chuyển sang bước tiếp theo
}
```

## 4. Ưu điểm vượt trội

- **Single Responsibility:** Mỗi bước xử lý nằm trong 1 class riêng biệt.
- **Dễ dàng mở rộng:** Muốn thêm bước "Gửi thông báo", chỉ cần thêm 1 class vào mảng `through`.
- **Dễ Unit Test:** Bạn có thể test từng Pipe một cách cô lập.
- **Code "Sạch":** Hàm chính của bạn cực kỳ ngắn gọn và mang tính khai báo (Declarative).

## 5. Quizz cho phỏng vấn Senior

**Câu hỏi:** Điều gì xảy ra nếu một "Pipe" không gọi hàm `$next($passable)` mà trả về kết quả ngay lập tức?

**Trả lời:**
Toàn bộ chuỗi Pipeline sẽ **dừng lại ngay lập tức**. Đây chính là cơ chế "bẻ lái" của Middleware. Ví dụ: Nếu `AuthMiddleware` thấy người dùng chưa đăng nhập, nó trả về redirect sang trang login thay vì gọi `$next($request)`. Kết quả là request sẽ không bao giờ chạm tới được Controller. Điều này cực kỳ hữu ích để ngăn chặn các tác vụ không hợp lệ ngay từ đầu chuỗi xử lý.

## 6. Kết luận

Pipeline Pattern là một trong những "viên ngọc quý" của Laravel. Hiểu và áp dụng nó sẽ giúp bạn chuyển từ tư duy viết code "thủ tục" (procedural) sang tư duy xây dựng kiến trúc (architectural).
