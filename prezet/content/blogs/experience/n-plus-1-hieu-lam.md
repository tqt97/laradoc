---
title: "N+1 Query: Những hiểu lầm tai hại và cách giải quyết triệt để"
excerpt: Phân tích lỗi N+1 Query trong Laravel Eloquent, tại sao Eager Loading đôi khi vẫn chậm và các kỹ thuật nâng cao để tối ưu hóa hiệu năng Database.
date: 2026-04-18
category: Kinh nghiệm
image: /prezet/img/ogimages/blogs-experience-n-plus-1-hieu-lam.webp
tags: [laravel, n+1-query, eloquent, database, performance, optimization]
---

Nếu bạn hỏi một lập trình viên Laravel về cách tối ưu performance, câu trả lời đầu tiên luôn là: "Dùng `with()` để tránh N+1". Tuy nhiên, N+1 Query có những biến thể "nguy hiểm" hơn bạn tưởng, và đôi khi `with()` lại chính là nguyên nhân làm hệ thống chậm đi.

## 1. N+1 Query là gì? (Nhắc lại nhanh)

Nó xảy ra khi bạn truy cập một quan hệ của Model bên trong một vòng lặp.

```php
$users = User::all(); // 1 Query lấy 100 users
foreach ($users as $user) {
    echo $user->profile->bio; // 100 Queries lấy profile
}
```

**Tổng cộng:** 1 + 100 = 101 Queries. Đây là thảm họa.

## 2. Hiểu lầm 1: Cứ dùng `with()` là sẽ nhanh

Giả sử bạn có 1 triệu bài viết và mỗi bài viết có hàng nghìn comment. Bạn chạy lệnh:
`$posts = Post::with('comments')->get();`

Laravel sẽ thực hiện:

1. `SELECT * FROM posts;`
2. `SELECT * FROM comments WHERE post_id IN (...);`

Lệnh số 2 sẽ nạp **hàng triệu comment** vào RAM của PHP. Kết quả là server của bạn sẽ bị lỗi **Out of Memory (OOM)** trước khi kịp hiển thị trang web.

*Giải pháp:* Sử dụng `withCount()` nếu chỉ cần số lượng, hoặc sử dụng **Lazy Eager Loading** có giới hạn.

## 3. Hiểu lầm 2: Query Builder không bị N+1

Nhiều người nghĩ N+1 chỉ là "đặc sản" của Eloquent. Thực tế, nếu bạn viết logic sai trong Query Builder, bạn vẫn gặp N+1 như thường:

```php
$users = DB::table('users')->get();
foreach ($users as $user) {
    $profile = DB::table('profiles')->where('user_id', $user->id)->first();
}
```

Bản chất của N+1 là **Tư duy lặp (Iterative Thinking)** thay vì **Tư duy tập hợp (Set-based Thinking)** của Database.

## 4. Kỹ thuật nâng cao: `preventLazyLoading()`

Để không bao giờ để lọt lỗi N+1 lên Production, hãy thêm dòng này vào `AppServiceProvider`:

```php
public function boot()
{
    Model::preventLazyLoading(! app()->isProduction());
}
```

Trong môi trường Dev, Laravel sẽ **ném ra Exception** ngay lập tức nếu bạn quên không dùng `with()`. Đây là cách tốt nhất để rèn luyện kỷ luật viết code.

## 5. Quizz cho phỏng vấn Senior

**Câu hỏi:** Làm thế nào để giải quyết N+1 khi bạn cần lấy "Bài viết mới nhất" của mỗi User trong danh sách 1000 người? (Lưu ý: `with('latestPost')` vẫn sẽ nạp rất nhiều dữ liệu không cần thiết).

**Trả lời:**
Sử dụng kỹ thuật **Subquery Select**. Thay vì Join hay Eager Loading thông thường, chúng ta nhúng một câu query con vào lệnh SELECT chính.

```php
User::addSelect(['latest_post_title' => Post::select('title')
    ->whereColumn('user_id', 'users.id')
    ->latest()
    ->take(1)
])->get();
```

Cách này chỉ tốn **DUY NHẤT 1 câu query SQL**, và dữ liệu trả về cực kỳ gọn nhẹ (chỉ gồm thông tin User và 1 cột tiêu đề bài viết). Đây là đỉnh cao của tối ưu hóa Eloquent.

## 6. Kết luận

Đừng coi `with()` là liều thuốc vạn năng. Hãy hiểu bản chất của câu lệnh SQL mà Laravel sinh ra (dùng `toSql()` hoặc Debugbar) để đưa ra chiến lược nạp dữ liệu phù hợp nhất với quy mô dữ liệu của bạn.
