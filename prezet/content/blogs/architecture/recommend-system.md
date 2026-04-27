---
title: Recommendation System Deep Dive (Ranking, ANN, Feature Store, Real-time Personalization)
excerpt: "Handbook production-level về recommendation system: multi-stage ranking, embedding, ANN, feature store, real-time pipeline, A/B testing, failure và incident thực tế."
date: 2026-04-27
category: architecture
image: /prezet/img/ogimages/blogs-laravel-index.webp
tags: [ratelimit]
---

## Glossary (Thuật ngữ nâng cao)

* Candidate: tập item ban đầu
* Ranking: sắp xếp kết quả
* Embedding: vector biểu diễn user/item
* ANN: Approximate Nearest Neighbor (tìm gần đúng)
* Feature store: nơi lưu feature
* Online learning: update realtime
* Offline learning: training batch

## 1. Bản chất hệ thống

> Recommendation = Multi-stage decision system

## 2. Multi-stage Architecture (Production)

```
Candidate → Pre-ranking → Ranking → Re-ranking
```

#### Giải thích

* Candidate: lấy ~1000 item
* Pre-ranking: giảm còn ~100
* Ranking: model chính
* Re-ranking: rule business

#### Insight

> Multi-stage giúp giảm latency + tăng accuracy

## 3. Candidate Generation (Deep)

#### 3.1 Embedding

* user/item → vector

#### 3.2 ANN Search

* tìm item gần nhất trong vector space

#### Trade-off

| Type  | Ưu        | Nhược  |
| ----- | --------- | ------ |
| Exact | chính xác | chậm   |
| ANN   | nhanh     | sai số |

## 4. Ranking System (Deep)

#### Formula

```
score = model(user, item, context)
```

#### Feature

* user behavior
* item info
* context (time, device)

#### Business Logic

* boost ads
* boost new content

## 5. Feature Store (Deep Dive)

#### Online Feature

* dùng cho serving (low latency)

#### Offline Feature

* dùng training

#### Problem

* mismatch giữa training và serving

#### Fix

* shared feature store

## 6. Real-time Personalization

#### Flow

```
User action → Event → Update feature → Update ranking
```

#### Example

* user click → update interest ngay

## 7. Online vs Offline Learning

| Type    | Use          |
| ------- | ------------ |
| Offline | train model  |
| Online  | update nhanh |

#### Hybrid

* train offline + update online

## 8. A/B Testing System

#### Mục tiêu

* test model

#### Flow

* user split group
* compare CTR

## 9. Metrics System

* CTR (click)
* retention
* watch time
* revenue

## 10. Failure Matrix (Cực sâu)

| Failure            | Nguyên nhân    | Hậu quả       | Fix      |
| ------------------ | -------------- | ------------- | -------- |
| bad model          | training lỗi   | UX kém        | rollback |
| feature mismatch   | data sai       | sai ranking   | validate |
| cold start         | thiếu data     | đề xuất kém   | fallback |
| feedback loop bias | self reinforce | lệch hệ thống | explore  |

## 11. Real Incident

#### Case 1: CTR drop

* deploy model mới

→ CTR giảm mạnh

#### Fix

* rollback model

#### Case 2: Feature lỗi

* data sai → recommend sai

## 12. Scaling Strategy

| Level | Strategy       |
| ----- | -------------- |
| 1     | simple ranking |
| 2     | cache          |
| 3     | distributed    |
| 4     | ML system      |

## 13. Cost

* compute model rất tốn

#### Fix

* multi-stage
* cache result

## 14. Observability

* CTR
* latency
* error rate

## 15. Code Example

```php
$items = RecommendService::get($userId);
```

## 16. Checklist Production

* [ ] multi-stage ranking
* [ ] embedding + ANN
* [ ] feature store
* [ ] A/B testing
* [ ] monitoring

## 17. Final Architect Insight

> Recommendation system = decision engine của product

Trade-off:

* accuracy
* latency
* cost
