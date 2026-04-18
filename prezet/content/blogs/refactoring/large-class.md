---
title: "Refactor: Large Class (God Object)"
excerpt: Khi class của bạn quá lớn, ôm đồm quá nhiều chức năng. Kỹ thuật tách class theo nguyên lý Single Responsibility.
date: 2026-04-18
category: Refactoring
image: /prezet/img/ogimages/blogs-refactoring-large-class.webp
tags: [refactoring, solid, clean-code]
---

## 1. Dấu hiệu (Smell)

Một class có quá nhiều phương thức (hàng chục, hàng trăm) và quá nhiều biến thành viên (fields). Bạn không biết bắt đầu từ đâu khi cần fix bug.

## 2. Giải pháp: Decomposition

- **Extract Class:** Tạo class mới cho các nhóm logic liên quan.
- **Extract Subclass:** Nếu class lớn có một nhóm phương thức chỉ dùng cho một trường hợp cụ thể, hãy tách nó ra lớp con.
- **Extract Interface:** Nếu class lớn đang làm nhiệm vụ "điều phối" (orchestrator), hãy tạo interface để các class nhỏ hơn có thể inject vào mà không phụ thuộc trực tiếp.

## 3. Tư duy Architect

- **Phân tách trách nhiệm:** Tách dữ liệu khỏi hành vi, tách logic tính toán khỏi logic lưu trữ.
- **Kinh nghiệm:** Một class "vừa vặn" thường nằm trong khoảng 100-200 dòng. Vượt quá mức này là lúc bạn nên cân nhắc tách (tuy nhiên, đừng tách một cách máy móc, hãy tách theo ngữ nghĩa).

## 4. Câu hỏi nhanh

**Q: "Làm sao để refactor class mà không làm mất tính đóng gói?"**
**A:** Hãy dùng `Composition` thay vì kế thừa. Đưa các class nhỏ vào class lớn như là các thuộc tính (dependencies), và ủy quyền (delegate) hành động cho chúng.
