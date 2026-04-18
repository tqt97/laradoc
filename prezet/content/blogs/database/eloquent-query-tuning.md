---
title: "Tuning Eloquent: Giải pháp tối ưu Query hiệu năng cao"
excerpt: Cách phát hiện lỗi N+1, sử dụng Lazy Collections và tối ưu hóa bộ nhớ cho hệ thống Laravel dữ liệu lớn.
date: 2026-04-18
category: Database
image: /prezet/img/ogimages/blogs-database-eloquent-query-tuning.webp
tags: [database, eloquent, performance, tuning, sql]
---

## 1. N + 1 Problem
Đây là kẻ thù số 1. Eloquent tự động lazy loading quan hệ khi bạn truy cập `$user->posts` trong vòng lặp.
- **Giải pháp:** Luôn dùng `->with('posts')` (Eager Loading).
- **Phát hiện:** Dùng `Model::preventLazyLoading(! app()->isProduction())` trong `AppServiceProvider`.

## 2. Tối ưu bộ nhớ với Lazy Collections
Khi export 100k dòng, `get()` sẽ làm tràn RAM.
- **Giải pháp:** `User::cursor()` hoặc `User::lazy()`. Chúng dùng PHP Generators để load từng dòng một, cực kỳ tiết kiệm bộ nhớ.

## 3. Query Builder vs Eloquent
- **Query Builder (`DB::table`)**: Trả về `stdClass` hoặc mảng. Nhanh hơn, ít tốn RAM hơn. Dùng cho các báo cáo (Reporting) hoặc lấy data Read-only.
- **Eloquent**: Tiện dụng, mạnh mẽ, có Observers/Accessors. Dùng cho Business Logic nơi cần thao tác đối tượng.

## 4. Phỏng vấn
**Q: Làm sao để debug câu SQL thực sự đang chạy?**
**A:** `DB::enableQueryLog()` và `DB::getQueryLog()` hoặc dùng `->toSql()` kết hợp `->getBindings()`.
**Q: Khi nào đánh Index?**
**A:** Khi cột đó xuất hiện trong `WHERE`, `JOIN` hoặc `ORDER BY`. Index không phải là thuốc bổ, quá nhiều Index sẽ làm chậm quá trình `INSERT/UPDATE` (do DB phải update cây Index).
