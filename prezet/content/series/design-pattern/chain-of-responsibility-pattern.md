---
title: Chain of Responsibility - Chuỗi xử lý yêu cầu
excerpt: Tìm hiểu Chain of Responsibility Pattern - cách chuyển yêu cầu qua một chuỗi các trình xử lý, giải mã cơ chế Pipeline và Middleware huyền thoại của Laravel.
category: Design pattern
date: 2026-03-21
order: 14
image: /prezet/img/ogimages/series-design-pattern-chain-of-responsibility-pattern.webp
---

> Pattern thuộc nhóm **Behavioral Pattern (Hành vi)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang xây dựng một hệ thống đặt hàng trực tuyến. Trước khi đơn hàng được lưu vào Database, nó phải đi qua rất nhiều bước kiểm tra:

1. Kiểm tra xác thực (User đã đăng nhập chưa?)
2. Kiểm tra quyền hạn (User có quyền đặt hàng không?)
3. Kiểm tra dữ liệu (Form có hợp lệ không?)
4. Kiểm tra kho hàng (Sản phẩm còn đủ không?)

**Naive Solution:** Viết một hàm `handleOrder` khổng lồ.

```php
class OrderHandler {
    public function handle($request) {
        if ($this->authenticate($request)) {
            if ($this->authorize($request)) {
                if ($this->validate($request)) {
                    // Lưu database...
                }
            }
        }
    }
}
```

**Vấn đề:**

* **Cấu trúc lồng nhau (If-else hell):** Code cực kỳ khó đọc và rối rắm.
* **Vi phạm Single Responsibility:** Một class phải lo quá nhiều logic kiểm tra khác nhau.
* **Khó thay đổi:** Nếu muốn đổi thứ tự kiểm tra hoặc thêm một bước mới, bạn phải sửa lại hàm khổng lồ này.

## 2. Định nghĩa

**Chain of Responsibility** cho phép bạn chuyển các yêu cầu dọc theo một chuỗi các trình xử lý (handlers). Khi nhận được một yêu cầu, mỗi trình xử lý sẽ quyết định xử lý yêu cầu đó hoặc chuyển nó cho trình xử lý tiếp theo trong chuỗi.

**Ý tưởng cốt lõi:** Chia nhỏ các bước kiểm tra thành từng Class độc lập và kết nối chúng lại thành một "đường ống".

## 3. Implementation (PHP Clean Code)

### 3.1 Handler Interface

```php
abstract class Handler {
    private ?Handler $nextHandler = null;

    public function setNext(Handler $handler): Handler {
        $this->nextHandler = $handler;
        return $handler;
    }

    public function handle(string $request): ?string {
        if ($this->nextHandler) {
            return $this->nextHandler->handle($request);
        }
        return null;
    }
}
```

### 3.2 Concrete Handlers

```php
class AuthHandler extends Handler {
    public function handle(string $request): ?string {
        if ($request !== "authorized_user") {
            return "Dừng lại: Bạn chưa đăng nhập!";
        }
        return parent::handle($request);
    }
}

class ValidationHandler extends Handler {
    public function handle(string $request): ?string {
        // Giả sử logic validation...
        return parent::handle($request);
    }
}
```

### 3.3 Sử dụng (Lắp ráp chuỗi)

```php
$auth = new AuthHandler();
$validation = new ValidationHandler();

$auth->setNext($validation); // Xây dựng chuỗi

$result = $auth->handle("guest"); 
echo $result; // Dừng lại: Bạn chưa đăng nhập!
```

## 4. Liên hệ Laravel (The Pipeline Power)

Nếu bạn từng thắc mắc **Middleware** trong Laravel hoạt động như thế nào, thì đây chính là câu trả lời.

Laravel sử dụng một biến thể của pattern này gọi là **Pipeline**.

```php
// Bên trong nhân của Laravel
return app(Pipeline::class)
            ->send($request)
            ->through([
                \App\Http\Middleware\Authenticate::class,
                \App\Http\Middleware\CheckRole::class,
                \App\Http\Middleware\VerifyCsrfToken::class,
            ])
            ->then(fn ($request) => $this->dispatchToRouter($request));
```

Mỗi Middleware giống như một mắt xích trong chuỗi. Nó xử lý request của mình, sau đó gọi `$next($request)` để chuyển cho Middleware tiếp theo.

## 5. Khi nào nên dùng

* Khi hệ thống cần xử lý một yêu cầu qua nhiều bước theo một thứ tự nhất định.
* Khi thứ tự các bước xử lý có thể thay đổi linh hoạt tại runtime.
* Khi bạn muốn tách biệt logic xử lý của từng bước để dễ quản lý và test.

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Giảm Coupling:** Người gửi yêu cầu không cần biết ai trong chuỗi sẽ xử lý nó.
* **Linh hoạt:** Dễ dàng thêm, bớt hoặc thay đổi thứ tự các trình xử lý.
* **Tuân thủ SRP:** Mỗi class chỉ đảm nhận một nhiệm vụ xử lý duy nhất.

**Nhược điểm:**

* **Không đảm bảo xử lý:** Nếu không có handler nào phù hợp ở cuối chuỗi, yêu cầu có thể bị "rơi vào hư vô".
* **Khó debug:** Việc yêu cầu nhảy qua nhảy lại giữa các class có thể làm lập trình viên mới bối rối.

## 7. Câu hỏi phỏng vấn

1. **Sự khác biệt giữa Chain of Responsibility và Decorator?** (Chain có thể dừng yêu cầu bất cứ lúc nào, Decorator thường thực thi tất cả các lớp bọc và thêm hành vi).
2. **Làm thế nào để đảm bảo một yêu cầu chắc chắn được xử lý trong chuỗi?** (Nên có một "Default Handler" ở cuối chuỗi để xử lý các trường hợp không khớp).
3. **Tại sao Middleware Laravel lại dùng pattern này?** (Để cho phép các module độc lập như Auth, Logging, Cache can thiệp vào request một cách tuần tự mà không làm dơ code Controller).

## Kết luận

Chain of Responsibility biến code của bạn thành một dây chuyền sản xuất chuyên nghiệp. Hãy sử dụng nó để chế ngự những hàm `if/else` lồng nhau phức tạp và xây dựng các hệ thống Pipeline mạnh mẽ như Laravel.
