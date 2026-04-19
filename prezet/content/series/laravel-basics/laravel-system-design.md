---
title: System Design Basics cho Backend Developer – Từ Monolith đến Scaling
excerpt: "Tìm hiểu các khái niệm nền tảng trong system design: monolith vs microservices, scaling, load balancing và database design."
date: 2026-04-19
category: System Design
image: /prezet/img/ogimages/series-laravel-basics-laravel-system-design.webp
tags: [system design, backend, scaling, architecture]
order: 15
---

Khi hệ thống của bạn bắt đầu có nhiều user hơn, bạn sẽ gặp:

* Server quá tải
* Query chậm
* Response time tăng

Đây là lúc bạn cần **System Design**.

## System Design là gì?

> Là cách bạn thiết kế kiến trúc hệ thống để đáp ứng scale, performance và reliability.

## Monolith vs Microservices

### Monolith

* Một codebase
* Deploy cùng nhau

Ưu điểm:

* Đơn giản
* Dễ phát triển ban đầu

Nhược điểm:

* Khó scale
* Khó maintain khi lớn

### Microservices

* Nhiều service nhỏ
* Deploy độc lập

Ưu điểm:

* Scale từng phần
* Linh hoạt

Nhược điểm:

* Phức tạp
* Khó debug

Rule:

* Bắt đầu với monolith
* Scale → tách microservices

## Scaling là gì?

### Vertical Scaling

* Tăng CPU, RAM

Dễ nhưng giới hạn

### Horizontal Scaling

* Thêm nhiều server

Khó hơn nhưng scalable

## Load Balancing

> Phân phối request đến nhiều server

Ví dụ:

* Nginx
* AWS ELB

Giúp:

* Tăng performance
* Tăng availability

## Database Design Basics

### Normalization

* Tránh duplicate data

### Index

* Tăng tốc query

### Read/Write Split

* 1 DB write
* N DB read

Scale database

## Caching Layer

* Redis
* CDN

Giảm load hệ thống

## Real Case Production

### Case: High traffic app

* Load balancer
* Multiple app servers
* Redis cache
* DB replication

## Anti-pattern

* **Over-engineering** Dùng microservices quá sớm

* **Không dùng cache** DB quá tải

* **Single point of failure** Hệ thống dễ sập

## Performance Tips

* Cache nhiều layer
* Optimize DB
* Scale theo bottleneck

## Mindset

Junior:

> Code chạy là được

Senior:

> Hệ thống phải chịu tải và ổn định

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. Monolith và Microservices khác nhau như thế nào?</summary>

Monolith là một khối, microservices là nhiều service nhỏ độc lập

</details>

<details open>
<summary>2. Horizontal scaling là gì?</summary>

Thêm nhiều server để xử lý request

</details>

<details open>
<summary>3. Load balancer dùng để làm gì?</summary>

Phân phối request đến nhiều server

</details>

<details open>
<summary>4. Index trong database là gì?</summary>

Giúp tăng tốc truy vấn

</details>

<details open>
<summary>5. Khi nào nên dùng microservices?</summary>

Khi hệ thống lớn, cần scale và tách domain

</details>

## Kết luận

System Design là kỹ năng bắt buộc nếu bạn muốn đi xa.

> Không chỉ viết code, mà còn phải thiết kế hệ thống.

Đây là bước chuyển từ developer → engineer → architect.
