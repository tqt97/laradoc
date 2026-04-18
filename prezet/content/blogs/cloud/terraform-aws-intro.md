---
title: "Nhập môn Terraform & AWS: Tư duy Hạ tầng bằng Code (IaC)"
excerpt: Tìm hiểu về Terraform, tại sao lập trình viên hiện đại cần biết về Infrastructure as Code và hướng dẫn cơ bản để khởi tạo hạ tầng AWS bằng code.
date: 2026-04-18
category: Cloud
image: /prezet/img/ogimages/blogs-cloud-terraform-aws-intro.webp
tags: [cloud, aws, terraform, iac, devops, automation, infrastructure]
---

Bạn đã bao giờ tốn cả buổi sáng để click chuột trên giao diện AWS Console chỉ để tạo một cụm Server, rồi sau đó nhận ra mình quên cấu hình Firewall? **Terraform** sinh ra để chấm dứt cơn ác mộng đó bằng tư duy **Infrastructure as Code (IaC)**.

## 1. IaC là gì và tại sao lại cần thiết?

Hạ tầng bằng code (IaC) nghĩa là thay vì thao tác bằng tay, bạn viết các file cấu hình để định nghĩa hạ tầng của mình.

- **Tính nhất quán:** Bạn có thể tạo 10 môi trường (Dev, Staging, Prod) giống hệt nhau 100%.
- **Version Control:** Hạ tầng của bạn được lưu trên Git. Bạn biết ai đã thay đổi gì, khi nào.
- **Tốc độ:** Khởi tạo cả một hệ thống phức tạp chỉ bằng một câu lệnh.

## 2. Terraform: Công cụ "quốc dân" cho IaC

Terraform sử dụng ngôn ngữ **HCL (HashiCorp Configuration Language)**, cực kỳ dễ đọc và mạnh mẽ.

```hcl
# Ví dụ tạo 1 EC2 instance trên AWS
resource "aws_instance" "web_server" {
  ami           = "ami-0c55b159cbfafe1f0"
  instance_type = "t2.micro"

  tags = {
    Name = "Laravel-Prod-Server"
  }
}
```

## 3. Quy trình làm việc với Terraform

Có 3 lệnh "thần thánh" bạn cần nhớ:

1. **`terraform init`:** Khởi tạo thư mục và tải các provider cần thiết (AWS, Google Cloud...).
2. **`terraform plan`:** Xem trước những gì Terraform sẽ thay đổi. Đây là bước cực kỳ quan trọng để tránh sai sót.
3. **`terraform apply`:** Thực thi việc tạo/sửa hạ tầng thực tế.

## 4. State File: "Bộ não" của Terraform

Terraform lưu trạng thái hạ tầng vào một file gọi là `terraform.tfstate`.

- **Lưu ý quan trọng:** Đừng bao giờ sửa file này bằng tay.
- **Tip Senior:** Trong môi trường làm việc nhóm, hãy lưu file State này trên **S3** và bật tính năng **State Locking** bằng DynamoDB để tránh trường hợp 2 người cùng chạy lệnh một lúc gây xung đột.

## 5. Quizz cho phỏng vấn Senior

**Câu hỏi:** Phân biệt sự khác biệt giữa **Terraform** và các công cụ quản lý cấu hình như **Ansible**?

**Trả lời:**
Đây là sự phối hợp chứ không phải thay thế:

- **Terraform (Orchestration):** Tập trung vào việc "Xây nhà". Nó tạo ra các tài nguyên thô như: VPC, Subnet, EC2, RDS, Load Balancer.
- **Ansible (Configuration Management):** Tập trung vào việc "Sắp xếp nội thất". Sau khi Terraform tạo xong server, Ansible sẽ SSH vào để cài đặt PHP, Nginx, cấu hình file `.env` và deploy code.
*Tư duy hiện đại:* Người ta thường dùng Terraform để tạo hạ tầng, sau đó dùng Docker để đóng gói ứng dụng, giảm bớt sự phụ thuộc vào Ansible.

## 6. Kết luận

Terraform giúp xóa bỏ rào cản giữa Developer và SysAdmin. Khi bạn làm chủ được hạ tầng bằng code, bạn thực sự nắm giữ quyền năng vận hành hệ thống một cách chuyên nghiệp và tự động hóa hoàn toàn.
