---
title: KISS Principle - Đơn giản hóa thiết kế và code (Tránh over-engineering)
excerpt: "Hiểu sâu KISS (Simplicity): cách chọn giải pháp đơn giản nhất, tránh over-engineering, áp dụng thực tế với PHP thuần và Laravel."
tags: [KISS, simplicity, over-engineering, maintainability]
date: 2025-10-07
order: 7
image: /prezet/img/ogimages/series-clean-code-principles-core-kiss-simplicity.webp
---

> Đơn giản” không phải là ít code nhất, mà là **ít khái niệm nhất để hiểu và vận hành**.

* Ít layer hơn
* Ít abstraction hơn
* Ít trạng thái hơn

**Simplicity = giảm số thứ phải nghĩ cùng lúc (cognitive surface area)**

## 2. Anti-pattern: Over-Engineering

### ❌ PHP thuần - Ví dụ tệ

```php
// Một hệ thống “framework con” chỉ để check permission đơn giản
interface AccessStrategy {
    public function evaluate(array $context): string; // permit/deny
}

class ContextBuilder {
    public function build(array $user, array $resource, string $action): array {
        return [
            'subject' => $user,
            'resource' => $resource,
            'action' => $action,
            'env' => ['time' => time()]
        ];
    }
}

class AccessManager {
    private array $strategies = [];

    public function addStrategy(AccessStrategy $s): void {
        $this->strategies[] = $s;
    }

    public function check(array $context): bool {
        foreach ($this->strategies as $s) {
            if ($s->evaluate($context) === 'permit') {
                return true;
            }
        }
        return false;
    }
}
```

👉 200+ dòng chỉ để làm việc rất đơn giản: “user có quyền không?”

## 3. Refactor theo KISS (PHP thuần)

### ✅ Giải pháp đơn giản

```php
function canUserAccessDocument(array $user, array $document, string $action): bool
{
    // Admin toàn quyền
    if ($user['role'] === 'admin') {
        return true;
    }

    // Owner toàn quyền
    if ($document['owner_id'] === $user['id']) {
        return true;
    }

    // Tìm permission
    foreach ($document['permissions'] as $permission) {
        if ($permission['user_id'] === $user['id']) {
            return hasRequiredLevel($permission['level'], $action);
        }
    }

    return false;
}

function hasRequiredLevel(string $level, string $action): bool
{
    $hierarchy = ['read', 'write', 'admin'];

    $required = [
        'read' => 'read',
        'write' => 'write',
        'delete' => 'admin'
    ][$action] ?? 'admin';

    return array_search($level, $hierarchy) >= array_search($required, $hierarchy);
}
```

### ✅ Ưu điểm

* Đọc 10s là hiểu
* Không abstraction dư thừa
* Debug cực dễ

## 4. Nguyên lý phía sau (Deep Theory)

### 4.1 YAGNI (You Aren’t Gonna Need It)

> Đừng build thứ bạn *có thể* cần

Chỉ build thứ bạn **đang cần**

### 4.2 Occam’s Razor

> Giải pháp đơn giản nhất thường là đúng nhất

### 4.3 Essential vs Accidental Complexity

* Essential: bắt buộc (business rule)
* Accidental: do dev tạo ra (framework thừa, abstraction thừa)

👉 KISS = giảm **accidental complexity**

## 5. Quy tắc thực chiến

### Rule 1: Tránh abstraction sớm

❌

```php
interface Repository {}
interface Service {}
interface Manager {}
```

👉 Khi chưa có nhu cầu

### Rule 2: Inline trước, extract sau

```php
// Bắt đầu đơn giản
function calculateTotal($items) {}

// Khi phức tạp mới tách
```

### Rule 3: Không tạo framework nội bộ khi chưa cần

👉 Sai lầm phổ biến:

* Tự build mini-Laravel
* Tự build permission engine

### Rule 4: Prefer function > class (khi đơn giản)

```php
// ❌
class SumCalculator { public function calc($a, $b) {} }

// ✅
function sum($a, $b) { return $a + $b; }
```

### Rule 5: Add complexity khi có “signal thật”

Signal thật:

* Logic lặp lại nhiều lần
* Requirement thay đổi
* Code bắt đầu khó maintain

## 6. Mapping sang Laravel

### 6.1 Đừng over-layer

❌

```php
Controller -> Service -> Manager -> Handler -> Processor -> Repository
```

👉 Không cần thiết

### 6.2 Flow đơn giản (chuẩn)

```php
Controller -> Service -> Repository
```

### 6.3 Policy đơn giản cho authorization

```php
class DocumentPolicy
{
    public function view(User $user, Document $doc): bool
    {
        if ($user->isAdmin()) return true;
        if ($doc->owner_id === $user->id) return true;

        return $doc->permissions()
            ->where('user_id', $user->id)
            ->exists();
    }
}
```

👉 Không cần build permission engine phức tạp

### 6.4 Service rõ ràng

```php
class OrderService
{
    public function create(array $data): Order
    {
        $total = $this->calculateTotal($data['items']);

        return Order::create([
            'total' => $total
        ]);
    }
}
```

👉 Không cần abstraction thừa

## 7. Khi nào nên “phức tạp hóa”?

### ✅ Khi scale thực sự

* Multi-tenant
* Multi-role phức tạp
* Rule dynamic

### ✅ Khi có nhiều biến thể

* Strategy pattern
* Policy engine

### ❌ Không phải vì “clean”

👉 Clean ≠ complex

## 8. Pitfalls thực tế

### ❌ Over-abstract

* Interface everywhere
* Generic everything

### ❌ Premature optimization

* Optimize khi chưa cần

### ❌ Framework mindset

* Nghĩ mọi thứ phải “enterprise-ready” từ đầu

## 9. Interview Questions

<details>
  <summary>KISS khác gì YAGNI?</summary>

**Summary:**

* KISS → đơn giản hóa giải pháp
* YAGNI → không build cái chưa cần

**Deep:**

* YAGNI giúp giữ KISS
* Nếu vi phạm YAGNI → mất KISS

</details>

<details>
  <summary>Khi nào nên refactor từ simple → complex?</summary>

**Summary:**

* Khi requirement tăng

**Deep:**

* Có nhiều case variation
* Logic bắt đầu duplicate
* Code khó maintain

</details>

<details>
  <summary>Tại sao over-engineering nguy hiểm?</summary>

**Summary:**

* Tăng complexity

**Deep:**

* Dev mới không hiểu
* Debug khó
* Tốn thời gian build

</details>

## 10. Kết luận

> Simplicity không phải là “ít code”

> Mà là **ít thứ phải hiểu nhất**

KISS giúp:

* Ship nhanh
* Ít bug
* Maintain dễ
