---
title: Chuyến phiêu lưu đầu tiên của tôi
excerpt: Một câu chuyện ngắn về sự bắt đầu của một hành trình mới đầy thú vị và những bài học quý giá.
category: Nhật ký
image: /prezet/img/writing-tests-in-laravel.webp
date: 2024-04-20
tags: [kể chuyện, hành trình, khởi đầu]
---

## Chuyến phiêu lưu đầu tiên của tôi

Hôm nay là một ngày đặc biệt. Tôi quyết định bắt đầu viết nhật ký để ghi lại những khoảnh khắc đáng nhớ trong cuộc sống của mình.

### Sự khởi đầu

Mọi thứ bắt đầu từ một ý tưởng nhỏ...

> "Hành trình vạn dặm bắt đầu từ một bước chân đầu tiên." - Lão Tử

Tôi hy vọng rằng qua những dòng chữ này, tôi có thể nhìn lại bản thân mình đã trưởng thành như thế nào qua thời gian.

### Cảm xúc lúc này

Tôi cảm thấy vừa hồi hộp vừa phấn khích. Việc chia sẻ câu chuyện của mình giống như việc mở cánh cửa bước vào một thế giới mới.

Cảm ơn bạn đã ghé thăm và lắng nghe câu chuyện của tôi.


## 1. Bài toán

Bạn có danh sách 1 tỷ user đã đăng ký. Khi có người đăng ký mới, bạn phải kiểm tra ngay xem username đó đã tồn tại chưa. Đọc 1 tỷ row từ DB hoặc load vào RAM là quá chậm.

## 2. Định nghĩa

**Bloom Filter** là cấu trúc dữ liệu xác suất. Nó có thể trả về:

- **"Chắc chắn KHÔNG tồn tại"**: Kết quả chính xác 100%.
- **"Có thể ĐÃ tồn tại"**: Có sai số nhỏ (False positive).

## 3. Bản chất

Dùng một mảng bit lớn. Khi thêm 1 key, dùng nhiều hàm băm khác nhau để set các vị trí tương ứng trong mảng bit thành 1. Khi check, nếu bất kỳ vị trí nào bằng 0 -> Chắc chắn chưa tồn tại.

## 4. Ứng dụng

- Chống **Cache Penetration**: Nếu Bloom Filter báo không tồn tại, chặn luôn request, không cho chạm vào DB.
- Lọc spam email, kiểm tra URL độc hại.

## 5. Câu hỏi nhanh

**Q: Tại sao không xóa được dữ liệu khỏi Bloom Filter?**
**A:** Vì nhiều phần tử dùng chung 1 bit trong mảng. Nếu bạn xóa (set 0), bạn có thể vô tình xóa luôn sự tồn tại của các phần tử khác.
**Q: Làm sao giảm sai số (False positive)?**
**A:** Tăng kích thước mảng bit hoặc tăng số lượng hàm băm.

## 1. Bài toán

Bạn có danh sách 1 tỷ user đã đăng ký. Khi có người đăng ký mới, bạn phải kiểm tra ngay xem username đó đã tồn tại chưa. Đọc 1 tỷ row từ DB hoặc load vào RAM là quá chậm.

## 2. Định nghĩa

**Bloom Filter** là cấu trúc dữ liệu xác suất. Nó có thể trả về:

- **"Chắc chắn KHÔNG tồn tại"**: Kết quả chính xác 100%.
- **"Có thể ĐÃ tồn tại"**: Có sai số nhỏ (False positive).

## 3. Bản chất

Dùng một mảng bit lớn. Khi thêm 1 key, dùng nhiều hàm băm khác nhau để set các vị trí tương ứng trong mảng bit thành 1. Khi check, nếu bất kỳ vị trí nào bằng 0 -> Chắc chắn chưa tồn tại.

## 4. Ứng dụng

- Chống **Cache Penetration**: Nếu Bloom Filter báo không tồn tại, chặn luôn request, không cho chạm vào DB.
- Lọc spam email, kiểm tra URL độc hại.

## 5. Câu hỏi nhanh

**Q: Tại sao không xóa được dữ liệu khỏi Bloom Filter?**
**A:** Vì nhiều phần tử dùng chung 1 bit trong mảng. Nếu bạn xóa (set 0), bạn có thể vô tình xóa luôn sự tồn tại của các phần tử khác.
**Q: Làm sao giảm sai số (False positive)?**
**A:** Tăng kích thước mảng bit hoặc tăng số lượng hàm băm.

## 1. Bài toán

Bạn có danh sách 1 tỷ user đã đăng ký. Khi có người đăng ký mới, bạn phải kiểm tra ngay xem username đó đã tồn tại chưa. Đọc 1 tỷ row từ DB hoặc load vào RAM là quá chậm.

## 2. Định nghĩa

**Bloom Filter** là cấu trúc dữ liệu xác suất. Nó có thể trả về:

- **"Chắc chắn KHÔNG tồn tại"**: Kết quả chính xác 100%.
- **"Có thể ĐÃ tồn tại"**: Có sai số nhỏ (False positive).

## 3. Bản chất

Dùng một mảng bit lớn. Khi thêm 1 key, dùng nhiều hàm băm khác nhau để set các vị trí tương ứng trong mảng bit thành 1. Khi check, nếu bất kỳ vị trí nào bằng 0 -> Chắc chắn chưa tồn tại.

## 4. Ứng dụng

- Chống **Cache Penetration**: Nếu Bloom Filter báo không tồn tại, chặn luôn request, không cho chạm vào DB.
- Lọc spam email, kiểm tra URL độc hại.

## 5. Câu hỏi nhanh

**Q: Tại sao không xóa được dữ liệu khỏi Bloom Filter?**
**A:** Vì nhiều phần tử dùng chung 1 bit trong mảng. Nếu bạn xóa (set 0), bạn có thể vô tình xóa luôn sự tồn tại của các phần tử khác.
**Q: Làm sao giảm sai số (False positive)?**
**A:** Tăng kích thước mảng bit hoặc tăng số lượng hàm băm.

## 1. Bài toán

Bạn có danh sách 1 tỷ user đã đăng ký. Khi có người đăng ký mới, bạn phải kiểm tra ngay xem username đó đã tồn tại chưa. Đọc 1 tỷ row từ DB hoặc load vào RAM là quá chậm.

## 2. Định nghĩa

**Bloom Filter** là cấu trúc dữ liệu xác suất. Nó có thể trả về:

- **"Chắc chắn KHÔNG tồn tại"**: Kết quả chính xác 100%.
- **"Có thể ĐÃ tồn tại"**: Có sai số nhỏ (False positive).

## 3. Bản chất

Dùng một mảng bit lớn. Khi thêm 1 key, dùng nhiều hàm băm khác nhau để set các vị trí tương ứng trong mảng bit thành 1. Khi check, nếu bất kỳ vị trí nào bằng 0 -> Chắc chắn chưa tồn tại.

## 4. Ứng dụng

- Chống **Cache Penetration**: Nếu Bloom Filter báo không tồn tại, chặn luôn request, không cho chạm vào DB.
- Lọc spam email, kiểm tra URL độc hại.

## 5. Câu hỏi nhanh

**Q: Tại sao không xóa được dữ liệu khỏi Bloom Filter?**
**A:** Vì nhiều phần tử dùng chung 1 bit trong mảng. Nếu bạn xóa (set 0), bạn có thể vô tình xóa luôn sự tồn tại của các phần tử khác.
**Q: Làm sao giảm sai số (False positive)?**
**A:** Tăng kích thước mảng bit hoặc tăng số lượng hàm băm.

