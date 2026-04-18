---
title: "AWS cho Web Developer: 5 Dịch vụ 'Sống còn' và Cách Tối ưu"
excerpt: Hướng dẫn dành cho lập trình viên Web khi bắt đầu với AWS, phân biệt EC2, S3, RDS, Lambda, IAM và cách thiết kế hạ tầng chịu tải cao, tiết kiệm chi phí.
date: 2026-04-18
category: Cloud
image: /prezet/img/ogimages/blogs-cloud-aws-co-ban-cho-dev.webp
tags: [cloud, aws, devops, serverless, architecture, scalability, s3, rds]
---

Thế giới Cloud của AWS cực kỳ rộng lớn với hàng trăm dịch vụ. Với một Web Developer, bạn không cần biết hết, nhưng phải làm chủ được 5 "trụ cột" sau đây để xây dựng và vận hành ứng dụng thực tế.

## 1. Amazon EC2 (Elastic Compute Cloud)

Đây là những máy chủ ảo (Virtual Servers). Bạn có toàn quyền cài đặt OS (thường là Linux), Nginx, PHP...

- **Tip Senior:** Đừng bao giờ lưu dữ liệu quan trọng trên ổ cứng của EC2 (Instance Store) vì nó sẽ mất sạch khi bạn Stop instance. Hãy dùng **EBS (Elastic Block Store)**.
- **Tối ưu chi phí:** Dùng **Reserved Instances** hoặc **Savings Plans** nếu server chạy 24/7 để tiết kiệm tới 72% chi phí so với On-demand.

## 2. Amazon S3 (Simple Storage Service)

Đừng lưu ảnh, video người dùng upload trực tiếp trên ổ cứng server. Hãy đẩy lên S3.

- **Độ bền (Durability):** 99.999999999% (11 con số 9). Gần như không bao giờ mất dữ liệu.
- **Phân phối:** Kết hợp với **CloudFront (CDN)** để ảnh được tải cực nhanh từ các Edge Server gần người dùng nhất.

## 3. Amazon RDS (Relational Database Service)

Thay vì tự cài MySQL/PostgreSQL lên EC2 và tự lo backup, hãy dùng RDS.

- **Lợi ích:** Tự động backup, tự động vá lỗi bảo mật.
- **High Availability:** Bật chế độ **Multi-AZ**. AWS sẽ tạo một bản sao ở một vùng vật lý khác. Nếu vùng chính gặp sự cố (đứt cáp, cháy nổ), hệ thống tự động nhảy sang bản sao trong vài giây.

## 4. AWS Lambda (Serverless)

Bạn chỉ viết code (function), AWS tự lo việc chạy code đó khi có event.

- **Ứng dụng:** Xử lý ảnh sau khi upload lên S3, gửi email notification, hoặc các task chạy định kỳ (Cron jobs).
- **Thanh toán:** Bạn chỉ trả tiền cho thời gian code thực sự chạy (tính bằng mili giây). Nếu không có ai dùng, chi phí bằng 0.

## 5. IAM (Identity and Access Management)

Đây là trái tim của bảo mật AWS.

- **Nguyên tắc:** Luôn dùng **IAM Roles** thay vì Access Keys.
- Nếu ứng dụng chạy trên EC2 cần truy cập S3, hãy gán Role cho EC2 đó. Bạn không cần phải lưu mã bí mật (`AWS_SECRET_KEY`) vào file `.env`, giảm thiểu rủi ro bị lộ key lên Github.

## 6.Câu hỏi nhanh

**Câu hỏi:** Làm thế nào để bảo mật các file "nhạy cảm" (ví dụ: hóa đơn khách hàng) trên S3 mà không cần để file ở chế độ Public?

**Trả lời:**
Sử dụng **S3 Presigned URLs**.

1. Mọi file trên S3 để ở chế độ **Private** hoàn toàn.
2. Khi người dùng hợp lệ muốn xem file, ứng dụng Laravel sẽ sử dụng AWS SDK để tạo một URL tạm thời có kèm chữ ký bảo mật và thời gian hết hạn (ví dụ 10 phút).
3. Người dùng sử dụng URL này để tải file trực tiếp từ S3. Hết 10 phút, URL sẽ vô hiệu lực.
Điều này giúp bảo mật tối đa và giảm tải cho server ứng dụng vì không phải đóng vai trò "người vận chuyển" dữ liệu.

## 7. Kết luận

AWS không khó nếu bạn biết tập trung vào những thứ quan trọng nhất. Hãy bắt đầu từ EC2 và S3, sau đó mở rộng dần sang RDS và Serverless để tối ưu hóa hệ thống.
