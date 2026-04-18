---
title: "Consistent Hashing: Nghệ thuật Sharding không gây 'sốc'"
excerpt: Cách giải quyết vấn đề tái phân phối dữ liệu khi thêm/bớt server trong hệ thống phân tán (Distributed Caching).
date: 2026-04-18
category: Architecture
image: /prezet/img/ogimages/blogs-architecture-consistent-hashing.webp
tags: [architecture, sharding, distributed-systems, hashing]
---

## 1. Bài toán
Khi sử dụng công thức `server = hash(key) % N`, nếu số lượng server `N` thay đổi (thêm hoặc xóa server), gần như toàn bộ dữ liệu cache cũ sẽ bị sai lệch vị trí -> Gây "Cache Miss" đồng loạt, làm sập Database.

## 2. Giải pháp: Consistent Hashing
Thay vì hash vào server cụ thể, ta hash vào một "vòng tròn" (Ring) 2³² điểm.
- Server và Data đều được hash vào vòng tròn này.
- Dữ liệu sẽ thuộc về server gần nhất phía chiều kim đồng hồ.
- **Lợi ích:** Khi thêm/xóa 1 server, chỉ một phần nhỏ dữ liệu (1/N) bị ảnh hưởng, thay vì toàn bộ dữ liệu.

## 3. Ứng dụng
- Hệ thống Caching phân tán (Memcached, Redis Cluster).
- Load Balancers.

## 4. Câu hỏi nhanh
**Q: Virtual Nodes (Vnodes) trong Consistent Hashing là gì?**
**A:** Để tránh việc dữ liệu phân bổ không đều (Hot Spot), ta map 1 server vật lý thành nhiều "Virtual Node" rải rác trên vòng tròn. Điều này giúp dữ liệu được trải đều hơn.
