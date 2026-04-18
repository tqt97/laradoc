---
title: "Kiến trúc & Thiết kế Hệ thống: Tư duy Architect"
description: Hệ thống hơn 50 câu hỏi về Clean Architecture, Microservices, Event-Driven, Scalability và System Design Patterns.
date: 2026-04-14
tags: [architecture, system-design, solid, ddd, clean-architecture]
image: /prezet/img/ogimages/knowledge-architecture-system-design.webp
---

> Kiến trúc không phải là việc chọn Framework, mà là việc quản lý sự phức tạp và các luồng dữ liệu trong hệ thống.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Tại sao chúng ta cần phân chia Layer (Tầng) trong ứng dụng?</summary>
  
  **Trả lời:**
  Để đảm bảo tính **Separation of Concerns**. Giúp thay đổi một bộ phận (ví dụ: đổi giao diện) mà không làm hỏng bộ phận khác (ví dụ: logic tính toán).
</details>

<details>
  <summary>Q2: Dependency Injection (DI) là gì?</summary>
  
  **Trả lời:**
  Là kỹ thuật cung cấp các phụ thuộc từ bên ngoài vào Class thay vì để Class tự khởi tạo. Giúp code linh hoạt và dễ test.
</details>

<details>
  <summary>Q3: Client-Server model là gì?</summary>
  
  **Trả lời:**
  Mô hình mà Client (trình duyệt/app) gửi yêu cầu và Server xử lý yêu cầu đó rồi trả về kết quả.
</details>

<details>
  <summary>Q4: Monolith Architecture (Kiến trúc đơn khối) là gì?</summary>
  
  **Trả lời:**
  Toàn bộ ứng dụng nằm chung trong một source code duy nhất và chạy trên một server duy nhất.
</details>

<details>
  <summary>Q5: API là gì và tại sao nó quan trọng trong thiết kế hệ thống?</summary>
  
  **Trả lời:**
  Application Programming Interface. Là "cửa sổ" để các phần mềm khác nhau có thể giao tiếp và trao đổi dữ liệu với nhau một cách chuẩn hóa.
</details>

<details>
  <summary>Q6: Khái niệm "Don't Repeat Yourself" (DRY) trong kiến trúc?</summary>
  
  **Trả lời:**
  Hạn chế lặp lại code. Mỗi phần kiến thức hoặc logic phải có một biểu diễn duy nhất và rõ ràng trong hệ thống.
</details>

<details>
  <summary>Q7: Stateless ứng dụng nghĩa là gì?</summary>
  
  **Trả lời:**
  Ứng dụng không lưu giữ dữ liệu phiên làm việc của người dùng trên bộ nhớ máy chủ, giúp dễ dàng mở rộng bằng cách thêm nhiều server.
</details>

<details>
  <summary>Q8: Vai trò của một Database trong hệ thống lớn?</summary>
  
  **Trả lời:**
  Đảm bảo dữ liệu được lưu trữ an toàn, nhất quán, hỗ trợ truy vấn nhanh và phục hồi dữ liệu khi có sự cố.
</details>

<details>
  <summary>Q9: Phân biệt Frontend và Backend.</summary>
  
  **Trả lời:**
  Frontend: Phần người dùng thấy và tương tác. Backend: Phần xử lý logic, tính toán và lưu trữ dữ liệu ngầm.
</details>

<details>
  <summary>Q10: "Single Point of Failure" (SPOF) là gì?</summary>
  
  **Trả lời:**
  Một thành phần mà nếu nó lỗi thì cả hệ thống sập theo. Mục tiêu của kiến trúc sư là loại bỏ SPOF.
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Phân biệt Coupling (Độ kết dính) và Cohesion (Độ gắn kết).</summary>
  
  **Trả lời:**
  Cohesion: Các thành phần trong 1 module liên quan chặt chẽ (nên cao). Coupling: Sự phụ thuộc giữa các module (nên thấp).
</details>

<details>
  <summary>Q2: Repository Pattern là gì? Lợi ích?</summary>
  
  **Trả lời:**
  Lớp trung gian giữa Business Logic và Data Source. Giúp tách biệt logic nghiệp vụ khỏi cách dữ liệu được lưu trữ.
</details>

<details>
  <summary>Q3: Inversion of Control (IoC) hoạt động như thế nào?</summary>
  
  **Trả lời:**
  Đảo ngược quyền điều khiển. Framework sẽ gọi code của bạn thay vì bạn gọi Framework.
</details>

<details>
  <summary>Q4: Service-Oriented Architecture (SOA) là gì?</summary>
  
  **Trả lời:**
  Thiết kế phần mềm dựa trên các dịch vụ có thể tái sử dụng, giao tiếp với nhau qua mạng.
</details>

<details>
  <summary>Q5: Phân biệt Authentication và Authorization trong hệ thống phân tán.</summary>
  
  **Trả lời:**
  AuthN xác định bạn là ai (Login). AuthZ xác định bạn được làm gì (Permissions). Trong hệ thống phân tán thường dùng JWT để truyền thông tin AuthZ.
</details>

<details>
  <summary>Q6: Cơ chế Pub/Sub (Publisher/Subscriber) pattern?</summary>

  **Trả lời:**
  Bên gửi (Publisher) không gửi tin nhắn trực tiếp cho bên nhận, mà bắn lên một kênh. Các bên nhận (Subscriber) đăng ký kênh đó sẽ nhận được tin. Giúp giảm sự phụ thuộc trực tiếp.
</details>

<details>
  <summary>Q7: Layered Architecture (Kiến trúc phân tầng) gồm những tầng nào phổ biến?</summary>
  
  **Trả lời:**
  Presentation Layer, Business/Service Layer, Persistence/Data Layer, Database Layer.
</details>

<details>
  <summary>Q8: Phân biệt MVC và MVVM.</summary>
  
  **Trả lời:**
  MVC: Controller điều phối. MVVM: ViewModel đồng bộ dữ liệu tự động với View qua Data Binding (phổ biến trong Frontend framework).
</details>

<details>
  <summary>Q9: Rate Limiting là gì? Tại sao hệ thống cần nó?</summary>
  
  **Trả lời:**
  Giới hạn số lượng request một user/IP có thể gửi trong một khoảng thời gian để bảo vệ server khỏi bị quá tải hoặc tấn công.
</details>

<details>
  <summary>Q10: Idempotency (Tính lũy đẳng) trong thiết kế API là gì?</summary>
  
  **Trả lời:**
  Đảm bảo thực hiện một yêu cầu nhiều lần cũng có kết quả giống như một lần duy nhất (rất quan trọng cho các lệnh thanh toán).
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Clean Architecture hoạt động như thế nào? Quy tắc phụ thuộc?</summary>
  
  **Trả lời:**
  Chia ứng dụng thành các vòng tròn đồng tâm. Quy tắc: Sự phụ thuộc chỉ được trỏ vào bên trong. Lõi (Entities) không được biết gì về Framework bên ngoài.
</details>

<details>
  <summary>Q2: Domain-Driven Design (DDD) - Entity vs Value Object vs Aggregate Root.</summary>
  
  **Trả lời:**
  Entity có ID. Value Object xác định bằng thuộc tính. Aggregate Root là cổng giao tiếp duy nhất của một nhóm đối tượng liên quan.
</details>

<details>
  <summary>Q3: CQRS (Command Query Responsibility Segregation) giải quyết vấn đề gì?</summary>
  
  **Trả lời:**
  Tách biệt logic Đọc và Ghi. Giúp tối ưu hóa hiệu năng cho từng loại thao tác (ví dụ: Ghi vào MySQL, Đọc từ Elasticsearch).
</details>

<details>
  <summary>Q4: Event Sourcing là gì? Ưu và nhược điểm?</summary>
  
  **Trả lời:**
  Lưu trữ mọi thay đổi trạng thái thành một chuỗi các Event thay vì chỉ lưu trạng thái cuối cùng. Ưu: Audit log tuyệt vời, khôi phục dữ liệu tại mọi thời điểm. Nhược: Phức tạp để truy vấn trạng thái hiện tại.
</details>

<details>
  <summary>Q5: Microservices vs Monolith: Phân tích sự đánh đổi về mặt Network và Data Consistency.</summary>
  
  **Trả lời:**
  Microservices: Linh hoạt, scale độc lập nhưng gặp vấn đề về độ trễ mạng và khó khăn trong việc đảm bảo dữ liệu nhất quán giữa các dịch vụ (Eventual Consistency).
</details>

<details>
  <summary>Q6: Giải thích mẫu thiết kế Sidecar trong kiến trúc Container.</summary>
  
  **Trả lời:**
  Chạy một container phụ cạnh container chính để hỗ trợ (ví dụ: log agent, proxy bảo mật) mà không làm thay đổi code của container chính.
</details>

<details>
  <summary>Q7: Circuit Breaker pattern hoạt động như thế nào?</summary>
  
  **Trả lời:**
  Ngắt kết nối tới một dịch vụ đang lỗi để tránh làm sập hệ thống dây chuyền. Có 3 trạng thái: Closed, Open, Half-Open.
</details>

<details>
  <summary>Q8: API Gateway đóng vai trò gì trong hệ thống Microservices?</summary>
  
  **Trả lời:**
  Cổng vào duy nhất cho Client. Đảm nhận: Routing, Authentication, Rate Limiting, Logging, và gộp dữ liệu từ nhiều service (Aggregator).
</details>

<details>
  <summary>Q9: Phân biệt Orchestration và Choreography trong điều phối Microservices.</summary>
  
  **Trả lời:**
  Orchestration: 1 bộ não trung tâm chỉ đạo. Choreography: Mỗi service tự phản ứng dựa trên các sự kiện (Events) nhận được.
</details>

<details>
  <summary>Q10: CAP Theorem - Tại sao bạn không thể có cả 3?</summary>
  
  **Trả lời:**
  Consistency, Availability, Partition Tolerance. Trong hệ thống phân tán luôn có rủi ro đứt mạng (P), nên bạn buộc phải chọn giữa sự nhất quán (C) hoặc tính sẵn sàng (A).
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế hệ thống xử lý 1 triệu giao dịch mỗi giây.</summary>
  
  **Trả lời:**
  Dùng kiến trúc **Distributed & Scalable**. Load Balancer tầng 4/7. Microservices stateless. Message Queue (Kafka) để buffer dữ liệu. In-memory DB (Redis) cho hot data. Database sharding.
</details>

<details>
  <summary>Q2: Làm thế nào để xử lý "Data Consistency" trong Microservices (Saga Pattern)?</summary>
  
  **Trả lời:**
  Thay vì Transaction toàn cục, Saga chia thành chuỗi các transaction cục bộ. Nếu 1 bước lỗi, thực hiện Compensating Transaction để hoàn tác các bước trước đó.
</details>

<details>
  <summary>Q3: Thiết kế giải pháp cho hệ thống bị "Thundering Herd" khi Cache hết hạn.</summary>
  
  **Trả lời:**
  Dùng Mutex lock (chỉ 1 request đi vào DB nạp cache), hoặc nạp cache ngầm (Soft Expiration) khi gần hết hạn.
</details>

<details>
  <summary>Q4: Phân tích kiến trúc Serverless: Khi nào nó là "bẫy chi phí"?</summary>
  
  **Trả lời:**
  Rẻ khi tải thấp và không đều. Đắt kinh khủng khi tải cao và ổn định 24/7. Gặp vấn đề về "Cold Start" và khó debug.
</details>

<details>
  <summary>Q5: Thiết kế hệ thống "Distributed Tracing" để theo dõi request qua hàng chục service.</summary>
  
  **Trả lời:**
  Dùng **Trace ID** duy nhất đính kèm vào Header của mọi request. Sử dụng các công cụ như Jaeger hoặc Zipkin để thu thập và trực quan hóa luồng đi của dữ liệu.
</details>

<details>
  <summary>Q6: Làm thế nào để thực hiện "Zero-Downtime Migration" cho một Database khổng lồ?</summary>
  
  **Trả lời:**
  Dùng Dual-Write: Ghi vào cả DB cũ và mới. Copy dữ liệu cũ sang mới ngầm. So sánh dữ liệu. Chuyển Đọc sang DB mới. Ngắt DB cũ.
</details>

<details>
  <summary>Q7: Thiết kế kiến trúc "Multi-tenant" cho ứng dụng SaaS (Shared vs Isolated DB).</summary>
  
  **Trả lời:**
  Shared DB: Tiết kiệm, dễ quản lý nhưng rủi ro lộ dữ liệu chéo. Isolated DB: Bảo mật tuyệt đối, dễ scale riêng từng khách hàng nhưng chi phí hạ tầng cao.
</details>

<details>
  <summary>Q8: Phân tích sự đánh đổi giữa Latency và Throughput.</summary>
  
  **Trả lời:**
  Latency: Thời gian xử lý 1 request. Throughput: Tổng số request xử lý được trong 1 giây. Tối ưu 1 cái thường làm giảm cái kia (ví dụ: Batching tăng throughput nhưng tăng latency cho từng request).
</details>

<details>
  <summary>Q9: Thiết kế hệ thống "Real-time Analytics" cho hàng tỷ sự kiện mỗi ngày.</summary>
  
  **Trả lời:**
  Dùng mô hình **Lambda Architecture** hoặc **Kappa Architecture**. Kafka cho stream dữ liệu. Apache Druid hoặc ClickHouse cho việc truy vấn phân tích siêu nhanh.
</details>

<details>
  <summary>Q10: Làm thế nào để đảm bảo hệ thống "Resilient" trước thảm họa (Disaster Recovery)?</summary>
  
  **Trả lời:**
  Deploy Multi-region. Dữ liệu replication liên tục. Có kịch bản diễn tập định kỳ (Chaos Engineering) để tự động switch sang Region dự phòng khi Region chính sập.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Hệ thống bị treo do một vòng lặp sự kiện (Event Loop) bị block. Bạn xử lý thế nào?</summary>
  
  **Xử lý:** Tìm đoạn code xử lý CPU intensive hoặc I/O block đồng bộ. Chuyển các tác vụ đó sang Worker pool hoặc xử lý bất đồng bộ hoàn toàn.
</details>

<details>
  <summary>S2: Database quá tải do vạn lượt truy cập vào cùng 1 bài viết hot. Giải pháp?</summary>

  **Xử lý:** Triển khai **Hot Key Caching** với Redis. Sử dụng Local Cache ngay tại App server để không phải gọi ra Redis/DB liên tục.
</details>

## Nên biết

* Sự khác biệt bản chất giữa Monolith và Microservices.
* Hiểu rõ 5 nguyên lý SOLID.
* Biết cách áp dụng Design Patterns phù hợp.

## Lưu ý

* Over-engineering: Áp dụng kiến trúc quá phức tạp cho bài toán đơn giản.
* Quên không xử lý lỗi mạng giữa các service (Network is unreliable).
* Database trở thành nút thắt cổ chai do join quá nhiều bảng.

## Mẹo và thủ thuật

* Luôn thiết kế hệ thống theo hướng **Stateless** ngay từ đầu.
* Sử dụng **Feature Flags** để bật/tắt tính năng mới mà không cần deploy lại.
