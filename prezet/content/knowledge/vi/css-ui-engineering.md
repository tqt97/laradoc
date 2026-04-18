---
title: "CSS & UI Engineering: Nghệ thuật Giao diện Chuyên nghiệp"
description: Hệ thống hơn 50 câu hỏi về Box Model, Flexbox, Grid, CSS Architecture, Performance và Responsive Design.
date: 2026-02-22
tags: [css, frontend, ui, design-system, responsive]
image: /prezet/img/ogimages/knowledge-vi-css-ui-engineering.webp
---

> Giao diện là bộ mặt của ứng dụng. Một UI Engineer giỏi không chỉ biết làm cho đẹp, mà còn phải làm cho nó nhẹ, dễ bảo trì và khả năng tương thích cao.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: CSS Box Model là gì?</summary>
  
  **Trả lời:**
  Là mô hình biểu diễn mọi phần tử HTML dưới dạng một hình hộp, bao gồm: Content (nội dung), Padding (khoảng đệm), Border (viền), và Margin (khoảng cách ngoài).
</details>

<details>
  <summary>Q2: Phân biệt `position: relative`, `absolute`, và `fixed`.</summary>
  
  **Trả lời:**

- Relative: Nằm theo luồng bình thường nhưng có thể dịch chuyển so với vị trí gốc.
- Absolute: Nằm so với phần tử cha gần nhất có position (không phải static).
- Fixed: Nằm cố định so với cửa sổ trình duyệt (viewport).

</details>

<details>
  <summary>Q3: Flexbox dùng để làm gì?</summary>
  
  **Trả lời:**
  Là mô hình dàn trang 1 chiều (theo hàng hoặc cột), giúp căn chỉnh và phân bổ không gian giữa các phần tử một cách linh hoạt.
</details>

<details>
  <summary>Q4: Selector trong CSS là gì? Cho ví dụ.</summary>
  
  **Trả lời:**
  Dùng để chọn phần tử cần định dạng. Ví dụ: `p` (thẻ), `.class` (lớp), `#id` (định danh), `input[type="text"]` (thuộc tính).
</details>

<details>
  <summary>Q5: Đơn vị `px`, `em`, `rem` khác nhau như thế nào?</summary>
  
  **Trả lời:**

- `px`: Cố định.
- `em`: Phụ thuộc vào font-size của phần tử cha.
- `rem`: Phụ thuộc vào font-size của phần tử gốc (`<html>`). Nên dùng `rem` cho tính dễ tiếp cận (Accessibility).

</details>

<details>
  <summary>Q6: Làm thế nào để căn giữa một phần tử bằng Flexbox?</summary>
  
  **Trả lời:**
  Dùng `display: flex; justify-content: center; align-items: center;` cho phần tử cha.
</details>

<details>
  <summary>Q7: Pseudo-classes và Pseudo-elements là gì?</summary>
  
  **Trả lời:**

- Pseudo-class: Trạng thái của phần tử (ví dụ: `:hover`, `:focus`, `:nth-child(1)`).
- Pseudo-element: Phần cụ thể của phần tử (ví dụ: `::before`, `::after`, `::first-letter`).

</details>

<details>
  <summary>Q8: CSS Reset và Normalize.css để làm gì?</summary>
  
  **Trả lời:**
  Để loại bỏ sự khác biệt về định dạng mặc định giữa các trình duyệt khác nhau, giúp giao diện hiển thị thống nhất hơn.
</details>

<details>
  <summary>Q9: Z-index hoạt động như thế nào?</summary>
  
  **Trả lời:**
  Quyết định thứ tự hiển thị lớp (lên trên hay xuống dưới). Chỉ có tác dụng với phần tử có `position` khác `static`.
</details>

<details>
  <summary>Q10: Làm thế nào để tạo Responsive Design đơn giản nhất?</summary>
  
  **Trả lời:**
  Sử dụng Media Queries (`@media`) để thay đổi CSS dựa trên kích thước màn hình.
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: CSS Grid vs Flexbox: Khi nào dùng cái nào?</summary>
  
  **Trả lời:**

- Grid: Dàn trang 2 chiều (cả hàng và cột), phù hợp cho bố cục lớn.
- Flexbox: Dàn trang 1 chiều, phù hợp cho các thành phần nhỏ bên trong.

</details>

<details>
  <summary>Q2: Giải thích về "Specificity" (Độ ưu tiên) trong CSS.</summary>

  **Trả lời:**
  Thứ tự ưu tiên: Inline style > ID > Class/Attribute/Pseudo-class > Element/Pseudo-element. Nếu bằng nhau, cái viết sau sẽ thắng.
</details>

<details>
  <summary>Q3: BEM (Block Element Modifier) là gì và tại sao cần nó?</summary>

  **Trả lời:**
  Là quy tắc đặt tên class (ví dụ: `.card__title--active`). Giúp code CSS dễ đọc, tránh xung đột tên và dễ tái sử dụng.
</details>

<details>
  <summary>Q4: CSS Variables (Custom Properties) hoạt động thế nào?</summary>
  
  **Trả lời:**
  Khai báo: `--main-color: #ff0000;`. Sử dụng: `color: var(--main-color);`. Giúp quản lý theme cực kỳ hiệu quả.
</details>

<details>
  <summary>Q5: Phân biệt `display: none` và `visibility: hidden`.</summary>
  
  **Trả lời:**

- `display: none`: Xóa hoàn toàn phần tử khỏi luồng trang (không chiếm diện tích).
- `visibility: hidden`: Ẩn phần tử nhưng vẫn chiếm diện tích như bình thường.

</details>

<details>
  <summary>Q6: Ý nghĩa của `box-sizing: border-box`?</summary>
  
  **Trả lời:**
  Khi set width/height, nó bao gồm cả padding và border. Giúp việc tính toán kích thước phần tử dễ dàng và chính xác hơn nhiều.
</details>

<details>
  <summary>Q7: Làm thế nào để tạo hiệu ứng chuyển động mượt mà (Transitions vs Animations)?</summary>
  
  **Trả lời:**

- Transition: Thay đổi từ trạng thái A sang B khi có sự kiện (hover).
- Animation: Chuỗi các thay đổi phức tạp qua nhiều bước (`@keyframes`), chạy tự động.

</details>

<details>
  <summary>Q8: Mobile-First Strategy là gì trong CSS?</summary>
  
  **Trả lời:**
  Viết CSS cho màn hình nhỏ trước, sau đó dùng Media Queries để thêm định dạng cho màn hình lớn. Giúp code sạch và hiệu năng tốt hơn trên mobile.
</details>

<details>
  <summary>Q9: Phân biệt `object-fit: cover` và `contain` khi hiển thị ảnh.</summary>
  
  **Trả lời:**

- Cover: Ảnh lấp đầy vùng chứa (có thể bị cắt).
- Contain: Ảnh hiện đầy đủ bên trong vùng chứa (có thể có khoảng trống).

</details>

<details>
  <summary>Q10: Tailwind CSS khác gì so với CSS truyền thống?</summary>
  
  **Trả lời:**
  Tailwind là Utility-first framework. Bạn viết CSS trực tiếp qua các class ngắn gọn trong HTML. Giúp dev nhanh hơn và không cần phải đau đầu đặt tên class.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Giải thích về "Stacking Context" trong CSS.</summary>
  
  **Trả lời:**
  Là khái niệm quyết định phần tử nào nằm trên. Một phần tử có thể tạo ra stacking context riêng (ví dụ qua `opacity < 1` hoặc `transform`), làm cho `z-index` của con nó chỉ có tác dụng bên trong đó.
</details>

<details>
  <summary>Q2: CSS Performance: Tại sao selector quá dài lại làm chậm trình duyệt?</summary>
  
  **Trả lời:**
  Trình duyệt đọc selector từ phải sang trái. Selector như `body div section ul li a` bắt trình duyệt phải duyệt qua quá nhiều phần tử để so khớp.
</details>

<details>
  <summary>Q3: Làm thế nào để tối ưu hóa Fonts (Web Font Optimization)?</summary>
  
  **Trả lời:**
  Dùng định dạng WOFF2, sử dụng `font-display: swap`, và chỉ load các ký tự thực sự cần thiết (Subsetting).
</details>

<details>
  <summary>Q4: CSS-in-JS (Styled Components) hoạt động như thế nào?</summary>
  
  **Trả lời:**
  Viết CSS trực tiếp trong file JavaScript/React. Thư viện sẽ tự động generate class name duy nhất để tránh xung đột và hỗ trợ dynamic styling mạnh mẽ.
</details>

<details>
  <summary>Q5: Giải thích về "Critical CSS".</summary>
  
  **Trả lời:**
  Chỉ lấy phần CSS cần thiết để hiển thị phần trang người dùng thấy đầu tiên (above the fold) và inline trực tiếp vào HTML để tăng tốc độ hiển thị ban đầu.
</details>

<details>
  <summary>Q6: Làm thế nào để tạo giao diện Dark Mode hiệu quả?</summary>
  
  **Trả lời:**
  Sử dụng CSS Variables kết hợp với media query `(prefers-color-scheme: dark)` hoặc một class `.dark` ở thẻ body.
</details>

<details>
  <summary>Q7: Container Queries là gì và tại sao nó thay đổi cách làm Component?</summary>
  
  **Trả lời:**
  Cho phép phần tử thay đổi CSS dựa trên kích thước của "phần tử cha" thay vì kích thước toàn bộ màn hình. Giúp tạo ra các component thực sự độc lập.
</details>

<details>
  <summary>Q8: Phân tích sự đánh đổi giữa SVG và Icon Fonts.</summary>
  
  **Trả lời:**

- SVG: Sắc nét, dễ tùy chỉnh màu qua CSS, hỗ trợ animation tốt, SEO tốt hơn.
- Icon Fonts: Nhẹ khi dùng nhiều icon, nhưng khó căn chỉnh pixel-perfect và gây ra vấn đề accessibility.

</details>

<details>
  <summary>Q9: "Aspect Ratio" trong CSS hiện đại xử lý thế nào?</summary>
  
  **Trả lời:**
  Dùng thuộc tính `aspect-ratio: 16 / 9;`. Không còn cần dùng kỹ thuật `padding-top` phức tạp như trước.
</details>

<details>
  <summary>Q10: Tối ưu hóa CSS Animations (Hardware Acceleration).</summary>
  
  **Trả lời:**
  Sử dụng các thuộc tính `transform` và `opacity` vì chúng được xử lý bởi GPU, không gây ra re-layout (Reflow) và re-paint, giúp animation mượt mà 60fps.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế một Design System / Component Library dùng chung cho nhiều dự án.</summary>
  
  **Trả lời:**
  Sử dụng **Design Tokens** (biến cho màu sắc, khoảng cách, font). Xây dựng thư viện component Atomic (Atom -> Molecule -> Organism). Đảm bảo tính nhất quán qua Storybook.
</details>

<details>
  <summary>Q2: Phân tích chiến lược CSS Architecture (ITCSS, Atomic CSS).</summary>
  
  **Trả lời:**

- ITCSS: Phân tầng CSS theo độ ưu tiên và phạm vi (Settings -> Tools -> Generic -> Elements -> Objects -> Components -> Trumps).
- Atomic CSS: Mỗi class chỉ làm 1 việc duy nhất.

</details>

<details>
  <summary>Q3: Làm thế nào để quản lý CSS trong hệ thống Micro-frontends?</summary>
  
  **Trả lời:**
  Dùng **CSS Modules** hoặc **Shadow DOM** để cô lập hoàn toàn CSS của từng module, tránh việc module này làm vỡ giao diện module kia.
</details>

<details>
  <summary>Q4: Tầm nhìn: Tương lai của CSS với Houdini API.</summary>
  
  **Trả lời:**
  Cho phép lập trình viên can thiệp trực tiếp vào quá trình Rendering của trình duyệt bằng JavaScript, mở ra khả năng tạo ra các hiệu ứng hình ảnh và bố cục chưa từng có.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Giao diện hiển thị đúng trên Chrome nhưng bị lệch trên Safari. Cách xử lý?</summary>
  
  **Xử lý:** 1. Kiểm tra Vendor Prefixes (`-webkit-`). 2. Sử dụng công cụ Autoprefixer. 3. Kiểm tra các thuộc tính CSS mới xem Safari đã hỗ trợ chưa qua "Can I Use".
</details>

<details>
  <summary>S2: File CSS của bạn quá lớn (> 500KB) làm chậm trang web. Cách tối ưu?</summary>

  **Xử lý:** 1. Sử dụng PurgeCSS để xóa code thừa. 2. Chia nhỏ CSS theo trang. 3. Bật nén Brotli/Gzip. 4. Sử dụng Tailwind để giảm thiểu lặp lại code.
</details>

## Nên biết

- Box Model và Flexbox/Grid.
- CSS Specificity.
- Responsive Design với Media Queries.

## Lưu ý

- Sử dụng `!important` quá nhiều (gây khó khăn khi ghi đè).
- Đặt tên class quá chung chung (gây xung đột).
- Quên không tối ưu CSS cho Mobile.

## Mẹo và thủ thuật

- Dùng `gap` cho Flexbox (đã hỗ trợ hầu hết trình duyệt hiện đại) thay vì margin.
- Tận dụng `clamp()` để tạo font-size linh hoạt giữa các màn hình mà không cần quá nhiều media queries.
