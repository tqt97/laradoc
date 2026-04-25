---
title: State Pattern - Nghệ thuật quản lý trạng thái đối tượng
excerpt: Tìm hiểu State Pattern - giải pháp thay thế switch/case khổng lồ, cách quản lý vòng đời đối tượng (Order, Post, Task) một cách chuyên nghiệp trong PHP.
category: Design pattern
date: 2026-03-22
order: 15
image: /prezet/img/ogimages/series-design-pattern-state-pattern.webp
---

> Pattern thuộc nhóm **Behavioral Pattern (Hành vi)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang xây dựng tính năng quản lý bài viết. Một bài viết có các trạng thái: `Draft` (Nháp), `Moderation` (Chờ duyệt), `Published` (Đã đăng).

**Vấn đề:** Các hành động (Publish, Edit, Delete) sẽ có kết quả khác nhau tùy vào trạng thái hiện tại.

```php
class Post {
    private string $state;

    public function publish() {
        if ($this->state === 'draft') {
            $this->state = 'moderation';
        } elseif ($this->state === 'moderation') {
            $this->state = 'published';
        } elseif ($this->state === 'published') {
            // Không làm gì cả
        }
    }
    // Tương tự cho hàm edit(), delete()...
}
```

**Vấn đề thật sự:**

* **If-else Hell:** Khi số lượng trạng thái tăng lên (ví dụ: `Archived`, `Spam`), các hàm sẽ trở nên cực kỳ dài và khó kiểm soát.
* **Vi phạm SRP:** Class `Post` phải ôm đồm tất cả logic xử lý của mọi trạng thái.

## 2. Định nghĩa

**State Pattern** cho phép một đối tượng thay đổi hành vi của nó khi trạng thái nội bộ của nó thay đổi. Đối tượng sẽ trông như thể nó đã thay đổi class của mình.

**Ý tưởng cốt lõi:** Thay vì dùng biến string để lưu trạng thái, hãy dùng **một Object**. Mỗi trạng thái là một Class riêng biệt.

## 3. Implementation (PHP Clean Code)

### 3.1 State Interface

```php
interface PostState {
    public function publish(Post $post): void;
}
```

### 3.2 Concrete States

```php
class DraftState implements PostState {
    public function publish(Post $post): void {
        echo "Chuyển từ Nháp sang Chờ duyệt...\n";
        $post->transitionTo(new ModerationState());
    }
}

class PublishedState implements PostState {
    public function publish(Post $post): void {
        echo "Bài viết đã đăng rồi, không làm gì thêm.\n";
    }
}
```

### 3.3 Context (Đối tượng chính)

```php
class Post {
    public function __construct(protected PostState $state) {}

    public function transitionTo(PostState $state): void {
        $this->state = $state;
    }

    public function publish(): void {
        $this->state->publish($this);
    }
}

// Sử dụng
$post = new Post(new DraftState());
$post->publish(); // Output: Chuyển sang Chờ duyệt...
```

## 4. Liên hệ Laravel

Trong Laravel, State Pattern thường được áp dụng thủ công trong các hệ thống xử lý Workflow. Tuy nhiên, có những thư viện mạnh mẽ giúp bạn implement pattern này một cách "Laravel style":

**1. Spatie Laravel Model States:**
Thư viện cực hay giúp quản lý trạng thái của Eloquent Model ngay trong Database.

```php
// Post Model
protected $casts = [
    'state' => PostState::class,
];
```

**2. Laravel Workflow:**
Dùng cho các quy trình phức tạp, cần quản lý transition và history.

## 5. Khi nào nên dùng

* Khi đối tượng có hành vi thay đổi tùy theo trạng thái hiện tại.
* Khi bạn thấy mình đang viết quá nhiều câu lệnh `switch` hoặc `if/else` dựa trên một trường `status`.
* Khi các transition (chuyển đổi) giữa các trạng thái có logic phức tạp.

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Single Responsibility:** Chia nhỏ logic của từng trạng thái vào các class riêng.
* **Open/Closed:** Thêm trạng thái mới mà không ảnh hưởng đến code cũ.
* **Loại bỏ If-else:** Code trở nên cực kỳ trong sáng và dễ đọc.

**Nhược điểm:**

* **Overkill:** Nếu đối tượng chỉ có 2-3 trạng thái đơn giản, dùng pattern này sẽ khiến hệ thống trở nên cồng kềnh.

## 7. So sánh: State vs Strategy

| Đặc điểm | State | Strategy |
| :--- | :--- | :--- |
| **Mục tiêu** | Quản lý trạng thái nội bộ. | Thay đổi thuật toán xử lý. |
| **Giao tiếp** | Các trạng thái thường biết về nhau để chuyển đổi (transition). | Các chiến thuật thường độc lập và không biết về nhau. |
| **Cơ chế** | Tự động đổi trạng thái bên trong. | Thường do Client quyết định dùng loại nào. |

## 8. Câu hỏi phỏng vấn

1. **Làm thế nào để các State class biết về nhau mà không bị vòng lặp?** (Thường thông qua Context object hoặc sử dụng một State Factory/Registry).
2. **State Pattern có giúp bảo mật dữ liệu không?** (Có, bằng cách ngăn chặn các hành động không hợp lệ ở một trạng thái nhất định, ví dụ: không cho phép Edit khi bài viết đã Published).
3. **Tại sao nên lưu trạng thái vào database thay vì chỉ để trong memory?** (Để duy trì vòng đời của đối tượng qua nhiều request khác nhau của người dùng).

## Kết luận

State Pattern biến những khối code logic rối rắm thành một sơ đồ trạng thái (Finite State Machine) rõ ràng và khoa học. Hãy dùng nó để nâng tầm hệ thống quản lý quy trình (Workflow) của bạn.
