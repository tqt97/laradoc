---
title: "Xử lý Race Condition trong hệ thống thanh toán: Từ lý thuyết đến thực chiến"
excerpt: Chia sẻ kinh nghiệm xương máu về lỗi trùng lặp giao dịch (Race Condition), phân tích các kỹ thuật Locking trong Database và cách sử dụng Redis Distributed Lock để bảo vệ hệ thống.
date: 2026-04-18
category: Kinh nghiệm
image: /prezet/img/ogimages/blogs-experience-race-condition-thanh-toan.webp
tags: [race-condition, database, locking, payment-system, concurrency, redis]
---

Trong một dự án Fintech tôi từng tham gia, chúng tôi đã gặp một bug "triệu đô": Người dùng nhấn nút "Thanh toán" 2 lần cực nhanh, và hệ thống trừ tiền... 2 lần. Chào mừng bạn đến với thế giới của **Race Condition** - lỗi logic phát sinh khi nhiều tiến trình cùng thao tác trên một dữ liệu dùng chung tại cùng một thời điểm.

## 1. Nguyên nhân gốc rễ: "Check-then-Act" Anti-pattern

Hãy tưởng tượng luồng xử lý rút tiền:

1. **Check:** Đọc số dư từ DB (`Balance = 100k`).
2. **Validate:** Kiểm tra nếu `Balance >= 50k` (OK).
3. **Act:** Tính toán số dư mới (`100k - 50k = 50k`).
4. **Persist:** Lưu `50k` vào DB.

Nếu 2 request đến cùng lúc:

- Request 1 đọc DB: 100k.
- Request 2 đọc DB: 100k (vì Request 1 chưa lưu).
- Cả 2 đều thấy 100k >= 50k -> Cả 2 đều trừ tiền và lưu 50k.
**Hậu quả:** Khách hàng rút 100k nhưng số dư chỉ bị trừ 50k (hoặc ngược lại tùy logic).

## 2. Giải pháp 1: Pessimistic Locking (Khóa bi quan)

Dùng lệnh `SELECT FOR UPDATE` trong SQL. Khi Request 1 đang đọc, nó sẽ "khóa" hàng đó lại, Request 2 phải ĐỢI cho đến khi Request 1 kết thúc transaction.

```php
// Laravel code
DB::transaction(function () {
    $wallet = DB::table('wallets')
        ->where('user_id', 1)
        ->lockForUpdate() // Kích hoạt SELECT FOR UPDATE
        ->first();

    if ($wallet->balance >= 50000) {
        DB::table('wallets')
            ->where('user_id', 1)
            ->decrement('balance', 50000);
    }
});
```

- **Ưu điểm:** An toàn tuyệt đối ở mức Database.
- **Nhược điểm:** Dễ gây nghẽn cổ chai (bottleneck) nếu hàng bị khóa quá lâu hoặc có quá nhiều request tranh chấp.

## 3. Giải pháp 2: Optimistic Locking (Khóa lạc quan)

Thêm cột `version` hoặc `timestamp` vào bảng. Chúng ta không dùng khóa, mà chỉ kiểm tra xem dữ liệu có bị ai khác sửa mất trong lúc mình đang tính toán không.

```sql
-- Câu lệnh SQL thực tế
UPDATE wallets 
SET balance = 50000, version = version + 1 
WHERE id = 1 AND version = 5; -- 5 là version lúc chúng ta vừa đọc ra
```

Nếu `UPDATE` trả về 0 hàng bị ảnh hưởng -> Nghĩa là có ai đó đã nhanh tay sửa trước -> Báo lỗi hoặc thử lại (Retry).

## 4. Giải pháp 3: Redis Distributed Lock (Khóa phân tán)

Khi hệ thống chạy trên nhiều server, Database Locking đôi khi là chưa đủ. Chúng ta dùng Redis để tạo một "chiếc chìa khóa" chung.

```php
use Illuminate\Support\Facades\Redis;

$lockKey = "lock_user_1";
$lock = Redis::set($lockKey, true, 'NX', 'EX', 10); // NX: Chỉ set nếu chưa có, EX: Hết hạn sau 10s

if ($lock) {
    try {
        // Xử lý thanh toán tại đây
    } finally {
        Redis::del($lockKey); // Luôn luôn giải phóng khóa
    }
} else {
    return response()->json(['message' => 'Giao dịch đang được xử lý...'], 429);
}
```

## 5. Quizz cho phỏng vấn Senior

**Câu hỏi:** Tại sao chúng ta cần thời gian hết hạn (TTL/Expiration) cho khóa trong Redis (`EX 10` ở ví dụ trên)?

**Trả lời:**
Để phòng trường hợp **Server bị sập đột ngột** ngay sau khi vừa chiếm được khóa nhưng chưa kịp chạy đến dòng `Redis::del()`. Nếu không có thời gian hết hạn, khóa đó sẽ tồn tại vĩnh viễn trong Redis, và người dùng đó sẽ không bao giờ thực hiện được giao dịch nữa (Deadlock). 10 giây là khoảng thời gian "an toàn" đủ để code xử lý xong nhưng cũng đủ ngắn để hệ thống tự hồi phục.

## 6. Kết luận

Race Condition không chỉ là vấn đề kỹ thuật, nó là vấn đề về **tư duy phòng thủ**. Với các hệ thống tài chính, hãy luôn ưu tiên sự nhất quán (Consistency) hơn là tốc độ (Availability).
