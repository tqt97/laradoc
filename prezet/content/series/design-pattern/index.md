---
title: Design Patterns & Architecture
excerpt: Tổng hợp các Design Pattern từ cơ bản đến nâng cao, hướng dẫn ứng dụng thực tế trong hệ sinh thái Laravel.
category: Design pattern
date: 2026-04-15
order: 1
image: /prezet/img/ogimages/series-design-pattern-index.webp
---

## 1. Design Pattern là gì?
Design Pattern (mẫu thiết kế) là các giải pháp đã được kiểm chứng cho các vấn đề thường gặp trong lập trình phần mềm. Chúng không phải là mã nguồn cụ thể, mà là các "chiến lược tổ chức code" giúp hệ thống trở nên dễ mở rộng, bảo trì và kiểm thử.

> **Tư duy cốt lõi:** Pattern là công cụ, không phải mục tiêu. Người kiến trúc sư giỏi là người dùng đúng pattern, đúng lúc.

## 2. Phân loại Design Pattern

Chúng ta chia Design Pattern thành 3 nhóm chính dựa trên mục đích sử dụng (GoF - Gang of Four):

### 🏗️ Creational Patterns (Khởi tạo)
Tập trung vào cách tạo đối tượng một cách linh hoạt, giấu đi logic khởi tạo phức tạp.

- [Abstract Factory](abstract-factory-pattern): Tạo ra các họ đối tượng liên quan mà không cần chỉ định class cụ thể.
- [Builder](builder-pattern): Lắp ráp đối tượng phức tạp qua từng bước.
- [Dependency Injection](dependency-injection-pattern): Tiêm phụ thuộc giúp tách biệt code và dễ kiểm thử.
- [Factory](factory-pattern): Giấu logic khởi tạo đối tượng.
- [Factory Method](factory-method-pattern): Ủy quyền việc tạo đối tượng cho các lớp con.
- [Prototype](prototype-pattern): Nhân bản đối tượng bằng cơ chế clone.
- [Service Locator](service-locator-pattern): Trung tâm điều phối và lấy dịch vụ khi cần.
- [Singleton](singleton-pattern): Đảm bảo một Class chỉ có duy nhất một thực thể.

### 🧱 Structural Patterns (Cấu trúc)
Tổ chức mối quan hệ giữa các class/object để tạo ra cấu trúc hệ thống linh hoạt.

- [Adapter](adapter-pattern): Bộ chuyển đổi Interface không tương thích.
- [Active Record](active-record-pattern): Linh hồn của Eloquent (Dữ liệu & Hành vi trong 1 class).
- [Bridge](bridge-pattern): Tách biệt cấu trúc trừu tượng và triển khai.
- [Composite](composite-pattern): Xử lý cấu trúc cây (Menu, Filesystem).
- [Data Mapper](data-mapper-pattern): Tách biệt hoàn toàn tầng dữ liệu và nghiệp vụ.
- [Decorator](decorator-pattern): Thêm hành vi mới mà không dùng kế thừa.
- [DTO](dto-pattern): Chuẩn hóa luồng dữ liệu giữa các tầng.
- [Facade](facade-pattern): Giao diện đơn giản hóa cho hệ thống phức tạp.
- [Flyweight](flyweight-pattern): Tối ưu bộ nhớ bằng cách chia sẻ dữ liệu chung.
- [Proxy](proxy-pattern): Người đại diện kiểm soát truy cập đối tượng.
- [Repository](repository-pattern): Lớp đệm truy xuất dữ liệu.
- [Value Object](value-object-pattern): Đóng gói dữ liệu nhỏ với tính bất biến.

### 🔄 Behavioral Patterns (Hành vi)
Quản lý giao tiếp và luồng xử lý giữa các đối tượng.

- [Chain of Responsibility](chain-of-responsibility-pattern): Truyền yêu cầu qua chuỗi xử lý (Middleware).
- [Command](command-pattern): Đóng gói yêu cầu thành đối tượng (Artisan, Job Queue).
- [Iterator](iterator-pattern): Duyệt tập hợp dữ liệu chuyên nghiệp (Collection).
- [Mediator](mediator-pattern): Trạm trung chuyển thông tin (Event Dispatcher).
- [Memento](memento-pattern): Cỗ máy thời gian (Undo/Redo).
- [Null Object](null-object-pattern): Loại bỏ logic kiểm tra null rườm rà.
- [Observer](observer-pattern): Theo dõi thay đổi (Events & Listeners).
- [State](state-pattern): Quản lý trạng thái đối tượng.
- [Strategy](strategy-pattern): Thay đổi thuật toán runtime.
- [Template Method](template-method-pattern): Khung xương quy trình (Base classes).
- [Unit of Work](unit-of-work-pattern): Quản lý giao dịch tập trung (Database Transactions).
- [Visitor](visitor-pattern): Tách biệt thuật toán khỏi cấu trúc dữ liệu.

---
*Lưu ý: Đừng quá lạm dụng Design Pattern. Hãy ưu tiên sự đơn giản, rõ ràng và khả năng bảo trì (maintainability) trước khi nghĩ đến việc áp dụng các mẫu phức tạp.*
