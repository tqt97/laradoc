---
title: "Dockerize ứng dụng Laravel: Từ Development đến Production chuẩn Senior"
excerpt: Hướng dẫn xây dựng hệ thống môi trường Docker chuẩn cho Laravel, tối ưu Image size bằng Multi-stage Build và quy trình bảo mật container cho môi trường Production.
date: 2026-04-18
category: DevOps
image: /prezet/img/ogimages/blogs-devops-dockerize-laravel-chuan-prod.webp
tags: [devops, docker, laravel, deployment, automation, multi-stage-build]
---

"Chạy trên máy tôi ngon mà!" - Câu nói này sẽ biến mất vĩnh viễn nếu bạn dùng Docker đúng cách. Bài viết này hướng dẫn bạn Dockerize ứng dụng Laravel không chỉ để "chạy được", mà là chạy **nhanh, nhẹ và bảo mật** theo tiêu chuẩn Production.

## 1. Tại sao Image của bạn nặng hàng GB?

Nhiều lập trình viên có thói quen copy toàn bộ source code vào một image duy nhất chứa cả Node.js, Composer, và các thư viện build. Kết quả là Image cực nặng, kéo dài thời gian deploy và tốn băng thông.

- **Giải pháp:** Sử dụng **Multi-stage Build**.
- **Nguyên tắc:** Chia quá trình build thành nhiều giai đoạn. Chỉ giai đoạn cuối cùng (Runtime) mới được giữ lại và đẩy lên Server.

## 2. Dockerfile chuẩn Production mẫu

Dưới đây là cấu trúc một Dockerfile tối ưu:

```docker
# Stage 1: Build Frontend Assets
FROM node:20-alpine AS assets
WORKDIR /app
COPY package*.json ./
RUN npm install
COPY . .
RUN npm run build

# Stage 2: Install PHP Dependencies
FROM composer:2 AS vendor
WORKDIR /app
COPY composer*.json ./
RUN composer install --no-dev --optimize-autoloader --no-scripts

# Stage 3: Runtime Image
FROM php:8.3-fpm-alpine
WORKDIR /var/www/html

# Cài đặt các extension cần thiết (gd, pdo_mysql, bcmath...)
RUN apk add --no-cache libpng-dev libzip-dev zip ... \
    && docker-php-ext-install pdo_mysql bcmath gd

# Copy source code từ máy host và dependencies từ Stage 2
COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

# Phân quyền cho Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

USER www-data
```

## 3. Tối ưu hóa bảo mật và hiệu năng

- **Dùng Alpine Linux:** Image nhỏ gọn hơn, ít lỗ hổng bảo mật hơn so với Ubuntu/Debian.
- **Dọn dẹp cache:** Luôn dùng `--no-cache` khi cài đặt gói và xóa file tạm sau khi build.
- **Không chạy bằng Root:** Luôn khai báo `USER www-data` để hạn chế quyền hạn của tiến trình PHP nếu container bị chiếm quyền điều khiển.
- **.dockerignore:** Cực kỳ quan trọng! Hãy liệt kê `.git`, `node_modules`, `tests`, `storage/logs` vào đây để Docker không copy những thứ thừa thãi vào image.

## 4.Câu hỏi nhanh

**Câu hỏi:** Tại sao chúng ta không nên chạy lệnh `php artisan migrate` bên trong `Dockerfile` hoặc trong bước khởi động của Container (Entrypoint) khi chạy trên một cụm máy chủ (như Kubernetes)?

**Trả lời:**
Bởi vì khi bạn scale hệ thống lên 10 pods (10 container chạy song song), cả 10 pods sẽ cùng lúc cố gắng chạy lệnh migrate khi chúng khởi động. Điều này gây ra **Race Condition** ở mức cấu trúc Database, có thể làm hỏng bảng hoặc gây treo hệ thống.
*Giải pháp:* Chạy migrate như một bước riêng biệt (Job) trong pipeline CI/CD trước khi deploy các container mới, hoặc sử dụng các cơ chế locking (như `flock`) nếu buộc phải chạy trong entrypoint.

## 5. Kết luận

Docker không chỉ là công cụ đóng gói, nó là một tư duy về **Hạ tầng bất biến (Immutable Infrastructure)**. Một Image chuẩn sẽ giúp quá trình deploy của bạn diễn ra trong vài giây thay vì vài phút, và đảm bảo mọi môi trường từ Dev đến Prod đều đồng nhất 100%.
