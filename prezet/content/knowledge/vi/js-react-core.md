---
title: "JavaScript & React Core: Từ Cơ bản đến Chuyên gia"
description: Hệ thống hơn 50 câu hỏi về JavaScript Internals, React Hooks, State Management và Performance Optimization.
date: 2025-08-07
tags: [js, react, frontend, internals, performance]
image: /prezet/img/ogimages/knowledge-vi-js-react-core.webp
---

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: JavaScript là ngôn ngữ Single-threaded hay Multi-threaded?</summary>
  
  **Trả lời:**
  Single-threaded. JavaScript chỉ thực thi một lệnh tại một thời điểm trên luồng chính (Main thread).
</details>

<details>
  <summary>Q2: Phân biệt `var`, `let`, và `const`.</summary>
  
  **Trả lời:**

- `var`: Function scope, có hoisting, có thể khai báo lại.
- `let`: Block scope, có hoisting nhưng nằm trong "Temporal Dead Zone", không thể khai báo lại trong cùng scope.
- `const`: Giống `let` nhưng giá trị không thể gán lại sau khi khởi tạo.

</details>

<details>
  <summary>Q3: Các kiểu dữ liệu cơ bản (Primitive types) trong JS là gì?</summary>

  **Trả lời:**
  String, Number, BigInt, Boolean, Undefined, Symbol, NULL.
</details>

<details>
  <summary>Q4: React là gì và tại sao gọi nó là "Library" thay vì "Framework"?</summary>

  **Trả lời:**
  React là thư viện UI. Nó chỉ tập trung vào việc render view. Khác với Framework (Angular), nó không ép buộc bạn cách làm routing hay gọi API.
</details>

<details>
  <summary>Q5: JSX là gì?</summary>

  **Trả lời:**
  JavaScript XML. Nó là cú pháp mở rộng cho phép viết HTML bên trong JavaScript. Babel sẽ biên dịch JSX thành `React.createElement()`.
</details>

<details>
  <summary>Q6: Component trong React là gì?</summary>

  **Trả lời:**
  Là các khối xây dựng UI độc lập, có thể tái sử dụng. Có 2 loại: Functional Component (phổ biến) và Class Component.
</details>

<details>
  <summary>Q7: Props trong React dùng để làm gì?</summary>

  **Trả lời:**
  Dùng để truyền dữ liệu từ component cha xuống component con. Props là "Read-only" (không thể thay đổi từ bên trong component con).
</details>

<details>
  <summary>Q8: State trong React là gì?</summary>

  **Trả lời:**
  Dữ liệu nội bộ của một component, có thể thay đổi theo thời gian. Khi state thay đổi, component sẽ tự động re-render.
</details>

<details>
  <summary>Q9: Arrow Function khác gì Function truyền thống?</summary>
  
  **Trả lời:**
  Cú pháp ngắn gọn hơn, không có `this` riêng (nó kế thừa `this` từ scope bên ngoài), không có object `arguments`.
</details>

<details>
  <summary>Q10: DOM là gì?</summary>
  
  **Trả lời:**
  Document Object Model. Là giao diện lập trình cho các tài liệu HTML/XML, biểu diễn trang web dưới dạng một cây các đối tượng.
</details>

<details>
  <summary>Q11: Optional Chaining (`?.`) và Nullish Coalescing (`??`) trong JS dùng để làm gì?</summary>
  
  **Trả lời:**

- `?.`: Truy cập thuộc tính mà không sợ lỗi nếu object là null/undefined.
- `??`: Trả về giá trị mặc định CHỈ khi biến là null/undefined (khác với `||` vốn bỏ qua cả 0 và chuỗi rỗng).

</details>

<details>
  <summary>Q12: React Fragment (`<>...</>`) giải quyết vấn đề gì?</summary>
  
  **Trả lời:**
  Cho phép nhóm một danh sách các component con mà không cần thêm thẻ `div` thừa vào DOM, giúp cấu trúc HTML sạch sẽ hơn.
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Closure trong JavaScript là gì?</summary>
  
  **Trả lời:**
  Là một hàm có khả năng "nhớ" và truy cập các biến từ phạm vi (scope) bên ngoài ngay cả sau khi scope đó đã thực thi xong.
</details>

<details>
  <summary>Q2: Giải thích về Prototype và Prototypal Inheritance.</summary>
  
  **Trả lời:**
  Mọi object trong JS đều có một thuộc tính ẩn trỏ tới object khác gọi là Prototype. Khi truy cập một thuộc tính không có ở object hiện tại, JS sẽ tìm ngược lên chuỗi Prototype (Prototype Chain).
</details>

<details>
  <summary>Q3: Virtual DOM hoạt động như thế nào? Tại sao nó nhanh?</summary>
  
  **Trả lời:**
  React giữ một bản sao của DOM thật trong bộ nhớ (Virtual DOM). Khi dữ liệu thay đổi, React tạo bản Virtual DOM mới, so sánh với bản cũ (Diffing), rồi chỉ cập nhật những phần thực sự thay đổi lên DOM thật (Reconciliation).
</details>

<details>
  <summary>Q4: useEffect dùng để làm gì? Giải thích mảng dependencies.</summary>
  
  **Trả lời:**
  Dùng để xử lý side effects (gọi API, subscription). Mảng rỗng `[]`: chạy 1 lần sau khi mount. Có giá trị `[prop]`: chạy lại khi giá trị đó đổi. Không có mảng: chạy sau mỗi lần render.
</details>

<details>
  <summary>Q5: Phân biệt `==` và `===` trong JS.</summary>
  
  **Trả lời:**
  Tương tự PHP, `==` so sánh giá trị sau khi ép kiểu, `===` so sánh nghiêm ngặt cả giá trị và kiểu dữ liệu.
</details>

<details>
  <summary>Q6: Promise là gì? Các trạng thái của Promise?</summary>
  
  **Trả lời:**
  Là đối tượng đại diện cho kết quả của một tác vụ bất đồng bộ. 3 trạng thái: Pending (đang chờ), Fulfilled (thành công), Rejected (thất bại).
</details>

<details>
  <summary>Q7: Async/Await là gì? Nó có thay thế Promise không?</summary>
  
  **Trả lời:**
  Là cú pháp giúp viết code bất đồng bộ trông như đồng bộ. Nó được xây dựng dựa trên Promise, giúp code dễ đọc và xử lý lỗi (try/catch) tốt hơn.
</details>

<details>
  <summary>Q8: HOF (Higher Order Function) là gì?</summary>
  
  **Trả lời:**
  Hàm nhận hàm khác làm tham số hoặc trả về một hàm. Ví dụ: `map`, `filter`, `reduce`.
</details>

<details>
  <summary>Q9: React Hooks có những quy tắc (Rules) nào?</summary>
  
  **Trả lời:**

  1. Chỉ gọi ở cấp cao nhất (Top level), không gọi trong vòng lặp hay câu lệnh điều kiện. 2. Chỉ gọi trong React Function Components hoặc Custom Hooks.

</details>

<details>
  <summary>Q10: Keys trong danh sách React (`map`) có tác dụng gì?</summary>
  
  **Trả lời:**
  Giúp React xác định phần tử nào bị thay đổi, thêm mới hoặc xóa bỏ để tối ưu quá trình re-render danh sách.
</details>

<details>
  <summary>Q11: Custom Hooks là gì? Tại sao nên dùng?</summary>
  
  **Trả lời:**
  Là các hàm Javascript bắt đầu bằng `use` và có thể gọi các hook khác của React. Giúp tách biệt và tái sử dụng logic (ví dụ: `useFetch`, `useAuth`) giữa nhiều component.
</details>

<details>
  <summary>Q12: Phân biệt `Map` và `Object` trong Javascript.</summary>
  
  **Trả lời:**
  `Map` hỗ trợ key là bất kỳ kiểu dữ liệu nào (ngay cả object), giữ đúng thứ tự thêm vào và có hiệu năng tốt hơn khi thêm/xóa phần tử thường xuyên. `Object` chỉ hỗ trợ key là string/symbol.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Giải thích sâu về Event Loop (Call Stack, Web APIs, Callback Queue, Microtask Queue).</summary>
  
  **Trả lời:**
  Call Stack thực thi lệnh. Web APIs xử lý async (setTimeout, fetch). Callback Queue chứa task xong. Microtask Queue (Promise) có ưu tiên cao hơn Callback Queue. Event Loop đẩy task từ Queue lên Stack khi Stack trống.
</details>

<details>
  <summary>Q2: React Re-render diễn ra khi nào? Làm thế nào để ngăn chặn re-render vô ích?</summary>
  
  **Trả lời:**
  Re-render khi: State đổi, Props đổi, Parent re-render, Context đổi.
  **Tối ưu:** Dùng `React.memo`, `useMemo`, `useCallback`.
</details>

<details>
  <summary>Q3: Phân biệt useMemo và useCallback.</summary>
  
  **Trả lời:**

- `useMemo`: Ghi nhớ **giá trị** kết quả của một phép tính đắt đỏ.
- `useCallback`: Ghi nhớ chính **instance của hàm** để tránh tạo hàm mới mỗi lần render (gây lỗi memo ở component con).

</details>

<details>
  <summary>Q4: Giải thích cơ chế Reconciliation và thuật toán Diffing của React.</summary>
  
  **Trả lời:**
  React so sánh 2 cây Virtual DOM. Nếu type element đổi -> xóa cũ tạo mới. Nếu type giống nhưng thuộc tính đổi -> chỉ update thuộc tính. Thuật toán có độ phức tạp O(n) nhờ giả định key và component type.
</details>

<details>
  <summary>Q5: Redux vs Context API: Khi nào dùng cái nào?</summary>
  
  **Trả lời:**

- Context API: Tốt cho dữ liệu ít thay đổi (Theme, Auth).
- Redux: Tốt cho state phức tạp, thay đổi liên tục, cần công cụ debug mạnh (DevTools) và logic tập trung.

</details>

<details>
  <summary>Q6: Hoisting trong JavaScript hoạt động như thế nào với Class và Function?</summary>
  
  **Trả lời:**
  Function declaration được hoisted hoàn toàn. Class và biến `let`/`const` được hoisted nhưng không khởi tạo (nằm trong TDZ), truy cập sớm sẽ báo lỗi.
</details>

<details>
  <summary>Q7: Curry Function và ứng dụng thực tế?</summary>
  
  **Trả lời:**
  Biến đổi một hàm nhận nhiều tham số thành chuỗi các hàm, mỗi hàm nhận 1 tham số. Ứng dụng: cấu hình hàm (partial application), middleware trong Redux.
</details>

<details>
  <summary>Q8: Pure Component và Pure Function trong React là gì?</summary>
  
  **Trả lời:**

- Pure Function: Output chỉ phụ thuộc vào Input, không có side effects.
- Pure Component: Chỉ re-render khi props/state thực sự thay đổi giá trị (Shallow compare).

</details>

<details>
  <summary>Q9: Cơ chế Hydration trong Server-side Rendering (SSR) là gì?</summary>
  
  **Trả lời:**
  Server gửi HTML tĩnh xuống. Browser nhận HTML và "gắn" các event listener, khởi tạo state của React lên HTML đó để biến nó thành ứng dụng tương tác.
</details>

<details>
  <summary>Q10: "This" keyword trong JS được xác định như thế nào (4 quy tắc)?</summary>
  
  **Trả lời:**

  1. Default (Global). 2. Implicit (object gọi hàm). 3. Explicit (`bind`, `call`, `apply`). 4. New (constructor). Arrow function không tuân theo quy tắc này.

</details>

<details>
  <summary>Q11: Giải thích cơ chế "Batching" trong React 18.</summary>
  
  **Trả lời:**
  React tự động gộp nhiều lần cập nhật state (ngay cả trong các tác vụ async như fetch, setTimeout) vào 1 lần re-render duy nhất để tối ưu hiệu năng.
</details>

<details>
  <summary>Q12: Phân tích sự khác biệt giữa `useLayoutEffect` và `useEffect`.</summary>
  
  **Trả lời:**

- `useEffect`: Chạy bất đồng bộ sau khi trình duyệt đã vẽ xong giao diện (không chặn UI).
- `useLayoutEffect`: Chạy đồng bộ ngay sau khi React cập nhật DOM nhưng TRƯỚC KHI trình duyệt vẽ. Dùng để đo đạc kích thước phần tử để tránh hiện tượng nháy hình (flickering).

</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế kiến trúc State Management cho một ứng dụng E-commerce khổng lồ.</summary>
  
  **Trả lời:**
  Dùng mô hình lai:

  1. **Server State:** Dùng React Query (TanStack Query) để cache, fetch dữ liệu từ API.
  2. **Global UI State:** Dùng Zustand hoặc Redux Toolkit cho giỏ hàng, thông tin user.
  3. **Local State:** `useState` cho các UI nhỏ (modal, toggle).

</details>

<details>
  <summary>Q2: Giải thích cơ chế React Fiber và Concurrent Mode (Concurrent Rendering).</summary>
  
  **Trả lời:**
  Fiber chia quá trình render thành các khối nhỏ (unit of work) có thể tạm dừng và ưu tiên. Concurrent Mode cho phép React render nhiều phiên bản UI cùng lúc ngầm, giúp ứng dụng mượt mà hơn khi xử lý task nặng.
</details>

<details>
  <summary>Q3: Micro-frontend là gì? Các hướng tiếp cận (Module Federation)?</summary>
  
  **Trả lời:**
  Chia nhỏ ứng dụng lớn thành các phần độc lập có thể deploy riêng biệt. Module Federation (Webpack 5) cho phép load code từ ứng dụng khác tại runtime một cách hiệu quả.
</details>

<details>
  <summary>Q4: Phân tích hiệu năng giữa Client-side Rendering (CSR), SSR, và Static Site Generation (SSG).</summary>
  
  **Trả lời:**

- CSR: Nhanh sau khi load xong, SEO kém.
- SSR: SEO tốt, FCP (First Contentful Paint) nhanh, Server tải nặng.
- SSG: Nhanh nhất, bảo mật, SEO tốt, nhưng dữ liệu không realtime.

</details>

<details>
  <summary>Q5: Thiết kế giải pháp Error Boundary toàn cục cho React app.</summary>
  
  **Trả lời:**
  Dùng Class Component làm Error Boundary bao bọc các module lớn. Kết hợp với dịch vụ log lỗi (Sentry) để báo cáo lỗi runtime về server.
</details>

<details>
  <summary>Q6: Làm thế nào để tối ưu hóa Bundle Size của một ứng dụng React lớn?</summary>
  
  **Trả lời:**
  Code splitting (`React.lazy`, `Suspense`), Tree shaking, dùng thư viện nhẹ, nén ảnh, tối ưu hóa Third-party dependencies.
</details>

<details>
  <summary>Q7: Phân tích sự khác biệt giữa Shadow DOM và Virtual DOM.</summary>
  
  **Trả lời:**
  Shadow DOM: Công nghệ của Web Components để cô lập CSS/HTML. Virtual DOM: Kỹ thuật của thư viện để tối ưu update UI. Chúng không liên quan trực tiếp đến nhau.
</details>

<details>
  <summary>Q8: Thiết kế hệ thống Design System (Component Library) dùng chung cho nhiều dự án.</summary>
  
  **Trả lời:**
  Dùng Storybook để phát triển, TailWind hoặc Styled Components để styling, đóng gói qua NPM, hỗ trợ Typescript và Accessibility (ARIA).
</details>

<details>
  <summary>Q9: Cơ chế Garbage Collection trong V8 Engine hoạt động như thế nào?</summary>
  
  **Trả lời:**
  Dùng Generational Collection: chia bộ nhớ thành Young Generation (Scavenge) và Old Generation (Mark-Sweep-Compact).
</details>

<details>
  <summary>Q10: Tương lai của React: Server Components (RSC) giải quyết vấn đề gì?</summary>
  
  **Trả lời:**
  RSC chạy hoàn toàn trên server, không gửi JS xuống client cho những component đó, giúp bundle size cực nhỏ và fetch data trực tiếp từ nguồn (DB).
</details>

<details>
  <summary>Q11: Thiết kế hệ thống "Micro-frontends" - Phân tích Module Federation vs Iframe.</summary>
  
  **Trả lời:**
  Iframe: Cô lập tuyệt đối nhưng khó chia sẻ state và hiệu năng kém. Module Federation (Webpack 5): Cho phép chia sẻ thư viện (như React) giữa các app, load code động mượt mà, là tiêu chuẩn cho Micro-frontends hiện đại.
</details>

<details>
  <summary>Q12: Tầm nhìn: Tại sao "Signal" (trong Solid/Preact/Angular) lại đang đe dọa vị thế của "React State"?</summary>
  
  **Trả lời:**
  React re-render toàn bộ component tree (cần ảo hóa/memo). Signals cho phép cập nhật trực tiếp từng node DOM nhỏ nhất mà không cần chạy lại component logic, mang lại hiệu năng tiệm cận Javascript thuần mà vẫn giữ được sự tiện lợi của React.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Component bị re-render liên tục dù dữ liệu không đổi. Cách tìm nguyên nhân?</summary>
  
  **Xử lý:** Dùng React DevTools Profiler để xem component nào render. Kiểm tra xem có đang tạo object/array mới trong mỗi lần render rồi truyền xuống props không.
</details>

<details>
  <summary>S2: Ứng dụng bị giật lag khi người dùng nhập vào ô search lớn. Giải pháp?</summary>
  
  **Xử lý:** Dùng **Debounce** hoặc **Throttle** để giới hạn số lần gọi hàm search. Hoặc dùng `useDeferredValue` trong React 18.
</details>

## Nên biết

- Event Loop và cách JS xử lý bất đồng bộ.
- React Lifecycle và sự ra đời của Hooks.
- Các kỹ thuật tối ưu hóa re-render.

## Lưu ý

- Quên cleanup trong `useEffect` (gây memory leak).
- Thay đổi trực tiếp (mutate) state thay vì dùng `setState`.
- Sử dụng index làm key trong danh sách có thể thay đổi thứ tự.

## Mẹo và thủ thuật

- Dùng `Optional Chaining` (`?.`) để tránh lỗi crash trang khi dữ liệu bị NULL.
- Tận dụng `Strict Mode` để phát hiện các side effects không mong muốn trong quá trình phát triển.
