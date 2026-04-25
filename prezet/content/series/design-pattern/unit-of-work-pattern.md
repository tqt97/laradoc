---
title: Unit of Work - Quản lý giao dịch dữ liệu tập trung
excerpt: Tìm hiểu Unit of Work Pattern - cách đảm bảo tính toàn vẹn dữ liệu khi thực hiện nhiều thay đổi, giải mã cơ chế Database Transactions trong Laravel.
category: Design pattern
date: 2026-04-07
order: 31
image: /prezet/img/ogimages/series-design-pattern-unit-of-work-pattern.webp
---

> Pattern thuộc nhóm **Enterprise Pattern (Mẫu ứng dụng doanh nghiệp)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang xử lý một quy trình chuyển tiền:

1. Trừ tiền từ tài khoản người gửi.
2. Cộng tiền vào tài khoản người nhận.
3. Lưu lịch sử giao dịch.

**Vấn đề:**
Nếu bước 1 và 2 thành công, nhưng bước 3 thất bại (do lỗi server hoặc mất kết nối DB) → Dữ liệu sẽ bị sai lệch nghiêm trọng: tiền đã bị trừ nhưng không có dấu vết giao dịch.

**Naive Solution:** Thực hiện lưu từng Model một ngay khi thay đổi.
**Hệ quả:** Bạn tạo ra rất nhiều câu lệnh SQL gửi đến DB liên tục, và cực kỳ khó để hoàn tác (rollback) nếu một bước ở giữa bị lỗi.

## 2. Định nghĩa

**Unit of Work** duy trì một danh sách các đối tượng bị ảnh hưởng bởi một giao dịch (transaction) và điều phối việc lưu trữ các thay đổi cũng như giải quyết các vấn đề về tính đồng nhất.

**Ý tưởng cốt lõi:** Đừng lưu từng món đồ vào kho ngay lập tức. Hãy chất tất cả lên một chiếc xe đẩy (Unit of Work), và khi đã xong xuôi, đẩy xe vào kho và lưu tất cả chỉ trong **một lần duy nhất**.

## 3. Implementation (Tư duy quy trình)

Unit of Work thường có 3 nhiệm vụ chính:

1. **Register Dirty:** Ghi lại những đối tượng bị thay đổi.
2. **Register New:** Ghi lại những đối tượng được thêm mới.
3. **Commit:** Thực hiện tất cả các thay đổi vào DB trong một Database Transaction duy nhất.

```php
// Giả lập Unit of Work
class UnitOfWork {
    private array $newEntities = [];
    private array $dirtyEntities = [];

    public function commit() {
        DB::beginTransaction();
        try {
            foreach ($this->newEntities as $entity) { /* INSERT */ }
            foreach ($this->dirtyEntities as $entity) { /* UPDATE */ }
            
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }
}
```

## 4. Liên hệ Laravel

Trong Laravel, bạn thường sử dụng Unit of Work một cách trực tiếp qua **DB Transactions**:

```php
DB::transaction(function () use ($from, $to, $amount) {
    // Đây chính là một Unit of Work
    $from->decrement('balance', $amount);
    $to->increment('balance', $amount);
    Transaction::create([...]);
});
```

Nếu bất kỳ dòng code nào bên trong closure ném ra ngoại lệ (Exception), Laravel sẽ tự động `rollback` toàn bộ, trả dữ liệu về trạng thái ban đầu như chưa có chuyện gì xảy ra.

## 5. Khi nào nên dùng

* Khi một quy trình nghiệp vụ yêu cầu thay đổi nhiều Model/Bảng cùng lúc.
* Khi bạn muốn tối ưu hiệu năng bằng cách gom các câu lệnh SQL lại (Batch processing).
* Khi tính toàn vẹn dữ liệu là ưu tiên hàng đầu (Tài chính, Kho vận).

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Tính nguyên tử (Atomicity):** Tất cả cùng thành công hoặc tất cả cùng thất bại.
* **Tăng hiệu năng:** Giảm số lượng kết nối và giao dịch mở đến Database.
* **Tránh dữ liệu "mồ côi":** Đảm bảo các quan hệ dữ liệu luôn khớp nhau.

**Nhược điểm:**

* Làm tăng độ phức tạp của code xử lý.
* Nếu giao dịch quá lớn và tốn thời gian, nó có thể làm khóa (lock) các bảng trong Database, gây nghẽn hệ thống.

## 7. Câu hỏi phỏng vấn

1. **Unit of Work và Repository có quan hệ gì với nhau?** (Repository lo việc lấy và chứa đối tượng, Unit of Work lo việc quản lý các thay đổi trên các đối tượng đó và lưu vào DB).
2. **Tại sao không nên để logic Unit of Work trong Controller?** (Vì đây là logic hạ tầng và nghiệp vụ quan trọng, nên đưa vào Service hoặc dùng Transaction để đảm bảo tính tái sử dụng).
3. **Rollback trong Unit of Work là gì?** (Là hành động hủy bỏ toàn bộ các thay đổi tạm thời nếu có lỗi xảy ra, đảm bảo Database không bị lưu dữ liệu rác).

## Kết luận

Unit of Work là "người bảo vệ" sự trung thực của dữ liệu. Trong Laravel, hãy luôn sử dụng `DB::transaction()` cho các quy trình quan trọng để đảm bảo ứng dụng của bạn luôn hoạt động ổn định và tin cậy.
