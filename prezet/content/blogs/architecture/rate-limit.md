---
title: Rate Limiting Deep Dive (Token Bucket, Sliding Window, Distributed, Redis, Lua)
excerpt: "Handbook production-level về rate limiting: thuật toán, distributed design, Redis/Lua, failure, cost, scaling, incident."
date: 2026-04-27
category: architecture
image: /prezet/img/ogimages/blogs-laravel-index.webp
tags: [ratelimit]
---

## Glossary (Thuật ngữ)

* Rate limiting: giới hạn số request trong 1 khoảng thời gian
* Throttle: giảm tốc độ
* Burst: spike ngắn hạn
* Fixed window / Sliding window / Token bucket / Leaky bucket: thuật toán
* QPS: request/giây
* Key: định danh (user/ip/api_key)
* Atomic: thao tác không bị race condition
* Clock drift: lệch thời gian giữa node

## 1. Bản chất kỹ thuật

Rate limiting = **control layer** trước khi request chạm business/DB

Mục tiêu:

* bảo vệ hệ thống (backpressure)
* fairness giữa user
* cost control

## 2. Decision Tree (chọn chiến lược)

```
if API public → bắt buộc rate limit
if cần burst → token bucket
if cần chính xác cao → sliding window
if đơn giản → fixed window
if multi-node → Redis + atomic
```

## 3. Thuật toán (Deep Dive)

#### 3.1 Fixed Window

* Đếm trong cửa sổ cố định
* Redis:

```
INCR key
EXPIRE key 60
```

* Fail: burst tại boundary (cuối window + đầu window)

#### 3.2 Sliding Window

###### 2 cách:

* Log-based (ZSET timestamp)
* Counter-based (approximate)

###### Redis ZSET (chuẩn)

```lua
-- add timestamp, remove old, count
```

Ưu: chính xác
Nhược: tốn RAM/CPU

#### 3.3 Token Bucket (khuyên dùng)

* Có capacity + refill rate
* Cho phép burst có kiểm soát

Pseudo:

```
now = time()
tokens = min(capacity, tokens + (now-last)*rate)
if tokens >= 1:
  tokens -= 1
  allow
else:
  reject
```

#### 3.4 Leaky Bucket

* Output rate cố định
* Dùng khi cần làm mượt traffic (smoothing)

## 4. So sánh & Khi nào FAIL

| Algo    | Ưu        | Nhược          | Fail khi        |
| ------- | --------- | -------------- | --------------- |
| Fixed   | đơn giản  | burst          | traffic spike   |
| Sliding | chính xác | tốn tài nguyên | QPS cao         |
| Token   | linh hoạt | phức tạp       | config sai rate |
| Leaky   | mượt      | không burst    | cần burst       |

## 5. Distributed Design (bắt buộc production)

#### Problem

* nhiều instance → counter lệch

#### Solution

* Redis làm shared state
* dùng atomic (INCR / Lua)

#### Redis + Lua (atomic)

```lua
local key = KEYS[1]
local limit = tonumber(ARGV[1])
local ttl = tonumber(ARGV[2])

local current = redis.call('INCR', key)
if current == 1 then
  redis.call('EXPIRE', key, ttl)
end

if current > limit then
  return 0
else
  return 1
end
```

👉 đảm bảo không race condition

## 6. Key Design (rất quan trọng)

```php
$key = "rate:user:$userId:api:$endpoint";
```

Variants:

* per IP
* per user
* per API key
* global

👉 combine để tránh abuse

## 7. Multi-Dimensional Limiting

| Type     | Ví dụ        |
| -------- | ------------ |
| per user | 100 req/min  |
| per IP   | 1000 req/min |
| global   | 1M req/min   |

## 8. Failure Matrix

| Failure        | Nguyên nhân | Hậu quả    | Fix            |
| -------------- | ----------- | ---------- | -------------- |
| Redis down     | infra       | mất limit  | fallback local |
| race condition | concurrent  | vượt limit | Lua            |
| clock drift    | multi node  | sai window | server time    |
| hot key        | traffic lớn | bottleneck | sharding       |

## 9. Hot Key & Sharding

```php
$key = "rate:$userId:" . ($userId % 10);
```

👉 distribute load

## 10. Backpressure Integration

Rate limit = lớp backpressure đầu tiên

Flow:

```
Client → Rate limit → Queue → DB
```

## 11. Cost Estimation

* 1 key ~ 50–100 bytes
* 1M user → ~100MB RAM

Ops:

* Redis ~100k–1M ops/sec

## 12. Scaling Strategy

| Level | Solution      |
| ----- | ------------- |
| 1     | in-memory     |
| 2     | Redis         |
| 3     | Redis cluster |
| 4     | multi-region  |

## 13. Real Scenario (100k QPS)

Assume:

* 100k req/sec
* limit 100 req/min/user

Nếu 90% bị chặn:
→ chỉ còn 10k QPS vào hệ thống

👉 giảm 10x load

## 14. Advanced Techniques

#### Dynamic Rate Limit

```php
if ($user->vip) {
    $limit = 1000;
}
```

#### Adaptive (theo load)

* CPU cao → giảm limit

#### Shadow mode

* log nhưng không block (test config)

## 15. Production Incidents

#### Case 1: Không có rate limit

→ bot spam → DB sập

#### Case 2: Limit quá thấp

→ user thật bị block

#### Case 3: Redis lag

→ allow sai

## 16. Laravel Implementation

```php
RateLimiter::for('api', function ($request) {
    return Limit::perMinute(60)->by($request->user()?->id ?: $request->ip());
});
```

## 17. Security & Abuse

* rotate IP
* fake user

👉 combine key + captcha + auth

## 18. Final Architect Insight

> Rate limiting không phải chỉ để chặn
> → mà để **bảo vệ toàn bộ hệ thống**

Trade-off:

* performance
* fairness
* user experience

## 19. Checklist Production

* [ ] Redis cluster
* [ ] Lua script atomic
* [ ] multi-level limit
* [ ] monitoring + alert
* [ ] fallback khi Redis down
