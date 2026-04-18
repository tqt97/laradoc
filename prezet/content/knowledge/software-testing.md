---
title: "Software Testing: Đảm bảo Chất lượng Phần mềm"
description: Hệ thống hơn 50 câu hỏi về Unit Test, Integration Test, Mocking, TDD và chiến lược kiểm thử trong Laravel.
date: 2026-04-19
tags: [testing, phpunit, tdd, laravel, quality]
image: /prezet/img/ogimages/knowledge-software-testing.webp
---

> Testing không phải là tìm lỗi, mà là xây dựng sự tự tin để thay đổi mã nguồn mà không sợ làm hỏng hệ thống.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Tại sao chúng ta cần viết Test?</summary>
  
  **Trả lời:**
  Để đảm bảo code chạy đúng như mong đợi, phát hiện lỗi sớm khi thay đổi code (regressions), và giúp code dễ bảo trì hơn.
</details>

<details>
  <summary>Q2: Unit Test là gì?</summary>
  
  **Trả lời:**
  Là việc kiểm thử một đơn vị nhỏ nhất của mã nguồn (thường là một hàm hoặc một class) một cách cô lập.
</details>

<details>
  <summary>Q3: PHPUnit là gì?</summary>
  
  **Trả lời:**
  Là framework kiểm thử phổ biến nhất cho PHP, được Laravel tích hợp sẵn để viết và chạy các bộ test.
</details>

<details>
  <summary>Q4: Sự khác biệt giữa Unit Test và Feature Test trong Laravel?</summary>
  
  **Trả lời:**

- Unit Test: Chỉ test logic của code, không khởi động Laravel framework (nhanh).
- Feature Test: Test một tính năng hoàn chỉnh, có gửi request HTTP và khởi động framework (chậm hơn nhưng bao quát hơn).

</details>

<details>
  <summary>Q5: Assertion trong Testing là gì?</summary>
  
  **Trả lời:**
  Là câu lệnh khẳng định kết quả mong đợi. Ví dụ: `assertEquals(10, $sum)` nghĩa là tôi mong đợi biến `$sum` phải bằng 10.
</details>

<details>
  <summary>Q6: "Test Driven Development" (TDD) là gì?</summary>
  
  **Trả lời:**
  Quy trình: Viết test lỗi -> Viết code cho test qua -> Refactor (Red-Green-Refactor).
</details>

<details>
  <summary>Q7: Làm thế nào để chạy test trong Laravel?</summary>
  
  **Trả lời:**
  Dùng lệnh `php artisan test` hoặc `./vendor/bin/phpunit`.
</details>

<details>
  <summary>Q8: Mocking là gì (giải thích đơn giản)?</summary>
  
  **Trả lời:**
  Là việc tạo ra một object "giả" để thay thế cho một service thực tế (như API bên thứ 3) nhằm mục đích kiểm soát kết quả trả về trong lúc test.
</details>

<details>
  <summary>Q9: Tại sao nên dùng Database riêng cho Testing?</summary>
  
  **Trả lời:**
  Để tránh làm hỏng dữ liệu thực tế (Production/Dev) và đảm bảo môi trường test luôn sạch sẽ, có thể dự đoán được.
</details>

<details>
  <summary>Q10: "Code Coverage" là chỉ số gì?</summary>
  
  **Trả lời:**
  Phần trăm mã nguồn đã được thực thi bởi các bộ test. Tuy nhiên, coverage cao không đồng nghĩa với việc không có bug.
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Integration Test khác gì với Unit Test?</summary>
  
  **Trả lời:**
  Integration Test kiểm tra sự tương tác giữa nhiều thành phần (ví dụ: Controller gọi Service gọi Database) thay vì chỉ kiểm tra từng phần riêng lẻ.
</details>

<details>
  <summary>Q2: Giải thích về "Test Doubles" (Stub vs Mock).</summary>
  
  **Trả lời:**

- Stub: Chỉ trả về dữ liệu cố định.
- Mock: Kiểm tra xem object đó có được gọi với tham số đúng và số lần đúng hay không.

</details>

<details>
  <summary>Q3: Làm thế nào để test các Route yêu cầu Authentication trong Laravel?</summary>
  
  **Trả lời:**
  Dùng method `$this->actingAs($user)` để giả lập một user đã đăng nhập trước khi thực hiện request.
</details>

<details>
  <summary>Q4: "RefreshDatabase" trait hoạt động như thế nào?</summary>
  
  **Trả lời:**
  Nó sẽ chạy lại toàn bộ migrations trước mỗi lần chạy test để đảm bảo cấu trúc DB luôn mới nhất và sạch sẽ.
</details>

<details>
  <summary>Q5: Tại sao không nên dùng `new` trực tiếp trong code nếu muốn test tốt?</summary>
  
  **Trả lời:**
  Vì nó gây ra sự phụ thuộc cứng nhắc (Hard dependency), khiến bạn không thể thay thế (Mock) object đó khi viết Unit Test. Nên dùng Dependency Injection.
</details>

<details>
  <summary>Q6: Làm thế nào để test việc gửi Mail hoặc bắn Event trong Laravel?</summary>
  
  **Trả lời:**
  Dùng `Mail::fake()` hoặc `Event::fake()`. Laravel sẽ chặn việc gửi thật và cho phép bạn assert xem chúng có được gọi không.
</details>

<details>
  <summary>Q7: Test Suites là gì?</summary>
  
  **Trả lời:**
  Là cách nhóm các file test lại với nhau (ví dụ: nhóm Unit và nhóm Feature) để chạy riêng biệt trong file `phpunit.xml`.
</details>

<details>
  <summary>Q8: Giải thích về "Factory States".</summary>
  
  **Trả lời:**
  Cho phép bạn định nghĩa các trạng thái khác nhau của dữ liệu mẫu (ví dụ: User trạng thái `admin` hoặc `suspended`) để tái sử dụng trong test.
</details>

<details>
  <summary>Q9: Làm thế nào để test một Artisan Command?</summary>
  
  **Trả lời:**
  Dùng `$this->artisan('command:name')->expectsOutput('...')->assertExitCode(0)`.
</details>

<details>
  <summary>Q10: Sự khác biệt giữa `assertTrue` và `assertSame`.</summary>
  
  **Trả lời:**
  `assertTrue` kiểm tra giá trị là true. `assertSame` kiểm tra cả giá trị và kiểu dữ liệu (strict comparison) giữa hai biến.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Phân tích chiến lược "Testing Pyramid" (Kim tự tháp kiểm thử).</summary>
  
  **Trả lời:**
  Ưu tiên viết nhiều Unit Tests (nhanh, rẻ), ít Integration Tests hơn, và ít nhất là End-to-End (E2E) Tests (chậm, đắt).
</details>

<details>
  <summary>Q2: Làm thế nào để test các tác vụ bất đồng bộ (Queued Jobs)?</summary>
  
  **Trả lời:**
  Dùng `Queue::fake()`. Bạn có thể assert xem một Job cụ thể có được đẩy vào queue với dữ liệu đúng hay không.
</details>

<details>
  <summary>Q3: Giải thích về "Contract Testing" (Pact).</summary>
  
  **Trả lời:**
  Dùng để đảm bảo sự tương thích giữa API Provider và API Consumer. Nếu một bên thay đổi cấu trúc dữ liệu, test sẽ báo lỗi ngay lập tức.
</details>

<details>
  <summary>Q4: Cách test các hàm có sử dụng thời gian thực (`now()`)?</summary>
  
  **Trả lời:**
  Dùng `Carbon::setTestNow($fixedDate)` để "đóng băng" thời gian tại một thời điểm cụ thể, giúp kết quả test luôn ổn định.
</details>

<details>
  <summary>Q5: "Mutation Testing" là gì?</summary>
  
  **Trả lời:**
  Tự động thay đổi logic code (ví dụ đổi `>` thành `<`) và chạy lại test. Nếu test vẫn pass, nghĩa là bộ test của bạn chưa đủ tốt để phát hiện lỗi logic.
</details>

<details>
  <summary>Q6: Làm thế nào để test một ứng dụng SPA sử dụng Laravel Dusk?</summary>
  
  **Trả lời:**
  Dusk khởi động trình duyệt thật (Chrome) để thực hiện các thao tác như click, nhập liệu, và kiểm tra giao diện như một người dùng thật.
</details>

<details>
  <summary>Q7: Phân tích rủi ro của "Mocking quá nhiều".</summary>
  
  **Trả lời:**
  Khiến test quá phụ thuộc vào cấu trúc code bên trong (implementation details). Khi refactor code, test sẽ bị hỏng dù logic vẫn đúng.
</details>

<details>
  <summary>Q8: Làm thế nào để test hiệu năng (Performance Testing) trong bộ test CI/CD?</summary>
  
  **Trả lời:**
  Dùng các công cụ như `phpbench` hoặc viết test assert thời gian thực thi của một tác vụ không được vượt quá ngưỡng X ms.
</details>

<details>
  <summary>Q9: Giải thích về "Parallel Testing" trong Laravel.</summary>
  
  **Trả lời:**
  Sử dụng lệnh `php artisan test --parallel` để tận dụng nhiều nhân CPU chạy nhiều bộ test cùng lúc, giúp giảm thời gian chờ đợi đáng kể.
</details>

<details>
  <summary>Q10: Cách test lỗi 500 hoặc các Exceptions không mong muốn.</summary>
  
  **Trả lời:**
  Dùng `$this->withoutExceptionHandling()` để Laravel throw lỗi thật ra thay vì trả về view lỗi, giúp bạn debug trực tiếp trong terminal khi test fail.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế hệ thống CI/CD đảm bảo 100% code mới phải có test và coverage > 80%.</summary>
  
  **Trả lời:**
  Sử dụng Github Actions/Gitlab CI. Chạy test tự động mỗi khi có Pull Request. Dùng các công cụ như Codecov để kiểm tra và chặn merge nếu không đạt chỉ số.
</details>

<details>
  <summary>Q2: Làm thế nào để test một hệ thống Microservices phức tạp?</summary>
  
  **Trả lời:**
  Kết hợp: 1. Unit test cho từng service. 2. Contract test cho giao tiếp giữa các service. 3. End-to-End test cho các luồng nghiệp vụ quan trọng nhất.
</details>

<details>
  <summary>Q3: Phân tích chiến lược "Test-Induced Design Damage".</summary>
  
  **Trả lời:**
  Hiện tượng thay đổi kiến trúc code chỉ để làm cho nó dễ test hơn (ví dụ biến mọi thứ thành public). Architect cần cân bằng giữa tính dễ test và tính đóng gói của code.
</details>

<details>
  <summary>Q4: Thiết kế giải pháp Testing cho hệ thống có hàng tỷ record dữ liệu.</summary>
  
  **Trả lời:**
  Không thể migration toàn bộ. Dùng "In-memory database" cho logic tests. Dùng "Partial production data snapshot" (anonymized) cho integration tests.
</details>

<details>
  <summary>Q5: Tầm nhìn: Tại sao TDD không phải là "viên đạn bạc"?</summary>
  
  **Trả lời:**
  TDD rất tốt cho logic phức tạp nhưng có thể làm chậm quá trình prototype. Cần linh hoạt: TDD cho core logic, Feature test cho UI/Flow.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Bộ test của bạn chạy mất 20 phút. Làm sao để tối ưu xuống dưới 5 phút?</summary>
  
  **Xử lý:** 1. Chạy Parallel testing. 2. Mock các API/Service chậm. 3. Dùng In-memory DB (SQLite). 4. Tách các test E2E/Dusk ra chạy riêng.
</details>

<details>
  <summary>S2: Bạn phát hiện một bug trên Production. Các bước xử lý theo tư duy Testing?</summary>
  
  **Xử lý:** 1. Viết một test case tái hiện đúng bug đó (test sẽ fail). 2. Sửa code để test pass. 3. Deploy code kèm theo test case đó để đảm bảo bug không quay lại.
</details>

## Nên biết

- Sự khác biệt giữa Unit, Feature và E2E Test.
- Cách dùng Mockery và PHPUnit Assertions.
- Quy trình Red-Green-Refactor của TDD.

## Lưu ý

- Viết test quá phụ thuộc vào dữ liệu DB (dễ bị fail khi data đổi).
- Không test các trường hợp lỗi (Edge cases).
- Coi Code Coverage là mục tiêu duy nhất.

## Mẹo và thủ thuật

- Dùng `dump()` hoặc `dd()` ngay trong test để debug dữ liệu response.
- Sử dụng thư viện `Faker` để tạo dữ liệu ngẫu nhiên nhưng hợp lệ.
