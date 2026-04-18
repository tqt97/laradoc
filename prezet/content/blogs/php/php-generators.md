---
title: "PHP Generators (yield): Giải pháp xử lý Big Data tiết kiệm RAM"
excerpt: Hiểu sâu về cách PHP Generator hoạt động, so sánh với mảng truyền thống và ứng dụng trong các bài toán xử lý dữ liệu khổng lồ.
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-php-generators.webp
tags: [php, performance, memory-management, generators, big-data]
---

Khi xử lý file log 5GB hoặc bảng Database 1 triệu dòng, việc đưa tất cả vào mảng (`array`) sẽ làm sập RAM server của bạn. **Generators** là "vị cứu tinh".

## 1. Bản chất

Thay vì dùng `return array`, bạn dùng `yield`.
PHP sẽ "đóng băng" trạng thái của hàm và trả về từng phần tử một. Khi gọi lại, hàm sẽ chạy tiếp từ câu lệnh `yield` cuối cùng.

## 2. Tiết kiệm RAM

- `return array`: RAM = size của toàn bộ dữ liệu.
- `yield`: RAM = size của 1 phần tử (cực thấp).

## 3. Ứng dụng thực tế

Dùng Generator khi đọc file log hoặc export dữ liệu lớn từ Database để đảm bảo ứng dụng luôn ổn định ở mức bộ nhớ thấp.
