---
title: "Refactor: Xử lý Message Chains (Chuỗi liên kết)"
excerpt: "Khi code quá phụ thuộc vào cấu trúc của các đối tượng lồng nhau (VD: $a->b()->c()->d()). Cách ẩn giấu cấu trúc nội bộ."
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-message-chains.webp
tags: [refactoring, clean-code, architecture]
---

## 1. Dấu hiệu (Smell)

Bạn thấy một đoạn code gọi chồng chéo: `$user->account->profile->address->getCity()`.

- **Vấn đề:** Nếu một ngày `profile` không còn nữa, bạn phải sửa toàn bộ code ở khắp nơi. Client (đoạn gọi code) biết quá nhiều về cấu trúc nội bộ của `User`.

## 2. Giải pháp: Hide Delegate

Thêm phương thức vào class cha để giấu đi sự phức tạp của class con.

```php
// NÊN:
public function getCity() {
    return $this->account->profile->address->city;
}
// Client chỉ cần: $user->getCity();
```

## 3. Bài học xương máu

- **Law of Demeter:** "Chỉ nói chuyện với bạn thân". Một đối tượng chỉ nên biết về đối tượng trực tiếp của nó, không nên biết về "cháu" hay "chắt".
- **Lưu ý:** Đừng lạm dụng tạo ra hàng trăm method trung gian (hàm ủy quyền) nếu class cha trở nên quá béo.

## 4. Câu hỏi nhanh

**Q: Khi nào chain là chấp nhận được?**
**A:** Khi nó là một Fluent API được thiết kế chủ đích (như Query Builder của Laravel hoặc Collection). Đó là tính năng, không phải "mùi".
