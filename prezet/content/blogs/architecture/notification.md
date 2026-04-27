---
title: Notification System Deep Dive (Fan-out, Delivery, Scaling, Cost, Failure)
excerpt: "Handbook production-level về notification: fan-out strategy, delivery guarantee, distributed design, cost optimization, failure scenarios và incident thực tế."
date: 2026-04-27
category: architecture
image: /prezet/img/ogimages/blogs-laravel-index.webp
tags: [notification]
---

## Glossary (Thuật ngữ nâng cao)

* Fan-out: 1 event → nhiều user
* Channel: push/email/SMS/in-app
* Delivery guarantee: at-least-once
* Idempotency: chống duplicate
* Inbox: nơi lưu notification cho user
* Outbox: nơi lưu event gửi đi
* Digest: gom nhiều notification

## 1. Bản chất hệ thống

> Notification = distributed fan-out + delivery system

## 2. Fan-out Strategy (Deep Dive)

#### 2.1 Fan-out on write

* tạo notification cho từng user ngay khi event xảy ra

#### 2.2 Fan-out on read

* chỉ lưu event → build khi user đọc

#### 2.3 Hybrid (production)

* user ít → write
* user nhiều → read

👉 giảm load write + tối ưu read

## 3. Inbox / Outbox Pattern

#### Outbox

```php
save event → outbox table → queue
```

#### Inbox

```php
user_notifications table
```

#### Insight

> đảm bảo không mất event + retry dễ

## 4. Delivery Guarantee

* at-least-once → duplicate có thể xảy ra

#### Fix

* idempotency key
* DB constraint

## 5. Multi-Channel Design

| Channel | Cost  | Use          |
| ------- | ----- | ------------ |
| Push    | thấp  | realtime     |
| Email   | trung | nội dung dài |
| SMS     | cao   | critical     |

## 6. Preference System (Deep)

* per user
* per notification type

```php
if (!$user->wants('marketing_email')) return;
```

## 7. Queue & Backpressure

#### Queue per channel

```
push_queue
email_queue
sms_queue
```

#### Backpressure

* limit send rate
* tránh overload provider

## 8. Rate Limiting

* per user
* global

## 9. Idempotency (Deep)

#### Level 1

* cache key

#### Level 2

* DB unique

## 10. Failure Matrix (Nâng cao)

| Failure        | Nguyên nhân     | Hậu quả     | Fix              |
| -------------- | --------------- | ----------- | ---------------- |
| duplicate      | retry           | spam        | idempotent       |
| delay          | queue backlog   | chậm        | scale worker     |
| provider fail  | FCM/email down  | mất message | retry + fallback |
| device offline | user không nhận | retry       | store + resend   |

## 11. Cost Optimization

#### Problem

* SMS rất đắt

#### Solution

* ưu tiên push
* fallback email
* SMS chỉ critical

#### Digest

* gom nhiều notification

## 12. Scaling Strategy

| Level | Strategy          |
| ----- | ----------------- |
| 1     | sync              |
| 2     | queue             |
| 3     | multi worker      |
| 4     | shard theo userId |

## 13. Viral Scenario (1M fan-out)

#### Problem

* 1 event → 1M user

#### Solution

* hybrid fan-out
* batch processing
* rate limit

## 14. Distributed Design

* shard theo userId
* worker scaling
* provider failover

## 15. Observability

* delivery rate
* open rate
* failure rate

## 16. Production Incidents

#### Case 1: Spam notification

* retry + không limit

#### Case 2: Queue backlog

* worker thiếu

#### Case 3: Provider down

* mất notification

## 17. Code Example

```php
SendNotificationJob::dispatch($userId);
```

## 18. Checklist Production

* [ ] hybrid fan-out
* [ ] inbox/outbox
* [ ] idempotency
* [ ] rate limit
* [ ] retry + fallback
* [ ] monitoring

## 19. Final Architect Insight

> Notification = hệ thống phức tạp nhất vì combine nhiều system

Trade-off:

* latency
* cost
* user experience
