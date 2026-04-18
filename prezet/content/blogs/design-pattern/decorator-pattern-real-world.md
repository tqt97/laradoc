---
title: "Decorator Pattern: Mở rộng tính năng không cần kế thừa"
excerpt: Tìm hiểu cách sử dụng Decorator Pattern để thêm chức năng cho object một cách linh hoạt tại runtime. Ví dụ thực tế về hệ thống tính giá sản phẩm trong E-commerce.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-decorator-pattern-real-world.webp
tags: [design-patterns, oop, refactoring, php, clean-code]
---

Bạn có một class `Order` cơ bản. Bây giờ sếp yêu cầu:

- Nếu khách có mã giảm giá -> giảm 10%.
- Nếu khách là VIP -> giảm thêm 5%.
- Nếu là ngày lễ -> tặng quà.
Nếu bạn dùng kế thừa, bạn sẽ rơi vào thảm họa "Explosion of Classes" (ví dụ: `VipOrder`, `HolidayOrder`, `VipHolidayOrder`...). **Decorator Pattern** sinh ra để giải quyết vấn đề này.

## 1. Ý tưởng cốt lõi: "Cái phễu" bọc ngoài

Thay vì tạo class con, bạn tạo ra các "lớp vỏ" (wrappers). Mỗi lớp vỏ chứa object gốc và thêm một chút logic vào đó.

- Object gốc: `BasicService`.
- Wrapper 1: `LoggingDecorator(BasicService)`.
- Wrapper 2: `AuthDecorator(LoggingDecorator(BasicService))`.

## 2. Cấu trúc của Decorator

Mọi Decorator đều phải implement cùng một **Interface** với object gốc. Điều này giúp code ở nơi gọi không hề hay biết mình đang làm việc với object thật hay là một decorator.

## 3. Ví dụ thực tế với PHP

```php
interface Coffee {
    public function getCost(): int;
}

class SimpleCoffee implements Coffee {
    public function getCost(): int { return 10; }
}

class MilkDecorator implements Coffee {
    public function __construct(protected Coffee $coffee) {}
    public function getCost(): int {
        return $this->coffee->getCost() + 5; // Giá gốc + giá sữa
    }
}
```

## 4.Câu hỏi nhanh

**Câu hỏi:** Phân biệt sự khác biệt về mục đích sử dụng giữa **Decorator Pattern** và **Proxy Pattern**?

**Trả lời:**
Dù cấu trúc code khá giống nhau (đều là wrapper), nhưng mục đích hoàn toàn khác:

- **Decorator:** Tập trung vào việc **thêm tính năng** (behavior) cho object một cách linh hoạt.
- **Proxy:** Tập trung vào việc **kiểm soát truy cập** (access control) tới object gốc (ví dụ: lazy loading, logging, caching, security check) mà không nhất thiết phải thay đổi tính năng của nó.

**Câu hỏi mẹo:** Middleware trong Laravel có phải là Decorator Pattern không?
**Trả lời:** Rất chính xác! Middleware bao bọc Request qua một chuỗi các "pipes". Mỗi Middleware có thể thay đổi Request/Response hoặc thực hiện hành động phụ trước khi chuyển cho lớp bên trong. Đây là một biến thể của Decorator kết hợp với Chain of Responsibility.

## 5. Kết luận

Decorator giúp bạn tuân thủ nguyên lý **Open/Closed** tuyệt đối: mở rộng tính năng mà không cần sửa code cũ. Hãy nghĩ tới Decorator mỗi khi bạn thấy mình đang viết quá nhiều câu lệnh `if/else` để thay đổi hành vi của một class.
