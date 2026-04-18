---
title: "Branch by Abstraction: Thay thế hệ thống trong khi đang chạy"
excerpt: Cách thay thế một module cũ bằng module mới trong một hệ thống đang live mà không làm gián đoạn người dùng.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-branch-by-abstraction.webp
tags: [architecture, refactoring, legacy-code]
---

## 1. Bài toán

Bạn cần thay thế hoàn toàn hệ thống Payment Gateway cũ (rất tệ) bằng một hệ thống mới. Bạn không thể "ngừng" hệ thống để deploy bản rewrite trong 1 tuần.

## 2. Giải pháp: Branch by Abstraction

1. **Tạo Interface:** Tạo một `PaymentInterface`.
2. **Abstract:** Cho `OldPaymentGateway` implement interface này.
3. **Switch:** Trong `ServiceProvider`, đổi từ `OldPaymentGateway` sang `NewPaymentGateway`.
4. **Clean:** Sau khi test hệ thống mới ổn định, xóa bỏ `OldPaymentGateway` khỏi codebase.

## 3. Lợi ích

- **Không bao giờ "đứt gãy" (Zero downtime):** Hệ thống luôn chạy được trong suốt quá trình chuyển đổi.
- **Dễ rollback:** Nếu hệ thống mới lỗi, chỉ cần đổi lại binding trong `ServiceProvider`.

## 4. Phỏng vấn Senior

**Q: Sự khác biệt với Strategy Pattern?**
**A:** Cả hai đều dùng đa hình. Nhưng **Branch by Abstraction** là chiến lược (strategy) dùng cho refactoring một hệ thống cũ, còn **Strategy Pattern** là một design pattern để quản lý logic linh hoạt.
