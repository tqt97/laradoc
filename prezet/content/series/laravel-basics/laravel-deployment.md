---
title: Deployment & DevOps trong Laravel – Từ local đến production
excerpt: Hướng dẫn deploy Laravel từ local lên production, CI/CD, Docker, cấu hình môi trường và zero downtime deployment.
date: 2026-04-19
category: DevOps
image: /prezet/img/ogimages/series-laravel-basics-laravel-deployment.webp
tags: [laravel, devops, deployment, docker, cicd]
order: 16
---

Rất nhiều developer:

* Code chạy tốt ở local
* Nhưng fail khi lên production

Vì thiếu kiến thức về **Deployment & DevOps**.

## Deployment là gì?

> Là quá trình đưa code từ local lên môi trường production.

## Các môi trường (Environment)

* Local (dev)
* Staging (test)
* Production (live)

Rule:

* Không deploy thẳng từ local → production

## Flow deploy chuẩn

```txt
Code → Git → CI → Build → Deploy → Monitor
```

## Cấu hình môi trường (.env)

```txt
APP_ENV=production
APP_DEBUG=false
```

Không commit .env

## Tối ưu Laravel cho production

```bash
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

Giảm load runtime

## Queue & Scheduler

```bash
php artisan queue:work
php artisan schedule:work
```

Phải chạy trên server

## Web Server

* Nginx (phổ biến)
* Apache

Nginx + PHP-FPM là chuẩn production

## Docker (rất quan trọng)

> Đóng gói ứng dụng thành container

Lợi ích:

* Chạy giống nhau mọi môi trường
* Dễ deploy

## CI/CD là gì?

### CI (Continuous Integration)

* Run test
* Check code

### CD (Continuous Deployment)

* Deploy tự động

Tools:

* GitHub Actions
* GitLab CI

## Zero Downtime Deployment

> Deploy mà không làm gián đoạn user

### Cách làm

* Symlink release
* Rolling deploy
* Load balancer

## Real Case Production

**Laravel App**

* Nginx + PHP-FPM
* Redis (cache + queue)
* MySQL
* Supervisor (queue worker)

## Monitoring & Logging

* Log file
* Sentry
* New Relic

Phải theo dõi hệ thống

## Anti-pattern

* **Deploy thủ công** Dễ lỗi

* **Không có staging** Bug lên production

* **Không backup** Mất dữ liệu

## Performance Tips

* Cache config
* Optimize autoload

```bash
composer install --optimize-autoloader --no-dev
```

## Mindset

Junior:

> Code xong là xong

Senior:

> Code phải deploy được, chạy ổn định và monitor được

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. Deployment là gì?</summary>

Là quá trình đưa code lên production

</details>

<details open>
<summary>2. CI/CD là gì?</summary>

CI là tích hợp code liên tục, CD là deploy tự động

</details>

<details open>
<summary>3. Docker dùng để làm gì?</summary>

Đóng gói app để chạy nhất quán

</details>

<details open>
<summary>4. Zero downtime deployment là gì?</summary>

Deploy mà không gián đoạn user

</details>

<details open>
<summary>5. Tại sao cần staging?</summary>

Test trước khi lên production

</details>

## Kết luận

Deployment & DevOps giúp bạn:

* Đưa sản phẩm đến user
* Đảm bảo hệ thống ổn định
* Scale hệ thống

Đây là kỹ năng bắt buộc của backend engineer hiện đại.
