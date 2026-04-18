---
title: "Refactor: Xử lý Shotgun Surgery"
excerpt: Làm sao để gom nhóm các thay đổi vào 1 nơi thay vì phải 'phẫu thuật' nhiều nơi mỗi khi có yêu cầu mới.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-shotgun-surgery.webp
tags: [refactoring, architecture, clean-code]
---

## 1. Dấu hiệu (Smell)

Khi bạn cần thay đổi một quy tắc nghiệp vụ (VD: Cách tính thuế), bạn phải đi sửa 10 file (Controller, Service, Resource, Model, Test...).

## 2. Cách giải quyết

- **Move Method/Field:** Gom logic liên quan về một class duy nhất.
- **Form Template Method:** Nếu các lớp con có logic trùng lặp, hãy đưa logic đó vào một class cha hoặc một class Service dùng chung.
- **Dùng DTO:** Thay vì truyền nhiều tham số qua nhiều lớp, hãy đóng gói vào một DTO duy nhất. Khi cần thêm thông tin, chỉ cần update DTO.

## 3. Bài học xương máu

"Dấu vết" của kiến trúc tốt là **tính khu trú (Locality)**: Mọi logic liên quan đến tính năng A nằm ở một chỗ. Nếu bạn thấy mình phải mở quá nhiều file cho một thay đổi đơn giản, kiến trúc của bạn đang bị tán xạ.

## 4. Câu hỏi nhanh

**Q: "Làm sao để biết mình đang bị Shotgun Surgery?"**
**A:** Khi bạn làm một task, hãy đếm số lượng file cần sửa. Nếu con số > 3, hãy dừng lại và đặt câu hỏi: "Làm sao để gom nhóm các logic này vào một nơi?".
