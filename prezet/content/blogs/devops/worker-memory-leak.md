---
title: "Memory Leak trong Queue Worker: Khi Worker 'ăn' sạch RAM"
excerpt: Những bài học xương máu về rò rỉ bộ nhớ trong các process chạy ngầm (long-running processes) và cách xử lý.
date: 2026-04-18
category: DevOps
image: /prezet/img/ogimages/blogs-devops-worker-memory-leak.webp
tags: [devops, laravel, memory, performance, queue]
---

## 1. Bài toán
Bạn chạy `php artisan queue:work`. Ban đầu nó tốn 50MB RAM, sau 1 ngày nó tốn 2GB và bị OOM (Out of memory).

## 2. Tại sao?
Trong các process chạy ngầm (long-running), PHP không hủy mọi thứ sau khi xong 1 job.
- **Static Variables:** Dữ liệu lưu trong biến tĩnh không bao giờ mất đi.
- **Service Container Singleton:** Nếu bạn bind một service mà bên trong có mảng lưu log/data, nó sẽ tích tụ mãi mãi.
- **Eloquent Collections:** Load quá nhiều record vào bộ nhớ mà không `unset`.

## 3. Kinh nghiệm thực chiến
- **Restart worker:** Luôn dùng `php artisan queue:work --max-jobs=1000 --max-time=3600`.
- **Dùng Generator:** Luôn xử lý data lớn bằng `cursor()` để duyệt từng bản ghi.
- **Monitor:** Cài đặt Prometheus/Grafana hoặc đơn giản là dùng `htop` để nhìn process tăng trưởng.

## 4. Phỏng vấn
**Q: Sự khác biệt giữa `queue:work` và `queue:listen`?**
**A:** `listen` luôn tải lại framework sau mỗi job (chậm nhưng sạch). `work` giữ nguyên framework trong RAM (cực nhanh nhưng dễ bị leak nếu code không sạch).
**Mẹo đánh đố:** Với hệ thống lớn, hãy chạy `queue:work` kết hợp với `Supervisor` để nó tự động restart worker khi bị chết.
