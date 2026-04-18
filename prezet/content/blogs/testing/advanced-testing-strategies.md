---
title: "Advanced Testing: TDD và chiến lược Mocking thực chiến"
excerpt: Viết test cho logic nghiệp vụ phức tạp, cách Mocking các class ẩn bên trong service và tư duy TDD cho Laravel.
date: 2026-04-18
category: Testing
image: /prezet/img/ogimages/blogs-testing-advanced-testing-strategies.webp
tags: [testing, tdd, laravel, mocking, clean-code]
---

## 1. Mocking nâng cao

Đừng chỉ mock Facades. Hãy dùng **Dependency Injection** để inject Interface vào class, sau đó Mock Interface đó.

- Sử dụng `Mockery::mock()` hoặc `$this->mock()` (của Laravel) để kiểm tra các service bên thứ ba mà không cần gọi API thật.

## 2. Testing Logic phức tạp với DTO

Để test logic phức tạp:

- Đưa logic vào các **Action Classes**.
- Test Action Class như một Unit thuần túy. Dùng DTO để đảm bảo dữ liệu đầu vào luôn đúng chuẩn (Type-safety).

## 3. TDD (Test-Driven Development)

Quy trình:

1. **Red:** Viết test fail trước.
2. **Green:** Viết code tối thiểu để test pass.
3. **Refactor:** Tối ưu code mà vẫn giữ test pass.
=> Giúp bạn không bao giờ viết code thừa (YAGNI).

## 4. Quizz cho phỏng vấn

**Q: Mocking quá nhiều có hại không?**
**A:** Rất hại! Nó làm test của bạn bị "dính" (brittle). Khi refactor implementation bên trong, test fail dù logic nghiệp vụ vẫn đúng. Chỉ Mock những thứ bên ngoài (API, Mail, Queue).

**Q: Làm sao test code "xấu" (Legacy code)?**
**A:** Dùng **Characterization Testing**: Viết test cho hành vi hiện tại (dù nó sai) để ghi lại, sau đó refactor từ từ.
