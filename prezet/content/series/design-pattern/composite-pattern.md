---
title: Composite Pattern - Cấu trúc cây đồng nhất
excerpt: Tìm hiểu Composite Pattern - giải pháp xử lý cấu trúc phân cấp (Menu, Category, Filesystem), cách đối xử với nhóm đối tượng như một đối tượng đơn lẻ.
category: Design pattern
date: 2026-03-25
order: 18
image: /prezet/img/ogimages/series-design-pattern-composite-pattern.webp
---

> Pattern thuộc nhóm **Structural Pattern (Cấu trúc)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang xây dựng một hệ thống quản lý Menu đa cấp:

* Menu Item (Cấp thấp nhất, chỉ có link).
* Menu Group (Chứa nhiều Menu Item hoặc các Menu Group khác).

**Vấn đề:** Khi bạn muốn hiển thị (render) Menu, bạn phải kiểm tra:

```php
foreach ($menus as $item) {
    if ($item instanceof MenuGroup) {
        $item->renderHeader();
        foreach ($item->getItems() as $subItem) {
            $subItem->render();
        }
    } else {
        $item->render();
    }
}
```

**Vấn đề thật sự:**

* Code bị phụ thuộc vào class cụ thể (`instanceof`).
* Khi Menu có 3, 4 hoặc n cấp lồng nhau, các vòng lặp sẽ trở thành một thảm họa.
* Khó thêm các loại menu mới (ví dụ: `Separator`, `CustomHTML`).

## 2. Định nghĩa

**Composite Pattern** cho phép bạn nhóm các đối tượng tương tự nhau thành một cấu trúc cây để biểu diễn các phân cấp toàn bộ-thành phần (whole-part). Composite cho phép các client đối xử với các đối tượng cá riêng lẻ và các nhóm đối tượng một cách đồng nhất.

**Ý tưởng cốt lõi:** Cả "lá" (Leaf) và "cành" (Composite) đều phải implement cùng một Interface.

## 3. Implementation (PHP Clean Code)

### 3.1 Component Interface

```php
interface MenuComponent {
    public function render(): string;
}
```

### 3.2 Leaf (Lá - Đối tượng đơn lẻ)

```php
class MenuItem implements MenuComponent {
    public function __construct(protected string $name, protected string $url) {}

    public function render(): string {
        return "<li><a href='{$this->url}'>{$this->name}</a></li>";
    }
}
```

### 3.3 Composite (Cành - Nhóm đối tượng)

```php
class MenuGroup implements MenuComponent {
    protected array $components = [];

    public function __construct(protected string $title) {}

    public function add(MenuComponent $component) {
        $this->components[] = $component;
    }

    public function render(): string {
        $html = "<li><strong>{$this->title}</strong><ul>";
        foreach ($this->components as $component) {
            $html .= $component->render(); // Đệ quy ở đây!
        }
        $html .= "</ul></li>";
        return $html;
    }
}
```

### 3.4 Sử dụng

```php
$root = new MenuGroup("Main Menu");
$root->add(new MenuItem("Home", "/"));

$settings = new MenuGroup("Settings");
$settings->add(new MenuItem("Profile", "/profile"));
$settings->add(new MenuItem("Password", "/password"));

$root->add($settings); // Thêm một group vào group khác

echo $root->render(); // Client không cần biết đâu là đơn, đâu là nhóm
```

## 4. Liên hệ Laravel

Composite Pattern xuất hiện rất nhiều trong các thư viện UI và cấu trúc dữ liệu của Laravel:

**1. View Components / Blade:**
Một component Blade có thể chứa các component Blade khác bên trong. Khi bạn render component cha, nó tự động kích hoạt quá trình render các thành phần con.

**2. Validation Rules:**
Khi bạn dùng mảng các rule: `['required', 'string', 'max:255']`. Laravel đối xử với từng rule đơn lẻ hoặc một tập hợp rule lồng nhau một cách đồng nhất thông qua các class Validation.

**3. Filesystem:**
Duyệt thư mục và file. Cả Folder và File đều có thể có các phương thức chung như `getSize()`, `getPermissions()`, `delete()`.

## 5. Khi nào nên dùng

* Khi bạn cần biểu diễn cấu trúc phân cấp cây của các đối tượng.
* Khi bạn muốn Client có thể bỏ qua sự khác biệt giữa nhóm các đối tượng và các đối tượng đơn lẻ. Client sẽ coi tất cả đều là "Component".

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Tính đồng nhất:** Đơn giản hóa code của client.
* **Dễ mở rộng:** Thêm các loại Leaf hoặc Composite mới dễ dàng mà không cần sửa code cũ.
* **Tuân thủ SRP:** Tách biệt trách nhiệm quản lý cấu trúc cây khỏi logic nghiệp vụ của từng đối tượng.

**Nhược điểm:**

* **Thiết kế quá tổng quát:** Đôi khi khó có thể áp đặt các ràng buộc (ví dụ: chỉ cho phép Group A chứa Item B mà không chứa Item C) ngay từ mức Interface.

## 7. Câu hỏi phỏng vấn

1. **Tại sao đệ quy lại là chìa khóa của Composite Pattern?** (Vì nó cho phép một node duyệt qua tất cả các con của nó, và các con đó lại tiếp tục duyệt qua con của chúng cho đến khi chạm tới Node lá).
2. **Sự khác biệt giữa Composite và Decorator?** (Composite tập trung vào cấu trúc phân cấp toàn bộ-thành phần, Decorator tập trung vào việc thêm trách nhiệm/hành vi mà không làm thay đổi cấu trúc).
3. **Làm thế nào để quản lý việc thêm/xóa node con trong Composite một cách an toàn?** (Có hai cách: Định nghĩa hàm add/remove ngay ở Interface cha - tiện lợi nhưng kém an toàn; hoặc chỉ định nghĩa ở class Composite - an toàn nhưng client phải check kiểu dữ liệu).

## Kết luận

Composite Pattern là "chiếc đũa thần" giúp bạn xử lý những cấu trúc dữ liệu lồng nhau phức tạp một cách nhẹ nhàng. Hãy dùng nó để biến những hệ thống Menu, Danh mục hay Tổ chức phòng ban của bạn trở nên chuyên nghiệp và dễ bảo trì.
