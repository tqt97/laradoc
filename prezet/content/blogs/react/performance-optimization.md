---
title: "React Performance: Tối ưu Render với memo và useMemo"
excerpt: Khi nào nên 'ghi nhớ' (memoize) để tránh re-render lãng phí và khi nào nó lại trở thành gánh nặng?
date: 2026-04-18
category: React
image: /prezet/img/ogimages/blogs-react-performance-optimization.webp
tags: [react, performance, memoization, optimization]
---

## 1. Bài toán

Mỗi khi Component cha render, toàn bộ Component con cũng re-render theo. Nếu cây UI lớn, ứng dụng sẽ bị lag.

## 2. Công cụ

- **`React.memo`:** Chỉ re-render nếu `props` thay đổi.
- **`useMemo`:** Ghi nhớ kết quả của một phép tính toán phức tạp.
- **`useCallback`:** Ghi nhớ instance của hàm để truyền xuống component con mà không làm con re-render.

## 3. Tư duy Senior: "Đừng tối ưu sớm"

- Việc dùng `memo` tốn chi phí so sánh (shallow comparison). Nếu component render nhanh, việc so sánh props còn tốn kém hơn việc re-render.
- **Quy tắc:** Chỉ dùng `memo` khi component con "nặng" hoặc được render lại quá nhiều lần (ví dụ: trong List/Table).

## 4. Quizz Phỏng vấn

**Q: Khi nào `useMemo` không có tác dụng?**
**A:** Khi các dependencies trong `useMemo` thay đổi ở mỗi lần render (ví dụ: khai báo một object/array mới ngay trong component cha).
**Q: Sự khác biệt giữa `useMemo` và `useCallback`?**
**A:** `useMemo` trả về **giá trị** (kết quả tính toán). `useCallback` trả về **hàm** (function) đã được ghi nhớ.
