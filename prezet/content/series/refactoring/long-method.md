---
title: Long Method – Khi một function trở thành “con quái vật”
excerpt: Trong quá trình code, có những method ban đầu rất nhỏ gọn, nhưng theo thời gian bị “nhồi nhét” thêm logic mà không được tách ra. Kết quả là một method dài lê thê, khó đọc, khó maintain và cực kỳ dễ bug. Đây chính là code smell Long Method – một trong những mùi code phổ biến nhất.
category: Refactoring
date: 2026-03-08
order: 3
image: /prezet/img/ogimages/series-refactoring-long-method.webp
---

> Trong quá trình code, có những method ban đầu rất nhỏ gọn, nhưng theo thời gian bị “nhồi nhét” thêm logic mà không được tách ra. Kết quả là một method dài lê thê, khó đọc, khó maintain và cực kỳ dễ bug. Đây chính là code smell **Long Method** – một trong những mùi code phổ biến nhất.

## **Long Method là gì?**

Hiểu đơn giản: một method có quá nhiều dòng code.

Không có con số tuyệt đối, nhưng nếu một method dài hơn ~10 dòng mà bạn bắt đầu thấy khó theo dõi, thì nên đặt dấu hỏi

Ví dụ dấu hiệu dễ nhận biết:

* Scroll mỏi tay vẫn chưa hết function
* Có nhiều comment giải thích từng đoạn
* Một method làm quá nhiều việc khác nhau
* Đọc xong không thể nói ngắn gọn “nó làm gì”

## **Vì sao lại xảy ra?**

Một số nguyên nhân phổ biến:

* “Thêm tí nữa thôi” → thêm 2 dòng → rồi thêm tiếp → thành cả đống
* Tâm lý ngại tạo method mới (“có 2 dòng thôi mà tách làm gì”)
* Viết code thì dễ, nhưng đọc lại thì khó → nhưng dev thường không để ý lúc viết
* Logic bị dính chặt vào nhau → càng khó tách → càng để nguyên

Kết quả: một mớ spaghetti code

## **Cách xử lý (Refactor như thế nào?)**

> Rule cực kỳ quan trọng:

Nếu bạn cần comment để giải thích một đoạn code → hãy tách nó ra thành method riêng

Một số hướng xử lý:

### Extract Method (tách method)

* Mỗi đoạn logic nên có một method riêng
* Đặt tên rõ ràng để thay cho comment

### Đặt tên có ý nghĩa

* Code tốt = đọc tên method là hiểu nó làm gì
* Ví dụ:

    ```php
    // Bad
    process()

    // Good
    calculateOrderTotal()
    validateUserInput()
    sendEmailNotification()
    ```

### Một method chỉ nên làm một việc (Single Responsibility)

* Đừng vừa validate, vừa xử lý business, vừa gọi API trong cùng 1 method

### Nhỏ nhưng rõ vẫn tốt hơn to mà rối

* Thậm chí 1–2 dòng vẫn có thể tách nếu nó cần giải thích

## **Lợi ích khi fix Long Method**

* Code dễ đọc hơn 👀
* Dễ test hơn 🧪
* Dễ reuse hơn ♻️
* Dễ maintain và scale hơn 📈

🧩 **Kết luận**

Long Method không phải lỗi cú pháp, mà là “nợ kỹ thuật”
Càng để lâu, càng khó trả.

> Viết code đừng chỉ nghĩ “chạy được là xong". Hãy nghĩ “6 tháng sau mình đọc lại có hiểu không?

Nếu câu trả lời là “không chắc” → tách method ngay 😄

👉 Ở bài tiếp theo, chúng ta sẽ bắt đầu với: [Các Case Refactor Long Method và Cách Xử Lý Hiệu Quả](/series/refactoring/refactor-long-method)
