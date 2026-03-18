---
title: Các Case Refactor Long Method và Cách Xử Lý Hiệu Quả
excerpt: Trong quá trình phát triển phần mềm, Long Method (hàm quá dài) là một trong những “code smell” phổ biến nhất. Khi một method trở nên quá dài, nó không chỉ khó đọc mà còn rất khó bảo trì, test và mở rộng.
category: Refactoring
date: 2026-03-08
order: 4
image: /prezet/img/ogimages/series-refactoring-refactor-long-method.webp
---

## Mô tả

Trong quá trình phát triển phần mềm, **Long Method (hàm quá dài)** là một trong những “code smell” phổ biến nhất. Khi một method trở nên quá dài, nó không chỉ khó đọc mà còn rất khó bảo trì, test và mở rộng.

Bài này sẽ đi sâu vào **các tình huống thực tế (case)** khi gặp Long Method và cách xử lý chúng bằng các kỹ thuật refactoring kinh điển như:

* Extract Method
* Replace Temp with Query
* Introduce Parameter Object
* Replace Method with Method Object
* Decompose Conditional

Mục tiêu là giúp bạn **biến code dài, rối → thành code rõ ràng, có cấu trúc, dễ maintain**.

## 1. Extract Method (Tách Method)

**🚨 Problem**

Bạn có một đoạn code trong method có thể **gom nhóm lại thành một chức năng riêng**.

```php
function printOwing() {
  $this->printBanner();

  // Print details.
  print("name:  " . $this->name);
  print("amount " . $this->getOutstanding());
}
```

**✅ Solution**

Tách đoạn code đó thành một method riêng.

```php
function printOwing() {
  $this->printBanner();
  $this->printDetails($this->getOutstanding());
}

function printDetails($outstanding) {
  print("name:  " . $this->name);
  print("amount " . $outstanding);
}
```

**🎯 Insight**

* Mỗi method chỉ nên làm **1 việc**
* Tên method giúp code **tự mô tả (self-documenting)**

## 2. Giảm biến tạm và parameter trước khi Extract

**🚨 Problem**

Biến local hoặc parameter làm bạn **khó tách method**

### Cách 1: Replace Temp with Query

**❌ Trước**

```php
$basePrice = $this->quantity * $this->itemPrice;

if ($basePrice > 1000) {
  return $basePrice * 0.95;
}
```

**✅ Sau**

```php
if ($this->basePrice() > 1000) {
  return $this->basePrice() * 0.95;
}

function basePrice() {
  return $this->quantity * $this->itemPrice;
}
```

👉 Không dùng biến tạm → gọi method trực tiếp

### Cách 2: Introduce Parameter Object

**🚨 Problem**

Method có nhiều parameter lặp lại

```php
function createOrder($name, $price, $quantity, $address) {}
```

**✅ Solution**

```php
class OrderData {
  public $name;
  public $price;
  public $quantity;
  public $address;
}
```

👉 Gom lại thành object → code sạch hơn, dễ mở rộng

### Cách 3: Preserve Whole Object

**❌ Trước**

```php
$low = $range->getLow();
$high = $range->getHigh();

$plan->withinRange($low, $high);
```

**✅ Sau**

```php
$plan->withinRange($range);
```

👉 Tránh “bóc tách object” → giữ nguyên object để truyền

## 3. Replace Method with Method Object

**🚨 Problem**

Method quá dài + biến local phụ thuộc chặt chẽ → không thể Extract Method

```php
class Order {
  public function price() {
    $primaryBasePrice = 10;
    $secondaryBasePrice = 20;
    // logic rất dài...
  }
}
```

**✅ Solution**

Chuyển method thành **một class riêng**

```php
class Order {
  public function price() {
    return (new PriceCalculator($this))->compute();
  }
}

class PriceCalculator {
  private $primaryBasePrice;

  public function __construct(Order $order) {
    // lấy dữ liệu từ order
  }

  public function compute() {
    // xử lý logic
  }
}
```

**🎯 Insight**

* Biến local → trở thành **field của class**
* Dễ chia nhỏ method hơn
* Áp dụng rất nhiều trong **Service Layer / Clean Architecture**

## 4. Xử lý Conditionals và Loops

**🚨 Problem**

* if/else phức tạp
* loop dài và khó đọc

### Cách 1: Decompose Conditional

**❌ Trước**

```php
if ($date->before(SUMMER_START) || $date->after(SUMMER_END)) {
  $charge = $quantity * $winterRate + $winterServiceCharge;
}
```

**✅ Sau**

```php
if (isSummer($date)) {
  $charge = summerCharge($quantity);
} else {
  $charge = winterCharge($quantity);
}
```

👉 Tách condition và từng nhánh xử lý

### Cách 2: Extract Method với Loop

**❌ Trước**

```php
for ($i = 0; $i < $users->size(); $i++) {
  $result = "";
  $result .= $users->get($i)->getName();
  $result .= " ";
  $result .= $users->get($i)->getAge();
}
```

**✅ Sau**

```php
foreach ($users as $user) {
  echo $this->getProperties($user);
}

function getProperties($user) {
  return $user->getName() . " " . $user->getAge();
}
```

👉 Loop chỉ giữ orchestration, logic tách riêng

## Payoff (Lợi ích)

* Code **ngắn hơn → dễ đọc hơn**
* Dễ **test từng phần**
* Giảm duplicate code
* Dễ mở rộng và maintain

👉 Rule quan trọng:

> “Classes with short methods live longest”

## Performance có bị ảnh hưởng không?

👉 Câu trả lời: **Gần như KHÔNG đáng kể**

* Overhead của việc gọi method là rất nhỏ
* Đổi lại bạn có code rõ ràng hơn và dễ optimize hơn khi cần

## Tổng kết tư duy

Khi thấy một method dài, hãy tự hỏi:

* Có đoạn nào có thể **đặt tên được không?** → Extract Method
* Có biến tạm nào dư thừa không? → Replace Temp
* Parameter có quá nhiều không? → Object hóa
* Logic có quá phức tạp không? → Tách class

👉 Refactor không phải để “đẹp”, mà để:

> **Giảm chi phí thay đổi trong tương lai**
