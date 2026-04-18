---
title: "Laravel Cơ bản: Nền tảng phát triển Web"
description: Hệ thống hơn 50 câu hỏi về Routing, Middleware, Validation, Blade Engine và kiến trúc Controller.
date: 2025-10-11
tags: [laravel, basics, routing, middleware, validation]
image: /prezet/img/ogimages/knowledge-vi-laravel-the-basics.webp
---

> Làm chủ các kiến thức cơ bản không chỉ là biết cú pháp; đó là hiểu được lý do đằng sau các mẫu thiết kế mà Laravel sử dụng.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Tại sao chúng ta cần Routing thay vì truy cập trực tiếp file PHP?</summary>
  
  **Trả lời:**
  Để tách biệt URL khỏi cấu trúc file vật lý. Giúp tạo URL đẹp, quản lý bảo mật tập trung và dễ dàng thay đổi code mà không đổi link.
</details>

<details>
  <summary>Q2: Middleware là gì (giải thích đơn giản)?</summary>
  
  **Trả lời:**
  Là bộ lọc cho request HTTP. Giống như bouncer ở cửa hộp đêm, kiểm tra ID (Auth) hoặc trang phục (Validation) trước khi cho vào.
</details>

<details>
  <summary>Q3: Blade Engine là gì?</summary>
  
  **Trả lời:**
  Là templating engine mạnh mẽ của Laravel, cho phép viết code PHP trong HTML bằng cú pháp ngắn gọn và đẹp mắt.
</details>

<details>
  <summary>Q4: Controller dùng để làm gì?</summary>
  
  **Trả lời:**
  Là nơi tập trung logic xử lý các request HTTP. Nó nhận input, gọi model xử lý và trả về view hoặc json.
</details>

<details>
  <summary>Q5: Cách tạo một project Laravel mới qua Composer?</summary>
  
  **Trả lời:**
  Dùng lệnh `composer create-project laravel/laravel project-name`.
</details>

<details>
  <summary>Q6: Tham số trong Route (`{id}`) lấy ra ở đâu?</summary>
  
  **Trả lời:**
  Laravel tự động truyền tham số đó vào hàm xử lý trong Controller theo thứ tự.
</details>

<details>
  <summary>Q7: CSRF bảo vệ website khỏi điều gì?</summary>
  
  **Trả lời:**
  Ngăn chặn kẻ xấu giả mạo request từ một trang web khác gửi tới server của bạn khi người dùng đang đăng nhập.
</details>

<details>
  <summary>Q8: Làm thế nào để trả về một JSON response?</summary>
  
  **Trả lời:**
  Dùng `response()->json($data)`. Laravel sẽ tự động set header Content-Type phù hợp.
</details>

<details>
  <summary>Q9: Mục đích của thư mục `storage` trong Laravel?</summary>
  
  **Trả lời:**
  Lưu trữ các file do ứng dụng sinh ra: log, cache, và các file upload từ người dùng.
</details>

<details>
  <summary>Q10: Cách validate dữ liệu cơ bản trong Controller?</summary>
  
  **Trả lời:**
  Dùng `$request->validate([...])`. Nếu lỗi, Laravel tự động quay lại trang trước kèm theo thông báo lỗi.
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Middleware giải quyết vấn đề gì trong các hệ thống lớn?</summary>
  
  **Trả lời:**
  Giải quyết **Cross-cutting concerns**. Viết logic chung (như check admin) một lần và áp dụng cho hàng trăm route thay vì lặp lại code.
</details>

<details>
  <summary>Q2: Tại sao nên dùng Form Requests thay vì viết validate trong Controller?</summary>
  
  **Trả lời:**
  Để tuân thủ nguyên lý **Single Responsibility**. Tách biệt logic kiểm tra dữ liệu khỏi logic điều phối của Controller.
</details>

<details>
  <summary>Q3: Phân biệt `Redirect::back()` và `Redirect::to()`.</summary>
  
  **Trả lời:**
  `back()` quay lại trang ngay trước đó (dựa trên session). `to()` chuyển hướng tới một URL cụ thể.
</details>

<details>
  <summary>Q4: Giải thích khái niệm "Route Model Binding".</summary>
  
  **Trả lời:**
  Tự động inject instance của Model vào Controller dựa trên ID trong URL. Ví dụ: `/users/1` sẽ tự tìm và đưa object `User` có ID 1 vào hàm.
</details>

<details>
  <summary>Q5: View Composers là gì?</summary>
  
  **Trả lời:**
  Là các callback hoặc class được gọi khi một view được render. Dùng để chia sẻ dữ liệu dùng chung (như menu, thông tin user) cho nhiều view mà không cần truyền thủ công ở mọi Controller.
</details>

<details>
  <summary>Q6: "Named Routes" có lợi ích gì khi maintain ứng dụng?</summary>
  
  **Trả lời:**
  Giúp tạo link qua tên route thay vì URL cứng. Khi bạn đổi URL trong file route, toàn bộ link trong View/Controller sẽ tự cập nhật theo.
</details>

<details>
  <summary>Q7: Làm thế nào để group các routes lại với nhau?</summary>
  
  **Trả lời:**
  Dùng `Route::middleware()->prefix()->group(function() { ... })`. Giúp quản lý code sạch sẽ và tránh lặp lại cấu hình.
</details>

<details>
  <summary>Q8: Cách truyền dữ liệu vào Blade component (`x-component`).</summary>
  
  **Trả lời:**
  Dùng cú pháp attributes: `<x-alert type="error" :message="$msg" />`. Dấu `:` dùng để truyền biến hoặc biểu thức PHP.
</details>

<details>
  <summary>Q9: Phân biệt `Request::input()` và `Request::all()`.</summary>
  
  **Trả lời:**
  `all()` lấy toàn bộ dữ liệu. `input('key')` lấy một giá trị cụ thể, có thể cung cấp giá trị mặc định nếu key không tồn tại.
</details>

<details>
  <summary>Q10: "Route Redirect" và "Route View" dùng trong trường hợp nào?</summary>
  
  **Trả lời:**
  Dùng cho các route đơn giản không cần logic Controller. Giúp file route ngắn gọn và hiệu năng nhanh hơn một chút.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Giải thích cơ chế "Pipeline" hoạt động bên trong Middleware và Router.</summary>
  
  **Trả lời:**
  Laravel dùng hàm `array_reduce` để bao bọc các middleware lồng vào nhau. Request đi từ ngoài vào trong, Response đi từ trong ra ngoài (mô hình củ hành).
</details>

<details>
  <summary>Q2: Cách xử lý Validation cho mảng dữ liệu phức tạp (Nested Arrays)?</summary>
  
  **Trả lời:**
  Dùng dấu chấm (dot notation). Ví dụ: `'products.*.price' => 'required|numeric'`. Laravel tự động duyệt qua toàn bộ mảng con để kiểm tra.
</details>

<details>
  <summary>Q3: Làm thế nào để ghi đè (Override) thông báo lỗi validation mặc định toàn cục?</summary>
  
  **Trả lời:**
  Chỉnh sửa file ngôn ngữ trong `lang/en/validation.php` (hoặc `vi`). Hoặc định nghĩa method `messages()` trong Form Request class.
</details>

<details>
  <summary>Q4: Phân tích cơ chế biên dịch (Compiling) của Blade.</summary>
  
  **Trả lời:**
  Blade chuyển cú pháp `@...` thành mã PHP thuần (`<?php ... ?>`) và lưu vào `storage/framework/views`. Laravel chỉ biên dịch lại khi file gốc thay đổi.
</details>

<details>
  <summary>Q5: Làm thế nào để tạo một Custom Validation Rule riêng?</summary>
  
  **Trả lời:**
  Dùng lệnh `php artisan make:rule`. Implement interface `ValidationRule` và định nghĩa logic trong method `validate()`.
</details>

<details>
  <summary>Q6: "Resource Controllers" và cơ chế "Shallow Nesting" là gì?</summary>
  
  **Trả lời:**
  Tự động tạo 7 route chuẩn CRUD. Shallow nesting giúp rút gọn URL của các resource con khi đã biết ID của nó (ví dụ: `/comments/1` thay vì `/posts/1/comments/1`).
</details>

<details>
  <summary>Q7: Cách xử lý Authorization trực tiếp trong Form Request qua method `authorize()`.</summary>
  
  **Trả lời:**
  Laravel gọi method này trước khi chạy validation. Bạn có thể check quyền tại đây, nếu trả về `false`, user nhận ngay lỗi 403 Forbidden.
</details>

<details>
  <summary>Q8: Giải thích về "Route Model Binding" tùy chỉnh (Customizing the Key).</summary>
  
  **Trả lời:**
  Mặc định dùng `id`. Bạn có thể đổi sang `slug` bằng cách định nghĩa `getRouteKeyName()` trong Model hoặc viết trực tiếp trong route: `{post:slug}`.
</details>

<details>
  <summary>Q9: Làm thế nào để handle Exception toàn cục trong Laravel 11?</summary>
  
  **Trả lời:**
  Dùng callback `withExceptions()` trong file `bootstrap/app.php`. Bạn có thể dùng `reportable()` để log hoặc `renderable()` để trả về view lỗi tùy chỉnh.
</details>

<details>
  <summary>Q10: "Fallback Routes" dùng để làm gì?</summary>
  
  **Trả lời:**
  Định nghĩa route cuối cùng sẽ chạy nếu không có route nào khác khớp. Thường dùng để hiện trang 404 tùy chỉnh hoặc xử lý các SPA client-side routing.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế chiến lược Routing cho hệ thống khổng lồ có hàng nghìn route.</summary>
  
  **Trả lời:**

  1. Chia file route theo module (ví dụ: `api_v1.php`, `admin.php`). 2. Sử dụng Route Caching (`php artisan route:cache`). 3. Nhóm các route dùng chung middleware để giảm overhead.

</details>

<details>
  <summary>Q2: Khi nào bạn nên tránh sử dụng Controller và dùng Closure trực tiếp trong Route?</summary>
  
  **Trả lời:**
  CHỈ khi route cực kỳ đơn giản (như hiện 1 trang tĩnh). Tuy nhiên, Architect luôn khuyến khích dùng Controller vì Closure khiến việc **Route Caching** bị lỗi (trong các bản Laravel cũ) và khó tổ chức code.
</details>

<details>
  <summary>Q3: Thiết kế hệ thống Validation đa tầng (Client-side, Server-side, Database-level).</summary>
  
  **Trả lời:**
  Server-side là bắt buộc (Form Requests). Client-side để tăng UX. Database-level (Constraints) là lớp bảo vệ cuối cùng để đảm bảo toàn vẹn dữ liệu ngay cả khi code có bug.
</details>

<details>
  <summary>Q4: Phân tích sự đánh đổi khi dùng Blade Components vs Vue/React trong cùng project.</summary>
  
  **Trả lời:**
  Blade: Nhanh, SEO tốt, SSR mặc định. Vue/React: Tương tác cực cao nhưng tốn bundle size và cấu hình phức tạp. Giải pháp Architect: Dùng **Inertia.js** để gộp ưu điểm cả hai.
</details>

<details>
  <summary>Q5: Thiết kế cơ chế "Dynamic Middleware" dựa trên dữ liệu Database.</summary>
  
  **Trả lời:**
  Tạo một middleware nhận tham số. Bên trong hàm `handle`, nó query database hoặc cache để quyết định cho phép request đi tiếp hay không.
</details>

<details>
  <summary>Q6: Làm thế nào để tối ưu hóa "View Rendering" cho ứng dụng có hàng vạn request mỗi giây?</summary>
  
  **Trả lời:**

  1. Bật View Cache. 2. Inline các CSS/JS nhỏ. 3. Sử dụng CDN cho file tĩnh. 4. Cân nhắc dùng Fragment Caching (cache từng phần HTML) lưu vào Redis.

</details>

<details>
  <summary>Q7: Thiết kế hệ thống đa ngôn ngữ (Localization) cho URL mà vẫn đảm bảo SEO.</summary>
  
  **Trả lời:**
  Dùng prefix URL (ví dụ: `/vi/about`, `/en/about`). Dùng middleware để set Locale dựa trên segment đầu tiên. Đảm bảo có thẻ `hreflang` trong HTML.
</details>

<details>
  <summary>Q8: Phân tích rủi ro bảo mật khi sử dụng directive `@php` hoặc `{!! !!}` trong Blade.</summary>
  
  **Trả lời:**
  `@php` cho phép viết code logic trong View (vi phạm MVC). `{!! !!}` không escape dữ liệu, nếu biến chứa input từ user sẽ dẫn đến lỗ hổng XSS nghiêm trọng.
</details>

<details>
  <summary>Q9: Làm thế nào để xây dựng hệ thống "Feature Flags" ở mức Route level?</summary>
  
  **Trả lời:**
  Tạo một custom middleware `CheckFeature`. Nó kiểm tra trong cấu hình hoặc DB xem tính năng đó có bật không. Nếu tắt, trả về 404 hoặc 403.
</details>

<details>
  <summary>Q10: Tầm nhìn: Tại sao Laravel 11 lại loại bỏ hầu hết các file cấu hình và Kernel mặc định?</summary>
  
  **Trả lời:**
  Để giảm bớt sự choáng ngợp cho người mới và thúc đẩy kiến trúc "Lean". Mọi cấu hình tập trung vào 1 chỗ giúp quản lý dễ dàng hơn và code khởi động nhanh hơn.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Bạn cần thực hiện validate một file upload lớn (20MB) và chỉ cho phép định dạng PDF. Cách làm?</summary>
  
  **Xử lý:** Trong Form Request: `'document' => 'required|file|mimes:pdf|max:20480'`. Cần lưu ý cấu hình `upload_max_filesize` trong `php.ini` cũng phải >= 20MB.
</details>

<details>
  <summary>S2: Route `/user/{name}` bị tranh chấp với route `/user/settings`. Xử lý thế nào?</summary>
  
  **Xử lý:** Đưa route `/user/settings` lên phía trên. Hoặc dùng regex để ràng buộc: `Route::get('/user/{name}', ...)->where('name', '[A-Za-z]+')`.
</details>

---

## Nên biết

* Luồng xử lý một Request cơ bản.
* Cách sử dụng CSRF protection.
* Cú pháp và cách hoạt động của Blade.

## Lưu ý

* Quên không return kết quả từ Controller (trang trắng).
* Viết quá nhiều logic nghiệp vụ (tính toán, query DB) ngay trong file Route.
* Sử dụng biến không tồn tại trong Blade dẫn đến lỗi crash trang.

## Mẹo và thủ thuật

* Dùng lệnh `php artisan route:list` thường xuyên để kiểm soát các đường dẫn của ứng dụng.
* Sử dụng directive `@auth` và `@guest` để hiện nội dung theo trạng thái đăng nhập một cách gọn gàng.
