---
title: Factory Method - Tạo đối tượng qua lớp con
excerpt: Tìm hiểu Factory Method Pattern - cách ủy quyền việc tạo đối tượng cho các lớp con, giúp hệ thống linh hoạt hơn khi thêm mới loại sản phẩm.
category: Design pattern
date: 2026-04-10
order: 34
image: /prezet/img/ogimages/series-design-pattern-factory-method-pattern.webp
---

> Pattern thuộc nhóm **Creational Pattern (Khởi tạo)**

## 1. Problem & Motivation

Bạn có một hệ thống Logistics hỗ trợ vận chuyển bằng **Truck**. Sau đó, bạn muốn mở rộng thêm **Ship** (tàu thủy). Nếu bạn viết cứng logic `new Truck()` trong class `Logistics`, khi thêm `Ship`, bạn sẽ phải sửa toàn bộ code cũ.

## 2. Định nghĩa

**Factory Method** định nghĩa một interface để tạo đối tượng, nhưng để các lớp con quyết định class nào sẽ được khởi tạo.

## 3. Implementation

```php
abstract class Logistics {
    abstract public function createTransport(): Transport;
    public function planDelivery() {
        $transport = $this->createTransport();
        $transport->deliver();
    }
}

class RoadLogistics extends Logistics {
    public function createTransport(): Transport { return new Truck(); }
}
```

## 4. Liên hệ Laravel

Laravel sử dụng Factory Method trong hệ thống `Application` (Service Container) khi tạo ra các instance của các loại Driver khác nhau.

## 5. Kết luận

Factory Method giúp bạn tuân thủ **Open/Closed Principle** – bạn có thể thêm các phương thức vận chuyển mới mà không cần chỉnh sửa logic xử lý Logistics hiện có.
