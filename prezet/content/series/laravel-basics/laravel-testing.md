---
title: "Testing trong Laravel – Unit, Feature và chiến lược test production"
excerpt: Tìm hiểu testing trong Laravel từ cơ bản đến nâng cao, unit test, feature test, mock, fake và cách xây dựng chiến lược test hiệu quả.
date: 2026-04-19
category: Laravel
image: /prezet/img/ogimages/blogs-laravel-testing.webp
tags: [laravel, testing, unit test, feature test, tdd]
order: 12
---

Rất nhiều developer:

* Không viết test
* Hoặc viết test cho có

Nhưng trong production:

> Không có test = hệ thống không an toàn

## Testing là gì?

> Là quá trình kiểm tra code hoạt động đúng như mong đợi

Mục tiêu:

* Tránh bug
* Đảm bảo chất lượng
* Refactor an toàn

## Các loại test trong Laravel

### Unit Test

> Test một class/function riêng lẻ

```php
public function test_add()
{
    $this->assertEquals(2, 1 + 1);
}
```

Nhanh, không phụ thuộc DB

### Feature Test

> Test flow của hệ thống

```php
$response = $this->get('/login');
$response->assertStatus(200);
```

Test gần với thực tế

### Integration Test

> Test nhiều component cùng nhau

Ví dụ: controller + service + DB

## Database Testing

Laravel hỗ trợ:

```php
use RefreshDatabase;
```

Reset DB mỗi test

## Mock & Fake

### Mock

```php
$this->mock(UserService::class, function ($mock) {
    $mock->shouldReceive('create')->once();
});
```

Giả lập dependency

### Fake

```php
Mail::fake();
Queue::fake();
```

Không thực thi thật

## HTTP Testing

```php
$this->post('/login', [
    'email' => 'test@example.com'
]);
```

Test API / form

## Real Case Production

**Case: Register User**

* Validate input
* Create user
* Send email

Test full flow bằng feature test

**Case: Service logic**

Test bằng unit test

## Test Strategy

* Unit test cho logic
* Feature test cho flow
* Không cần test mọi thứ

Focus vào:

* Business logic
* Critical path

## Anti-pattern

* **Không viết test**: Rất nguy hiểm

* **Test quá nhiều UI**: Chậm, không cần thiết

* **Test phụ thuộc môi trường**: Không ổn định

## Performance Tips

* Dùng SQLite in-memory
* Tách test nhanh/chậm

## Mindset

Junior:

> Test để pass CI

Senior:

> Test để bảo vệ hệ thống và refactor an toàn

## Câu hỏi thường gặp (Interview)

<details open>
<summary>1. Unit test là gì?</summary>

Test một đơn vị code nhỏ, không phụ thuộc bên ngoài

</details>

<details open>
<summary>2. Feature test là gì?</summary>

Test flow của hệ thống từ request đến response

</details>

<details open>
<summary>3. Khi nào dùng mock?</summary>

Khi cần giả lập dependency

</details>

<details open>
<summary>4. Fake trong Laravel là gì?</summary>

Là cách giả lập service như Mail, Queue mà không chạy thật

</details>

<details open>
<summary>5. Có cần test 100% coverage không?</summary>

Không, chỉ cần test phần quan trọng

</details>

## Kết luận

Testing không phải optional.

> Nó là bắt buộc nếu bạn muốn build hệ thống lớn.

Test tốt giúp:

* Tự tin deploy
* Giảm bug
* Dễ refactor
