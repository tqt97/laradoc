---
title: Middleware Deep Dive trong Laravel – Kiểm soát Request/Response như một Senior
excerpt: Phân tích sâu Middleware trong Laravel, pipeline pattern, before/after, global vs route và cách áp dụng trong production.
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/series-laravel-basics-laravel-middleware-deep-dive.webp
tags: [laravel, middleware, pipeline, architecture, http]
order: 9
---

Trong thực tế, bạn thường cần:

* Kiểm tra authentication
* Log request/response
* Rate limiting
* Transform dữ liệu trước/sau controller

Nếu nhét tất cả vào controller:

Code sẽ rối, khó tái sử dụng và khó kiểm soát.

## Middleware là gì?

> Middleware là lớp trung gian xử lý request/response trước và sau khi vào controller.

Hiểu đơn giản:

```txt
Request → Middleware → Controller → Middleware → Response
```

## Pipeline Pattern (cốt lõi)

Laravel triển khai middleware theo **pipeline pattern**:

```txt
Request → M1 → M2 → M3 → Controller → M3 → M2 → M1 → Response
```

Đi vào theo thứ tự, đi ra theo thứ tự ngược lại.

## Before & After Middleware

```php
public function handle($request, Closure $next)
{
    // BEFORE

    $response = $next($request);

    // AFTER

    return $response;
}
```

* BEFORE: validate, auth, transform request
* AFTER: add header, log, transform response

## Global vs Route Middleware

### Global

Áp dụng cho mọi request

```php
// app/Http/Kernel.php
protected $middleware = [
    \App\Http\Middleware\TrustProxies::class,
];
```

### Route

Áp dụng theo route/group

```php
Route::middleware(['auth'])->group(function () {
    Route::get('/dashboard', ...);
});
```

Rule:

* Global → cross-cutting (security, proxies)
* Route → theo use case (auth, role)

## Thứ tự Middleware (rất quan trọng)

```php
protected $middlewarePriority = [
    \Illuminate\Session\Middleware\StartSession::class,
];
```

Sai thứ tự → bug khó debug.

## Parameterized Middleware

```php
Route::middleware('role:admin')->get('/admin', ...);
```

```php
public function handle($request, Closure $next, $role)
```

Dùng để truyền config động.

## Real Case Production

* **Authentication**

```php
if (!auth()->check()) {
    return redirect('/login');
}
```

* **Logging**

```php
Log::info($request->path());
```

* **Rate Limiting**

* Chống spam API
* Bảo vệ hệ thống

* **Multi-tenant**

* Xác định tenant theo domain/header
* Bind tenant vào container

## Kết hợp với Service Container

Bạn có thể inject dependency:

```php
public function __construct(Logger $logger)
```

Middleware vẫn được resolve qua container.

## Anti-pattern

* **Business logic trong middleware**: Middleware chỉ nên xử lý cross-cutting concern

* **Middleware quá nhiều tầng**: Tăng latency, khó debug

* **Không kiểm soát thứ tự**: Gây lỗi logic (session, auth)

## Performance Tips

* Giữ middleware nhẹ
* Tránh I/O nặng trong middleware
* Cache nếu cần (ví dụ config/feature flag)

## Mindset Senior

Junior:

> Middleware để check auth

Senior:

> Middleware là pipeline kiểm soát toàn bộ flow request/response

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. Middleware là gì?</summary>

Lớp trung gian xử lý request/response trước và sau controller

</details>

<details open>
<summary>2. Pipeline pattern là gì trong Laravel?</summary>

Là cách các middleware được xâu chuỗi xử lý request theo thứ tự và trả về theo thứ tự ngược

</details>

<details open>
<summary>3. Global vs Route middleware khác nhau như thế nào?</summary>

Global áp dụng cho toàn app, Route áp dụng theo endpoint/group

</details>

<details open>
<summary>4. Before và After middleware là gì?</summary>

Before chạy trước controller, After chạy sau controller

</details>

<details open>
<summary>5. Khi nào không nên dùng middleware?</summary>

Khi logic thuộc business domain hoặc cần xử lý sâu trong service

</details>

## Kết luận

Middleware là công cụ mạnh để:

* Kiểm soát flow
* Tách cross-cutting concerns
* Xây dựng hệ thống rõ ràng, dễ mở rộng

Hiểu middleware = hiểu cách Laravel xử lý request.
