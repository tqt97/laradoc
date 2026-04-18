---
title: "API Design: Xây dựng Giao diện Lập trình Chuyên nghiệp"
description: Hệ thống hơn 50 câu hỏi về RESTful, gRPC, GraphQL, Versioning, Security và thiết kế API có khả năng mở rộng.
date: 2025-12-05
tags: [api, rest, graphql, grpc, design]
image: /prezet/img/ogimages/knowledge-api-design.webp
---

> Một API tốt giống như một quản gia tận tụy: nó thực hiện đúng yêu cầu, dễ giao tiếp và không bao giờ gây bất ngờ tiêu cực cho người dùng.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: REST API là gì?</summary>

  **Trả lời:**
  Representational State Transfer. Là một phong cách kiến trúc sử dụng các phương thức HTTP (GET, POST, PUT, DELETE) để thao tác với tài nguyên (Resources) qua URL.
</details>

<details>
  <summary>Q2: Tài nguyên (Resource) trong API nên được đặt tên như thế nào?</summary>

  **Trả lời:**
  Nên dùng danh từ số nhiều. Ví dụ: `/users`, `/orders` thay vì `/getUser` hoặc `/all-orders`.
</details>

<details>
  <summary>Q3: Tại sao cần dùng Status Codes (mã trạng thái)?</summary>

  **Trả lời:**
  Để Client biết nhanh kết quả mà không cần đọc nội dung: 200 (OK), 201 (Created), 400 (Bad Request), 404 (Not Found), 500 (Server Error).
</details>

<details>
  <summary>Q4: JSON là gì và tại sao nó phổ biến trong API?</summary>

  **Trả lời:**
  JavaScript Object Notation. Nó nhẹ, dễ đọc cho cả người và máy, và được hầu hết các ngôn ngữ lập trình hỗ trợ.
</details>

<details>
  <summary>Q5: Phân biệt tham số Query (`?id=1`) và tham số Path (`/users/1`).</summary>

  **Trả lời:**

- Path: Dùng để xác định 1 tài nguyên cụ thể.
- Query: Dùng để lọc, sắp xếp hoặc phân trang danh sách tài nguyên.

</details>

<details>
  <summary>Q6: API Documentation là gì?</summary>

  **Trả lời:**
  Là tài liệu hướng dẫn cách sử dụng API (endpoint, tham số, dữ liệu trả về). Công cụ phổ biến nhất là Swagger/OpenAPI.
</details>

<details>
  <summary>Q7: Stateless trong API nghĩa là gì?</summary>

  **Trả lời:**
  Mỗi request từ client phải chứa đầy đủ thông tin để server hiểu và xử lý, server không lưu giữ "trạng thái" của client giữa các lần gọi.
</details>

<details>
  <summary>Q8: Payload trong một API Request là gì?</summary>

  **Trả lời:**
  Là phần thân (Body) chứa dữ liệu thực tế được gửi lên server, thường dùng cho POST, PUT, PATCH.
</details>

<details>
  <summary>Q9: API Key dùng để làm gì?</summary>

  **Trả lời:**
  Là một chuỗi định danh để server biết client nào đang gọi và có quyền truy cập hay không.
</details>

<details>
  <summary>Q10: Sự khác biệt giữa Public API và Private API.</summary>

  **Trả lời:**

- Public: Bất kỳ ai cũng có thể sử dụng (thường cần đăng ký).
- Private: Chỉ dùng nội bộ trong công ty hoặc giữa các service của chính mình.

</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Versioning API - Tại sao cần và các cách thực hiện?</summary>
  
  **Trả lời:**
  Để không làm hỏng các client cũ khi API thay đổi. Cách làm: URL (`/v1/users`), Header (`Accept: v1`), hoặc Query string (`?version=1`).
</details>

<details>
  <summary>Q2: Giải thích về Idempotency trong thiết kế API.</summary>
  
  **Trả lời:**
  Một API là lũy đẳng nếu gọi nhiều lần với cùng dữ liệu thì kết quả trên hệ thống vẫn như gọi 1 lần (GET, PUT, DELETE là lũy đẳng; POST thì không).
</details>

<details>
  <summary>Q3: HATEOAS là gì trong REST?</summary>
  
  **Trả lời:**
  Hypermedia as the Engine of Application State. Server trả về dữ liệu kèm theo các đường link dẫn tới các hành động tiếp theo có thể thực hiện.
</details>

<details>
  <summary>Q4: Thiết kế cơ chế Phân trang (Pagination) hiệu quả.</summary>
  
  **Trả lời:**
  Dùng `page` & `limit` (Offset-based) hoặc `cursor` (Cursor-based). Cursor-based tốt hơn cho dữ liệu lớn và thay đổi liên tục.
</details>

<details>
  <summary>Q5: Cách xử lý Error Response chuẩn (Error Object).</summary>
  
  **Trả lời:**
  Nên trả về một object có cấu trúc thống nhất: `error_code`, `message`, và `details` (nếu cần cho validation).
</details>

<details>
  <summary>Q6: Rate Limiting - Làm thế nào để bảo vệ API khỏi bị lạm dụng?</summary>
  
  **Trả lời:**
  Dùng thuật toán Token Bucket hoặc Leaky Bucket. Trả về lỗi 429 (Too Many Requests) kèm header `Retry-After`.
</details>

<details>
  <summary>Q7: Phân biệt PUT và PATCH về mặt ngữ nghĩa và triển khai.</summary>
  
  **Trả lời:**

- PUT: Thay thế toàn bộ tài nguyên (nếu thiếu trường sẽ bị null/default).
- PATCH: Chỉ cập nhật các trường được gửi lên (giữ nguyên các trường khác).

</details>

<details>
  <summary>Q8: Cách thiết kế API hỗ trợ đa ngôn ngữ (Localization).</summary>
  
  **Trả lời:**
  Dùng header `Accept-Language` hoặc tham số query `?lang=vi`.
</details>

<details>
  <summary>Q9: "Filtering" và "Sorting" trong API danh sách.</summary>
  
  **Trả lời:**
  Dùng query string rõ ràng. Ví dụ: `?status=active&sort=-created_at` (dấu trừ đại diện cho DESC).
</details>

<details>
  <summary>Q10: Bảo mật API bằng JWT (JSON Web Token) hoạt động thế nào?</summary>
  
  **Trả lời:**
  Client gửi username/pass -> Server trả về Token -> Client lưu và đính kèm Token vào Header `Authorization: Bearer <token>` cho mọi request sau.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Khi nào chọn GraphQL thay vì REST? Phân tích sự đánh đổi.</summary>
  
  **Trả lời:**
  Chọn GraphQL khi Client cần lấy dữ liệu phức tạp từ nhiều nguồn trong 1 request và muốn tránh Over-fetching. Đánh đổi: Caching phức tạp hơn, rủi ro query quá nặng làm sập server.
</details>

<details>
  <summary>Q2: gRPC là gì? Tại sao nó nhanh hơn REST/JSON?</summary>
  
  **Trả lời:**
  Dùng HTTP/2 và Protocol Buffers (Binary format). Dữ liệu được nén nhỏ, truyền nhanh, hỗ trợ streaming 2 chiều và Strong typing.
</details>

<details>
  <summary>Q3: Thiết kế cơ chế Webhooks an toàn.</summary>
  
  **Trả lời:**
  Server bắn request tới Client khi có sự kiện. An toàn: Dùng `X-Hub-Signature` (HMAC) để client xác thực request thực sự đến từ server mình.
</details>

<details>
  <summary>Q4: Làm thế nào để xử lý "Long-running Tasks" qua API?</summary>
  
  **Trả lời:**
  Trả về 202 Accepted kèm `job_id`. Client sẽ polling vào endpoint `/jobs/{id}` để kiểm tra trạng thái hoặc server bắn Webhook khi xong.
</details>

<details>
  <summary>Q5: Phân tích cơ chế "API Gateway" trong hệ thống Microservices.</summary>
  
  **Trả lời:**
  Là cổng vào duy nhất, chịu trách nhiệm: Routing, Authentication, Rate Limiting, Logging, và Response Aggregation (gộp data từ nhiều service).
</details>

<details>
  <summary>Q6: Cách thiết kế API hỗ trợ "Batch Requests" (nhiều hành động trong 1 call).</summary>
  
  **Trả lời:**
  Nhận một mảng các operations. Cần quyết định xem nếu 1 cái lỗi thì có rollback tất cả (Atomic) hay vẫn xử lý các cái khác (Partial success).
</details>

<details>
  <summary>Q7: Giải thích về "Idempotency Key" trong các API thanh toán.</summary>
  
  **Trả lời:**
  Client gửi kèm 1 key duy nhất. Nếu server nhận được 2 request cùng key, nó sẽ trả về kết quả của lần đầu thay vì thực hiện giao dịch lần 2.
</details>

<details>
  <summary>Q8: Làm thế nào để tối ưu "API Response Time" (TTFB)?</summary>
  
  **Trả lời:**
  Dùng Eager loading, Caching (Redis), Gzip compression, và giảm thiểu số lượng Join trong database.
</details>

<details>
  <summary>Q9: Phân biệt "Internal API" và "External API" về mặt thiết kế bảo mật.</summary>
  
  **Trả lời:**
  Internal có thể dùng mTLS, tin tưởng lẫn nhau hơn. External cần OAuth2, Rate limit gắt gao, và tài liệu cực kỳ chi tiết.
</details>

<details>
  <summary>Q10: "API First Design" là gì?</summary>
  
  **Trả lời:**
  Viết tài liệu (OpenAPI spec) trước khi viết code. Giúp team Frontend và Backend có thể làm việc song song dựa trên "hợp đồng" đã chốt.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế hệ thống API cho ứng dụng Global phục vụ 100 triệu người dùng.</summary>
  
  **Trả lời:**
  Dùng Edge Computing/CDN để cache response. Triển khai API Gateway đa vùng (Multi-region). Dùng cơ chế Token-based Auth stateless để dễ scale ngang.
</details>

<details>
  <summary>Q2: Làm thế nào để thực hiện "Zero-downtime API Migration" khi thay đổi hoàn toàn cấu trúc dữ liệu?</summary>
  
  **Trả lời:**
  Hỗ trợ song song cả 2 version. Dùng Adapter layer để map dữ liệu cũ sang mới. Monitor traffic và dần dần tắt version cũ sau khi thông báo cho client.
</details>

<details>
  <summary>Q3: Phân tích chiến lược "BFF" (Backend For Frontend).</summary>
  
  **Trả lời:**
  Tạo các service riêng cho từng loại client (Mobile, Web, IoT) để tối ưu hóa payload và logic phù hợp nhất cho từng thiết bị.
</details>

<details>
  <summary>Q4: Thiết kế giải pháp "Service Mesh" cho giao tiếp giữa hàng nghìn API nội bộ.</summary>
  
  **Trả lời:**
  Dùng Istio/Linkerd. Tách biệt logic hạ tầng (Retries, Circuit breaker, Auth) ra khỏi mã nguồn ứng dụng qua Sidecar proxy.
</details>

<details>
  <summary>Q5: Tầm nhìn: Sự trỗi dậy của Event-driven API (AsyncAPI).</summary>
  
  **Trả lời:**
  Thay vì Request-Response truyền thống, hệ thống giao tiếp qua Events. Dùng AsyncAPI để mô tả các message, channel giúp hệ thống cực kỳ linh hoạt và chịu tải tốt.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Client phàn nàn API trả về quá nhiều dữ liệu thừa làm chậm app mobile. Giải pháp?</summary>
  
  **Xử lý:** 1. Triển khai tham số `?fields=id,name` để client tự chọn cột. 2. Hoặc xây dựng GraphQL layer. 3. Hoặc dùng BFF để trả về payload thu gọn.
</details>

<details>
  <summary>S2: API của bạn bị tấn công Brute-force vào endpoint đăng nhập. Cách xử lý?</summary>
  
  **Xử lý:** 1. Implement Rate Limiting theo IP và Username. 2. Bật cơ chế Account Lockout sau 5 lần sai. 3. Trả về mã lỗi chung (không báo là sai pass hay sai user).
</details>

## Nên biết

- Các phương thức HTTP và Status Codes.
- Cách thiết kế URL chuẩn RESTful.
- Bảo mật API cơ bản (Auth, Rate limit).

## Lưu ý

- Trả về lỗi 200 kèm nội dung "error: true" (sai nguyên tắc HTTP).
- Không có tài liệu (Document) hoặc tài liệu sai lệch với code.
- Để lộ thông tin nhạy cảm (như mật khẩu, token) trong URL.

## Mẹo và thủ thuật

- Luôn sử dụng `Snake_case` hoặc `camelCase` thống nhất cho toàn bộ API.
- Dùng `UUID` thay vì `Auto-increment ID` trong URL để bảo mật thông tin.
