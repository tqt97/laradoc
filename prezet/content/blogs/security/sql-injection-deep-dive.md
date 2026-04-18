---
title: "SQL Injection Deep Dive: Hacker đã tấn công Database của bạn như thế nào?"
excerpt: Đi sâu vào các kỹ thuật tấn công SQL Injection phổ biến, giải mã cách hacker bypass các lớp bảo mật cơ bản và cách bảo vệ ứng dụng Laravel một cách tuyệt đối.
date: 2026-04-18
category: Security
image: /prezet/img/ogimages/blogs-security-sql-injection-deep-dive.webp
tags: [security, hacking, sql-injection, laravel, database-security, owasp]
---

Dù đã xuất hiện hàng chục năm, **SQL Injection (SQLi)** vẫn luôn nằm trong Top 10 rủi ro bảo mật web của OWASP. Nhiều lập trình viên tự tin rằng: "Tôi dùng Eloquent/ORM nên tôi an toàn". Thực tế, hacker có những cách bypass cực kỳ tinh vi nếu bạn không hiểu rõ bản chất.

## 1. Bản chất của SQL Injection

SQLi xảy ra khi ứng dụng của bạn trộn lẫn giữa **Dữ liệu (Data)** và **Câu lệnh (Command)**.
Ví dụ: `$sql = "SELECT * FROM users WHERE email = '" . $email . "'";`
Hacker không nhập email, mà nhập: `' OR '1'='1`.
Câu lệnh trở thành: `SELECT * FROM users WHERE email = '' OR '1'='1'`.
**Hậu quả:** Toàn bộ bảng users bị lộ mà không cần mật khẩu.

## 2. Các kỹ thuật tấn công phổ biến

- **Union-based SQLi:** Dùng lệnh `UNION` để gộp kết quả từ bảng khác vào kết quả trả về. Hacker có thể dùng cách này để đọc bảng `passwords` hoặc `config`.
- **Error-based SQLi:** Hacker cố tình nhập sai để ứng dụng hiện lỗi Database ra màn hình. Lỗi này thường chứa thông tin về cấu trúc bảng, tên cột.
- **Blind SQLi (Mù):** Nguy hiểm nhất. Hacker không thấy kết quả trực tiếp, họ hỏi các câu hỏi Yes/No qua hàm `sleep()`. Nếu server phản hồi chậm 5s, họ biết câu trả lời là Yes. Cứ thế, họ dò từng ký tự mật khẩu của admin.

## 3. Lỗ hổng tiềm ẩn trong Laravel

Đúng, Eloquent mặc định dùng **Prepared Statements** nên rất an toàn. Nhưng hãy cẩn thận với:

- **`whereRaw()` hoặc `orderByRaw()`:** Nếu bạn nối chuỗi input vào đây, bạn đang mở toang cửa cho hacker.

```php
// CỰC KỲ NGUY HIỂM
User::whereRaw("id = $id")->get();

// AN TOÀN
User::whereRaw("id = ?", [$id])->get();
```

- **Validation:** Đừng bao giờ tin tưởng dữ liệu từ Request. Luôn luôn sử dụng `request()->validate()`.

## 4. Quizz cho phỏng vấn Senior

**Câu hỏi:** Tại sao Prepared Statements (PDO Parameter Binding) lại có thể ngăn chặn hoàn toàn SQL Injection?

**Trả lời:**
Vì Prepared Statements tách biệt quá trình **Biên dịch câu lệnh** và **Truyền dữ liệu**.

1. Đầu tiên, Database nhận câu lệnh mẫu: `SELECT * FROM users WHERE email = ?`. Nó biên dịch và chuẩn bị sẵn kế hoạch thực thi (Execution Plan).
2. Sau đó, dữ liệu mới được gửi xuống. Database coi toàn bộ dữ liệu này là **Literal String (chuỗi thuần)**. Dù hacker có nhập `' OR '1'='1`, Database cũng chỉ tìm kiếm một user có email đúng bằng chuỗi ký tự đó, chứ không thực thi nó như một phần của câu lệnh SQL.

## 5. Kết luận

Bảo mật là một quá trình "Defense in Depth" (Phòng thủ đa tầng). Ngoài việc dùng ORM, hãy:

- Tắt hiển thị lỗi DB trên Production (`APP_DEBUG=false`).
- Phân quyền User Database tối thiểu (không dùng quyền `root` cho Web App).
- Sử dụng WAF (Web Application Firewall).
