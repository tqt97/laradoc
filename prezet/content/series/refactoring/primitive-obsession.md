---
title: Primitive Obsession là gì? Nguyên nhân khiến code của bạn “toác” dần theo thời gian
excerpt: Primitive Obsession là một trong những code smell phổ biến khi dev lạm dụng các kiểu dữ liệu nguyên thủy như string, int để biểu diễn logic business
category: Refactoring
date: 2026-03-09
order: 7
image:

---

> Primitive Obsession là một trong những code smell phổ biến khi dev lạm dụng các kiểu dữ liệu nguyên thủy như string, int để biểu diễn logic business. Bài viết này sẽ giúp bạn hiểu rõ nguyên nhân gốc rễ của vấn đề này và vì sao nó khiến code ngày càng khó maintain.

## Nguyên nhân gây ra Primitive Obsession

**Khi dev “yếu lòng”**

Giống như hầu hết các *code smell* khác, **Primitive Obsession** thường xuất hiện trong những khoảnh khắc rất đời thường:

> Chỉ cần thêm một field để lưu data thôi mà…

Việc tạo một biến kiểu `string`, `int` rõ ràng là nhanh và đơn giản hơn rất nhiều so với việc thiết kế hẳn một class mới.

Và thế là:

* Một field được thêm vào
* Rồi thêm field thứ hai
* Rồi thêm tiếp…

👉 Đến một lúc nào đó, class bắt đầu trở nên **cồng kềnh, khó kiểm soát và khó hiểu**.

### Dùng primitive để “giả lập” kiểu dữ liệu

Một thói quen phổ biến khác là dùng các kiểu primitive để **mô phỏng (simulate)** một kiểu dữ liệu thực sự.

Thay vì tạo một type riêng cho một concept trong business, dev lại dùng:

* Một tập hợp các `int`
* Hoặc một tập hợp các `string`

để đại diện cho các giá trị hợp lệ.

Sau đó, để dễ đọc hơn, các giá trị này được gán tên thông qua **constants**.

**Điều này dẫn đến:**

* Constants xuất hiện khắp nơi trong codebase
* Logic business bị “phân tán” và khó kiểm soát
* Không có type safety (vẫn có thể truyền giá trị sai)

### Dùng array để mô phỏng object (Field Simulation)

Một dạng lạm dụng primitive khác là **nhét toàn bộ dữ liệu vào một array lớn**.

**Class sẽ chứa:**

* Một array chứa nhiều loại dữ liệu khác nhau
* Các string constant dùng làm key để truy cập dữ liệu

**Kiểu code này thường trông như:**

* Dữ liệu bị gom vào một chỗ nhưng không có cấu trúc rõ ràng
* Phải nhớ key dạng string
* Dễ typo → bug runtime

**Kết quả:**

* Mất hoàn toàn lợi ích của OOP
* IDE không hỗ trợ tốt (autocomplete kém)
* Code rất khó maintain khi scale

## Góc nhìn thực tế

Primitive Obsession không phải do dev “kém”, mà thường đến từ:

* Muốn code nhanh
* Thiếu thời gian thiết kế
* Hoặc hệ thống bắt đầu nhỏ rồi phình to dần

Nhưng về lâu dài, nó khiến:

* Code khó đọc hơn
* Logic business bị rối
* Việc refactor trở nên đau đớn hơn rất nhiều

## Insight kiểu Senior

> “Nếu bạn đang dùng primitive để đại diện cho một concept trong business,
> thì gần như chắc chắn bạn đang thiếu một abstraction.”

Khi thấy:

* Một `string` nhưng có rule riêng
* Một `int` nhưng có ý nghĩa đặc biệt

Thì đó là tín hiệu rõ ràng:

👉 **Đã đến lúc tạo một object đúng nghĩa.** 🚀
