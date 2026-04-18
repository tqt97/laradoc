---
title: "CQRS & Event Sourcing: Cặp đôi quyền năng cho Hệ thống phức tạp"
excerpt: Tìm hiểu về mẫu thiết kế CQRS và Event Sourcing, cách chúng giải quyết vấn đề về hiệu năng và khả năng truy vết (audit) trong các hệ thống quy mô lớn.
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-cqrs-event-sourcing.webp
tags: [architecture, cqrs, event-sourcing, system-design, scalability, audit-log]
---

Khi hệ thống của bạn lớn dần, Database thường trở thành nút thắt cổ chai. Một câu Query thống kê phức tạp có thể làm nghẽn toàn bộ luồng Đặt hàng. **CQRS** và **Event Sourcing** là hai mẫu thiết kế sinh ra để giải quyết triệt để vấn đề này.

## 1. CQRS là gì? (Command Query Responsibility Segregation)

CQRS đề xuất việc tách biệt hoàn toàn logic **Ghi (Command)** và logic **Đọc (Query)** của ứng dụng.

- **Command Side:** Chịu trách nhiệm thực hiện các hành động làm thay đổi trạng thái (Tạo, Sửa, Xóa). Nó tập trung vào tính đúng đắn của nghiệp vụ (Business Rules).
- **Query Side:** Chịu trách nhiệm lấy dữ liệu để hiển thị. Nó tập trung vào tốc độ.

**Tại sao lại cần tách?** Vì nhu cầu của Đọc và Ghi thường khác nhau. Bạn có thể dùng MySQL để Ghi nhưng dùng Elasticsearch hoặc Redis để Đọc nhằm đạt hiệu năng tối đa.

## 2. Event Sourcing là gì?

Thay vì chỉ lưu trạng thái cuối cùng của một đối tượng (ví dụ: Số dư hiện tại = 100k), Event Sourcing lưu trữ **mọi thay đổi** dưới dạng một chuỗi các sự kiện (Events):

1. User nạp 50k.
2. User nạp 100k.
3. User tiêu 50k.

**Lợi ích:**

- **Audit Log tuyệt đối:** Bạn biết chính xác tại sao số dư lại là 100k.
- **Time Travel:** Bạn có thể khôi phục trạng thái hệ thống tại bất kỳ thời điểm nào trong quá khứ bằng cách "diễn lại" (replay) các sự kiện.

## 3. Sự kết hợp hoàn hảo

CQRS và Event Sourcing thường đi đôi với nhau:

1. Khi có một Command (User tiêu tiền), Event sẽ được lưu vào **Event Store**.
2. Một tiến trình ngầm (Worker) lắng nghe Event này và cập nhật dữ liệu vào **Read Database** (ví dụ mảng phẳng trong MySQL hoặc NoSQL).
3. Ứng dụng chỉ việc Query từ Read Database để hiển thị cho người dùng cực nhanh.

## 4. Quizz cho phỏng vấn Senior

**Câu hỏi:** Nhược điểm lớn nhất của sự kết hợp CQRS + Event Sourcing là gì?

**Trả lời:**
Đó là **Sự phức tạp (Complexity)** và **Tính nhất quán sau cùng (Eventual Consistency)**.

- **Phức tạp:** Bạn phải duy trì 2 Database, hệ thống Message Queue và logic đồng bộ dữ liệu. Đòi hỏi trình độ team rất cao.
- **Nhất quán sau cùng:** Vì dữ liệu ở Read Database được cập nhật bất đồng bộ, có một khoảng thời gian ngắn (vài mili giây đến vài giây) người dùng vừa thực hiện hành động xong nhưng Query lại chưa thấy dữ liệu mới. Bạn phải xử lý trải nghiệm người dùng (UX) khéo léo ở bước này.

## 5. Kết luận

CQRS và Event Sourcing không phải là "viên đạn bạc". Nó cực kỳ mạnh mẽ cho các hệ thống như: Ngân hàng, E-commerce quy mô lớn, hoặc các hệ thống cần khả năng truy vết cao. Với các dự án vừa và nhỏ, hãy cân nhắc kỹ trước khi áp dụng để tránh rơi vào bẫy "Over-engineering".
