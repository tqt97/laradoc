---
title: "Custom Hooks: Kiến trúc tách biệt Logic và UI"
excerpt: Cách xây dựng các Custom Hooks để biến Component thành 'View-only', giúp code sạch và tái sử dụng logic cực cao.
date: 2026-04-18
category: React
image: /prezet/img/ogimages/blogs-react-custom-hooks-architecture.webp
tags: [react, architecture, hooks, clean-code]
---

## 1. Bài toán

Một Component vừa chứa logic gọi API, vừa chứa logic validate form, vừa chứa logic hiển thị UI. Kết quả là 1 file 500 dòng không ai dám đụng vào.

## 2. Giải pháp: Custom Hooks

Tách toàn bộ logic ra các hook: `useAuth`, `useFetchProducts`, `useFormValidation`. Component bây giờ chỉ nhận data và hiển thị.

## 3. Ví dụ

```javascript
function ProductList() {
    const { products, loading } = useFetchProducts(); // Logic tách biệt
    if (loading) return <Spinner />;
    return <div>{products.map(...)}</div>;
}
```

## 4. Lợi ích

- **Testability:** Bạn có thể test logic của hook bằng `react-hooks-testing-library` mà không cần render UI.
- **Reusability:** Một logic có thể dùng cho cả web, mobile hay nhiều component khác nhau.

## 5. Quizz Senior

**Q: "Nguyên tắc thiết kế của Hook là gì?"**
**A:** Không bao giờ gọi Hook trong vòng lặp hoặc điều kiện (if/else). React dựa vào thứ tự gọi để lưu trữ state, thay đổi thứ tự sẽ làm hỏng toàn bộ app.
