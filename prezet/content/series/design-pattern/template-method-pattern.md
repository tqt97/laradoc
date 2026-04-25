---
title: Template Method - Bộ khung xương vững chắc
excerpt: Tìm hiểu Template Method Pattern - cách định nghĩa khung thuật toán và cho phép class con tùy biến, bí quyết build BaseController và BaseService trong Laravel.
category: Design pattern
date: 2026-03-23
order: 16
image: /prezet/img/ogimages/series-design-pattern-template-method-pattern.webp
---

> Pattern thuộc nhóm **Behavioral Pattern (Hành vi)**

## 1. Problem & Motivation

Hãy tưởng tượng bạn đang xây dựng một hệ thống xuất báo cáo (Export). Bạn hỗ trợ xuất ra file **PDF** và **Excel**. Cả hai quy trình này đều có các bước giống hệt nhau:

1. Lấy dữ liệu từ Database.
2. Định dạng dữ liệu (Formatting).
3. Ghi dữ liệu vào file.
4. Gửi mail thông báo cho người dùng.

**Vấn đề:**

* Bước 1 và 4 giống hệt nhau cho mọi loại file.
* Bước 2 và 3 lại khác nhau hoàn toàn (PDF cần thư viện DomPDF, Excel cần thư viện Maatwebsite).

**Naive Solution:** Copy-paste toàn bộ quy trình cho mỗi class `PdfExporter` và `ExcelExporter`.
**Hệ quả:** Nếu sau này bạn muốn đổi logic gửi Mail (bước 4), bạn phải sửa ở tất cả các class Export. Code cực kỳ dư thừa và khó bảo trì.

## 2. Định nghĩa

**Template Method Pattern** định nghĩa bộ khung của một thuật toán trong một phương thức, và trì hoãn một số bước cho các lớp con. Pattern này cho phép các lớp con định nghĩa lại một số bước nhất định của thuật toán mà không làm thay đổi cấu trúc của thuật toán đó.

**Ý tưởng cốt lõi:** Định nghĩa một "quy trình chuẩn" (Template) ở lớp cha, các lớp con chỉ việc "điền vào chỗ trống" những phần riêng biệt.

## 3. Implementation (PHP Clean Code)

### 3.1 Abstract Class (Bộ khung)

```php
abstract class DataExporter {
    // Đây chính là Template Method
    public final function export(): void {
        $this->fetchData();
        $this->formatData();
        $this->writeFile();
        $this->sendNotification();
    }

    protected function fetchData(): void {
        echo "Đang lấy dữ liệu từ Database...\n";
    }

    protected function sendNotification(): void {
        echo "Gửi mail: Báo cáo đã sẵn sàng!\n";
    }

    // Các bước này class con PHẢI tự định nghĩa
    abstract protected function formatData(): void;
    abstract protected function writeFile(): void;
}
```

### 3.2 Concrete Classes (Triển khai cụ thể)

```php
class PdfExporter extends DataExporter {
    protected function formatData(): void {
        echo "Định dạng dữ liệu theo kiểu PDF (với DomPDF)...\n";
    }

    protected function writeFile(): void {
        echo "Ghi file .pdf vào Storage.\n";
    }
}

class ExcelExporter extends DataExporter {
    protected function formatData(): void {
        echo "Định dạng dữ liệu theo hàng/cột (với PhpSpreadsheet)...\n";
    }

    protected function writeFile(): void {
        echo "Ghi file .xlsx vào Storage.\n";
    }
}

// Sử dụng
$pdf = new PdfExporter();
$pdf->export(); 
```

## 4. Liên hệ Laravel

Laravel sử dụng Template Method ở khắp mọi nơi để tạo ra sự nhất quán:

**1. Eloquent Models:**
Các hàm như `save()`, `delete()` trong Eloquent thực chất là Template Method. Chúng có bộ khung xử lý sự kiện (Events), transaction... nhưng cho phép bạn tùy biến thông qua các "hooks" như `booted()` hoặc `$dispatchesEvents`.

**2. Artisan Commands:**
Hàm `handle()` chính là phần bạn "điền vào chỗ trống". Bộ khung bên dưới của Laravel sẽ lo việc parse tham số, hiển thị output, xử lý lỗi...

**3. Base Controllers/Services:**
Lập trình viên thường tạo một `BaseController` định nghĩa các hàm xử lý response chuẩn, và các Controller con chỉ việc gọi hoặc override khi cần.

## 5. Khi nào nên dùng

* Khi có nhiều class thực hiện các thuật toán tương tự nhau với một số khác biệt nhỏ.
* Khi bạn muốn kiểm soát các điểm mở rộng (hooks): chỉ cho phép class con thay đổi ở những bước nhất định.
* Khi muốn tránh lặp lại code (DRY principle) trong một hệ thống các class có liên quan.

## 6. Ưu & Nhược điểm

**Ưu điểm:**

* **Tái sử dụng code:** Gom tất cả code chung lên lớp cha.
* **Tính đóng gói:** Lớp cha kiểm soát quy trình, lớp con không thể làm sai thứ tự các bước.
* **Dễ bảo trì:** Thay đổi logic chung chỉ cần sửa một nơi duy nhất.

**Nhược điểm:**

* **Vi phạm Liskov Substitution:** Nếu lớp con thay đổi quá nhiều bước hoặc để trống các bước quan trọng, nó có thể phá vỡ logic của Template.
* **Khó mở rộng theo chiều ngang:** Nếu thuật toán có quá nhiều bước nhỏ, số lượng hàm abstract sẽ tăng lên rất nhanh.

## 7. Câu hỏi phỏng vấn

1. **Tại sao Template Method thường được đặt là `final`?** (Để ngăn chặn class con ghi đè lên cấu trúc quy trình đã định sẵn).
2. **"Hook" trong Template Method là gì?** (Là một phương thức có nội dung mặc định hoặc trống ở lớp cha, cho phép lớp con tùy chọn override hoặc không, khác với `abstract` là bắt buộc phải override).
3. **Template Method vs Strategy khác nhau thế nào?** (Template Method dùng kế thừa - cấp độ class, Strategy dùng thành phần - cấp độ object).

## Kết luận

Template Method Pattern là bí quyết để xây dựng các class `Base` chuyên nghiệp. Hãy sử dụng nó để áp đặt kỷ luật cho hệ thống của bạn, đảm bảo mọi quy trình đều chạy đúng "đường ray" mà bạn đã thiết kế.
