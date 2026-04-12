---
title: Design Pattern là gì?
excerpt: Tìm hiểu Design Pattern là gì, cách hoạt động, sự khác biệt với thuật toán và phân loại 3 nhóm Design Pattern phổ biến trong lập trình.
date: 2026-02-27
category: Design pattern
image:
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

| Pattern          | Mô tả ngắn                  |
| ---------------- | --------------------------- |
| Singleton        | Đảm bảo chỉ có 1 instance   |
| Factory Method   | Tạo object thông qua method |
| Abstract Factory | Tạo họ object liên quan     |
| Builder          | Xây dựng object từng bước   |
| Prototype        | Clone object có sẵn         |

**Khi dùng:**

- Khi việc khởi tạo object phức tạp
- Khi cần control cách object được tạo

### 4.2 Structural Patterns (Nhóm cấu trúc)

| Pattern   | Mô tả ngắn                               |
| --------- | ---------------------------------------- |
| Adapter   | Chuyển interface không tương thích       |
| Bridge    | Tách abstraction và implementation       |
| Composite | Cấu trúc dạng cây                        |
| Decorator | Mở rộng hành vi runtime                  |
| Facade    | Interface đơn giản cho hệ thống phức tạp |
| Flyweight | Tối ưu memory                            |
| Proxy     | Đại diện cho object khác                 |

**Khi dùng:**

- Khi cần tổ chức hệ thống lớn
- Khi muốn giảm coupling giữa các module

### 4.3 Behavioral Patterns (Nhóm hành vi)

| Pattern                 | Mô tả ngắn                       |
| ----------------------- | -------------------------------- |
| Observer                | Lắng nghe và notify              |
| Strategy                | Thay đổi thuật toán runtime      |
| Command                 | Đóng gói request thành object    |
| Chain of Responsibility | Xử lý theo chuỗi                 |
| State                   | Thay đổi hành vi theo trạng thái |
| Mediator                | Trung gian giao tiếp             |
| Iterator                | Duyệt collection                 |
| Template Method         | Định nghĩa skeleton              |
| Visitor                 | Tách logic khỏi object           |

**Khi dùng:**

- Khi logic phức tạp
- Khi cần tách biệt hành vi

## 5. Tổng kết

- Design Pattern không phải code, mà là tư duy thiết kế
- Giúp bạn viết code clean, scalable và maintainable
