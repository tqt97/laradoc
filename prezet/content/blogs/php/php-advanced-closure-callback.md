---
title: "PHP Advanced: Closure và Callback chuyên sâu"
excerpt: Hiểu sâu về cách Closure capture biến qua `use`, cách callback được thực thi trong Zend Engine và ứng dụng trong các framework hiện đại.
date: 2026-04-18
category: PHP
image: /prezet/img/ogimages/blogs-php-php-advanced-closure-callback.webp
tags: [php, closure, callback, internals, functional-programming]
---

## 1. Closure & Scope Binding

Trong PHP, Closure là một anonymous function có khả năng capture biến từ scope cha qua từ khóa `use`.

```php
$tax = 0.1;
$applyTax = function($price) use ($tax) {
    return $price * (1 + $tax);
};
```

## 2. Bản chất Closure

Bên dưới, mỗi Closure thực chất là một instance của class `Closure`. Khi bạn định nghĩa Closure, PHP tạo ra một object có chứa "state" (các biến đã capture). Đó là lý do bạn có thể `bindTo` (đổi scope) cho Closure để truy cập private properties của một class khác.

## 3. Callback trong Framework

Laravel dùng `callable` type-hinting ở khắp nơi (ví dụ: trong Event Listeners). Việc sử dụng `[ $this, 'methodName' ]` là một kiểu callback đặc biệt giúp Framework gọi đúng method mong muốn mà không cần biết class cụ thể.
