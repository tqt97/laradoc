---
title: Cache là gì? Deep Dive Cache System (Redis, Consistency, Invalidation, Scaling, Failure)
excerpt: "Tài liệu đầy đủ về cache system ở level production: bản chất, chiến lược cache, invalidation, consistency, scaling, cost, failure handling, benchmark và incident thực tế."
date: 2026-04-27
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-index.webp
tags: [laravel, queue]
---

## Glossary (Giải thích thuật ngữ)

* Cache: bộ nhớ tạm để lưu dữ liệu truy cập nhanh
* Cache hit: có dữ liệu trong cache
* Cache miss: không có → query DB
* TTL (Time To Live): thời gian sống của cache
* Invalidation: xóa cache khi data thay đổi
* Consistency: tính nhất quán dữ liệu

  * Strong consistency: luôn đúng ngay
  * Eventual consistency: đúng sau 1 thời gian
* Stale data: dữ liệu cũ
* Hot key: key bị truy cập cực nhiều
* Cache stampede: nhiều request cùng miss cache
* Cache penetration: request key không tồn tại liên tục
* Cache avalanche: nhiều key expire cùng lúc

## 1. Cache là gì? (Bản chất kỹ thuật)

Cache = lưu kết quả đã xử lý để **không phải tính lại**

👉 Mục tiêu:

* giảm load DB
* tăng tốc response

## 2. Tại sao cần cache?

#### Không dùng cache

```php
$user = User::find($id);
```

→ mỗi request query DB

#### Dùng cache

```php
$user = Cache::remember("user_$id", 60, function () use ($id) {
        return User::find($id);
});
```

👉 DB chỉ query 1 lần

## 3. Decision Tree (Khi nào dùng cache)

```txt
if data thay đổi liên tục
    → không cache

if data read nhiều, write ít
    → cache

if cần strong consistency
    → không cache

if query chậm (>50ms)
    → cache
```

## 4. Cache Patterns (Chiến lược)

| Pattern       | Bản chất          | Khi dùng         | Trade-off     |
| ------------- | ----------------- | ---------------- | ------------- |
| Cache Aside   | lazy load         | phổ biến         | stale data    |
| Write Through | write DB + cache  | cần consistency  | chậm write    |
| Write Back    | write cache trước | high performance | risk mất data |
| Read Through  | cache tự load     | abstraction      | phức tạp      |

## 5. Failure Matrix

| Failure     | Nguyên nhân       | Hậu quả      | Giải pháp   |
| ----------- | ----------------- | ------------ | ----------- |
| Stale data  | không invalidate  | dữ liệu sai  | event-based |
| Stampede    | miss đồng loạt    | DB overload  | lock        |
| Hot key     | 1 key bị spam     | bottleneck   | sharding    |
| Penetration | key không tồn tại | DB spam      | null cache  |
| Avalanche   | expire cùng lúc   | system spike | random TTL  |

## 6. Cache Invalidation (KHÓ NHẤT)

#### 6.1 TTL (đơn giản)

```php
Cache::put('user_1', $user, 60);
```

👉 vấn đề:

* data có thể stale trong 60s

#### 6.2 Event-based (chuẩn production)

```php
Cache::forget('user_1');
```

👉 chính xác hơn

#### 6.3 Hybrid (best practice)

* TTL + event

## 7. Consistency vs Cache

Cache = eventual consistency

👉 KHÔNG dùng cho:

* payment
* inventory

## 8. Cache Stampede (Thundering Herd)

#### Problem

* nhiều request miss cache
* cùng query DB

#### Fix

```php
Cache::lock('key')->get(function () {
    return Cache::remember('key', 60, function () {
        return DB::query();
    });
});
```

## 9. Hot Key Problem

#### Problem

* 1 key bị truy cập hàng triệu lần

#### Fix

```php
$key = 'post_'.$id.'_'.rand(1,5);
```

👉 distribute load

## 10. Multi-layer Cache

| Layer | Ví dụ         | Mục đích      |
| ----- | ------------- | ------------- |
| CDN   | Cloudflare    | cache global  |
| App   | Laravel cache | business data |
| DB    | query cache   | internal      |

## 11. Cost Estimation

#### Redis

* key ~1KB
* 1M key = ~1GB RAM

👉 RAM rất đắt

## 12. Scaling Strategy

| Level | Giải pháp    | Vì sao       |
| ----- | ------------ | ------------ |
| 1     | single node  | đơn giản     |
| 2     | replica      | read scale   |
| 3     | cluster      | shard data   |
| 4     | multi-region | giảm latency |

## 13. Benchmark

* Redis ~100k–1M ops/sec
* latency rất thấp

## 14. Failure Handling

#### Redis down

```php
try {
    return Cache::get('key');
} catch (Exception $e) {
    return DB::query();
}
```

## 15. Advanced Failure Scenarios

#### Cache avalanche

* nhiều key expire cùng lúc

👉 fix:

```php
$ttl = rand(50, 70);
```

#### Cache penetration

```php
Cache::put('null_key', null, 60);
```

## 16. Production Incident

#### Case: DB sập vì cache miss

* cache hết hạn
* traffic cao
  → DB overload

👉 fix:

* preload cache
* lock

## 17. Example Code (Full)

```php
$user = Cache::remember("user_$id", 60, function () use ($id) {
    return User::find($id);
});
```

## 18. Interview Q&A

#### Q1: Cache invalidation khó không?

👉 rất khó vì phải đảm bảo consistency

#### Q2: Khi nào không dùng cache?

👉 khi cần strong consistency

#### Q3: Cache stampede là gì?

👉 nhiều request cùng miss

## 19. Final Insight

> Cache giúp tăng performance nhưng đổi lại consistency

## 20. Write-heavy System (Cache trong hệ thống ghi nhiều)

#### Problem

Hệ thống có write nhiều (ví dụ: like, view, counter):

* dữ liệu thay đổi liên tục
* cache dễ bị stale
* invalidation xảy ra liên tục

👉 nếu dùng cache sai:

* dữ liệu sai liên tục
* tốn chi phí invalidation

#### Các chiến lược xử lý

| Strategy           | Bản chất          | Khi dùng        | Trade-off     |
| ------------------ | ----------------- | --------------- | ------------- |
| No cache           | không cache       | write cực nhiều | chậm read     |
| Write through      | update DB + cache | cần consistency | write chậm    |
| Write back         | ghi cache trước   | throughput cao  | risk mất data |
| Incremental update | update từng phần  | counter         | phức tạp      |

#### Ví dụ: Counter (view, like)

###### ❌ Sai

```php
$post->views += 1;
$post->save();
```

→ DB write liên tục → overload

###### ✅ Đúng (Redis increment)

```php
Redis::incr("post_views_$id");
```

👉 nhanh, không lock DB

###### Sync về DB bằng Queue

```php
SyncPostViewJob::dispatch($id);
```

#### Insight

> Write-heavy → không nên phụ thuộc DB trực tiếp
> → dùng cache + queue để buffer

## 21. Cache + Queue Combo (Cực kỳ quan trọng)

#### Problem

* cache miss nhiều
* DB bị spike

#### Solution: Async cache warming

###### Flow

1. request miss cache
2. trả response (fallback DB)
3. push job để preload cache

#### Code ví dụ

```php
$data = Cache::get($key);

if (!$data) {
    $data = DB::query();

    PreloadCacheJob::dispatch($key);
}
```

#### Job preload

```php
class PreloadCacheJob implements ShouldQueue
{
    public function handle()
    {
        Cache::put($this->key, DB::query(), 60);
    }
}
```

#### Vì sao chọn cách này?

* tránh nhiều request cùng query DB
* giảm spike
* scale tốt hơn

#### Trade-off

* data có thể stale ngắn hạn
* tăng complexity

## 22. Real Scaling Scenario (10M user, 100k QPS)

#### Problem

* 100k request/sec
* DB không chịu nổi

#### Architecture

| Layer     | Giải pháp         | Mục tiêu         |
| --------- | ----------------- | ---------------- |
| CDN       | cache static      | giảm global load |
| App cache | Redis             | giảm DB          |
| DB        | primary + replica | durability       |

#### Flow

```
User → CDN → App → Redis → DB
```

#### Key decisions

###### 1. Cache everything possible

* user profile
* post
* config

###### 2. TTL strategy

* hot data: TTL ngắn (30–60s)
* cold data: TTL dài

###### 3. Sharding Redis

* tránh single bottleneck

###### 4. Use queue for async update

* write → queue → update cache

#### Estimate

* 100k QPS
* cache hit 90%

→ DB chỉ xử lý 10k QPS

👉 giảm 10x load

#### Failure scenario

###### Cache down

* toàn bộ traffic dồn vào DB

👉 fix:

* rate limit
* fallback degraded mode

#### Insight

> Scaling = không để DB chịu load trực tiếp
> → cache là layer bắt buộc

## 23. Final Architect Insight

> Cache không chỉ là tối ưu performance
> → nó là layer sống còn để scale hệ thống

## 24. Read-after-write Consistency (Đọc ngay sau khi ghi)

#### Problem

User update data:

```php
$user->name = 'Tuan';
$user->save();
```

Nhưng cache vẫn còn dữ liệu cũ → user refresh vẫn thấy dữ liệu cũ

👉 gọi là **read-after-write inconsistency**

#### Vì sao xảy ra?

* DB update trước
* cache chưa được invalidate/update

#### Giải pháp

###### 1. Write-through (đồng bộ cache + DB)

```php
$user->save();
Cache::put("user_$id", $user, 60);
```

👉 đảm bảo cache luôn mới

###### 2. Invalidate ngay sau write

```php
$user->save();
Cache::forget("user_$id");
```

👉 lần sau sẽ query lại DB

###### 3. Delay cache update (eventual consistency)

```php
UpdateCacheJob::dispatch($id);
```

👉 chấp nhận dữ liệu stale ngắn hạn

#### Trade-off

| Strategy      | Ưu điểm         | Nhược điểm |
| ------------- | --------------- | ---------- |
| Write-through | consistency cao | chậm write |
| Invalidate    | đơn giản        | miss tăng  |
| Async update  | nhanh           | stale data |

#### Insight

> Không có cách nào hoàn hảo
> → phải chọn trade-off phù hợp business

## 25. Multi-tenant Cache Design (Thiết kế cache đa tenant)

#### Problem

Hệ thống SaaS:

* nhiều tenant (company)
* dữ liệu phải tách biệt

👉 nếu không:

* lộ dữ liệu giữa tenant
* cache conflict

#### Giải pháp

###### Prefix key theo tenant

```php
$key = "tenant_{$tenantId}_user_{$userId}";
```

👉 mỗi tenant có namespace riêng

###### Cache tagging (Laravel)

```php
Cache::tags(['tenant_'.$tenantId])->put('user_'.$id, $user);
```

👉 invalidate toàn tenant dễ dàng

#### Khi nào cần?

* SaaS system
* multi-organization

#### Trade-off

* key dài hơn → tốn RAM
* cần quản lý namespace

#### Insight

> Multi-tenant cache = vấn đề bảo mật + scaling

## 26. Cache Eviction Policy (Chiến lược xoá cache)

#### Eviction là gì?

Khi cache đầy → phải xoá bớt dữ liệu

#### Các chiến lược phổ biến

| Policy                      | Bản chất                | Khi dùng       |
| --------------------------- | ----------------------- | -------------- |
| LRU (Least Recently Used)   | xoá key ít dùng gần đây | general        |
| LFU (Least Frequently Used) | xoá key ít dùng nhất    | hot key system |
| FIFO                        | xoá theo thứ tự         | đơn giản       |
| TTL                         | hết hạn                 | phổ biến       |

#### Redis hỗ trợ

* allkeys-lru
* allkeys-lfu
* volatile-ttl

#### Ví dụ config Redis

```bash
maxmemory-policy allkeys-lru
```

#### Trade-off

* LRU: phù hợp đa số
* LFU: tốt khi có hot key

#### Insight

> Eviction policy ảnh hưởng trực tiếp performance

## 27. Final Architect Insight

> Cache không chỉ là tối ưu
> → nó là bài toán trade-off giữa:

* performance
* consistency
* cost
