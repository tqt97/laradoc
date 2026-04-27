---
title: Search System Deep Dive (Indexing, Ranking, Distributed, Elasticsearch, Scaling)
excerpt: "Handbook cấp production về search: indexing pipeline, ranking nâng cao, distributed search, cost, failure và incident thực tế."
date: 2026-04-27
category: architecture
image: /prezet/img/ogimages/blogs-laravel-index.webp
tags: [search]
---

## Glossary (Thuật ngữ nâng cao)

* Inverted index: map từ → document
* Indexing: build index
* Shard: phân mảnh
* Replica: bản sao
* Coordinator node: node điều phối query
* Relevance: độ liên quan
* NRT (Near real-time): gần realtime

## 1. Bản chất hệ thống

> Search = hệ thống riêng biệt (không phải DB feature)

## 2. Indexing Strategy (Deep Dive)

#### 2.1 Full Reindex

* rebuild toàn bộ index

###### Khi dùng

* thay đổi schema
* data lớn thay đổi

###### Nhược

* tốn thời gian
* downtime nếu không xử lý tốt

#### 2.2 Incremental Index

* update từng record

```php
Post::updated → push queue → update index
```

###### Ưu

* realtime hơn

#### 2.3 Batch vs Streaming

| Type      | Bản chất       | Khi dùng    |
| --------- | -------------- | ----------- |
| Batch     | xử lý theo lô  | analytics   |
| Streaming | xử lý realtime | user search |

#### 2.4 Near Real-time (NRT)

* Elasticsearch refresh mỗi vài giây

👉 trade-off:

* latency vs consistency

## 3. Ranking System (Deep Dive)

#### 3.1 BM25 (base)

* relevance theo text

#### 3.2 Custom Scoring

```json
score = bm25_score * weight + business_score
```

#### 3.3 Business Ranking

Ví dụ:

* ưu tiên paid user
* ưu tiên bài mới

#### 3.4 Personalization

* user A vs user B kết quả khác nhau

#### Insight

> Ranking = kết hợp text + business + user behavior

## 4. Query Optimization

#### 4.1 Filter vs Query

* filter: không tính score (nhanh)
* query: có scoring

#### 4.2 Caching

* cache query phổ biến

#### 4.3 Deep Pagination Problem

```json
from: 10000
size: 10
```

→ chậm

###### Fix

* search_after

## 5. Distributed Architecture

```
Client → Coordinator → Shards → Merge → Result
```

#### 5.1 Coordinator Node

* nhận query
* gửi đến shard
* merge kết quả

#### 5.2 Shard Routing

* xác định shard chứa data

#### 5.3 Replica Read

* read từ replica để scale

## 6. Failure Matrix (Nâng cao)

| Failure       | Nguyên nhân | Hậu quả       | Fix        |
| ------------- | ----------- | ------------- | ---------- |
| index corrupt | disk lỗi    | mất data      | reindex    |
| shard chết    | node down   | mất shard     | replica    |
| split brain   | cluster lỗi | inconsistency | quorum     |
| lag index     | delay       | stale data    | monitoring |

## 7. Cost & Storage

#### Estimate

* index size = 2–5x data

#### RAM

* cần để cache index

#### Storage

| Type | Ưu    | Nhược |
| ---- | ----- | ----- |
| SSD  | nhanh | đắt   |
| HDD  | rẻ    | chậm  |

## 8. Real Scenario (100M documents)

#### Problem

* query chậm

#### Solution

* shard theo userId
* replica để scale read

## 9. Production Incidents

#### Case 1: Index lag

* user update không thấy search

#### Case 2: Shard hotspot

* 1 shard chịu tải lớn

#### Case 3: Cluster split brain

* dữ liệu inconsistent

## 10. Advanced Patterns

#### Synonym

* "car" = "auto"

#### Autocomplete

* prefix search

#### Fuzzy Search

* typo tolerance

## 11. Code Example

```php
Post::search('laravel')->get();
```

## 12. Checklist Production

* [ ] indexing pipeline
* [ ] ranking tuning
* [ ] shard + replica
* [ ] monitoring
* [ ] reindex strategy

## 13. Final Architect Insight

> Search system = hệ thống độc lập cần design riêng

Trade-off:

* relevance
* latency
* cost
