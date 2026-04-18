---
title: "React State Management: Chiến lược cho hệ thống lớn"
excerpt: Phân biệt Local State, Global State, và Server State. Khi nào dùng Context, Redux, hay React Query?
date: 2026-04-18
category: React
image: /prezet/img/ogimages/blogs-react-state-management-patterns.webp
tags: [react, state-management, architecture, frontend]
---

## 1. Phân loại State

- **Local State:** Dùng `useState` (chỉ 1 component dùng).
- **Global State:** Dùng Context/Redux/Zustand (chia sẻ nhiều nơi).
- **Server State:** Dữ liệu từ API. **Kinh nghiệm:** Đừng lưu server state vào Redux nếu không cần thiết. Dùng `React Query` (TanStack Query) để quản lý caching, loading, refetching tự động.

## 2. Kiến trúc Clean React

- **Container/Presenter Pattern:** Tách Component "xử lý logic" (Container) và Component "chỉ hiển thị" (Presenter). Giúp component tái sử dụng cực cao.
- **Custom Hooks:** Nơi chứa logic xử lý state phức tạp. Biến component thành nơi chỉ "gọi hook và render".

## 3. Phỏng vấn

**Q: Khi nào dùng Context thay vì Redux/Zustand?**
**A:** Context tốt cho những dữ liệu ít thay đổi (Theme, Auth, Locale). Nếu dữ liệu thay đổi thường xuyên (real-time, form lớn), Context gây re-render cả cây Component con, hãy dùng Zustand/Redux để tối ưu hóa re-render.
