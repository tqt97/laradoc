---
title: Webhook System Deep Dive (Delivery Guarantee, Idempotency, Retry Storm, Scaling)
excerpt: "Handbook cấp production về webhook: delivery guarantee, retry, idempotency, ordering, failure, security, scaling và incident thực tế."
date: 2026-04-27
category: architecture
image: /prezet/img/ogimages/blogs-laravel-index.webp
tags: [webhook]
---

## Glossary (Thuật ngữ nâng cao)

* Webhook: HTTP callback khi có event
* Producer: hệ thống gửi
* Consumer: hệ thống nhận
* Delivery guarantee:

  * At-most-once: gửi tối đa 1 lần
  * At-least-once: gửi ≥1 lần (phổ biến)
  * Exactly-once: lý tưởng (gần như không khả thi)
* Idempotency: xử lý nhiều lần nhưng kết quả không đổi
* Retry storm: retry đồng loạt gây quá tải
* Ordering: thứ tự event

## 1. Bản chất hệ thống

> Webhook = distributed system communication

Không phải chỉ là HTTP request

## 2. Delivery Guarantee (Cực quan trọng)

#### Các loại

| Type          | Ý nghĩa    | Thực tế   |
| ------------- | ---------- | --------- |
| At-most-once  | gửi 1 lần  | mất event |
| At-least-once | gửi ≥1 lần | duplicate |
| Exactly-once  | lý tưởng   | rất khó   |

👉 Webhook thực tế = **at-least-once**

#### Insight

> Duplicate KHÔNG phải bug → là expected behavior

## 3. Idempotency (Deep Dive)

#### Level 1: Cache

```php
if (Cache::has($key)) return;
Cache::put($key, true, 60);
```

#### Level 2: DB Unique Constraint

```sql
UNIQUE(idempotency_key)
```

#### Level 3: Business Logic

```php
if ($order->status === 'paid') return;
```

#### Insight

> Idempotency phải enforce ở DB hoặc business level

## 4. Retry Strategy (Deep)

#### Exponential Backoff

```
1s → 5s → 10s → 30s → 60s
```

#### Retry Storm Problem

###### Scenario

* consumer down
* hàng ngàn job retry cùng lúc

👉 DDOS consumer

#### Fix

* jitter (random delay)
* rate limit retry
* circuit breaker

## 5. Failure Matrix (Nâng cao)

| Failure               | Nguyên nhân      | Hậu quả           | Fix              |
| --------------------- | ---------------- | ----------------- | ---------------- |
| duplicate             | retry            | data sai          | idempotency      |
| partial success       | crash giữa chừng | data inconsistent | transaction      |
| timeout nhưng success | network          | duplicate         | idempotency      |
| retry storm           | mass retry       | overload          | backoff + jitter |

## 6. Ordering Problem (Deep Dive)

#### Problem

Event A → B nhưng nhận B trước A

#### Giải pháp

###### 1. Versioning

```php
if ($incomingVersion < $currentVersion) return;
```

###### 2. Last-write-wins

* timestamp lớn hơn thắng

###### 3. Event sourcing

* replay toàn bộ event

## 7. Producer vs Consumer Responsibility

| Role     | Responsibility           |
| -------- | ------------------------ |
| Producer | gửi đủ (delivery)        |
| Consumer | xử lý đúng (correctness) |

#### Insight

> Producer không đảm bảo không duplicate
> Consumer phải handle duplicate

## 8. Architecture (Production)

```
Event → Queue → Worker → HTTP → Consumer
                 ↓
                Retry → DLQ
```

## 9. Security (Advanced)

#### Signature

```php
hash_hmac('sha256', payload, secret)
```

#### Replay protection

* timestamp
* expire

## 10. Scaling Strategy

| Level | Strategy     |
| ----- | ------------ |
| 1     | sync         |
| 2     | queue        |
| 3     | multi worker |
| 4     | distributed  |

## 11. Observability

* log request
* tracking status
* retry count

## 12. Real Incident Simulation

#### Case 1: Payment duplicate

* webhook retry
* không idempotent

→ double charge

#### Case 2: Retry storm

* consumer down
* retry đồng loạt

→ system sập

#### Case 3: Out-of-order

* update sai trạng thái

## 13. Advanced Patterns

#### Fan-out

* 1 event → nhiều consumer

#### Webhook versioning

* backward compatibility

#### Dead Letter Queue

* fail nhiều lần → manual xử lý

## 14. Code Example (Laravel)

```php
class SendWebhookJob implements ShouldQueue
{
    public $tries = 5;
    public $backoff = [1,5,10,30];

    public function handle()
    {
        Http::post($this->url, $this->payload);
    }
}
```

## 15. Checklist Production

* [ ] Queue bắt buộc
* [ ] Retry + backoff + jitter
* [ ] Idempotency (DB level)
* [ ] Signature verify
* [ ] DLQ
* [ ] Monitoring

## 16. Final Architect Insight

> Webhook = hệ thống giao tiếp bất đồng bộ giữa system

Trade-off:

* reliability
* latency
* complexity
