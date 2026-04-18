---
title: Design Pattern là gì?
excerpt: Tìm hiểu Design Pattern là gì, cách hoạt động, sự khác biệt với thuật toán và phân loại 3 nhóm Design Pattern phổ biến trong lập trình.
date: 2026-02-27
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-index.webp
---

## 1. Design Pattern là gì?

Design Pattern (mẫu thiết kế) là các giải pháp điển hình cho những vấn đề thường xuyên xuất hiện trong quá trình thiết kế phần mềm.

Nó giống như những bản thiết kế (blueprint) có sẵn mà bạn có thể tùy chỉnh để giải quyết các vấn đề lặp đi lặp lại trong code.

Bạn không thể chỉ đơn giản copy một Design Pattern và sử dụng ngay như một hàm hay thư viện có sẵn. Bởi vì Design Pattern không phải là một đoạn code cụ thể, mà là một ý tưởng hoặc cách tiếp cận tổng quát để giải quyết một vấn đề.

> Bạn cần hiểu pattern và tự implement lại sao cho phù hợp với hệ thống của mình.

## 2. Design Pattern khác gì Algorithm?

Design Pattern thường bị nhầm với thuật toán (Algorithm), nhưng thực tế chúng khác nhau:

- **Algorithm (thuật toán):**
  - Là một chuỗi các bước rõ ràng để giải quyết một bài toán
  - Có thể implement trực tiếp
Ví dụ: QuickSort, Binary Search

- **Design Pattern:**
  - Là mô tả ở mức cao (high-level)
  - Không có code cố định
  - Áp dụng linh hoạt tùy vào context

> **Algorithm** giống như công thức nấu ăn (có step rõ ràng). **Design Pattern** giống như bản vẽ nhà (biết kết quả, nhưng cách xây tùy bạn)

## 3. Tại sao cần Design Pattern?

- Giải quyết vấn đề đã được kiểm chứng
- Tăng khả năng maintain code
- Giúp team dễ hiểu code hơn
- Tái sử dụng tư duy thay vì copy code

## 4. Phân loại Design Pattern

**Design Pattern được chia thành 3 nhóm chính:**

| Tiêu chí      | Creational           | Structural                 | Behavioral                      |
| ------------- | -------------------- | -------------------------- | ------------------------------- |
| Mục tiêu      | Tạo object           | Tổ chức cấu trúc           | Quản lý hành vi                 |
| Focus chính   | Khởi tạo             | Quan hệ giữa class/object  | Giao tiếp & logic               |
| Độ trừu tượng | Trung bình           | Trung bình - cao           | Cao                             |
| Khi sử dụng   | Tạo object phức tạp  | Hệ thống lớn, nhiều module | Logic phức tạp, nhiều tương tác |
| Lợi ích chính | Linh hoạt tạo object | Giảm coupling              | Tách biệt logic                 |

### 4.1 Creational Patterns (Nhóm khởi tạo)

| Pattern          | Mô tả ngắn                  | Link |
| ---------------- | --------------------------- | ---- |
| Singleton        | Đảm bảo chỉ có 1 instance   | [Xem chi tiết](/blogs/design-pattern/singleton-pattern-in-laravel) |
| Factory Method   | Tạo object thông qua method | [Xem chi tiết](/blogs/design-pattern/factory-method-pattern) |
| Abstract Factory | Tạo họ object liên quan     | [Xem chi tiết](/blogs/design-pattern/abstract-factory-pattern) |
| Builder          | Xây dựng object phức tạp    | [Xem chi tiết](/blogs/design-pattern/builder-pattern-deep-dive) |
| Prototype        | Clone đối tượng linh hoạt   | [Xem chi tiết](/blogs/design-pattern/prototype-pattern) |

### 4.2 Structural Patterns (Nhóm cấu trúc)

| Pattern   | Mô tả ngắn                               | Link |
| --------- | ---------------------------------------- | ---- |
| Adapter   | Chuyển interface không tương thích       | [Xem chi tiết](/blogs/design-pattern/adapter-pattern-integration) |
| Composite | Xử lý cấu trúc cây                       | [Xem chi tiết](/blogs/design-pattern/composite-pattern) |
| Decorator | Mở rộng hành vi runtime                  | [Xem chi tiết](/blogs/design-pattern/decorator-pattern-real-world) |
| Facade    | Interface đơn giản cho hệ thống phức tạp | [Xem chi tiết](/blogs/design-pattern/facade-pattern) |
| Proxy     | Đại diện ủy quyền                         | [Xem chi tiết](/blogs/design-pattern/proxy-pattern) |

### 4.3 Behavioral Patterns (Nhóm hành vi)

| Pattern                 | Mô tả ngắn                       | Link |
| ----------------------- | -------------------------------- | ---- |
| Observer                | Lắng nghe và notify              | [Xem chi tiết](/blogs/design-pattern/observer-pattern-laravel-events) |
| Strategy                | Thay đổi thuật toán runtime      | [Xem chi tiết](/blogs/design-pattern/strategy-pattern) |
| Command                 | Đóng gói tác vụ thành đối tượng  | [Xem chi tiết](/blogs/design-pattern/command-pattern) |
| Chain of Responsibility | Chuỗi xử lý Middleware           | [Xem chi tiết](/blogs/design-pattern/chain-of-responsibility) |
| State                   | Thay đổi hành vi theo trạng thái | [Xem chi tiết](/blogs/design-pattern/state-pattern) |
| Template Method         | Định nghĩa bộ khung xử lý        | [Xem chi tiết](/blogs/design-pattern/template-method-pattern) |

## 5. Tổng kết

- Design Pattern không phải code, mà là tư duy thiết kế
- Giúp bạn viết code clean, scalable và maintainable
