---
title: API Design & Best Practices trong Laravel – Thiết kế chuẩn RESTful & scalable
excerpt: Hướng dẫn thiết kế API trong Laravel theo chuẩn RESTful, versioning, pagination, error handling và best practices trong production.
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/series-laravel-basics-laravel-api.webp
tags: [laravel, api, rest, design, backend]
order: 13
---

API là xương sống của hầu hết hệ thống hiện đại.

Nhưng rất nhiều developer:

* Thiết kế API không nhất quán
* Trả response lộn xộn
* Không chuẩn HTTP

Kết quả: khó maintain, khó scale.

## API Design là gì?

> Là cách bạn thiết kế endpoint, request và response của hệ thống.

Mục tiêu:

* Dễ hiểu
* Dễ sử dụng
* Dễ mở rộng

## RESTful API là gì?

REST (Representational State Transfer) là chuẩn phổ biến nhất.

### Ví dụ chuẩn REST

| Method | Endpoint    | Ý nghĩa       |
| ------ | ----------- | ------------- |
| GET    | /users      | Lấy danh sách |
| GET    | /users/{id} | Lấy chi tiết  |
| POST   | /users      | Tạo mới       |
| PUT    | /users/{id} | Update        |
| DELETE | /users/{id} | Xóa           |

Rule:

* Dùng đúng HTTP method
* Endpoint là resource, không phải action

## Naming Convention

❌ Sai

```txt
/getUsers
/createUser
```

✅ Đúng

```txt
/users
```

HTTP method đã thể hiện action.

## Response Format (rất quan trọng)

### Ví dụ chuẩn

```json
{
  "data": {...},
  "message": "success",
  "errors": null
}
```

Consistent là chìa khóa.

## HTTP Status Code

| Code | Ý nghĩa      |
| ---- | ------------ |
| 200  | OK           |
| 201  | Created      |
| 400  | Bad Request  |
| 401  | Unauthorized |
| 403  | Forbidden    |
| 404  | Not Found    |
| 500  | Server Error |

Không nên luôn trả 200 ❌

## Pagination

```php
User::paginate(10);
```

Response:

```json
{
  "data": [...],
  "meta": {
    "page": 1
  }
}
```

Tránh load toàn bộ data.

## Filtering & Sorting

```php
/users?status=active&sort=created_at
```

Giúp API linh hoạt.

## API Versioning

### Cách phổ biến

```txt
/api/v1/users
/api/v2/users
```

Tránh breaking change.

## Error Handling

### Ví dụ

```json
{
  "message": "Validation failed",
  "errors": {
    "email": ["Email is required"]
  }
}
```

Rõ ràng, dễ debug.

## Authentication cho API

* Token-based (Sanctum)
* Bearer token

## Real Case Production

### Case: Mobile App

* API phải stable
* Response consistent

### Case: Microservices

* Versioning bắt buộc
* Error rõ ràng

## Anti-pattern

* **Endpoint không nhất quán**: Khó maintain

* **Không dùng status code đúng**: Khó debug

* **Response lộn xộn**: Frontend khó xử lý

## Performance Tips

* Pagination
* Cache API
* Giảm payload

## Mindset Senior

Junior:

> API trả data là được

Senior:

> API phải ổn định, rõ ràng và dễ scale

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. RESTful API là gì?</summary>

Là chuẩn thiết kế API dựa trên resource và HTTP method

</details>

<details open>
<summary>2. Tại sao cần versioning API?</summary>

Tránh breaking change khi update hệ thống

</details>

<details open>
<summary>3. HTTP status code quan trọng như thế nào?</summary>

Giúp client hiểu kết quả request

</details>

<details open>
<summary>4. Pagination là gì?</summary>

Chia nhỏ dữ liệu để tránh load quá nhiều

</details>

<details open>
<summary>5. API nên trả response như thế nào?</summary>

Consistent, rõ ràng, có data + message + error

</details>

## Kết luận

API design tốt giúp:

* Frontend dễ làm việc
* Hệ thống dễ scale
* Dễ maintain lâu dài

Đây là kỹ năng bắt buộc của backend developer.
