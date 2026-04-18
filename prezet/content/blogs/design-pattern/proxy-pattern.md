---
title: "Proxy Pattern: Đại diện ủy quyền"
excerpt: Proxy Pattern cung cấp một đối tượng đại diện cho một đối tượng khác để kiểm soát quyền truy cập.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-proxy-pattern.webp
tags: [design-patterns, php, structural, security]
---

## 1. Vấn đề

Đối tượng thực tế quá nặng (ví dụ: cần tải tệp tin lớn từ server) hoặc cần kiểm tra quyền trước khi thực thi lệnh.

## 2. Định nghĩa

Proxy Pattern cung cấp một đối tượng đại diện hoặc giữ chỗ (placeholder) cho một đối tượng khác để kiểm soát quyền truy cập, lazy loading, hoặc logging.

## 3. Cách giải quyết

```php
class RealSubject { public function request() { echo "Data"; } }

class ProxySubject {
    protected $real;
    public function request() {
        if ($this->checkAccess()) {
            if (!$this->real) $this->real = new RealSubject();
            $this->real->request();
        }
    }
}
```

## 4. Ứng dụng & Mẹo

- **Ứng dụng:** Lazy loading hình ảnh lớn, Logging truy cập DB, Kiểm tra quyền (Auth).
- **Mẹo:** Trong Laravel, `Deferred Service Providers` có thể coi là một dạng Proxy: nó chỉ load service thực sự khi bạn yêu cầu.

## 5. Câu hỏi phỏng vấn

- **Q: Khác biệt với Decorator?** Decorator thêm tính năng mới. Proxy quản lý quyền truy cập/kiểm soát đối tượng.
- **Q: Proxy có làm tăng hiệu năng không?** Có, nếu nó dùng để Lazy Loading (chỉ load khi cần).

## 6. Kết luận

Proxy là "người gác cổng" giúp hệ thống an toàn và tối ưu tài nguyên hơn.
