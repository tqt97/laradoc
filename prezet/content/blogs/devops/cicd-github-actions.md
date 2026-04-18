---
title: "CI/CD cho Laravel với Github Actions: Tự động hóa quy trình Deploy"
excerpt: Hướng dẫn xây dựng Pipeline CI/CD chuyên nghiệp cho ứng dụng Laravel bằng Github Actions, từ bước chạy Unit Test đến tự động Deploy lên Server qua SSH.
date: 2026-04-18
category: DevOps
image: /prezet/img/ogimages/blogs-devops-cicd-github-actions.webp
tags: [devops, github-actions, cicd, laravel, automation, deployment]
---

Bạn vẫn đang dùng FTP để upload code lên server? Hay phải SSH vào server và gõ `git pull` thủ công mỗi khi có thay đổi? Đã đến lúc để **Github Actions** lo việc đó. Một quy trình CI/CD chuẩn sẽ giúp bạn yên tâm hơn mỗi khi bấm nút "Merge".

## 1. CI (Continuous Integration): Chốt chặn chất lượng

CI đảm bảo rằng code mới của bạn không làm hỏng những tính năng cũ. Mỗi khi bạn đẩy code lên Github, một máy ảo sẽ tự động:

- Cài đặt PHP và các extension.
- Cài đặt dependencies (`composer install`).
- Chạy Linter (check cú pháp).
- Chạy **Unit Tests** và **Feature Tests**.

Nếu bất kỳ bước nào thất bại, Github sẽ ngăn bạn merge PR.

## 2. CD (Continuous Deployment): Đưa code lên Prod

Sau khi CI đã "pass", bước CD sẽ tự động đưa code lên server. Có 2 cách phổ biến:

- **SSH Deploy:** Script sẽ SSH vào server, chạy các lệnh `git pull`, `php artisan migrate`, `php artisan optimize`.
- **Docker Deploy:** Build image mới, đẩy lên Registry, và cập nhật container trên server.

## 3. Workflow mẫu cho Laravel

Tạo file `.github/workflows/deploy.yml`:

```yaml
name: Deploy Laravel
on:
  push:
    branches: [ main ]
jobs:
  tests:
    runs-on: ubuntu-latest
    steps:
      - uses: actions/checkout@v4
      - name: Setup PHP
        uses: shivammathur/setup-php@v2
        with:
          php-version: '8.3'
      - name: Install Dependencies
        run: composer install -q --no-ansi --no-interaction --no-scripts --no-progress --prefer-dist
      - name: Execute tests
        run: vendor/bin/phpunit

  deploy:
    needs: tests
    runs-on: ubuntu-latest
    steps:
      - name: Deploy to Server via SSH
        uses: appleboy/ssh-action@master
        with:
          host: ${{ secrets.HOST }}
          username: ${{ secrets.USERNAME }}
          key: ${{ secrets.SSH_KEY }}
          script: |
            cd /var/www/my-app
            php artisan down
            git pull origin main
            composer install --optimize-autoloader --no-dev
            php artisan migrate --force
            php artisan optimize
            php artisan up
```

## 4.Câu hỏi nhanh

**Câu hỏi:** Làm thế nào để thực hiện **Zero-downtime Deployment** bằng Github Actions mà không dùng các công cụ đắt tiền như Envoyer hay Deployer?

**Trả lời:**
Chiến lược phổ biến là dùng **Symbolic Links (Symlinks)**.

1. Mỗi lần deploy, bạn tạo một thư mục mới có tên là timestamp (ví dụ: `releases/202604181200`).
2. Clone code, cài đặt dependencies và chạy các bước chuẩn bị trong thư mục mới đó.
3. Chạy `migrate` (đảm bảo tính tương thích ngược).
4. Cuối cùng, thay đổi Symlink `current` trỏ từ thư mục cũ sang thư mục mới. Thao tác thay đổi symlink diễn ra trong mili giây, giúp người dùng không cảm nhận được hệ thống đang được cập nhật.
*Lưu ý:* Các thư mục như `storage` và `.env` phải được dùng chung (shared) giữa các bản release.

## 5. Kết luận

CI/CD không chỉ dành cho các dự án khổng lồ. Ngay cả với dự án cá nhân, tự động hóa giúp bạn giải phóng tâm trí khỏi các thao tác lặp đi lặp lại và giảm thiểu rủi ro sai sót do yếu tố con người.
