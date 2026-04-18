---
title: "AWS, DevOps & Cloud Computing: Từ Code đến Hạ tầng"
description: Hệ thống hơn 50 câu hỏi về AWS EC2, S3, Docker, Kubernetes, CI/CD và Infrastructure as Code.
date: 2026-04-18
tags: [aws, devops, docker, cloud, cicd]
image: /prezet/img/ogimages/knowledge-vi-aws-devops-cloud.webp
---

> Hành trình của một đoạn code không dừng lại ở việc "chạy tốt trên máy tôi". Hiểu về hạ tầng và tự động hóa là yếu tố then chốt của kỹ sư Backend hiện đại.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Cloud Computing (Điện toán đám mây) là gì?</summary>
  
  **Trả lời:**
  Là việc cung cấp các tài nguyên IT (server, storage, DB) qua Internet với mô hình trả tiền theo mức sử dụng (pay-as-you-go). Thay vì mua server vật lý, bạn thuê từ các nhà cung cấp như AWS, Azure, Google Cloud.
</details>

<details>
  <summary>Q2: DevOps là gì?</summary>
  
  **Trả lời:**
  Là sự kết hợp giữa Development (Phát triển) và Operations (Vận hành). Nó là một văn hóa và tập hợp các phương pháp giúp rút ngắn chu kỳ phát triển phần mềm và đảm bảo chất lượng cao.
</details>

<details>
  <summary>Q3: Docker là gì? Tại sao nó giải quyết được vấn đề "chạy trên máy tôi"?</summary>
  
  **Trả lời:**
  Docker đóng gói ứng dụng và tất cả các phụ thuộc (thư viện, OS config) vào một **Container**. Container này sẽ chạy giống hệt nhau trên bất kỳ máy nào có cài Docker.
</details>

<details>
  <summary>Q4: AWS EC2 là gì?</summary>
  
  **Trả lời:**
  Elastic Compute Cloud. Là dịch vụ cung cấp các máy chủ ảo (Virtual Servers) trên đám mây của Amazon.
</details>

<details>
  <summary>Q5: AWS S3 dùng để làm gì?</summary>
  
  **Trả lời:**
  Simple Storage Service. Là dịch vụ lưu trữ đối tượng (Object Storage) dùng để lưu ảnh, video, file backup với độ bền và quy mô cực lớn.
</details>

<details>
  <summary>Q6: CI/CD viết tắt của từ gì?</summary>
  
  **Trả lời:**
  Continuous Integration (Tích hợp liên tục) và Continuous Deployment/Delivery (Triển khai/Chuyển giao liên tục).
</details>

<details>
  <summary>Q7: Nginx là gì?</summary>
  
  **Trả lời:**
  Là một Web Server hiệu năng cao, đồng thời là Reverse Proxy, Load Balancer và HTTP Cache.
</details>

<details>
  <summary>Q8: Biến môi trường (.env) quan trọng như thế nào trong DevOps?</summary>
  
  **Trả lời:**
  Giúp tách biệt cấu hình (DB password, API keys) khỏi mã nguồn, cho phép ứng dụng chạy trên nhiều môi trường (Dev, Staging, Prod) mà không cần đổi code.
</details>

<details>
  <summary>Q9: IP tĩnh (Static IP) và IP động (Dynamic IP) khác nhau thế nào?</summary>
  
  **Trả lời:**
  Tĩnh: Không đổi (dùng cho server). Động: Thay đổi mỗi khi khởi động lại (dùng cho máy cá nhân). Trong AWS, IP tĩnh gọi là Elastic IP.
</details>

<details>
  <summary>Q10: SSH dùng để làm gì?</summary>
  
  **Trả lời:**
  Secure Shell. Là giao thức dùng để truy cập và điều khiển máy chủ từ xa một cách an toàn qua dòng lệnh.
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Sự khác biệt giữa Docker Image và Docker Container.</summary>
  
  **Trả lời:**
  Image là "bản vẽ" (blueprint) chứa code và môi trường (chỉ đọc). Container là một "thực thể" đang chạy được khởi tạo từ Image (có thể ghi).
</details>

<details>
  <summary>Q2: Phân biệt IaaS, PaaS và SaaS.</summary>
  
  **Trả lời:**

- IaaS (Infrastructure): Thuê hạ tầng thô (AWS EC2).
- PaaS (Platform): Thuê nền tảng để chạy app (Heroku, AWS Elastic Beanstalk).
- SaaS (Software): Thuê phần mềm hoàn chỉnh (Gmail, Slack).

</details>

<details>
  <summary>Q3: Giải thích về Docker Compose.</summary>
  
  **Trả lời:**
  Công cụ dùng để định nghĩa và chạy các ứng dụng Docker đa container (Multi-container). Ví dụ: 1 file `docker-compose.yml` để chạy cả App, DB và Redis cùng lúc.
</details>

<details>
  <summary>Q4: AWS RDS là gì? Tại sao dùng nó tốt hơn tự cài MySQL lên EC2?</summary>
  
  **Trả lời:**
  Relational Database Service. AWS tự động hóa việc: backup, vá lỗi bảo mật, scale dung lượng, và hỗ trợ High Availability (Multi-AZ) chỉ bằng vài cú click.
</details>

<details>
  <summary>Q5: Load Balancer (Cân bằng tải) hoạt động như thế nào?</summary>
  
  **Trả lời:**
  Đứng trước các server, nhận request từ người dùng và phân phối tới các server đang rảnh phía sau để tránh quá tải cho 1 máy duy nhất.
</details>

<details>
  <summary>Q6: Giải thích quy trình CI/CD cơ bản.</summary>
  
  **Trả lời:**
  Code Push -> Trigger Jenkins/Github Actions -> Chạy Unit Test -> Build Docker Image -> Push to Registry -> Deploy to Server.
</details>

<details>
  <summary>Q7: AWS IAM dùng để làm gì?</summary>
  
  **Trả lời:**
  Identity and Access Management. Quản lý người dùng và quyền hạn truy cập vào các tài nguyên AWS theo nguyên tắc "Quyền hạn tối thiểu".
</details>

<details>
  <summary>Q8: "Infrastructure as Code" (IaC) là gì?</summary>
  
  **Trả lời:**
  Quản lý hạ tầng (server, network) bằng code (như Terraform, CloudFormation). Giúp việc tạo hạ tầng có thể lặp lại, kiểm soát phiên bản và tự động hóa hoàn toàn.
</details>

<details>
  <summary>Q9: Phân biệt Vertical Scaling và Horizontal Scaling.</summary>
  
  **Trả lời:**
  Vertical: Tăng sức mạnh 1 máy (Thêm RAM/CPU). Horizontal: Thêm nhiều máy chạy song song. Đám mây ưu tiên Horizontal vì khả năng mở rộng vô hạn.
</details>

<details>
  <summary>Q10: Container Registry là gì? (Ví dụ: Docker Hub, AWS ECR).</summary>
  
  **Trả lời:**
  Nơi lưu trữ và quản lý các Docker Image sau khi được build, để các server deploy có thể tải về.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Kubernetes (K8s) giải quyết vấn đề gì mà Docker không làm được?</summary>
  
  **Trả lời:**
  Docker quản lý container lẻ. K8s điều phối (Orchestration) hàng nghìn container: tự động hồi phục khi lỗi (Self-healing), tự động scale, quản lý service discovery và cân bằng tải nội bộ.
</details>

<details>
  <summary>Q2: Giải thích cơ chế "Blue-Green Deployment" và "Canary Deployment".</summary>
  
  **Trả lời:**

- Blue-Green: Chạy 2 bản cũ (Blue) và mới (Green) song song. Switch router sang Green 100%. Lỗi thì switch back cực nhanh.
- Canary: Đưa bản mới cho 5% user dùng thử. Nếu ổn thì tăng dần lên 100%.

</details>

<details>
  <summary>Q3: AWS Lambda và kiến trúc Serverless hoạt động như thế nào?</summary>
  
  **Trả lời:**
  Bạn chỉ viết code (Function). AWS tự lo việc chạy code đó khi có event (request HTTP, file upload). Bạn không quản lý server và chỉ trả tiền cho thời gian thực thi (tính bằng mili giây).
</details>

<details>
  <summary>Q4: Docker Networking: Phân biệt Bridge, Host và Overlay network.</summary>
  
  **Trả lời:**

- Bridge: Network mặc định cho container trên 1 host.
- Host: Dùng trực tiếp network của máy host.
- Overlay: Kết nối các container trên nhiều host khác nhau (dùng cho Docker Swarm hoặc K8s).

</details>

<details>
  <summary>Q5: Giải thích khái niệm "Twelve-Factor App".</summary>
  
  **Trả lời:**
  Bộ 12 quy tắc để xây dựng ứng dụng SaaS hiện đại, tối ưu cho môi trường Cloud và Deployment tự động (ví dụ: Stateless, Config in environment, logs as event streams...).
</details>

<details>
  <summary>Q6: AWS VPC (Virtual Private Cloud) là gì? Giải thích Public Subnet và Private Subnet.</summary>
  
  **Trả lời:**
  Mạng ảo riêng trên AWS. Public Subnet: Có thể truy cập từ Internet (Web server). Private Subnet: Không thể truy cập từ ngoài (Database), bảo mật tối đa.
</details>

<details>
  <summary>Q7: GitOps là gì?</summary>
  
  **Trả lời:**
  Dùng Git làm "Single Source of Truth" cho toàn bộ hạ tầng và ứng dụng. Mọi thay đổi ở Git sẽ được tự động đồng bộ xuống hệ thống thực tế (thường dùng ArgoCD trong K8s).
</details>

<details>
  <summary>Q8: Phân tích cơ chế Multi-stage Build trong Docker.</summary>
  
  **Trả lời:**
  Dùng nhiều câu lệnh `FROM` trong 1 Dockerfile. Stage 1: Build/Compile code (tốn nhiều thư viện nặng). Stage 2: Chỉ lấy file thực thi copy sang môi trường chạy siêu nhẹ. Giúp Image cuối cùng nhỏ gọn và an toàn hơn.
</details>

<details>
  <summary>Q9: AWS Auto Scaling hoạt động dựa trên những chỉ số nào?</summary>
  
  **Trả lời:**
  CPU Utilization, RAM usage, số lượng Request, hoặc lịch trình thời gian cụ thể. Nó tự động thêm/bớt server EC2 dựa trên tải thực tế.
</details>

<details>
  <summary>Q10: Giải thích về "Zero Downtime Database Migration".</summary>
  
  **Trả lời:**
  Kỹ thuật thay đổi cấu trúc DB mà không làm gián đoạn ứng dụng. Thường dùng chiến lược: 1. Thêm cột mới. 2. Code hỗ trợ cả 2 cột. 3. Copy data cũ sang mới. 4. Xóa cột cũ.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế hạ tầng Cloud cho ứng dụng Global có 50 triệu người dùng, đảm bảo High Availability.</summary>
  
  **Trả lời:**
  Dùng kiến trúc **Multi-Region**. DNS Route 53 (Latency routing). CloudFront CDN. AWS EKS (Kubernetes) trên nhiều Availability Zones. Aurora Global Database. S3 replication.
</details>

<details>
  <summary>Q2: Làm thế nào để xử lý việc "Stateful" trong môi trường Container (K8s)?</summary>
  
  **Trả lời:**
  Dùng **StatefulSet** thay vì Deployment. Kết hợp với **Persistent Volumes** (EBS, EFS) để dữ liệu không bị mất khi Pod bị xóa và được mount lại đúng vào Pod mới.
</details>

<details>
  <summary>Q3: Thiết kế quy trình Disaster Recovery (DR) cho hệ thống tài chính.</summary>
  
  **Trả lời:**
  Chiến lược **Pilot Light** hoặc **Warm Standby**. Database liên tục replication sang Region khác. Backup định kỳ lên S3 Glacier. Có kịch bản tự động chuyển đổi DNS và hạ tầng khi Region chính sập.
</details>

<details>
  <summary>Q4: Phân tích chi phí (FinOps) khi sử dụng On-demand vs Reserved vs Spot Instances trên AWS.</summary>
  
  **Trả lời:**
  On-demand: Đắt nhất, linh hoạt. Reserved: Rẻ hơn 40-60%, cam kết dùng 1-3 năm. Spot: Rẻ nhất (giảm 90%), nhưng có thể bị AWS thu hồi bất cứ lúc nào (phù hợp cho worker xử lý job không gấp).
</details>

<details>
  <summary>Q5: Thiết kế kiến trúc Microservices giao tiếp qua Service Mesh (Istio).</summary>
  
  **Trả lời:**
  Dùng Sidecar pattern. Istio quản lý: Traffic shifting, bảo mật mTLS giữa các service, observability (tracing/metrics) mà không cần sửa code ứng dụng.
</details>

<details>
  <summary>Q6: Làm thế nào để bảo mật hoàn toàn một hệ thống Container?</summary>
  
  **Trả lời:**
  Quét lỗ hổng Image (Trivy), không chạy container bằng user root, dùng Network Policies để chặn traffic thừa, mã hóa secret (Vault/KMS), giám sát runtime (Falco).
</details>

<details>
  <summary>Q7: Phân tích sự khác biệt giữa Monolith Deployment và Microservices Deployment.</summary>
  
  **Trả lời:**
  Monolith: 1 pipeline, dễ quản lý nhưng chậm chạp. Microservices: Hàng trăm pipeline độc lập, đòi hỏi tự động hóa cực cao, quản lý phiên bản và khả năng tương thích ngược giữa các service.
</details>

<details>
  <summary>Q8: Thiết kế hệ thống Centralized Logging cho môi trường phân tán.</summary>
  
  **Trả lời:**
  Dùng bộ **ELK Stack** (Elasticsearch, Logstash, Kibana) hoặc **EFK** (Fluentd). Các container đẩy log ra stdout, một agent (Fluentbit) thu thập và gửi về cluster tập trung để phân tích.
</details>

<details>
  <summary>Q9: Khi nào bạn sẽ dùng "Serverless" và khi nào dùng "Kubernetes"?</summary>
  
  **Trả lời:**
  Serverless: Task ngắn hạn, tải không đều, muốn dev nhanh, không muốn quản lý hạ tầng. Kubernetes: App chạy lâu dài, cần kiểm soát sâu hệ thống, tải lớn và ổn định (tiết kiệm hơn serverless ở quy mô lớn).
</details>

<details>
  <summary>Q10: Chiến lược tối ưu hóa CI/CD Pipeline cho hàng trăm developer.</summary>
  
  **Trả lời:**
  Parallel testing, Build caching, dùng Self-hosted runner để tăng tốc I/O, chỉ build các module có thay đổi (Incremental builds), sử dụng Docker layer caching hiệu quả.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Docker container khởi động lỗi "Exec format error". Nguyên nhân?</summary>
  
  **Xử lý:** Do sai kiến trúc CPU (ví dụ: build image trên máy Mac M1 (ARM) nhưng chạy trên server Intel (x86)). Cần dùng Docker Buildx để build cho đúng target architecture.
</details>

<details>
  <summary>S2: Server AWS EC2 bị CPU 100% liên tục. Bạn xử lý thế nào?</summary>
  
  **Xử lý:** 1. Dùng `top/htop` xem process nào chiếm. 2. Kiểm tra log web server xem có bị DDOS không. 3. Nếu do tải thực tế, nâng cấp instance (Vertical) hoặc thêm máy vào Auto Scaling group (Horizontal).
</details>

## Nên biết

- Cách Dockerizing một ứng dụng Laravel/Node.js.
- Hiểu về Security Groups trong AWS (Firewall).
- Biết cách đọc và hiểu cấu hình Nginx.

## Lưu ý

- Lưu dữ liệu vào trong Container mà không dùng Volume (mất sạch khi container restart).
- Để lộ AWS Access Key trong mã nguồn đẩy lên Github.
- Không giới hạn Resource (CPU/RAM) cho Container dẫn đến 1 container làm sập cả máy host.

## Mẹo và thủ thuật

- Luôn sử dụng `.dockerignore` để tránh copy `node_modules` hoặc `.git` vào image, giúp giảm size image đáng kể.
- Sử dụng `Healthcheck` trong Docker để Load Balancer tự động loại bỏ các container đang bị treo.
