---
title: Repository Pattern - Lớp đệm dữ liệu thông minh
excerpt: Tìm hiểu Repository Pattern - cách tách biệt logic nghiệp vụ khỏi tầng truy xuất dữ liệu, giúp code Clean hơn và dễ dàng Unit Test trong Laravel.
category: Design pattern
date: 2026-03-18
order: 11
image: /prezet/img/ogimages/series-design-pattern-repository-pattern.webp
---

> Pattern thuộc nhóm **Enterprise Pattern (Mẫu ứng dụng doanh nghiệp)**

## 1. Problem & Motivation

Giả sử bạn đang viết logic xử lý người dùng trong `UserController`. Bạn viết trực tiếp các câu lệnh Eloquent:

```php
class UserController extends Controller {
    public function index() {
        $users = User::where('active', true)
                     ->orderBy('name')
                     ->get();
        return view('users.index', compact('users'));
    }
}
```

**Vấn đề:**

1. **Dễ trùng lặp code:** Nếu ở 5 chỗ khác cũng cần lấy "danh sách user đang hoạt động", bạn phải copy lại đoạn `where('active', true)` đó.
2. **Khó Unit Test:** Bạn không thể test logic của Controller mà không chạm vào Database thật.
3. **Phụ thuộc vào Eloquent:** Nếu sau này bạn muốn đổi sang một DB khác hoặc dùng thư viện khác không phải Eloquent, bạn phải sửa hàng trăm Controller.

## 2. Định nghĩa

**Repository Pattern** đóng vai trò là một lớp trung gian giữa tầng Business Logic (Controllers, Services) và tầng Data Access (Eloquent, Query Builder). Nó giống như một "kho chứa" đối tượng, nơi bạn yêu cầu dữ liệu mà không cần quan tâm dữ liệu đó được lấy từ đâu (MySQL, Redis, hay API).

**Ý tưởng cốt lõi:** Controller chỉ cần nói: "Hãy cho tôi danh sách User", còn việc truy vấn thế nào là việc của Repository.

## 3. Implementation (Laravel Style)

### 3.1 Bước 1: Định nghĩa Interface

```php
interface UserRepositoryInterface {
    public function getActiveUsers();
    public function findById($id);
}
```

### 3.2 Bước 2: Tạo Repository cụ thể (Eloquent)

```php
class EloquentUserRepository implements UserRepositoryInterface {
    public function getActiveUsers() {
        return User::where('active', true)->get();
    }

    public function findById($id) {
        return User::findOrFail($id);
    }
}
```

### 3.3 Bước 3: Đăng ký trong AppServiceProvider

```php
public function register() {
    $this->app->bind(UserRepositoryInterface::class, EloquentUserRepository::class);
}
```

### 3.4 Bước 4: Sử dụng trong Controller

```php
class UserController extends Controller {
    public function __construct(protected UserRepositoryInterface $userRepo) {}

    public function index() {
        $users = $this->userRepo->getActiveUsers();
        return view('users.index', compact('users'));
    }
}
```

## 4. Tại sao lại có tranh luận về Repository trong Laravel?

Nhiều người cho rằng Eloquent bản thân nó đã là một dạng "Active Record" kết hợp "Repository" rồi. Việc bọc thêm một lớp nữa đôi khi làm code trở nên cồng kềnh vô ích.

**Khi nào nên dùng Repository:**

* Hệ thống cực lớn, cần Unit Test 100%.
* Có kế hoạch thay đổi nguồn dữ liệu thường xuyên.
* Logic truy vấn quá phức tạp và cần được tái sử dụng nhiều nơi.

**Khi nào KHÔNG nên dùng:**

* Project nhỏ, CRUD đơn giản.
* Bạn thấy mình chỉ đang viết các hàm Repository kiểu `all()`, `find()`, `create()`... chỉ để gọi lại các hàm y hệt của Eloquent (đây là lãng phí code).

## 5. Tips & Best Practices

* **Đừng bọc tất cả:** Chỉ tạo Repository cho những Model có logic truy vấn phức tạp.
* **Sử dụng Eloquent Scope:** Trước khi nghĩ đến Repository, hãy thử dùng `scope` trong Model. Nó giải quyết được 80% vấn đề trùng lặp code truy vấn.
* **Kết hợp với Service Pattern:** Repository lo việc "lấy dữ liệu", Service lo việc "xử lý nghiệp vụ".

## 6. Câu hỏi phỏng vấn

1. **Lợi ích lớn nhất của Repository Pattern là gì?** (Khả năng Unit Test và tách biệt phụ thuộc - Decoupling).
2. **Sự khác biệt giữa Repository và Service?** (Repository tập trung vào dữ liệu - Data, Service tập trung vào nghiệp vụ - Business Logic).
3. **Tại sao nên bind Interface vào Service Container thay vì dùng class cụ thể?** (Để có thể hoán đổi implementation dễ dàng, ví dụ đổi từ MySQL sang MongoDB Repository mà không cần sửa Controller).

## Kết luận

Repository Pattern là một công cụ mạnh mẽ để làm sạch code, nhưng nó yêu cầu sự cân nhắc kỹ lưỡng. Đừng dùng nó chỉ vì "người ta nói thế". Hãy dùng nó khi bạn thực sự cảm thấy Controller của mình đang bị "vấy bẩn" bởi quá nhiều logic truy vấn Database.
