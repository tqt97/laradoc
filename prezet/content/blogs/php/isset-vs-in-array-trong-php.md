---
title: isset() vs in_array() trong PHP
excerpt: Bài viết này giải thích sâu về bản chất của `isset()` và `in_array()` trong PHP
date: 2026-03-05
category: PHP
image: /prezet/img/ogimages/blogs-php-isset-vs-in-array-trong-php.webp
tags: [php]
---

Bài viết này giải thích **sâu về bản chất của `isset()` và `in_array()` trong PHP**, bao gồm:

* Bản chất thực sự của từng hàm
* Cách PHP lưu trữ array (HashTable internals)
* Performance (Big‑O)
* Các bug nghiêm trọng từng xảy ra trong production
* Benchmark so sánh
* Case study từ code của Laravel
* Checklist chuẩn khi lookup dữ liệu trong array

Mục tiêu: giúp bạn **hiểu đúng bản chất thay vì chỉ nhớ syntax**.

## 1. Khác biệt cốt lõi

| Hàm                  | Kiểm tra | Ý nghĩa                            |
| -- | -- | - |
| `isset()`            | key      | key tồn tại và value != null       |
| `array_key_exists()` | key      | key tồn tại kể cả khi value = null |
| `in_array()`         | value    | value có nằm trong array hay không |

Ví dụ:

```php
$arr = [
    'name' => 'Tuan',
    'age' => 25
];

isset($arr['name']); // true
in_array('Tuan', $arr); // true
```

Nhìn qua có vẻ giống nhau nhưng **bản chất hoàn toàn khác**.

## 2. Bản chất của PHP Array

Một điều rất quan trọng:

**PHP array thực chất là một HashTable.**

Không phải list đơn giản như nhiều người nghĩ.

#### HashTable lookup

```
key -> hash(key) -> bucket -> value
```

Diagram đơn giản:

```
Array

        ┌──────────────┐
key     │  HashTable   │
"name" ──hash()──────► bucket 1 ──► "Tuan"
"age"  ──hash()──────► bucket 7 ──► 25
"role" ──hash()──────► bucket 3 ──► "admin"
        └──────────────┘
```

Điều này có nghĩa:

**Lookup theo key là O(1)**.

Vì PHP chỉ cần:

```
hash(key) -> tìm bucket
```

## 3. Bản chất `isset()`

Khi chạy:

```php
isset($arr['name']);
```

PHP thực hiện:

```
1 hash('name')
2 tìm bucket
3 kiểm tra value != null
```

Nếu tồn tại và khác null → true.

Ví dụ:

```php
$arr = ['name' => null];

isset($arr['name']); // false
```

Key tồn tại nhưng value = null → `false`.

Đây là lý do `isset()` cực nhanh.

```
Time complexity: O(1)
```

## 4. Bản chất `array_key_exists()`

`array_key_exists()` chỉ kiểm tra **key có tồn tại hay không**.

```php
$arr = ['name' => null];

array_key_exists('name', $arr); // true
```

Internal:

```
hash(key)
lookup bucket
```

Khác biệt duy nhất:

`array_key_exists()` **không kiểm tra null**.

## 5. Bản chất `in_array()`

`in_array()` không dùng hash lookup.

PHP phải **scan toàn bộ array**.

Internal logic gần giống:

```php
foreach ($array as $value) {
    if ($value == $search) {
        return true;
    }
}
```

Do đó:

```
Time complexity: O(n)
```

Array càng lớn → càng chậm.

## 6. Bug security nổi tiếng của `in_array`

Một bug cực nguy hiểm liên quan đến **type juggling**.

Ví dụ:

```php
in_array(0, ['apple','banana']);
```

Kết quả:

```
true
```

Vì PHP convert kiểu:

```
"apple" -> 0
```

So sánh:

```
0 == "apple"
```

→ true.

Bug này từng gây lỗi trong:

* authentication
* permission check
* token validation

Ví dụ security bug:

```php
$allowed = ['admin','editor'];

if (in_array($_GET['role'], $allowed)) {
    allowAccess();
}
```

Nếu attacker gửi:

```
role=0
```

Có thể bypass logic.

## 7. Strict Mode trong `in_array()` là gì

Cú pháp đầy đủ của `in_array()`:

```php
in_array(mixed $needle, array $haystack, bool $strict = false): bool
```

Tham số thứ ba `$strict` quyết định **cách PHP so sánh giá trị**.

| Mode                     | Kiểu so sánh              |
|  | - |
| strict = false (default) | `==` (loose comparison)   |
| strict = true            | `===` (strict comparison) |

### Loose comparison (==)

Khi `strict = false`, PHP sẽ **ép kiểu (type juggling)** trước khi so sánh.

Ví dụ:

```php
in_array(1, ['1','2','3']);
```

PHP thực hiện:

```
1 == "1"
```

Kết quả:

```
true
```

Một số case nguy hiểm:

```php
in_array(0, ['apple']);
```

PHP convert:

```
"apple" -> 0
```

So sánh:

```
0 == 0
```

→ true.

### Strict comparison (===)

Khi bật strict mode:

```php
in_array(1, ['1','2','3'], true);
```

PHP so sánh:

```
1 === "1"
```

Điều kiện strict:

```
value giống
AND
kiểu dữ liệu giống
```

Kết quả:

```
false
```

## 8. Internal Algorithm của `in_array()`

Bên trong Zend Engine, `in_array()` thực hiện **linear search**.

Pseudo algorithm:

```php
function in_array($needle, $array, $strict) {

    foreach ($array as $value) {

        if ($strict) {
            if ($value === $needle) {
                return true;
            }
        } else {
            if ($value == $needle) {
                return true;
            }
        }

    }

    return false;
}
```

Đây là **thuật toán tìm kiếm tuyến tính (Linear Search)**.

## 9. Độ phức tạp thuật toán

Giả sử array có `n` phần tử.

#### Best case

```
O(1)
```

Nếu phần tử cần tìm nằm ngay đầu array.

#### Worst case

```
O(n)
```

Nếu phần tử nằm cuối hoặc không tồn tại.

PHP phải duyệt toàn bộ array.

#### Average case

```
O(n/2)
≈ O(n)
```

Trung bình phải duyệt **một nửa array**.

## 10. So sánh với `isset()` về thuật toán

#### `isset()`

Lookup theo **hash key**.

```
hash(key) -> bucket
```

Độ phức tạp:

```
O(1)
```

#### `in_array()`

Linear search:

```
scan array
```

Độ phức tạp:

```
O(n)
```

## 11. Phân tích thời gian thực thi

Giả sử:

```
array size = 100000
lookup = 10000 lần
```

#### in_array

```
10000 * 100000 comparisons
= 1,000,000,000 comparisons
```

#### isset lookup table

```
10000 * O(1)
```

Chỉ cần:

```
hash + bucket lookup
```

## 12. Vì sao strict mode quan trọng

Nếu không bật strict mode:

PHP sẽ áp dụng **type juggling rules**.

Ví dụ nổi tiếng:

```php
in_array("0e123", ["0e456"]);
```

Trong PHP:

```
"0e123" == "0e456"
```

Vì cả hai đều convert thành:

```
0 * 10^123
0 * 10^456
```

→ đều bằng `0`.

Kết quả:

```
true
```

Bug này từng xuất hiện trong:

* token validation
* password hash compare
* API key compare

## 13. Rule production

Luôn viết:

```php
in_array($value, $array, true);
```

Không bao giờ viết:

```php
in_array($value, $array);
```

Trừ khi **bạn thực sự muốn loose comparison**.

## 14. Benchmark thực tế

Benchmark thực tế

Giả sử array 100k phần tử.

Test:

```php
isset($arr['target']);
array_key_exists('target', $arr);
in_array('target', $arr);
```

Kết quả benchmark phổ biến:

| Function         | Time      |
| - |  |
| isset            | ~0.002 ms |
| array_key_exists | ~0.005 ms |
| in_array         | ~3 ms     |

`in_array()` có thể chậm hơn **1000 lần**.

## 9. Optimization technique trong hệ thống lớn

Nếu bạn phải check value nhiều lần.

Thay vì:

```php
in_array($role, $roles);
```

Hãy convert thành lookup table.

```php
$roles = array_flip($roles);

isset($roles[$role]);
```

Array trước:

```
['admin','editor','user']
```

Sau khi flip:

```
[
 'admin' => 0,
 'editor' => 1,
 'user' => 2
]
```

Lookup trở thành:

```
O(1)
```

## 10. Case Study trong Laravel Core

Trong source Laravel bạn sẽ thấy rất nhiều:

```php
isset($array['key'])
```

Ví dụ pattern thường thấy:

```php
if (isset($attributes['class'])) {
    $attributes['class'] .= ' new-class';
}
```

Lý do Laravel chọn `isset()`:

1. Nhanh hơn `array_key_exists`
2. 99% trường hợp không cần detect null
3. Tránh overhead function call

Laravel tối ưu rất mạnh cho performance ở các path nóng.

## 11. PHP Array Lookup Patterns (Checklist)

#### 1. Kiểm tra key

```
isset($arr['key'])
```

Use when:

* value không phải null
* performance quan trọng

#### 2. Key có thể null

```
array_key_exists('key', $arr)
```

#### 3. Kiểm tra value

```
in_array($value, $array, true)
```

Luôn strict.

#### 4. Lookup value nhiều lần

```
$set = array_flip($array);

isset($set[$value]);
```

## 12. Mental Model dễ nhớ

```
isset()  -> key lookup (hash table)

in_array() -> value scan (loop)
```

## 13. Vì sao cần convert sang Lookup Table

Trong nhiều hệ thống thực tế, bạn sẽ phải **kiểm tra một value lặp lại rất nhiều lần**.

Ví dụ:

```php
$roles = ['admin','editor','user'];

foreach ($requests as $req) {
    if (in_array($req->role, $roles, true)) {
        // allow
    }
}
```

Nếu `$requests` có 10.000 phần tử thì:

```
in_array() sẽ chạy 10.000 lần
```

Mỗi lần lại phải **scan toàn bộ array roles**.

Chi phí thực tế:

```
O(n * m)
```

Trong đó:

```
n = số lần lookup
m = size array
```

Khi hệ thống lớn, điều này trở thành **performance bottleneck**.

## 14. Lookup Table là gì

Lookup table là một cấu trúc dữ liệu giúp **tra cứu cực nhanh bằng key**.

Ý tưởng rất đơn giản:

Thay vì:

```
value lookup
```

Ta chuyển thành:

```
key lookup
```

Vì key lookup trong PHP HashTable là:

```
O(1)
```

## 15. `array_flip()` là gì

`array_flip()` là hàm **đảo key và value của array**.

Ví dụ:

```php
$roles = ['admin','editor','user'];

$lookup = array_flip($roles);
```

Kết quả:

```
[
 'admin' => 0,
 'editor' => 1,
 'user' => 2
]
```

Giờ ta có thể lookup:

```php
isset($lookup['admin']);
```

Thay vì:

```php
in_array('admin', $roles);
```

## 16. Bản chất bên trong `array_flip()`

Internal logic gần giống:

```php
$new = [];

foreach ($array as $key => $value) {
    $new[$value] = $key;
}

return $new;
```

Nghĩa là:

```
value -> trở thành key
```

Sau khi flip, array trở thành **Hash lookup table**.

Diagram:

Trước:

```
[0] -> admin
[1] -> editor
[2] -> user
```

Lookup `admin` cần scan.

Sau khi flip:

```
admin  -> 0
editor -> 1
user   -> 2
```

Lookup trở thành:

```
hash('admin') -> bucket
```

## 17. Complexity sau khi dùng lookup table

So sánh:

#### Dùng `in_array`

```
O(n)
```

#### Dùng lookup table

```
O(1)
```

Nếu check 10000 lần:

```
in_array -> 10000 * scan array
isset -> 10000 * O(1)
```

Sự khác biệt rất lớn.

## 18. Lưu ý quan trọng khi dùng `array_flip()`

#### 1. Value phải unique

Nếu value trùng nhau:

```php
$arr = ['a','b','a'];

array_flip($arr);
```

Kết quả:

```
[
 'a' => 2,
 'b' => 1
]
```

Value trùng sẽ **bị overwrite**.

#### 2. Value phải là string hoặc int

PHP chỉ cho phép key:

```
int
string
```

Nếu value là object hoặc array → warning.

## 19. Pattern thường dùng trong hệ thống lớn

Pattern chuẩn:

```php
$allowedRoles = ['admin','editor','user'];

$roleSet = array_flip($allowedRoles);

if (isset($roleSet[$role])) {
    allow();
}
```

Ưu điểm:

* lookup cực nhanh
* không scan array
* dễ đọc

## 20. Kết luận

Ba điều quan trọng nhất:

1. PHP array là **HashTable**.
2. `isset()` là **O(1)** lookup.
3. `in_array()` là **O(n)** scan.

Best practice production:

```
Key check -> isset()
Value check -> in_array(..., true)
Heavy lookup -> array_flip + isset
```

Nếu hiểu đúng bản chất này, bạn sẽ:

* tránh được nhiều bug logic
* viết code PHP nhanh hơn
* tối ưu performance trong hệ thống lớn.
