---
title: "Nguyên lý SOLID: Từ Lý thuyết đến Tư duy Architect"
excerpt: Khám phá lại 5 nguyên lý SOLID dưới góc nhìn của một Senior Developer, kèm theo các câu hỏi phỏng vấn hóc búa để kiểm tra tư duy thiết kế hệ thống.
date: 2026-04-18
image: /prezet/img/ogimages/blogs-architecture-solid-principles-revisited.webp
tags: [solid, design-principles, architecture, oop, clean-code, interview]
category: Architecture
---

SOLID là bộ 5 nguyên lý thiết kế hướng đối tượng giúp code của bạn linh hoạt, dễ hiểu và dễ bảo trì. Với một Junior, SOLID là định nghĩa. Với một Senior, SOLID là bản năng khi cầm phím.

## 1. S - Single Responsibility (Đơn trách nhiệm)

**Định nghĩa:** Một class chỉ nên có một lý do duy nhất để thay đổi.
**Tư duy Senior:** Đừng nhầm lẫn "trách nhiệm" với "hành động". Một class `UserRepository` có thể có nhiều hàm (save, find, delete) nhưng nó chỉ có một trách nhiệm duy nhất là **Giao tiếp với bảng Users trong Database**. Nếu bạn thêm hàm `sendWelcomeEmail` vào đây, bạn đã vi phạm SRP.

## 2. O - Open/Closed (Mở để mở rộng, Đóng để sửa đổi)

**Định nghĩa:** Bạn có thể thêm tính năng mới cho class mà không cần sửa code cũ của nó.
**Tư duy Senior:** Chìa khóa ở đây là **Interface** và **Polymorphism**. Nếu bạn phải dùng `if ($type == 'A')` để thêm loại xử lý mới, bạn đã vi phạm. Hãy dùng Strategy Pattern.

## 3. L - Liskov Substitution (Thay thế Liskov)

**Định nghĩa:** Class con phải có thể thay thế class cha mà không làm hỏng ứng dụng.
**Tư duy Senior:** Đây là nguyên lý khó hiểu nhất. Ví dụ điển hình: Chim cánh cụt kế thừa lớp Chim. Nếu lớp Chim có hàm `bay()`, chim cánh cụt sẽ ném ra lỗi. Điều này vi phạm Liskov. Giải pháp: Tách nhỏ Interface (ChimBiếtBay và ChimBiếtBơi).

## 4. I - Interface Segregation (Tách biệt Interface)

**Định nghĩa:** Đừng ép class phải implement những hàm mà nó không dùng tới.
**Tư duy Senior:** Thà tạo ra 10 Interface nhỏ còn hơn 1 Interface khổng lồ. Điều này giúp giảm tính phụ thuộc (Coupling) và giúp code linh hoạt hơn khi cần Mock để test.

## 5. D - Dependency Inversion (Đảo ngược phụ thuộc)

**Định nghĩa:** Class cấp cao không nên phụ thuộc vào class cấp thấp. Cả hai nên phụ thuộc vào Abstraction (Interface).
**Tư duy Senior:** Đây là nền tảng của **Dependency Injection**. Đừng gõ `new MySQLDatabase()` bên trong Controller. Hãy inject `DatabaseInterface`. Bạn sẽ dễ dàng đổi sang `PostgreSQL` hoặc `In-memory Database` để test mà không cần chạm vào một dòng code Controller nào.

## 6.Câu hỏi nhanh/Architect

<details>
<summary><b>Q1: Sự khác biệt bản chất giữa "Dependency Injection" và "Dependency Inversion" là gì?</b></summary>

**Trả lời:**

- **Dependency Inversion** là một **Nguyên lý** (Principle): Nó định hướng cách bạn tổ chức sự phụ thuộc (High-level trỏ vào Interface, Low-level cũng trỏ vào Interface).
- **Dependency Injection** là một **Kỹ thuật** (Pattern): Nó là cách cụ thể để thực hiện nguyên lý trên (truyền object vào constructor hoặc setter).
*Tóm lại:* Bạn dùng DI để đạt được mục tiêu của DIP.

</details>

<details>
<summary><b>Q2: Nếu áp dụng SOLID một cách máy móc, hệ thống sẽ gặp vấn đề gì?</b></summary>

**Trả lời:**
Vấn đề lớn nhất là **Over-engineering (Thiết kế quá mức)**. Việc tách quá nhiều class, interface nhỏ sẽ làm tăng số lượng file, tăng độ phức tạp của luồng dữ liệu và khiến người mới cực kỳ khó nắm bắt hệ thống. Architect giỏi là người biết khi nào nên "phá luật" để giữ cho hệ thống đơn giản và thực dụng (Pragmatic).
</details>

<details>
<summary><b>Q3: Nguyên lý nào trong SOLID trực tiếp hỗ trợ việc viết Unit Test tốt nhất?</b></summary>

**Trả lời:**
Đó là **Dependency Inversion (D)** và **Interface Segregation (I)**. Nhờ D, bạn có thể dễ dàng thay thế các service thật (như API thanh toán) bằng Mock Object. Nhờ I, bạn chỉ cần giả lập những hàm thực sự cần thiết cho test case đó, giúp test code ngắn gọn và tập trung.
</details>

## 7. Kết luận

SOLID không phải là những luật lệ cứng nhắc, nó là kim chỉ nam. Mục tiêu cuối cùng của SOLID không phải là tạo ra những đoạn code "đẹp mắt", mà là tạo ra những hệ thống **Rẻ để thay đổi**.
