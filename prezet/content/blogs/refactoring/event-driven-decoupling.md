---
title: "Refactor bằng Event: Xóa bỏ sự phụ thuộc chéo"
excerpt: Kỹ thuật biến các logic 'dính chặt' thành các sự kiện rời rạc để tăng tính linh hoạt.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-event-driven-decoupling.webp
tags: [refactoring, event-driven, decoupling, laravel]
---

## 1. Bài toán

Trong `OrderController`, bạn có: `SendEmail`, `UpdateStock`, `SyncCRM`, `NotifyMarketing`. Controller quá béo, không thể test nổi vì phụ thuộc vào quá nhiều service.

## 2. Giải pháp

Chỉ giữ lại việc lưu Order vào DB. Sau đó bắn Event: `OrderPlaced`.

- `SendEmailListener` lắng nghe `OrderPlaced`.
- `UpdateStockListener` lắng nghe `OrderPlaced`.
- Các service này hoàn toàn không biết gì về nhau.

## 3. Lợi ích

- **Tính mở rộng:** Muốn thêm tác vụ "Gửi SMS", chỉ cần viết 1 `SmsListener` mới. Không cần sửa 1 dòng code trong `OrderController`.
- **Unit Test:** Bạn test độc lập `OrderController` (không cần mock Mail, CRM...).

## 4. Phỏng vấn

**Q: "Event có làm hệ thống khó theo dõi dòng chảy dữ liệu không?"**
**A:** Có. Event-driven khiến việc trace code khó hơn. **Lời khuyên:** Luôn có bảng tài liệu (Documentation) hoặc dùng công cụ visualize event để team biết ai đang nghe sự kiện nào.
