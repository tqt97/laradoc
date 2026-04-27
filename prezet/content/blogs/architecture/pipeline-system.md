---
title: Analytics Pipeline Deep Dive (Kafka, Exactly-once, Streaming, Windowing, Scaling)
excerpt: "Handbook cấp production về analytics pipeline: Kafka internals, stream processing, consistency, schema evolution, failure và incident thực tế."
date: 2026-04-27
category: architecture
image: /prezet/img/ogimages/blogs-laravel-index.webp
tags: [pipeline]
---

## Glossary (Thuật ngữ nâng cao)

* Event: hành động (click, view)
* Partition: phân vùng dữ liệu
* Offset: vị trí đọc
* Broker: node Kafka
* Leader/Follower: node chính/phụ
* ISR (In-sync replica): replica đồng bộ
* Watermark: mốc thời gian xử lý event
* Window: khoảng thời gian tính toán

## 1. Bản chất hệ thống

> Analytics pipeline = hệ thống xử lý dữ liệu sự kiện ở scale lớn

## 2. Kafka Internals (Cực kỳ quan trọng)

#### 2.1 Partition

* chia topic thành nhiều phần

👉 giúp:

* scale
* parallel processing

#### 2.2 Replication

* mỗi partition có nhiều replica

👉 tránh mất data

#### 2.3 Leader / Follower

* leader xử lý read/write
* follower sync data

#### 2.4 ISR

* danh sách replica đang sync tốt

👉 nếu leader chết → ISR bầu leader mới

#### Insight

> Partition quyết định scale
> Replication quyết định durability

## 3. Exactly-once vs At-least-once (Deep Dive)

#### Reality

* exactly-once gần như không tồn tại

#### Simulation

###### Step 1: Idempotency

```php
if (processed(event_id)) return;
```

###### Step 2: Deduplication

* lưu processed event

#### Insight

> Exactly-once = at-least-once + idempotency

## 4. Partitioning & Ordering

#### Problem

* event có thể out-of-order

#### Solution

* key-based partition

```php
partition_key = user_id
```

👉 đảm bảo order theo user

#### Trade-off

* mất global ordering

## 5. Stream Processing Deep Dive

#### 5.1 Windowing

| Type     | Mô tả         |
| -------- | ------------- |
| Tumbling | không overlap |
| Sliding  | overlap       |

#### 5.2 Watermark

* xử lý event trễ

#### 5.3 Late Event

* event đến muộn

👉 cần logic handle

## 6. Schema Evolution

#### Problem

* event thay đổi format

#### Solution

* versioning

```json
{
  "version": 2
}
```

#### Backward Compatibility

* field mới optional

## 7. Failure Matrix (Cực sâu)

| Failure    | Nguyên nhân   | Hậu quả   | Fix          |
| ---------- | ------------- | --------- | ------------ |
| data loss  | broker chết   | mất event | replication  |
| duplicate  | retry         | sai số    | idempotent   |
| lag        | consumer chậm | delay     | scale        |
| corruption | disk lỗi      | sai data  | checksum     |
| offset sai | commit lỗi    | skip data | manual reset |

## 8. Backpressure

#### Problem

* consumer chậm

#### Fix

* scale consumer
* pause partition

## 9. Cost & Storage

#### Estimate

* data lớn (TB/PB)

#### Storage

* SSD → nhanh
* HDD → rẻ

## 10. Real Scenario (1M events/sec)

#### Problem

* throughput cực cao

#### Solution

* nhiều partition
* nhiều consumer group

## 11. Production Incidents

#### Case 1: Data loss

* replication thấp

#### Case 2: Consumer lag

* backlog tăng

#### Case 3: Data corruption

* disk lỗi

#### Case 4: Partition skew

* 1 partition quá tải

## 12. Advanced Patterns

#### ETL

* extract → transform → load

#### Aggregation

* count, sum

#### Real-time dashboard

* stream processing

## 13. Checklist Production

* [ ] Kafka cluster
* [ ] partition strategy
* [ ] idempotency
* [ ] schema versioning
* [ ] monitoring lag

## 14. Final Architect Insight

> Analytics pipeline = backbone của data system

Trade-off:

* latency
* accuracy
* cost
