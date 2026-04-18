---
title: "Lập trình Core & Nền tảng PHP: Từ Cơ bản đến Chuyên gia"
description: Hệ thống hơn 50 câu hỏi chuyên sâu về PHP Internals, OOP, SOLID và Tư duy lập trình Backend.
date: 2026-01-25
tags: [php, core, oop, solid, internals]
image: /prezet/img/ogimages/knowledge-vi-php-fundamentals-oop.webp
---

> Để thực sự làm chủ Laravel, bạn không thể chỉ học Laravel. Bạn phải hiểu cách PHP vận hành bên dưới lớp vỏ bọc của Framework.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: PHP thực thi mã nguồn như thế nào? Giải thích mô hình Request-Response.</summary>
  
  **Trả lời:**
  PHP là một ngôn ngữ kịch bản phía máy chủ (Server-side). Mỗi khi có một yêu cầu (Request) từ trình duyệt, máy chủ (như Nginx/Apache) sẽ gọi PHP để thực thi file script.
  
  **Tại sao:** PHP hoạt động theo mô hình "Shared Nothing". Tức là sau khi PHP xử lý xong một Request và trả về kết quả (Response), toàn bộ tài nguyên (biến, bộ nhớ) sẽ bị xóa sạch. Request tiếp theo sẽ bắt đầu từ con số 0.
</details>

<details>
  <summary>Q2: OOP (Lập trình hướng đối tượng) là gì và 4 tính chất cơ bản?</summary>
  
  **Trả lời:**
  OOP là một phương pháp lập trình dựa trên các "đối tượng" (Objects) chứa dữ liệu và hành động. 4 tính chất: Encapsulation (Đóng gói), Inheritance (Kế thừa), Polymorphism (Đa hình), Abstraction (Trừu tượng).
</details>

<details>
  <summary>Q3: Biến trong PHP bắt đầu bằng ký tự gì và quy tắc đặt tên là gì?</summary>
  
  **Trả lời:**
  Biến bắt đầu bằng `$`. Quy tắc: Phải bắt đầu bằng chữ cái hoặc dấu gạch dưới, không được bắt đầu bằng số, phân biệt chữ hoa chữ thường.
</details>

<details>
  <summary>Q4: Các kiểu dữ liệu cơ bản trong PHP là gì?</summary>
  
  **Trả lời:**
  String, Integer, Float, Boolean, Array, Object, NULL, Resource.
</details>

<details>
  <summary>Q5: Sự khác biệt giữa `==` và `===` là gì?</summary>
  
  **Trả lời:**

- `==` (Loose comparison): So sánh giá trị sau khi ép kiểu (Ví dụ: `'1' == 1` là true).
- `===` (Strict comparison): So sánh cả giá trị và kiểu dữ liệu (Ví dụ: `'1' === 1` là false).

</details>

<details>
  <summary>Q6: Hàm `isset()` và `empty()` khác nhau như thế nào?</summary>
  
  **Trả lời:**

- `isset()`: Kiểm tra biến có được khởi tạo và khác NULL hay không.
- `empty()`: Kiểm tra biến có giá trị "trống" hay không (NULL, false, 0, "", mảng rỗng).

</details>

<details>
  <summary>Q7: `include` và `require` khác nhau như thế nào?</summary>
  
  **Trả lời:**

- `include`: Nếu lỗi (không tìm thấy file), chỉ đưa ra cảnh báo (Warning) và script vẫn tiếp tục chạy.
- `require`: Nếu lỗi, sẽ gây ra lỗi nghiêm trọng (Fatal Error) và dừng script ngay lập tức.

</details>

<details>
  <summary>Q8: Mảng (Array) trong PHP có mấy loại?</summary>
  
  **Trả lời:**
  3 loại: Mảng chỉ số (Indexed arrays), Mảng kết hợp (Associative arrays), Mảng đa chiều (Multidimensional arrays).
</details>

<details>
  <summary>Q9: Constructor trong PHP là gì?</summary>
  
  **Trả lời:**
  Lớp phương thức đặc biệt `__construct()` tự động được gọi khi một đối tượng (object) được tạo ra từ lớp.
</details>

<details>
  <summary>Q10: Phạm vi truy cập (Visibility) trong OOP PHP gồm những gì?</summary>
  
  **Trả lời:**

- `public`: Truy cập được từ bất cứ đâu.
- `protected`: Chỉ truy cập được trong nội bộ lớp và các lớp kế thừa.
- `private`: Chỉ truy cập được duy nhất trong nội bộ lớp định nghĩa nó.

</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Nguyên lý SOLID là gì? Giải thích chữ S.</summary>
  
  **Trả lời:**
  SOLID là 5 nguyên lý thiết kế. Chữ S (Single Responsibility Principle): Mỗi lớp chỉ nên có một lý do duy nhất để thay đổi, tức là chỉ làm một nhiệm vụ duy nhất.
</details>

<details>
  <summary>Q2: Trait trong PHP là gì và khi nào nên dùng?</summary>
  
  **Trả lời:**
  Trait là một cơ chế giúp tái sử dụng code trong các ngôn ngữ đơn kế thừa như PHP.

- **Nên dùng:** Khi bạn có các phương thức muốn dùng chung ở nhiều lớp khác nhau nhưng các lớp đó không thuộc cùng một cây kế thừa.

</details>

<details>
  <summary>Q3: Interface và Abstract Class khác nhau như thế nào?</summary>
  
  **Trả lời:**

- Interface: Chỉ định nghĩa "hành vi" (contract), không chứa logic. Một lớp có thể thực thi nhiều interface.
- Abstract Class: Có thể chứa logic mặc định. Một lớp chỉ có thể kế thừa một lớp cha.

</details>

<details>
  <summary>Q4: Type Hinting là gì và tại sao nó quan trọng?</summary>
  
  **Trả lời:**
  Là việc chỉ định kiểu dữ liệu cho tham số đầu vào của hàm/phương thức.

- **Tại sao:** Giúp code rõ ràng hơn, giảm thiểu lỗi runtime và cho phép IDE hỗ trợ tốt hơn.

</details>

<details>
  <summary>Q5: Dependency Injection (DI) là gì?</summary>
  
  **Trả lời:**
  Là kỹ thuật cung cấp các phụ thuộc (dependencies) từ bên ngoài vào một lớp thay vì để lớp đó tự tạo ra. Giúp code dễ test và giảm sự phụ thuộc cứng nhắc.
</details>

<details>
  <summary>Q6: Sự khác biệt giữa `self` và `static` khi gọi phương thức tĩnh?</summary>
  
  **Trả lời:**

- `self`: Trỏ về lớp hiện tại nơi phương thức được định nghĩa.
- `static`: Trỏ về lớp thực tế đang gọi phương thức (hỗ trợ Late Static Binding).

</details>

<details>
  <summary>Q7: Anonymous Functions (Closure) là gì?</summary>
  
  **Trả lời:**
  Là các hàm không có tên, có thể được gán vào biến hoặc truyền như một tham số. Trong PHP, chúng sử dụng từ khóa `use` để truy cập các biến bên ngoài phạm vi của hàm.
</details>

<details>
  <summary>Q8: Magic Methods là gì? Kể tên 3 phương thức phổ biến.</summary>
  
  **Trả lời:**
  Là các phương thức đặc biệt bắt đầu bằng `__`. Ví dụ: `__construct()`, `__get()`, `__set()`, `__call()`, `__toString()`.
</details>

<details>
  <summary>Q9: Namespace là gì và giải quyết vấn đề gì?</summary>
  
  **Trả lời:**
  Namespace giúp nhóm các class liên quan lại với nhau và giải quyết vấn đề trùng tên class giữa các thư viện khác nhau.
</details>

<details>
  <summary>Q10: PSR-4 Autoloading hoạt động như thế nào?</summary>
  
  **Trả lời:**
  Nó ánh xạ (map) một namespace cụ thể tới một thư mục trên ổ đĩa. Khi gọi một class, Composer sẽ dựa trên map này để tự động `require` file tương ứng.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Zend Engine là gì? Giải thích luồng thực thi từ mã PHP sang Opcode.</summary>
  
  **Trả lời:**
  Zend Engine là trái tim của PHP. Luồng: PHP Source Code -> Lexing -> Parsing -> Compilation -> Opcode -> Execution.
  
  **HOW:** Mã nguồn được chuyển thành các chỉ thị máy (Opcode) mà Zend VM có thể hiểu và thực thi. Opcache giúp lưu trữ các Opcode này để không phải biên dịch lại ở request sau.
</details>

<details>
  <summary>Q2: Giải thích cơ chế Memory Management trong PHP (Reference Counting & Garbage Collection).</summary>
  
  **Trả lời:**
  PHP dùng Reference Counting: mỗi object có một bộ đếm số lượng tham chiếu. Khi đếm về 0, bộ nhớ được giải phóng.
  
  **Garbage Collection:** Xử lý các "vòng lặp tham chiếu" (Cyclic References) - nơi Object A trỏ tới B và B trỏ tới A, khiến bộ đếm không bao giờ về 0.
</details>

<details>
  <summary>Q3: Generators trong PHP là gì? Tại sao chúng giúp tiết kiệm bộ nhớ?</summary>
  
  **Trả lời:**
  Generators sử dụng từ khóa `yield`. Thay vì tạo ra một mảng khổng lồ trong bộ nhớ, Generator trả về từng giá trị một khi được yêu cầu. Thích hợp để xử lý các file log hàng GB hoặc hàng triệu dòng DB.
</details>

<details>
  <summary>Q4: Weak Maps và Weak References là gì (PHP 8.0+)?</summary>
  
  **Trả lời:**
  Cho phép bạn giữ một tham chiếu đến một đối tượng mà không ngăn cản Garbage Collector thu hồi đối tượng đó khi không còn tham chiếu mạnh nào khác. Hữu ích cho việc cache dữ liệu liên quan đến object.
</details>

<details>
  <summary>Q5: PHP JIT (Just-In-Time) compiler hoạt động như thế nào?</summary>
  
  **Trả lời:**
  JIT biên dịch các phần code thường xuyên được sử dụng từ Opcode sang trực tiếp mã máy (Machine Code) của CPU. Điều này giúp tăng tốc các tác vụ tính toán nặng (CPU-bound) thay vì các tác vụ I/O thông thường.
</details>

<details>
  <summary>Q6: Sự khác biệt giữa `array_map`, `array_filter` và `array_reduce` về mặt bản chất?</summary>
  
  **Trả lời:**

- `map`: Biến đổi từng phần tử, giữ nguyên số lượng.
- `filter`: Loại bỏ phần tử dựa trên điều kiện, có thể giảm số lượng.
- `reduce`: "Gộp" toàn bộ mảng thành một giá trị duy nhất (tổng, chuỗi, hoặc object).

</details>

<details>
  <summary>Q7: Giải thích về Fiber trong PHP 8.1.</summary>
  
  **Trả lời:**
  Fiber là các "luồng" nhẹ (lightweight threads) cho phép lập trình bất đồng bộ (concurrency) ở mức thấp. Nó cho phép tạm dừng và tiếp tục thực thi mã nguồn mà không làm block luồng chính.
</details>

<details>
  <summary>Q8: Cách PHP xử lý lỗi nội bộ: Error vs Exception?</summary>
  
  **Trả lời:**
  Trước PHP 7, nhiều lỗi là Fatal Error không thể bắt được. Từ PHP 7+, hầu hết lỗi được chuyển thành các class implement `Throwable`. Exception dùng cho logic nghiệp vụ, Error dùng cho các lỗi nghiêm trọng của hệ thống/engine.
</details>

<details>
  <summary>Q9: Phân tích hiệu năng giữa mảng (Array) và Object trong PHP.</summary>
  
  **Trả lời:**
  Mảng trong PHP thực chất là Hash Map. Object (đặc biệt là StdClass) tốn nhiều bộ nhớ hơn một chút nhưng từ PHP 7+, object có cấu trúc cố định (Typed properties) cực kỳ tối ưu về tốc độ truy cập.
</details>

<details>
  <summary>Q10: Kỹ thuật Serialization và các rủi ro bảo mật liên quan?</summary>
  
  **Trả lời:**
  Serialization chuyển object thành chuỗi để lưu trữ.
  **Rủi ro:** PHP Object Injection. Nếu `unserialize()` dữ liệu từ người dùng, kẻ tấn công có thể tạo ra các object độc hại kích hoạt các magic methods (`__destruct`, `__wakeup`) để thực thi mã từ xa.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế một hệ thống Plugin cho một ứng dụng PHP lớn sử dụng OOP.</summary>
  
  **Trả lời:**
  Sử dụng Interface để định nghĩa "hợp đồng" cho Plugin. Dùng Service Container để đăng ký và quản lý các Plugin. Áp dụng pattern **Observer** hoặc **Event Dispatcher** để các Plugin có thể "móc" (hook) vào các giai đoạn xử lý của ứng dụng mà không làm thay đổi code core.
</details>

<details>
  <summary>Q2: Tại sao PHP truyền thống lại khó scale theo chiều dọc (Vertical) hơn so với Node.js hay Go?</summary>
  
  **Trả lời:**
  Do mô hình "Synchronous & Blocking". Mỗi request chiếm dụng 1 worker process. Giải pháp kiến trúc hiện đại là dùng **Laravel Octane** với Swoole hoặc RoadRunner để giữ ứng dụng luôn trong bộ nhớ (Boot một lần, dùng nhiều lần).
</details>

<details>
  <summary>Q3: Phân tích sự khác biệt về mặt kiến trúc giữa Composer v1 và v2 (Optimization).</summary>
  
  **Trả lời:**
  V2 cải tiến thuật toán giải quyết phụ thuộc (SAT solver) và hỗ trợ tải song song. Về kiến trúc, nó tối ưu hóa việc sử dụng bộ nhớ và file hệ thống bằng cách dùng các file metadata thu gọn.
</details>

<details>
  <summary>Q4: Khi nào bạn nên chọn thiết kế Microservices bằng PHP thay vì Monolith?</summary>
  
  **Trả lời:**
  Chỉ khi team quá lớn (50+ dev), cần scale độc lập các module (ví dụ: module xử lý ảnh cần nhiều CPU), hoặc cần dùng các công nghệ khác nhau. PHP rất mạnh cho Microservices khi kết hợp với gRPC và Swoole.
</details>

<details>
  <summary>Q5: Giải thích chiến lược "Circuit Breaker" trong giao tiếp giữa các dịch vụ PHP.</summary>
  
  **Trả lời:**
  Nếu Service A gọi Service B và B đang lỗi, Circuit Breaker sẽ "ngắt mạch" ngay lập tức để A không phải đợi timeout, giúp hệ thống không bị treo dây chuyền. Sau một thời gian, nó sẽ thử kết nối lại.
</details>

<details>
  <summary>Q6: Làm thế nào để xử lý "Memory Leak" trong các script PHP chạy lâu dài (Daemon/Worker)?</summary>
  
  **Trả lời:**

  1. Hạn chế dùng biến toàn cục.
  2. Giải phóng các object lớn sau khi dùng (`unset`).
  3. Khởi động lại worker sau một số lượng request nhất định (ví dụ: `--max-requests=1000` trong Laravel Queue).

</details>

<details>
  <summary>Q7: So sánh mô hình Shared-Nothing của PHP với mô hình Multi-threading của Java.</summary>
  
  **Trả lời:**
  Shared-Nothing: An toàn tuyệt đối, không lo race condition giữa các request, dễ deploy. Multi-threading: Tận dụng bộ nhớ tốt hơn nhưng cực kỳ phức tạp để quản lý trạng thái chia sẻ và khóa (lock).
</details>

<details>
  <summary>Q8: Thiết kế cấu trúc dữ liệu cho một hệ thống phân quyền (RBAC) phức tạp.</summary>
  
  **Trả lời:**
  Dùng mô hình 5 bảng: Users, Roles, Permissions, role_user (pivot), role_permission (pivot). Để tối ưu, có thể dùng bitmask hoặc lưu cached permissions vào Redis dưới dạng mảng để kiểm tra O(1).
</details>

<details>
  <summary>Q9: Tại sao `eval()` và `extract()` được coi là "tội đồ" trong kiến trúc PHP?</summary>
  
  **Trả lời:**
  `eval()` thực thi chuỗi như code, cực kỳ nguy hiểm nếu có input người dùng. `extract()` tạo ra các biến từ mảng, dễ gây ghi đè các biến quan trọng của hệ thống (như `$isAdmin`), dẫn đến lỗ hổng bảo mật nghiêm trọng.
</details>

<details>
  <summary>Q10: Tương lai của PHP trong kỷ nguyên Cloud Native?</summary>
  
  **Trả lời:**
  PHP đang tiến tới mô hình Serverless và Concurrency. Với sự ra đời của Octane, Fiber và các cải tiến về hiệu năng, PHP vẫn là lựa chọn hàng đầu cho Backend nhờ hệ sinh thái khổng lồ và tốc độ phát triển cực nhanh.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Script chạy ngầm bị lỗi "Allowed memory size exhausted". Bạn xử lý thế nào?</summary>
  
  **Xử lý:** Kiểm tra các mảng lớn, chuyển sang dùng Generator (`yield`), hoặc xử lý dữ liệu theo từng khối (chunking). Tăng `memory_limit` chỉ là giải pháp tạm thời.
</details>

<details>
  <summary>S2: Bạn nhận bàn giao một codebase cũ không có Namespace. Làm thế nào để tích hợp thư viện hiện đại?</summary>
  
  **Xử lý:** Dùng tính năng `class_alias` hoặc cấu hình `classmap` trong Composer để map các class cũ. Sau đó dần dần refactor sang PSR-4.
</details>

<details>
  <summary>S3: Làm thế nào để debug một lỗi chỉ xảy ra trên Production mà không có trên Local?</summary>
  
  **Xử lý:** Sử dụng Logging chuyên sâu (Monolog), công cụ giám sát hiệu năng (Sentry, New Relic), hoặc remote debugging qua SSH tunnel (nếu an toàn).
</details>

## Nên biết

- Sự khác biệt bản chất giữa mảng (Array) và Object trong PHP.
- Cách hoạt động của Autoloading và Composer.
- Nguyên lý Dependency Injection và cách áp dụng nó.
- Cách PHP quản lý bộ nhớ để tránh rò rỉ (memory leaks).

## Lưu ý

- Sử dụng `global` quá nhiều làm mất kiểm soát luồng dữ liệu.
- Quên kiểm tra `isset()` trước khi truy cập phần tử mảng.
- Không sử dụng Prepared Statements khi query DB (SQL Injection).

## Mẹo và thủ thuật

- Luôn dùng `strict_types=1` để bắt lỗi kiểu dữ liệu sớm.
- Tận dụng Opcache để tăng tốc độ thực thi lên gấp nhiều lần.
- Dùng `match` thay cho `switch` trong PHP 8 để code ngắn gọn và an toàn hơn.
