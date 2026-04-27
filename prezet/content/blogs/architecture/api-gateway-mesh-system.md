---
title: "API Gateway & Service Mesh Deep Dive (Control Plane, Data Plane, Traffic Management, Istio)"
excerpt: "Handbook production-level về API Gateway & Service Mesh: control/data plane, traffic shifting, service discovery, observability, failure scenarios và incident thực tế."
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-api-gateway-deep-dive.webp
tags: [architecture, microservices, api-gateway, system-design]
---

## Glossary (Thuật ngữ nâng cao)

* API Gateway: entry point cho client (north-south)
* Service Mesh: giao tiếp nội bộ (east-west)
* Control Plane: quản lý config
* Data Plane: xử lý request (proxy)
* Sidecar: proxy đi kèm service
* Service Discovery: tìm service runtime
* Circuit Breaker: ngắt request khi lỗi

## 1. Bản chất hệ thống

> Gateway + Mesh = control layer của distributed system

## 2. Control Plane vs Data Plane (CỰC QUAN TRỌNG)

#### Data Plane

* Envoy proxy xử lý request

#### Control Plane

* push config xuống proxy

#### Insight

> Control plane quyết định behavior
> Data plane thực thi

## 3. Traffic Flow

```
Client → Gateway → Service A → Proxy → Proxy → Service B
```

## 4. Traffic Management (Deep)

#### 4.1 Canary Release

* deploy version mới cho 10% user

#### 4.2 Blue-Green

* switch toàn bộ traffic

#### 4.3 Traffic Shifting

```yaml
v1: 90%
v2: 10%
```

#### Insight

> giảm risk deploy

## 5. Service Discovery

#### Problem

* IP service thay đổi

#### Solution

* service registry

#### Flow

```
service register → gateway lookup → route
```

## 6. Retry + Timeout + Circuit Breaker (Deep)

#### Problem

config sai → DDOS nội bộ

#### Example

```yaml
retry: 3
timeout: 2s
breaker: open after 5 fails
```

#### Interaction

* retry nhiều + timeout dài → overload

#### Insight

> retry phải đi cùng timeout + breaker

## 7. Sidecar Pattern (Deep)

```
Service + Envoy sidecar
```

👉 intercept toàn bộ traffic

## 8. Observability (Deep)

#### Metrics

* latency
* error rate

#### Tracing

* distributed tracing (request flow)

#### Logging

* centralized log

#### Correlation ID

* trace request xuyên system

## 9. Security (Deep)

#### mTLS

* encrypt nội bộ

#### Auth at Gateway

* JWT validate

## 10. Failure Matrix (Cực sâu)

| Failure               | Nguyên nhân       | Hậu quả    | Fix             |
| --------------------- | ----------------- | ---------- | --------------- |
| cascading failure     | service chậm      | lan rộng   | circuit breaker |
| retry storm           | retry nhiều       | overload   | limit retry     |
| config sai            | control plane lỗi | system sai | validate config |
| service discovery lỗi | lookup sai        | route fail | fallback        |

## 11. Real Incident

#### Case 1: Cascading Failure

* service A chậm → B chờ → C chờ → system sập

#### Fix

* timeout + breaker

#### Case 2: Retry Storm

* retry đồng loạt

#### Case 3: Bad Config Deploy

* config sai → toàn system lỗi

## 12. Scaling Strategy

| Level | Strategy         |
| ----- | ---------------- |
| 1     | single gateway   |
| 2     | multiple gateway |
| 3     | mesh             |
| 4     | global mesh      |

## 13. Cost

* proxy tốn CPU/RAM

#### Trade-off

* observability vs cost

## 14. Advanced Patterns

#### Rate Limit tại Gateway

* global control

#### API Aggregation

* combine nhiều service

#### Fault Injection

* simulate failure

## 15. Checklist Production

* [ ] control/data plane
* [ ] traffic management
* [ ] service discovery
* [ ] retry + breaker
* [ ] observability

## 16. Final Architect Insight

> Gateway + Mesh = hệ thần kinh của microservices

Trade-off:

* complexity
* latency
* cost
