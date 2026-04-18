---
title: "Composition vs Inheritance: Khi nào nên ngừng dùng 'extends'?"
excerpt: Tại sao kế thừa (Inheritance) thường dẫn đến kiến trúc cứng nhắc và thảm họa 'Fragile Base Class'? Tìm hiểu cách thay thế bằng Composition để code linh hoạt và dễ test hơn.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-composition-over-inheritance.webp
tags: [refactoring, clean-code, design-principles, oop, solid]
---

"Inheritance is for 'is-a' relationships, Composition is for 'has-a' relationships". Đây là câu nói kinh điển, nhưng trong thực tế, ranh giới này rất mong manh. Nhiều Senior vẫn mắc bẫy khi cố gắng ép mọi thứ vào một cây kế thừa sâu hun hút.

## 1. Vấn đề của Kế thừa (The Dark Side of Inheritance)

### 1.1 Thảm họa "Fragile Base Class"

Khi bạn thay đổi một hàm nhỏ ở class cha (`BaseController`), hàng chục class con có thể bị hỏng một cách bí ẩn. Class con bị phụ thuộc quá chặt chẽ vào implementation của cha.

### 1.2 "Class Explosion"

Bạn có `User`, bạn muốn `UserCanPost`, `UserCanComment`. Nếu dùng kế thừa, bạn sẽ cần `UserCanPostAndComment`. Khi số lượng tính năng tăng lên, số lượng class con sẽ tăng theo cấp số nhân.

## 2. Giải pháp: Composition (Kết hợp)

Thay vì class con "là" một class cha, hãy để class con "chứa" một object thực hiện tính năng đó.
*Ví dụ:* Thay vì `Order extends Logger`, hãy dùng `Order` chứa một instance của `LoggerInterface`.

## 3. Lợi ích vượt trội

- **Linh hoạt tại Runtime:** Bạn có thể đổi implementation của component ngay khi ứng dụng đang chạy.
- **Dễ Unit Test:** Bạn có thể dễ dàng Mock các component được inject vào thay vì phải khởi tạo cả một cây kế thừa khổng lồ.
- **Tuân thủ SRP:** Mỗi component chỉ làm một việc duy nhất.

## 4.Câu hỏi nhanh

**Câu hỏi:** Làm thế nào để áp dụng tư duy "Composition" trong Laravel để tránh việc file `BaseController` hoặc `BaseModel` bị phình to (God Class)?

**Trả lời:**

1. **Sử dụng Traits:** Laravel cung cấp Trait như một cách để "compose" các tính năng vào class (như `SoftDeletes`, `HasApiTokens`). Tuy nhiên, lạm dụng Trait cũng có thể dẫn đến xung đột tên hàm.
2. **Sử dụng Service Classes:** Chuyển logic nghiệp vụ ra các class Service riêng biệt và inject chúng vào Controller thông qua Dependency Injection.
3. **Sử dụng Action Classes:** Mỗi class chỉ thực hiện duy nhất một hành động (ví dụ: `CreateOrderAction`). Controller chỉ việc gọi Action này.
4. **Sử dụng View Components/Composers:** Tách logic xử lý dữ liệu cho giao diện ra khỏi Controller.

**Câu hỏi mẹo:** Có bao giờ Kế thừa tốt hơn Composition không?
**Trả lời:** Có. Khi mối quan hệ thực sự là "is-a" và logic ở class cha là hoàn toàn ổn định (như các class Core của Framework: `Controller`, `Model`). Nếu bạn thấy mình đang ghi đè (override) hầu hết các hàm của cha, đó là lúc bạn nên chuyển sang Composition.

## 5. Kết luận

Hãy luôn tự hỏi: "Class này thực sự LÀ một thứ khác, hay nó chỉ CẦN tính năng của thứ đó?". Nếu là vế sau, hãy dùng Composition.
