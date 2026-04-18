---
title: "Zero-Downtime Deployment: Chiến lược Symlink và Blue-Green"
excerpt: Làm thế nào để deploy code mới mà người dùng không gặp lỗi 502 hay gián đoạn dịch vụ? Tìm hiểu cách các công cụ như Deployer hay Envoyer vận hành.
date: 2026-04-18
category: DevOps
image: /prezet/img/ogimages/blogs-devops-zero-downtime-deployment-symlinks.webp
tags: [devops, deployment, cicd, laravel, linux, automation]
---

Nhiều lập trình viên vẫn giữ thói quen `git pull` trực tiếp trên server production. Thao tác này cực kỳ nguy hiểm vì trong vài giây/phút Composer đang cài đặt thư viện hoặc NPM đang build assets, website của bạn sẽ bị "chết" hoặc gặp lỗi không nhất quán. **Zero-Downtime Deployment** là tiêu chuẩn bắt buộc cho các hệ thống chuyên nghiệp.

## 1. Chiến lược Symlink (Atomic Deployment)

Đây là cách các công cụ như **Deployer** (PHP) hoặc **Capistrano** vận hành.

- **Cấu trúc thư mục:**
  - `releases/`: Chứa các bản build khác nhau (ví dụ: `2026041801`, `2026041802`).
  - `shared/`: Chứa các file dùng chung không thay đổi qua các bản build (như `.env`, `storage/`).
  - `current`: Một đường dẫn ảo (Symlink) trỏ tới bản build mới nhất trong thư mục `releases/`.
- **Quy trình:**
  1. Tạo thư mục release mới.
  2. Clone code và chạy các bước build (Composer, NPM) trong thư mục đó.
  3. Khi mọi thứ đã sẵn sàng, thay đổi Symlink `current` trỏ sang thư mục mới. Thao tác đổi link diễn ra trong vài mili giây (Atomic), giúp người dùng không cảm nhận được sự thay đổi.

## 2. Chiến lược Blue-Green

Phức tạp và tốn kém hơn nhưng an toàn tuyệt đối.

- Bạn có 2 cụm server giống hệt nhau: **Blue** (đang chạy) và **Green** (chuẩn bị).
- Bạn deploy code mới lên cụm Green và test kỹ lưỡng.
- Sau đó, chỉ việc cấu hình Load Balancer chuyển hướng traffic từ Blue sang Green.
- Nếu Green có lỗi, bạn switch traffic ngược lại Blue ngay lập tức.

## 3. Thách thức: Database Migration

Zero-downtime không chỉ là về Code, mà còn là Database. Nếu bản build mới xóa một cột mà bản build cũ vẫn đang chạy (trong vài giây chuyển đổi), hệ thống sẽ sập.

- **Quy tắc:** Luôn đảm bảo tính tương thích ngược (Backward Compatibility). Migration chỉ nên Thêm, đừng Xóa hoặc Đổi tên cột trong cùng một lần deploy.

## 4.Câu hỏi nhanh

**Câu hỏi:** Tại sao khi dùng chiến lược Symlink cho Laravel, chúng ta phải khởi động lại (restart) PHP-FPM hoặc clear Opcache sau khi đổi link `current`?

**Trả lời:**
Vì PHP sử dụng **Opcache** để lưu trữ mã máy trong RAM. Opcache thường ghi nhớ đường dẫn tuyệt đối của file. Dù Symlink `current` đã trỏ sang thư mục mới, PHP-FPM có thể vẫn đang thực thi các file cũ nằm trong RAM. Việc restart PHP-FPM hoặc gọi hàm `opcache_reset()` giúp ép buộc PHP đọc lại mã nguồn từ thư mục release mới nhất.

**Câu hỏi mẹo:** Làm thế nào để xử lý các Job đang chạy trong Queue khi thực hiện Deploy mới?
**Trả lời:** Chúng ta nên gửi tín hiệu `SIGTERM` (qua lệnh `php artisan queue:restart`) cho các worker. Worker sẽ kết thúc nốt Job hiện tại rồi mới tự đóng và khởi động lại với code mới. Tuyệt đối không dùng `kill -9` vì sẽ làm mất dữ liệu Job đang xử lý.

## 5. Kết luận

Zero-downtime không chỉ là về công cụ, nó là về **quy trình**. Hãy đầu tư vào tự động hóa deploy để bạn có thể yên tâm "bấm nút" vào bất kỳ thời điểm nào trong ngày mà không sợ làm phiền khách hàng.
