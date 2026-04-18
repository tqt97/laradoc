---
title: "Repository Pattern: Khi nào nên dùng, khi nào nên bỏ?"
excerpt: Tìm hiểu về Repository Pattern trong Laravel, cách nó tạo ra lớp trừu tượng cho tầng dữ liệu và những tranh cãi về việc lạm dụng pattern này trong các dự án nhỏ.
date: 2026-04-18
category: Design pattern
image: /prezet/img/ogimages/blogs-design-pattern-repository-pattern-best-practices.webp
tags: [design-patterns, php, laravel, database, clean-code, architecture]
---

**Repository Pattern** là một trong những pattern phổ biến nhất trong cộng đồng Laravel. Nó đóng vai trò là một lớp trung gian (Mediator) giữa tầng nghiệp vụ (Domain) và tầng truy cập dữ liệu (Data Source).

## 1. Tại sao phải dùng Repository?

Hãy tưởng tượng bạn có 5 Controller khác nhau đều cần lấy "Top 10 bài viết mới nhất". Nếu bạn viết `Post::latest()->take(10)->get()` ở cả 5 nơi, khi bạn muốn đổi sang lấy "Top 20", bạn phải sửa ở 5 file.
**Repository** giải quyết vấn đề này bằng cách tập trung logic truy vấn vào một nơi duy nhất.

## 2. Cấu trúc chuẩn của một Repository

Một triển khai tốt thường đi kèm với **Interface**:

1. `UserRepositoryInterface`: Định nghĩa các phương thức (ví dụ: `getActiveUsers()`).
2. `EloquentUserRepository`: Triển khai interface đó bằng Eloquent.
3. `Service/Controller`: Chỉ gọi thông qua Interface.

```php
interface UserRepositoryInterface {
    public function all();
}

class EloquentUserRepository implements UserRepositoryInterface {
    public function all() {
        return User::all();
    }
}
```

## 3. Lợi ích vượt trội

- **Dễ Unit Test:** Bạn có thể dễ dàng tạo một `MockUserRepository` trả về dữ liệu mẫu mà không cần chạm vào Database thật.
- **Thay đổi Data Source linh hoạt:** Nếu ngày mai bạn muốn lấy User từ một API bên thứ 3 thay vì Database, bạn chỉ cần tạo class mới implement interface đó mà không phải sửa code ở Controller.

## 4.Câu hỏi nhanh

**Câu hỏi:** Tại sao nhiều chuyên gia lại cho rằng việc sử dụng Repository Pattern với Eloquent là một sự lãng phí (Redundant)?

**Trả lời:**
Vì bản thân **Eloquent đã là một implementation của Active Record Pattern**, nó vốn dĩ đã cung cấp một lớp trừu tượng rất mạnh mẽ cho Database.

- Nếu bạn chỉ viết `public function find($id) { return Post::find($id); }` trong Repository, bạn đang lặp lại chính xác những gì Eloquent đã làm.
- **Giải pháp Senior:** Chỉ nên dùng Repository khi:
  1. Logic truy vấn cực kỳ phức tạp (phối hợp nhiều bảng, cache phức tạp).
  2. Bạn thực sự có ý định đổi Database Engine trong tương lai (rất hiếm).
  3. Dự án áp dụng **Domain-Driven Design (DDD)** và muốn tách biệt hoàn toàn Domain khỏi Persistence layer.

**Câu hỏi mẹo:** Làm thế nào để giải quyết vấn đề "N+1 Query" khi sử dụng Repository?
**Trả lời:** Repository nên cung cấp các tham số để nạp quan hệ (Eager Loading). Ví dụ: `public function getAll($with = [])`. Điều này giúp lớp gọi (Controller) có thể quyết định nạp những quan hệ nào cần thiết mà không làm hỏng tính đóng gói của Repository.

## 5. Kết luận

Đừng dùng Repository chỉ vì "mọi người đều dùng". Hãy dùng nó khi bạn thực sự cần sự tách biệt và khả năng kiểm thử cao. Với các dự án nhỏ, **Query Scopes** của Eloquent thường là giải pháp gọn nhẹ và hiệu quả hơn.
