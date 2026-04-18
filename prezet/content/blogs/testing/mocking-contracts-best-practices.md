---
title: "Mocking & Contracts: Test code phức tạp mà không 'gãy'"
excerpt: Cách sử dụng Laravel Contracts và Mocking để test các dịch vụ ngoại vi mà không cần gọi API thật.
date: 2026-04-18
category: Testing
image: /prezet/img/ogimages/blogs-testing-mocking-contracts-best-practices.webp
tags: [testing, mocking, contracts, dependency-injection]
---

## 1. Vấn đề: "Test bị dính" (Brittle Test)

Nếu test của bạn gọi `Stripe` thật mỗi lần chạy, test sẽ rất chậm và dễ fail do network.

## 2. Giải pháp: Mocking qua Interface (Contracts)

- **Bước 1:** Định nghĩa Interface: `PaymentGatewayInterface`.
- **Bước 2:** Inject Interface vào Controller/Service.
- **Bước 3:** Trong test, dùng `$this->mock(PaymentGatewayInterface::class, fn($mock) => $mock->shouldReceive('pay')->once())`.

## 3. Kinh nghiệm "xương máu"

- **Đừng Mock tất cả:** Chỉ Mock các thứ bên ngoài (API bên thứ 3, Filesystem, Mail). Mock chính Service của mình sẽ làm test trở nên vô nghĩa (test không kiểm tra logic thật).
- **Test hành vi, đừng test implementation:** Đừng test xem hàm A có gọi hàm B không, hãy test xem kết quả cuối cùng có đúng không.

## 4. Câu hỏi nhanh

**Q: "Over-mocking" là gì?**
**A:** Là tình trạng bạn mock quá nhiều trong unit test, khiến cho unit test pass nhưng khi chạy thật thì vẫn lỗi. Đó là khi test chỉ test các "giả định" của bạn thay vì test code thật.
