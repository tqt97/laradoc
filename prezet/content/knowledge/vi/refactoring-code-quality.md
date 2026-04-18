---
title: "Refactoring & Code Quality: Xây dựng Mã nguồn Bền vững"
description: Hệ thống hơn 50 câu hỏi về Code Smells, Refactoring Patterns, Clean Code, Code Review và quy trình kỹ thuật chuyên nghiệp.
date: 2026-04-18
tags: [refactoring, clean-code, code-quality, code-review, architecture]
image: /prezet/img/ogimages/knowledge-vi-refactoring-code-quality.webp
---

> Viết code chạy được là chưa đủ. Viết code mà đồng nghiệp (và chính bạn trong 6 tháng tới) có thể đọc, hiểu và sửa đổi mới là đẳng cấp của một kỹ sư thực thụ.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Refactoring là gì?</summary>
  
  **Trả lời:**
  Là quá trình thay đổi cấu trúc bên trong của mã nguồn để làm nó dễ hiểu và dễ bảo trì hơn mà **không làm thay đổi hành vi bên ngoài** của ứng dụng.
</details>

<details>
  <summary>Q2: Tại sao chúng ta cần Refactoring?</summary>
  
  **Trả lời:**
  Để giảm nợ kỹ thuật (Technical Debt), giúp code sạch sẽ, dễ thêm tính năng mới và giảm thiểu bug tiềm ẩn.
</details>

<details>
  <summary>Q3: Clean Code là gì?</summary>
  
  **Trả lời:**
  Là mã nguồn dễ đọc, dễ hiểu và dễ bảo trì. Giống như một cuốn sách hay: mạch lạc, rõ ràng và không gây bối rối cho người đọc.
</details>

<details>
  <summary>Q4: Tầm quan trọng của việc đặt tên (Naming) trong Code Quality.</summary>
  
  **Trả lời:**
  Tên biến/hàm phải phản ánh đúng ý đồ (Intent). Ví dụ: `daysUntilExpiration` tốt hơn nhiều so với `d` hoặc `days`.
</details>

<details>
  <summary>Q5: "Code Smell" là gì?</summary>
  
  **Trả lời:**
  Là các dấu hiệu cho thấy có vấn đề sâu xa hơn trong thiết kế code (ví dụ: một hàm quá dài, một class có quá nhiều nhiệm vụ).
</details>

<details>
  <summary>Q6: DRY (Don't Repeat Yourself) nghĩa là gì?</summary>
  
  **Trả lời:**
  Hạn chế lặp lại code. Mỗi phần kiến thức hoặc logic phải có một biểu diễn duy nhất và rõ ràng trong hệ thống.
</details>

<details>
  <summary>Q7: KISS (Keep It Simple, Stupid) nghĩa là gì?</summary>
  
  **Trả lời:**
  Hãy giữ cho thiết kế và giải pháp đơn giản nhất có thể. Đừng phức tạp hóa vấn đề khi chưa cần thiết.
</details>

<details>
  <summary>Q8: Comment trong code: Khi nào là tốt, khi nào là xấu?</summary>
  
  **Trả lời:**

- Tốt: Giải thích "Tại sao" làm vậy (quyết định kiến trúc, logic nghiệp vụ đặc thù).
- Xấu: Giải thích "Cái gì" đang làm (vì code quá khó hiểu). Code tốt nên tự giải thích chính nó.

</details>

<details>
  <summary>Q9: Code Review là gì?</summary>
  
  **Trả lời:**
  Là quá trình các lập trình viên kiểm tra mã nguồn của nhau trước khi merge vào nhánh chính để đảm bảo chất lượng và chia sẻ kiến thức.
</details>

<details>
  <summary>Q10: Ý nghĩa của việc thống nhất Coding Standards (Style guide)?</summary>
  
  **Trả lời:**
  Giúp toàn bộ codebase trông như do một người viết duy nhất, giảm gánh nặng nhận thức khi đọc code của người khác.
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Phân tích các Code Smells phổ biến: Long Method, Large Class, Long Parameter List.</summary>
  
  **Trả lời:**

- Long Method: Hàm quá 20-30 dòng, làm quá nhiều việc.
- Large Class: Class ôm đồm nhiều trách nhiệm (vi phạm SRP).
- Long Parameter List: Truyền quá 3-4 tham số vào hàm (nên đóng gói vào object).

</details>

<details>
  <summary>Q2: Refactoring Pattern: "Extract Method" là gì?</summary>
  
  **Trả lời:**
  Tách một đoạn code logic từ một hàm lớn ra thành một hàm nhỏ hơn có tên rõ ràng. Giúp hàm gốc ngắn gọn và dễ đọc hơn.
</details>

<details>
  <summary>Q3: Refactoring Pattern: "Replace Magic Number with Symbolic Constant".</summary>
  
  **Trả lời:**
  Thay các số "bí ẩn" (ví dụ: `86400`) bằng các hằng số có tên (`SECONDS_IN_A_DAY`).
</details>

<details>
  <summary>Q4: Ý nghĩa của "Small Commits" trong quy trình Refactoring.</summary>
  
  **Trả lời:**
  Giúp dễ dàng track lại thay đổi, dễ dàng rollback nếu có lỗi và giảm thiểu xung đột (conflicts) khi làm việc nhóm.
</details>

<details>
  <summary>Q5: Giải thích về "Technical Debt" (Nợ kỹ thuật).</summary>
  
  **Trả lời:**
  Là cái giá phải trả sau này khi chọn giải pháp "nhanh và bẩn" thay vì giải pháp "đúng đắn" ở hiện tại. Nợ càng lâu lãi suất (công sức sửa chữa) càng cao.
</details>

<details>
  <summary>Q6: "Primitive Obsession" là gì và cách giải quyết?</summary>
  
  **Trả lời:**
  Sử dụng các kiểu dữ liệu cơ bản (string, int) cho các khái niệm phức tạp (email, tọa độ). Giải quyết bằng cách tạo các **Value Objects**.
</details>

<details>
  <summary>Q7: Làm thế nào để thực hiện Code Review hiệu quả?</summary>
  
  **Trả lời:**
  Tập trung vào logic, hiệu năng, bảo mật và kiến trúc. Đưa ra góp ý mang tính xây dựng, không chỉ trích cá nhân. Sử dụng checklist để không bỏ sót.
</details>

<details>
  <summary>Q8: "Boy Scout Rule" trong lập trình.</summary>
  
  **Trả lời:**
  "Luôn để lại bãi trại sạch hơn khi bạn mới đến". Nghĩa là mỗi khi sửa bug hoặc thêm feature, hãy cố gắng refactor một chút code xung quanh đó tốt hơn.
</details>

<details>
  <summary>Q9: Phân biệt "Refactoring" và "Rewriting".</summary>
  
  **Trả lời:**

- Refactoring: Thay đổi từng bước nhỏ trên code cũ.
- Rewriting: Đập đi xây lại mới hoàn toàn (thường rủi ro cao và tốn thời gian hơn dự kiến).

</details>

<details>
  <summary>Q10: "Inappropriate Intimacy" code smell.</summary>
  
  **Trả lời:**
  Khi hai class quá hiểu rõ và can thiệp sâu vào "chuyện riêng tư" (private data) của nhau. Cần tách biệt nhiệm vụ rõ ràng hơn.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Refactoring Pattern: "Replace Conditional with Polymorphism".</summary>
  
  **Trả lời:**
  Thay vì dùng chuỗi `if/else` hoặc `switch` phức tạp để xử lý các loại đối tượng khác nhau, hãy dùng kế thừa/interface để mỗi đối tượng tự thực hiện logic của nó.
</details>

<details>
  <summary>Q2: Cách xử lý "Legacy Code" không có test.</summary>
  
  **Trả lời:**
  Không refactor ngay. Bước 1: Viết "Characterization Tests" để khóa hành vi hiện tại. Bước 2: Refactor từng phần nhỏ. Bước 3: Viết Unit Test cho code mới.
</details>

<details>
  <summary>Q3: Giải thích về "Strangler Fig Pattern" khi chuyển đổi hệ thống.</summary>
  
  **Trả lời:**
  Thay thế từng phần nhỏ của hệ thống cũ bằng các module mới. Module mới "mọc quanh" hệ thống cũ cho đến khi hệ thống cũ hoàn toàn bị loại bỏ.
</details>

<details>
  <summary>Q4: "Liskov Substitution Principle" (L trong SOLID) ứng dụng trong Refactoring.</summary>
  
  **Trả lời:**
  Đảm bảo class con có thể thay thế hoàn toàn class cha mà không làm hỏng ứng dụng. Nếu refactor mà vi phạm cái này, kiến trúc kế thừa đang có vấn đề.
</details>

<details>
  <summary>Q5: Làm thế nào để đo lường "Code Quality" tự động?</summary>
  
  **Trả lời:**
  Dùng các công cụ Static Analysis: **PHPStan/Psalm** (check type), **PHP Insights** (check complexity/style), **SonarQube** (tổng thể).
</details>

<details>
  <summary>Q6: "Composition over Inheritance" - Tại sao Architect thường ưu tiên nó?</summary>
  
  **Trả lời:**
  Kế thừa tạo ra sự phụ thuộc cứng nhắc. Composition (kết hợp các object nhỏ) giúp hệ thống linh hoạt, dễ thay đổi hành vi tại runtime và dễ test hơn.
</details>

<details>
  <summary>Q7: Xử lý "Shotgun Surgery" code smell.</summary>
  
  **Trả lời:**
  Khi thay đổi một yêu cầu nhỏ bắt bạn phải sửa code ở hàng chục file khác nhau. Giải pháp là gom các logic liên quan đó vào một nơi duy nhất.
</details>

<details>
  <summary>Q8: Giải thích về "Cyclomatic Complexity".</summary>
  
  **Trả lời:**
  Chỉ số đo lường số lượng đường đi độc lập qua mã nguồn (số lượng `if`, `else`, `loop`). Chỉ số này càng cao code càng khó hiểu và khó test.
</details>

<details>
  <summary>Q9: Tầm quan trọng của "Automated Refactoring" trong IDE.</summary>
  
  **Trả lời:**
  Sử dụng các tool của IDE (PhpStorm) để rename, extract method... giúp tránh các lỗi gõ phím ngớ ngẩn và thực hiện thay đổi trên toàn project nhanh chóng.
</details>

<details>
  <summary>Q10: "Feature Envy" code smell và cách sửa.</summary>
  
  **Trả lời:**
  Khi một hàm trong Class A liên tục truy cập dữ liệu của Class B để tính toán. Hãy chuyển hàm đó sang Class B (nơi chứa dữ liệu).
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế quy trình "Engineering Excellence" cho một team 50 người.</summary>
  
  **Trả lời:**
  Thiết lập: 1. CI/CD pipeline tự động check lint/test/complexity. 2. Quy trình Code Review chéo. 3. Các buổi Tech Sharing hàng tuần. 4. Dành 20% thời gian mỗi sprint để xử lý Technical Debt.
</details>

<details>
  <summary>Q2: Phân tích sự đánh đổi giữa "Perfect Code" và "Time to Market".</summary>
  
  **Trả lời:**
  Code hoàn hảo là không tưởng. Architect cần biết khi nào chấp nhận "nợ kỹ thuật" có kiểm soát để kịp deadline, và có kế hoạch trả nợ ngay sau đó.
</details>

<details>
  <summary>Q3: Làm thế nào để thuyết phục Business/Product Manager dành thời gian cho Refactoring?</summary>
  
  **Trả lời:**
  Đừng nói về "code sạch". Hãy nói về "tốc độ phát triển tính năng mới sẽ giảm 50% nếu không sửa" hoặc "hệ thống sẽ sập khi đạt 10k users". Hãy quy đổi nợ kỹ thuật ra tiền và thời gian.
</details>

<details>
  <summary>Q4: Tầm nhìn: "Refactoring as a First-class Citizen" trong Agile.</summary>
  
  **Trả lời:**
  Refactoring không phải là một task riêng biệt, nó là một phần không thể tách rời của việc viết code hàng ngày. Một task chỉ xong khi code đã được refactor sạch sẽ.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Bạn nhận một project "Spaghetti code" khổng lồ và được yêu cầu thêm tính năng mới gấp. Cách tiếp cận?</summary>
  
  **Xử lý:** 1. Không refactor toàn bộ. 2. Dùng Strangler pattern: viết module mới sạch sẽ cho tính năng mới. 3. Chỉ refactor những phần code cũ mà tính năng mới trực tiếp chạm vào.
</details>

<details>
  <summary>S2: Trong Code Review, bạn thấy đồng nghiệp viết code rất khó hiểu nhưng chạy đúng. Bạn sẽ góp ý thế nào?</summary>
  
  **Xử lý:** Đưa ra các ví dụ cụ thể về việc code này sẽ khó bảo trì thế nào. Đề xuất một cách viết khác (ví dụ dùng Early Return thay vì If/Else lồng nhau) và giải thích lợi ích.
</details>

## Nên biết

- Nguyên lý DRY, KISS, YAGNI.
- Các Code Smells cơ bản (Long method, Magic numbers).
- Quy trình Code Review chuyên nghiệp.

## Lưu ý

- "Over-refactoring": Sửa code quá mức cần thiết dẫn đến trễ deadline mà không mang lại giá trị thực tế.
- Refactor mà không có Unit Test bảo vệ (cực kỳ rủi ro).
- Áp dụng Design Patterns quá sớm khi bài toán chưa yêu cầu.

## Mẹo và thủ thuật

- Dùng kỹ thuật "Early Return" (Guard Clauses) để xóa bỏ các tầng `if/else` lồng nhau.
- Sử dụng công cụ `PHP CS Fixer` để tự động định dạng code theo chuẩn.
