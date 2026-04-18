---
title: "Code Review & Engineering Practices: Quy trình Kỹ thuật Chuẩn"
description: Hệ thống câu hỏi về Git workflow, quy trình Review, tiêu chuẩn Commit và các thói quen tốt của một kỹ sư phần mềm.
date: 2026-04-18
tags: [code-review, git, workflow, engineering, practices]
image: /prezet/img/ogimages/knowledge-code-review-engineering-practices.webp
---

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Git là gì? Tại sao cần dùng Git?</summary>

  **Trả lời:**
  Hệ thống quản lý phiên bản phân tán. Giúp lưu lại lịch sử thay đổi code, làm việc nhóm không bị ghi đè dữ liệu của nhau và dễ dàng quay lại các bản cũ khi có lỗi.
</details>

<details>
  <summary>Q2: Pull Request (PR) hoặc Merge Request (MR) là gì?</summary>

  **Trả lời:**
  Lời yêu cầu merge code từ nhánh của bạn vào nhánh chung. Đây là nơi diễn ra các thảo luận và review code trước khi thay đổi chính thức được chấp nhận.
</details>

<details>
  <summary>Q3: Tại sao tin nhắn commit (Commit Message) lại quan trọng?</summary>

  **Trả lời:**
  Giúp đồng nghiệp (và chính bạn sau này) hiểu nhanh thay đổi này làm gì mà không cần đọc từng dòng code. Một commit message tốt giúp việc debug và tạo changelog dễ dàng hơn.
</details>

<details>
  <summary>Q4: Quy trình Git cơ bản: clone, add, commit, push, pull.</summary>

  **Trả lời:**

- `clone`: Tải code về máy.
- `add`: Chọn các thay đổi chuẩn bị lưu.
- `commit`: Lưu các thay đổi kèm mô tả.
- `push`: Đẩy code lên server.
- `pull`: Tải các thay đổi mới nhất từ server về.

</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Giải thích mô hình "GitFlow".</summary>

  **Trả lời:**
  Mô hình quản lý nhánh gồm: `master` (prod), `develop` (dev), `feature/` (tính năng mới), `release/` (chuẩn bị prod), và `hotfix/` (sửa lỗi gấp trên prod).
</details>

<details>
  <summary>Q2: Bạn nên kiểm tra những gì khi Review code của đồng nghiệp?</summary>

  **Trả lời:**

  1. Logic có đúng yêu cầu không? 2. Có lỗ hổng bảo mật không? 3. Hiệu năng có vấn đề không (N+1 query)? 4. Code có dễ đọc/clean không? 5. Đã có Unit Test chưa?

</details>

<details>
  <summary>Q3: Phân biệt `git merge` và `git rebase`.</summary>

  **Trả lời:**

- `merge`: Gộp nhánh, tạo ra một commit gộp (merge commit), giữ nguyên lịch sử rẽ nhánh.
- `rebase`: Đưa các commit của nhánh mình lên trên cùng của nhánh đích, tạo ra lịch sử dạng đường thẳng sạch sẽ nhưng làm thay đổi mã hash của commit cũ.

</details>

<details>
  <summary>Q4: Tiêu chuẩn "Conventional Commits" là gì?</summary>

  **Trả lời:**
  Quy tắc đặt tên commit: `<type>(scope): <description>`. Ví dụ: `feat(auth): add google login`, `fix(api): handle null response`.
</details>

<details>
  <summary>Q5: "Trunk-based Development" khác gì GitFlow?</summary>

  **Trả lời:**
  Mọi người cùng làm việc trên 1 nhánh chính (`main`/`trunk`). Commit nhỏ, thường xuyên merge và dùng Feature Flags để ẩn tính năng chưa xong. Giúp CI/CD nhanh hơn GitFlow.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Cách xử lý xung đột (Merge Conflicts) phức tạp trong team lớn.</summary>

  **Xử lý:** 1. Luôn pull code mới nhất trước khi làm. 2. Chia nhỏ PR để giảm phạm vi xung đột. 3. Sử dụng các công cụ so sánh (Diff tools). 4. Liên lạc trực tiếp với người viết đoạn code gây xung đột để hiểu ý đồ trước khi sửa.
</details>

<details>
  <summary>Q2: Làm thế nào để duy trì văn hóa Review tích cực?</summary>

  **Trả lời:**
  Dùng cấu trúc: "Tôi thấy... vì vậy tôi đề nghị..." thay vì "Bạn làm sai rồi". Khen ngợi những đoạn code hay. Review nhanh (trong vòng 24h) để không làm nghẽn tiến độ.
</details>

<details>
  <summary>Q3: Giải thích về "Pre-commit Hooks".</summary>

  **Trả lời:**
  Các script tự động chạy trên máy dev trước khi commit (ví dụ: tự động chạy linter, check style, chạy unit test). Giúp ngăn chặn code "bẩn" đẩy lên server.
</details>

<details>
  <summary>Q4: Chiến lược "Automated Code Review" dùng công cụ nào?</summary>

  **Trả lời:**
  Sử dụng SonarQube, Scrutinizer, hoặc Github Actions kết hợp với PHPStan/Psalm để tự động phát hiện lỗi logic và bảo mật ngay khi mở PR.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế quy trình CI/CD đảm bảo 0% lỗi logic lọt lên Production.</summary>

  **Trả lời:**
  Lắp đặt các chốt chặn: 1. Lint/Style check. 2. Static Analysis. 3. Unit/Integration Tests. 4. QA Manual test trên môi trường Staging. 5. Canary Deployment (chạy thử trên 5% user).
</details>

<details>
  <summary>Q2: Tầm nhìn: "Code Review as a Knowledge Sharing Tool".</summary>

  **Trả lời:**
  Review không chỉ là bắt lỗi, mà là cách Senior dạy Junior và ngược lại. Architect cần đảm bảo Review là quá trình học hỏi lẫn nhau, giúp nâng tầm trình độ chung của cả team.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: PR của bạn có 50 file thay đổi và bị đồng nghiệp từ chối review vì quá lớn. Bạn làm gì?</summary>

  **Xử lý:** 1. Xin lỗi team. 2. Tách nhỏ PR đó ra thành 3-4 PR nhỏ hơn, mỗi cái giải quyết 1 phần logic độc lập. 3. Lần sau tuân thủ nguyên tắc "Atomic PR".
</details>

<details>
  <summary>S2: Có tranh cãi nảy lửa về cách đặt tên biến trong PR. Bạn xử lý thế nào?</summary>

  **Xử lý:** 1. Tham chiếu tới Coding Standard của team. 2. Nếu không có, hãy chọn cách đơn giản nhất và kết thúc tranh cãi nhanh để làm việc khác. 3. Đưa vấn đề vào buổi họp team để thống nhất tiêu chuẩn chung sau này.
</details>

## Nên biết

- Các lệnh Git nâng cao: cherry-pick, stash, revert, reset.
- Cách viết một PR Description đầy đủ (Yêu cầu là gì? Đã làm gì? Ảnh minh chứng).

## Lưu ý

- Review hời hợt chỉ để merge nhanh.
- Commit những file không cần thiết (`vendor/`, `.env`, `node_modules/`).
- Để PR quá lâu không merge dẫn đến xung đột chồng chất.
