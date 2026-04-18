---
title: "Nghệ thuật Refactoring: Biến Code chạy được thành Code 'sạch' chuẩn Senior"
excerpt: Chia sẻ các kỹ thuật refactoring thực chiến để giải quyết "Code Smell", tối ưu cấu trúc bằng Design Patterns và giảm nợ kỹ thuật trong dự án lớn.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-clean-code-thuc-chien.webp
tags: [clean-code, refactoring, architecture, design-patterns, solid, maintainability]
---

Trong sự nghiệp của một lập trình viên, viết code cho máy hiểu thì dễ, viết code cho con người hiểu mới là thử thách thực sự. Bài viết này không bàn về lý thuyết suông, mà tập trung vào các kỹ thuật **Refactoring thực chiến** để giải quyết những "mùi" khó chịu nhất của code.

## 1. Nhận diện các "mùi" của Code (Code Smells)

Trước khi bắt tay vào sửa, bạn phải biết code đang "hôi" ở đâu:

- **Shotgun Surgery:** Đây là ác mộng khi bạn chỉ muốn sửa 1 logic nhỏ (ví dụ: đổi định dạng ngày tháng) nhưng lại phải mở ra và sửa ở 20 file khác nhau. Điều này chứng tỏ logic của bạn đang bị phân tán quá mức.
- **Feature Envy:** Khi một hàm trong class A lại "thèm khát" dữ liệu của class B, nó liên tục gọi các hàm getter của class B để tính toán. Điều này vi phạm tính đóng gói. Logic tính toán dựa trên dữ liệu của B **nên nằm ở trong B**.
- **Primitive Obsession:** Bạn dùng mảng `['id' => 1, 'name' => 'John']` khắp nơi thay vì tạo một Data Object (`UserDTO`). Khi cấu trúc mảng thay đổi, toàn bộ code của bạn sẽ sụp đổ.

## 2. Các kỹ thuật "Phẫu thuật" (Surgical Refactoring)

### 2.1 Replace Conditional with Polymorphism (Dùng Đa hình thay thế If/Else)

Nếu bạn thấy một chuỗi `switch-case` hoặc `if-else` lặp đi lặp lại dựa trên loại đối tượng:
*Thay vì:*

```php
if ($user->type == 'admin') { return 100; }
elseif ($user->type == 'member') { return 10; }
```

*Hãy dùng:*

```php
$user->getPermissions(); // Class Admin và Member sẽ tự implement hàm này
```

### 2.2 Introduce Parameter Object

Nếu hàm của bạn nhận vào 5-7 tham số (`$name, $email, $phone, $address, $city, $zip`), hãy gom chúng lại thành một object `ContactInfo`. Code sẽ ngắn gọn, dễ đọc và dễ mở rộng hơn rất nhiều.

## 3. Quy tắc "Trại hướng đạo" (Boy Scout Rule)
>
> "Luôn để lại bãi trại sạch hơn lúc bạn mới đến."

Đừng đợi đến khi có một đợt tổng refactor lớn (thường sẽ không bao giờ xảy ra). Hãy áp dụng **Surgical Refactoring**: mỗi khi bạn chạm vào một đoạn code cũ để sửa bug, hãy dành 5-10 phút để làm nó "sạch" hơn một chút.

## 4.Câu hỏi nhanh

**Câu hỏi:** Bạn được giao refactor một module core đang chạy trên Production nhưng không hề có Unit Test. Bạn sẽ làm gì để đảm bảo an toàn?

**Trả lời lý tưởng:**

1. **Tuyệt đối không sửa code ngay.**
2. Viết các **Characterization Tests** (Black-box testing): Chạy module với các input thực tế và ghi lại toàn bộ output hiện tại. Đây là bộ khung để đảm bảo sau khi sửa, module vẫn trả về kết quả như cũ.
3. Chia nhỏ module thành các phần độc lập qua kỹ thuật **Extract Method**.
4. Refactor từng phần nhỏ và chạy lại bộ test sau mỗi bước (Step-by-step refactoring).
5. Sau khi hoàn thành cấu trúc mới, bổ sung Unit Test đầy đủ để khóa hành vi của code mới.

## 5. Kết luận

Refactoring là một khoản đầu tư, không phải là chi phí. Nó giúp team đi nhanh hơn trong dài hạn và giữ cho lập trình viên luôn cảm thấy hạnh phúc khi làm việc với một codebase sạch sẽ. Hãy nhớ: **Code sạch là code dễ thay đổi.**
