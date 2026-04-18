---
title: "Observability & Monitoring: Làm chủ Trạng thái Hệ thống"
description: Hệ thống hơn 50 câu hỏi về Logging, Metrics, Tracing, APM và chiến lược giám sát hệ thống phân tán.
date: 2026-04-18
tags: [observability, monitoring, logging, tracing, metrics]
image: /prezet/img/ogimages/knowledge-vi-observability-monitoring.webp
---

> Đừng đợi đến khi người dùng phàn nàn mới biết hệ thống lỗi. Khả năng quan sát (Observability) giúp bạn hiểu "tại sao" hệ thống lại hành xử như vậy.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Monitoring (Giám sát) và Observability (Khả năng quan sát) khác nhau thế nào?</summary>
  
  **Trả lời:**

- Monitoring báo cho bạn biết hệ thống có lỗi (Cái gì lỗi?).
- Observability giúp bạn tìm ra nguyên nhân gốc rễ của lỗi (Tại sao lỗi?).

</details>

<details>
  <summary>Q2: 3 trụ cột của Observability là gì?</summary>
  
  **Trả lời:**
  Logs (Nhật ký), Metrics (Chỉ số), và Traces (Dấu vết).
</details>

<details>
  <summary>Q3: Logging là gì?</summary>
  
  **Trả lời:**
  Là việc ghi lại các sự kiện cụ thể xảy ra trong ứng dụng (ví dụ: "User A vừa đăng nhập", "Lỗi kết nối DB").
</details>

<details>
  <summary>Q4: Metrics là gì? Cho ví dụ.</summary>
  
  **Trả lời:**
  Là các dữ liệu định lượng đo lường theo thời gian. Ví dụ: Tỷ lệ CPU sử dụng, Số lượng request mỗi giây, Dung lượng RAM còn trống.
</details>

<details>
  <summary>Q5: Alerting là gì?</summary>
  
  **Trả lời:**
  Cơ chế tự động thông báo (qua Email, Slack, Telegram) khi một chỉ số vượt ngưỡng an toàn (ví dụ: Error rate > 5%).
</details>

<details>
  <summary>Q6: Log Level là gì? Kể tên các level phổ biến.</summary>
  
  **Trả lời:**
  Mức độ quan trọng của log: DEBUG, INFO, NOTICE, WARNING, ERROR, CRITICAL, ALERT, EMERGENCY.
</details>

<details>
  <summary>Q7: Tại sao không nên log quá nhiều thông tin DEBUG trên Production?</summary>
  
  **Trả lời:**
  Làm tốn dung lượng ổ cứng, làm chậm ứng dụng do I/O, và gây khó khăn khi tìm kiếm thông tin quan trọng trong "biển" log rác.
</details>

<details>
  <summary>Q8: Dashboard là gì?</summary>
  
  **Trả lời:**
  Giao diện trực quan hóa các Metrics và Logs bằng biểu đồ, giúp con người nhanh chóng nắm bắt trạng thái hệ thống.
</details>

<details>
  <summary>Q9: Health Check là gì?</summary>
  
  **Trả lời:**
  Một endpoint (ví dụ `/health`) để Load Balancer hoặc công cụ giám sát kiểm tra xem service còn sống và hoạt động bình thường không.
</details>

<details>
  <summary>Q10: Uptime là chỉ số gì?</summary>
  
  **Trả lời:**
  Thời gian hệ thống hoạt động liên tục mà không bị sập, thường tính theo tỷ lệ phần trăm (ví dụ: 99.9% uptime).
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Structured Logging là gì và tại sao nó tốt hơn Plain text logging?</summary>
  
  **Trả lời:**
  Log dưới dạng JSON hoặc Key-Value. Giúp các công cụ tìm kiếm (như Elasticsearch) dễ dàng phân tích, lọc và thống kê dữ liệu.
</details>

<details>
  <summary>Q2: Distributed Tracing giải quyết vấn đề gì?</summary>
  
  **Trả lời:**
  Theo dõi một request duy nhất khi nó đi xuyên qua nhiều microservices khác nhau, giúp xác định xem bước nào bị chậm hoặc gây lỗi.
</details>

<details>
  <summary>Q3: Phân biệt Pull-based và Push-based monitoring.</summary>
  
  **Trả lời:**

- Pull (Prometheus): Server giám sát chủ động gọi vào app để lấy dữ liệu.
- Push (CloudWatch, Datadog): App chủ động gửi dữ liệu về server giám sát.

</details>

<details>
  <summary>Q4: APM (Application Performance Monitoring) là gì?</summary>
  
  **Trả lời:**
  Công cụ giám sát chuyên sâu hiệu năng ứng dụng: thời gian chạy code, query DB chậm, lỗi runtime (ví dụ: New Relic, Dynatrace, Elastic APM).
</details>

<details>
  <summary>Q5: "Centralized Logging" - Tại sao không nên đọc log bằng lệnh `tail -f` trên từng server?</summary>
  
  **Trả lời:**
  Khi có hàng chục server, việc vào từng máy rất mất thời gian. Cần đẩy log về một nơi tập trung (ELK Stack, Graylog) để tìm kiếm và phân tích toàn cục.
</details>

<details>
  <summary>Q6: Ý nghĩa của chỉ số Latency (Độ trễ) và cách đo (p50, p95, p99).</summary>
  
  **Trả lời:**

- p50 (Median): 50% request nhanh hơn mức này.
- p99: Chỉ 1% request chậm hơn mức này. Đo p99 giúp phát hiện các vấn đề ảnh hưởng đến nhóm người dùng kém may mắn nhất.

</details>

<details>
  <summary>Q7: Làm thế nào để log mà không làm chậm ứng dụng (Async Logging)?</summary>
  
  **Trả lời:**
  Thay vì ghi trực tiếp vào file/network trong request, đẩy log vào một buffer hoặc queue (như Redis) để một process riêng xử lý ghi sau đó.
</details>

<details>
  <summary>Q8: Khái niệm "Log Rotation" là gì?</summary>
  
  **Trả lời:**
  Tự động nén và xóa các file log cũ theo thời gian hoặc dung lượng để tránh làm đầy ổ cứng server.
</details>

<details>
  <summary>Q9: "Correlation ID" trong logging là gì?</summary>
  
  **Trả lời:**
  Một ID duy nhất được gán cho mỗi request. Mọi log liên quan đến request đó (từ lúc vào đến lúc ra, qua nhiều hàm/service) đều đính kèm ID này để dễ truy vết.
</details>

<details>
  <summary>Q10: Sự khác biệt giữa Counters, Gauges và Histograms trong Metrics.</summary>
  
  **Trả lời:**

- Counter: Chỉ tăng (số request).
- Gauge: Tăng hoặc giảm (lượng RAM).
- Histogram: Phân bổ dữ liệu (thời gian phản hồi).

</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Giải thích cơ chế hoạt động của ELK Stack (Elasticsearch, Logstash, Kibana).</summary>
  
  **Trả lời:**
  Logstash thu thập và biến đổi log -> Elasticsearch lưu trữ và đánh index -> Kibana cung cấp giao diện trực quan hóa và tìm kiếm.
</details>

<details>
  <summary>Q2: OpenTelemetry là gì và tại sao nó là tương lai của Observability?</summary>
  
  **Trả lời:**
  Là một chuẩn chung (Open standard) cho việc thu thập Logs, Metrics, Traces. Giúp bạn chuyển đổi giữa các nhà cung cấp (như từ Datadog sang New Relic) mà không cần sửa code.
</details>

<details>
  <summary>Q3: Làm thế nào để giám sát "Silent Failures" (lỗi không throw exception)?</summary>
  
  **Trả lời:**
  Dùng Metrics để theo dõi các hành vi bất thường (ví dụ: số đơn hàng thành công giảm đột ngột dù không có log lỗi).
</details>

<details>
  <summary>Q4: "Semantic Logging" là gì?</summary>
  
  **Trả lời:**
  Log tập trung vào ý nghĩa nghiệp vụ thay vì thông tin kỹ thuật (ví dụ: `UserPurchasedProduct` thay vì `InsertIntoOrderTable`).
</details>

<details>
  <summary>Q5: Phân tích chiến lược Alerting để tránh "Alert Fatigue" (mệt mỏi vì quá nhiều cảnh báo).</summary>
  
  **Trả lời:**
  Chỉ cảnh báo cho những lỗi cần can thiệp ngay (Actionable). Phân loại mức độ: P1 (gọi điện), P2 (Slack), P3 (chỉ ghi log). Dùng cơ chế Deduplication để không bắn 1000 tin cho cùng 1 lỗi.
</details>

<details>
  <summary>Q6: "Black-box Monitoring" vs "White-box Monitoring".</summary>
  
  **Trả lời:**

- Black-box: Kiểm tra từ bên ngoài (như user thấy): ping, check HTTP status.
- White-box: Kiểm tra từ bên trong app: log, metrics nội bộ, trạng thái queue.

</details>

<details>
  <summary>Q7: Làm thế nào để bảo mật Logs (tránh lộ PII - thông tin cá nhân)?</summary>
  
  **Trả lời:**
  Dùng cơ chế Masking hoặc Redaction để tự động ẩn mật khẩu, số thẻ tín dụng, email... trước khi ghi vào log.
</details>

<details>
  <summary>Q8: Giải thích về "Sampling" trong Distributed Tracing.</summary>
  
  **Trả lời:**
  Chỉ lưu trữ vết của một phần nhỏ request (ví dụ 1% hoặc 10%) để tiết kiệm chi phí lưu trữ và băng thông mà vẫn đảm bảo tính thống kê.
</details>

<details>
  <summary>Q9: Tối ưu hóa chi phí lưu trữ Metrics (Downsampling).</summary>
  
  **Trả lời:**
  Giảm độ phân giải của dữ liệu cũ (ví dụ: dữ liệu 1 năm trước chỉ giữ lại trung bình theo giờ thay vì theo phút).
</details>

<details>
  <summary>Q10: Làm thế nào để giám sát các "Third-party Dependencies" (API bên ngoài)?</summary>
  
  **Trả lời:**
  Wrap các cuộc gọi API bằng các công cụ đo lường thời gian và tỷ lệ lỗi. Dùng cơ chế Circuit Breaker để tự động ngắt khi API bên ngoài sập.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế hệ thống Observability cho kiến trúc 100+ Microservices.</summary>
  
  **Trả lời:**
  Sử dụng OpenTelemetry collector làm agent trung gian. Triển khai Distributed Tracing (Jaeger/Zipkin). Centralized Logging qua cụm ELK/Loki. Dashboard tổng quát qua Grafana.
</details>

<details>
  <summary>Q2: Phân tích sự đánh đổi giữa "Log Everything" và chi phí vận hành.</summary>
  
  **Trả lời:**
  Chi phí lưu trữ và phân tích log có thể vượt quá chi phí chạy ứng dụng. Architect cần xác định: Cái gì CẦN log vĩnh viễn, cái gì chỉ cần Metrics, và cái gì có thể xóa sau 7 ngày.
</details>

<details>
  <summary>Q3: Định nghĩa SLA, SLO, SLI và cách triển khai giám sát chúng.</summary>
  
  **Trả lời:**

- SLI: Chỉ số đo được (Uptime).
- SLO: Mục tiêu hướng tới (99.9% uptime).
- SLA: Cam kết với khách hàng (Nếu không đạt 99.9% sẽ bồi thường).
  Triển khai bằng cách tạo Dashboard theo dõi "Error Budget".

</details>

<details>
  <summary>Q4: Làm thế nào để xây dựng hệ thống "Self-healing" dựa trên Monitoring?</summary>
  
  **Trả lời:**
  Khi Metrics báo quá tải hoặc lỗi liên tục -> Kích hoạt Automation script (ví dụ: tự động restart container, tự động scale thêm server, hoặc tự động switch sang Region dự phòng).
</details>

<details>
  <summary>Q5: Tầm nhìn: AI/ML trong Observability (AIOps).</summary>
  
  **Trả lời:**
  Sử dụng máy học để tự động phát hiện hành vi bất thường (Anomaly detection) mà con người không thể định nghĩa bằng các luật tĩnh (static rules).
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: User báo lỗi "Không thể thanh toán" nhưng bạn kiểm tra log Error không thấy gì. Giải pháp?</summary>
  
  **Xử lý:** 1. Kiểm tra log INFO/DEBUG của request đó để xem luồng đi. 2. Kiểm tra log của các service liên quan (Payment Gateway). 3. Kiểm tra Metrics để xem có sụt giảm tỷ lệ success không.
</details>

<details>
  <summary>S2: Server bị đầy ổ cứng do file log quá lớn. Bạn xử lý khẩn cấp và lâu dài thế nào?</summary>
  
  **Xử lý:** 1. Khẩn cấp: Xóa file log cũ (`.log.1`, `.gz`). 2. Lâu dài: Cấu hình `logrotate`, đẩy log về server trung tâm, và kiểm tra lại Log Level.
</details>

## Nên biết

- 3 trụ cột: Logs, Metrics, Traces.
- Các mức độ Log Level.
- Cách thiết lập Alerting cơ bản.

## Lưu ý

- Log thông tin nhạy cảm (mật khẩu, token) vào log file.
- Đặt cảnh báo quá nhạy dẫn đến "nhiễu" cảnh báo.
- Chỉ giám sát App mà quên giám sát Hạ tầng (CPU, Disk, Network).

## Mẹo và thủ thuật

- Luôn đính kèm ngữ cảnh (Context) vào log: User ID, Request ID, IP.
- Dùng `Log::channel()` trong Laravel để tách biệt các loại log khác nhau vào các file/server khác nhau.
