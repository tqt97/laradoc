---
title: "PHP Internals & Function Building: Đi sâu vào Zend Engine"
description: Khám phá cách PHP vận hành bên dưới lớp vỏ bọc, cấu trúc của Zend Engine, cách một hàm được thực thi và cách xây dựng các hàm core-like.
date: 2026-01-18
tags: [php, internals, zend-engine, c, performance, programming]
image: /prezet/img/ogimages/knowledge-php-internals-functions.webp
---

> Nếu bạn muốn thực sự làm chủ một ngôn ngữ, bạn phải hiểu cách nó được tạo ra." Đi sâu vào PHP Internals giúp bạn viết code không chỉ chạy được, mà còn tối ưu hóa đến từng byte bộ nhớ.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Zend Engine là gì?</summary>

  **Trả lời:**
  Là "trái tim" của PHP, chịu trách nhiệm biên dịch (compile) mã nguồn PHP thành Opcode và thực thi chúng (execute) trên máy ảo (Virtual Machine).
</details>

<details>
  <summary>Q2: PHP được viết bằng ngôn ngữ gì?</summary>

  **Trả lời:**
  Phần lõi (Core) của PHP được viết bằng ngôn ngữ **C**. Đó là lý do tại sao nhiều hàm PHP có tên và hành vi giống hệt các hàm trong thư viện chuẩn của C.
</details>

<details>
  <summary>Q3: Opcode là gì?</summary>

  **Trả lời:**
  Viết tắt của "Operation Code". Là các chỉ thị máy mức thấp mà Zend VM có thể hiểu được. Mã PHP của bạn không chạy trực tiếp, nó được dịch sang Opcode trước khi chạy.
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Giải thích cấu trúc của `zval`.</summary>

  **Trả lời:**
  `zval` (Zend Value) là cấu trúc dữ liệu cơ bản nhất lưu trữ mọi biến trong PHP. Nó gồm:
  1. **Value:** Giá trị thực tế (union của int, float, string...).
  2. **Type:** Loại dữ liệu (IS_STRING, IS_ARRAY...).
  3. **Refcount:** Bộ đếm số lượng biến đang trỏ tới giá trị này.
</details>

<details>
  <summary>Q2: Một lời gọi hàm (Function Call) diễn ra như thế nào bên dưới Zend Engine?</summary>

  **Trả lời:**
  1. Tìm tên hàm trong **Function Table** (một hash table khổng lồ).
  2. Kiểm tra tham số và đẩy vào **Stack**.
  3. Zend VM chuyển con trỏ lệnh tới vùng nhớ chứa Opcode của hàm đó.
  4. Thực thi và trả về giá trị qua `return_value`.
</details>

<details>
  <summary>Q3: Phân biệt User-land function và Internal function.</summary>

  **Trả lời:**
  - **User-land:** Hàm do bạn viết bằng PHP (ví dụ: `function mySum() { ... }`).
  - **Internal:** Hàm có sẵn trong PHP core được viết bằng C (ví dụ: `strlen()`, `array_map()`). Hàm internal luôn nhanh hơn vì không tốn bước biên dịch Opcode và chạy trực tiếp mã máy.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Cơ chế "Symbol Table" hoạt động như thế nào?</summary>

  **Trả lời:**
  Zend Engine dùng Hash Table để quản lý các biến. 
  - **Global Symbol Table:** Lưu các biến toàn cục.
  - **Active Symbol Table:** Lưu các biến cục bộ trong hàm hiện tại. 
  Mỗi khi bạn gọi `$a`, PHP phải thực hiện một phép lookup trong Hash Table này.
</details>

<details>
  <summary>Q2: Giải thích về "Immutable Strings" trong PHP 7+.</summary>

  **Trả lời:**
  Từ PHP 7, các chuỗi ký tự (string) được đánh dấu là `IS_STR_INTERNED`. Các chuỗi này (như tên class, tên hàm, chuỗi cố định) chỉ được lưu 1 bản duy nhất trong bộ nhớ và không bao giờ bị giải phóng cho đến khi tắt tiến trình. Giúp tiết kiệm RAM và so sánh chuỗi cực nhanh bằng địa chỉ vùng nhớ.
</details>

<details>
  <summary>Q3: Tối ưu hóa Hash Table trong PHP internals.</summary>

  **Trả lời:**
  Hash Table của PHP cực kỳ phức tạp để cân bằng giữa tốc độ lookup O(1) và khả năng lặp qua mảng theo thứ tự thêm vào (Linked List). Nó sử dụng mảng các `Bucket` và thuật toán băm `DJB2`.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Làm thế nào để viết một PHP Extension đơn giản bằng C?</summary>

  **Trả lời:**
  1. Định nghĩa `zend_function_entry` để khai báo hàm.
  2. Viết logic xử lý dùng macro `PHP_FUNCTION`.
  3. Sử dụng `ZEND_PARSE_PARAMETERS_START` để lấy input từ PHP.
  4. Build thành file `.so` (Linux) hoặc `.dll` (Windows) và nạp vào `php.ini`.
</details>

<details>
  <summary>Q2: Phân tích hiệu năng của "Variadic functions" (`...$args`) ở mức engine.</summary>

  **Trả lời:**
  Thay vì tạo một mảng tạm thời như `func_get_args()`, variadic gán trực tiếp các tham số từ Stack vào biến mảng. Điều này giúp giảm overhead và tránh copy dữ liệu không cần thiết.
</details>

## Câu hỏi Phỏng vấn (Interview Style)

<details>
  <summary>Q: Tại sao `count($array)` trong PHP lại có độ phức tạp O(1)?</summary>

  **Trả lời:**
  Vì trong cấu trúc dữ liệu `HashTable` (lõi của mảng PHP), luôn có một biến `nNumOfElements` lưu sẵn số lượng phần tử hiện tại. Hàm `count()` chỉ việc lấy giá trị của biến này ra mà không cần đếm lại từ đầu.
</details>

<details>
  <summary>Q: "Reference counting" có nhược điểm gì? GC giải quyết nó như thế nào?</summary>

  **Trả lời:**
  Nhược điểm là "Circular References" (A trỏ B, B trỏ A). Refcount của cả 2 luôn >= 1 nên không bao giờ được giải phóng tự động. PHP GC (Garbage Collector) định kỳ chạy thuật toán tìm các "cụm" object độc lập với Symbol Table và giải phóng chúng.
</details>

## Mẹo và thủ thuật

- **Sử dụng Type Hinting:** Giúp Zend Engine chuẩn bị sẵn kiểu dữ liệu trong zval, giảm thiểu bước kiểm tra kiểu lúc runtime (Type checking).
- **Hạn chế dùng References (`&$var`):** Trong PHP 7+, references làm hỏng cơ chế tối ưu "Copy-on-Write" và thường làm code chậm hơn thay vì nhanh hơn.
