---
title: "Advanced Networking: Hiểu sâu về Hạ tầng Mạng"
description: Hệ thống câu hỏi về DNS, TCP/UDP internals, TLS handshake, CDN và các kỹ thuật debug mạng nâng cao.
date: 2026-04-18
tags: [networking, tcp, udp, dns, tls, security]
image: /prezet/img/ogimages/knowledge-vi-advanced-networking.webp
---

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Địa chỉ IP là gì? Phân biệt IPv4 và IPv6.</summary>

  **Trả lời:**
  IP là địa chỉ định danh thiết bị trên mạng.

- IPv4: 32-bit (ví dụ: 192.168.1.1), giới hạn khoảng 4 tỷ địa chỉ.
- IPv6: 128-bit (ví dụ: 2001:0db8:...), cung cấp số lượng địa chỉ gần như vô hạn.

</details>

<details>
  <summary>Q2: DNS (Domain Name System) đóng vai trò gì?</summary>

  **Trả lời:**
  Đóng vai trò "danh bạ điện thoại" của Internet, giúp chuyển đổi tên miền dễ nhớ (google.com) thành địa chỉ IP mà máy tính hiểu được.
</details>

<details>
  <summary>Q3: Phân biệt TCP và UDP một cách đơn giản.</summary>
  
  **Trả lời:**

- TCP: Tin cậy, đảm bảo dữ liệu đến đúng và đủ (ví dụ: Web, Email).
- UDP: Tốc độ cao, không đảm bảo dữ liệu (ví dụ: Livestream, Game online).

</details>

<details>
  <summary>Q4: Cổng (Port) là gì? Các cổng phổ biến 80, 443, 22.</summary>
  
  **Trả lời:**
  Là điểm cuối của giao tiếp để phân loại dịch vụ.

- 80: HTTP.
- 443: HTTPS.
- 22: SSH.

</details>

<details>
  <summary>Q5: DHCP là dịch vụ gì?</summary>
  
  **Trả lời:**
  Tự động cấp phát địa chỉ IP cho các thiết bị khi chúng tham gia vào mạng.
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Giải thích quá trình "TCP 3-Way Handshake".</summary>

  **Trả lời:**

  1. Client gửi **SYN**.
  2. Server phản hồi **SYN-ACK**.
  3. Client gửi lại **ACK**.
  Sau 3 bước này, kết nối chính thức được thiết lập.

</details>

<details>
  <summary>Q2: DNS Lookup hoạt động như thế nào (Recursive vs Iterative)?</summary>

  **Trả lời:**

- Recursive: Bạn hỏi DNS Server, nó đi hỏi tất cả các cấp cho bạn rồi trả về kết quả cuối.
- Iterative: DNS Server trả về địa chỉ của server cấp tiếp theo (ví dụ Root -> .com -> google.com) để bạn tự đi hỏi.

</details>

<details>
  <summary>Q3: TTL (Time To Live) trong DNS nghĩa là gì?</summary>

  **Trả lời:**
  Thời gian (tính bằng giây) mà một bản ghi DNS được phép lưu trong bộ nhớ đệm (cache) trước khi phải đi hỏi lại server gốc.
</details>

<details>
  <summary>Q4: Bảng định tuyến (Routing Table) là gì?</summary>

  **Trả lời:**
  Là bản đồ chứa các quy tắc để Router biết nên gửi gói tin theo hướng nào (interface nào) để đến được đích.
</details>

<details>
  <summary>Q5: Private IP vs Public IP và NAT.</summary>

  **Trả lời:**

- Private IP: Dùng trong mạng nội bộ (LAN).
- Public IP: Dùng trên Internet.
- NAT (Network Address Translation): Kỹ thuật giúp nhiều máy dùng Private IP cùng đi ra ngoài Internet qua 1 Public IP duy nhất.

</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Giải thích quá trình TLS 1.2 Handshake (HTTPS).</summary>

  **Trả lời:**

  1. Client Hello (hỗ trợ thuật toán gì?).
  2. Server Hello + Certificate (kèm Public Key).
  3. Client xác thực Certificate, gửi Pre-master secret (mã hóa bằng Public Key server).
  4. Cả hai tạo Session Key (Symmetric) để mã hóa dữ liệu sau đó.

</details>

<details>
  <summary>Q2: TCP Flow Control vs Congestion Control.</summary>

  **Trả lời:**

- Flow Control: Ngăn client gửi quá nhanh làm server "ngạt thở" (dùng Window Size).
- Congestion Control: Ngăn toàn bộ mạng bị tắc nghẽn (dùng các thuật toán như Slow Start, Congestion Avoidance).

</details>

<details>
  <summary>Q3: Anycast routing là gì và ứng dụng trong CDN?</summary>
  
  **Trả lời:**
  Nhiều server ở các vị trí địa lý khác nhau cùng dùng chung 1 địa chỉ IP. Mạng sẽ tự động điều hướng gói tin đến server "gần" nhất về mặt network, giúp giảm độ trễ cực lớn cho CDN và DNS.
</details>

<details>
  <summary>Q4: BGP (Border Gateway Protocol) là gì?</summary>
  
  **Trả lời:**
  Là giao thức định tuyến giữa các Hệ thống tự trị (Autonomous Systems - AS) trên Internet. Nó quyết định "đường đi" của dữ liệu giữa các nhà mạng lớn.
</details>

<details>
  <summary>Q5: MTU (Maximum Transmission Unit) và lỗi phân mảnh (Fragmentation).</summary>
  
  **Trả lời:**
  Kích thước tối đa của một gói tin (thường là 1500 bytes). Nếu gói tin lớn hơn MTU của một thiết bị trung gian, nó phải bị xẻ nhỏ (phân mảnh), làm giảm hiệu năng và tăng độ trễ.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế hệ thống DNS phục vụ 1 tỷ request/ngày với độ trễ < 10ms.</summary>
  
  **Trả lời:**
  Sử dụng mô hình **Anycast IP** để phân tán traffic tới hàng trăm Edge nodes. Triển khai nhiều tầng Caching. Sử dụng Load Balancer tầng 4 hiệu năng cao (như DPDK) để xử lý gói tin UDP nhanh nhất có thể.
</details>

<details>
  <summary>Q2: Phân tích sự đánh đổi khi sử dụng gRPC over HTTP/2 so với REST over HTTP/1.1.</summary>
  
  **Trả lời:**
  gRPC: Nhỏ gọn, đa luồng trên 1 kết nối (Multiplexing), nhưng khó debug (binary), không hỗ trợ tốt trình duyệt cũ. REST: Dễ dùng, phổ biến nhưng overhead lớn và bị lỗi Head-of-line blocking trên HTTP/1.1.
</details>

<details>
  <summary>Q3: Tầm nhìn: Liệu QUIC (HTTP/3) có giải quyết được hoàn toàn các nhược điểm của TCP?</summary>
  
  **Trả lời:**
  QUIC chạy trên UDP, giải quyết lỗi Head-of-line blocking ở mức stream, hỗ trợ kết nối mượt mà khi đổi mạng (0-RTT), nhưng đòi hỏi CPU xử lý nặng hơn và có thể bị một số Firewall chặn vì dùng UDP.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: API bị lỗi thỉnh thoảng mất kết nối ("Connection reset by peer"). Bạn dùng tool gì để debug mạng?</summary>
  
  **Xử lý:** 1. Dùng `tcpdump` hoặc Wireshark để bắt gói tin. 2. Kiểm tra xem server có gửi gói RST không. 3. Kiểm tra Firewall/Load Balancer có timeout kết nối quá sớm không.
</details>

<details>
  <summary>S2: Website load chậm ở một số khu vực. Làm sao để kiểm tra lỗi định tuyến?</summary>
  
  **Xử lý:** Dùng lệnh `mtr` (My Traceroute) hoặc `traceroute`. Nó sẽ chỉ ra gói tin bị chậm hoặc mất tại node (nhà mạng) nào trên đường đi.
</details>

## Nên biết

- Mô hình OSI 7 tầng (đặc biệt tầng 3, 4, 7).
- Cách hoạt động của DNS và HTTPS.
- Các lệnh debug mạng: ping, telnet, curl, dig, mtr.

## Lưu ý

- Quên cấu hình bản ghi `A` hoặc `CNAME` đúng trong DNS.
- Không quan tâm tới độ trễ (latency) khi gọi các API ở region khác nhau.
