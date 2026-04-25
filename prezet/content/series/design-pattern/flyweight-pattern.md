---
title: Flyweight Pattern - Tối ưu bộ nhớ cho hệ thống lớn
excerpt: Tìm hiểu Flyweight Pattern - bí quyết chia sẻ dữ liệu để xử lý hàng triệu đối tượng, giải mã cách Laravel tối ưu bộ nhớ thông qua cơ chế Caching.
category: Design pattern
date: 2026-04-04
order: 28
image: /prezet/img/ogimages/series-design-pattern-flyweight-pattern.webp
---

> Pattern thuộc nhóm **Structural Pattern (Cấu trúc)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang xây dựng một hệ thống hiển thị bản đồ với hàng triệu cái cây (`Tree`). Mỗi cái cây có:

* **Dữ liệu nặng:** Hình ảnh (mesh), texture, màu sắc (giống hệt nhau cho cùng một loại cây).
* **Dữ liệu nhẹ:** Tọa độ X, Y (khác nhau cho mỗi cây).

**Vấn đề:** Nếu bạn tạo ra 1 triệu đối tượng `new Tree()`, mỗi đối tượng đều chứa cả hình ảnh và tọa độ → App của bạn sẽ ngốn hàng chục GB RAM và "chết" ngay lập tức.

**Naive Solution:** Khởi tạo mọi thứ trong mỗi object.
**Hệ quả:** Memory Leak và hiệu năng cực thấp.

## 2. Định nghĩa

**Flyweight Pattern** giúp giảm bớt lượng bộ nhớ tiêu thụ bằng cách chia sẻ càng nhiều dữ liệu càng tốt với các đối tượng tương tự khác.

**Ý tưởng cốt lõi:** Tách đối tượng thành 2 phần:

1. **Intrinsic State (Trạng thái nội tại):** Dữ liệu chung, không thay đổi (ví dụ: Hình ảnh cái cây). Phần này sẽ được chia sẻ.
2. **Extrinsic State (Trạng thái ngoại lai):** Dữ liệu riêng biệt, thay đổi theo ngữ cảnh (ví dụ: Tọa độ cây). Phần này sẽ được truyền vào khi cần.

## 3. Implementation (PHP Clean Code)

### 3.1 Flyweight (Phần chia sẻ - Nặng)

```php
class TreeType {
    public function __construct(
        protected string $name,
        protected string $color,
        protected string $texture
    ) {}

    public function draw(int $x, int $y): void {
        echo "Vẽ cây {$this->name} màu {$this->color} tại tọa độ ($x, $y)\n";
    }
}
```

### 3.2 Flyweight Factory (Quản lý chia sẻ)

```php
class TreeFactory {
    private static array $treeTypes = [];

    public static function getTreeType(string $name, string $color, string $texture): TreeType {
        $key = md5($name . $color . $texture);
        if (!isset(self::$treeTypes[$key])) {
            self::$treeTypes[$key] = new TreeType($name, $color, $texture);
        }
        return self::$treeTypes[$key];
    }
}
```

### 3.3 Context (Phần riêng biệt - Nhẹ)

```php
class Tree {
    public function __construct(
        private int $x,
        private int $y,
        private TreeType $type // Tham chiếu đến phần chung
    ) {}

    public function draw(): void {
        $this->type->draw($this->x, $this->y);
    }
}
```

### 3.4 Sử dụng

```php
$forest = [];
$type = TreeFactory::getTreeType("Cổ thụ", "Xanh", "Sần sùi");

for ($i = 0; $i < 1000000; $i++) {
    // 1 triệu cây nhưng chỉ có DUY NHẤT 1 đối tượng TreeType trong RAM
    $forest[] = new Tree(rand(0, 100), rand(0, 100), $type);
}
```

## 4. Liên hệ Laravel

Flyweight Pattern xuất hiện trong Laravel dưới dạng các cơ chế **Caching** và **Shared Instances**:

**1. Service Container (Singletons):**
Khi bạn yêu cầu một service (ví dụ `db`, `config`) nhiều lần, Laravel trả về cùng một instance duy nhất. Đây là một dạng Flyweight giúp tiết kiệm bộ nhớ khởi tạo.

**2. Translation (Đa ngôn ngữ):**
Hệ thống `__('auth.failed')` của Laravel load các file ngôn ngữ vào bộ nhớ một lần duy nhất (Intrinsic State) và chia sẻ nó cho toàn bộ các request cần dịch chuỗi đó.

**3. Eloquent Metadata:**
Các thông tin về cấu trúc bảng (columns, types) được Eloquent cache lại và dùng chung cho tất cả các instance của Model đó.

## 5. Khi nào nên dùng

* Khi ứng dụng cần tạo ra một số lượng khổng lồ các đối tượng tương tự nhau.
* Khi chi phí lưu trữ đối tượng quá cao làm cạn kiệt bộ nhớ.
* Khi hầu hết trạng thái của đối tượng có thể tách rời thành phần chung.

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* Tiết kiệm RAM cực lớn.
* Tăng hiệu năng hệ thống khi xử lý dữ liệu quy mô lớn.

**Nhược điểm:**

* Code trở nên phức tạp hơn do phải tách biệt trạng thái và dùng Factory quản lý.
* Tốn thêm CPU để tính toán hoặc truyền trạng thái ngoại lai mỗi khi gọi hàm.

## 7. Câu hỏi phỏng vấn

1. **Tại sao không thể dùng Singleton thay cho Flyweight?** (Singleton đảm bảo 1 class chỉ có 1 instance. Flyweight cho phép nhiều instance khác nhau nhưng chia sẻ dữ liệu chung bên trong).
2. **Intrinsic State là gì?** (Là dữ liệu cố định, dùng chung giữa các đối tượng, ví dụ: định dạng, hình ảnh mẫu).
3. **Flyweight có giúp giảm thời gian chạy (Execution Time) không?** (Chủ yếu nó giúp giảm Memory. Thời gian chạy có thể tăng nhẹ do phải truyền tham số, nhưng tổng thể hệ thống sẽ mượt hơn vì không bị Swap RAM).

## Kết luận

Flyweight Pattern là bí quyết của những hệ thống "vô địch" về hiệu suất bộ nhớ. Hãy dùng nó khi bạn đang phải đối mặt với bài toán Big Data hoặc xử lý hàng triệu bản ghi trong một chu kỳ request.
