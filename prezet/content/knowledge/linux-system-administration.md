---
title: "Linux & System Administration: Quản trị Máy chủ chuyên nghiệp"
description: Hệ thống câu hỏi về quản lý tiến trình, file system, permissions, shell scripting và tối ưu hóa hiệu năng server Linux.
date: 2026-03-22
tags: [linux, server, sysadmin, bash, devops]
image: /prezet/img/ogimages/knowledge-linux-system-administration.webp
---

> Làm chủ Linux là kỹ năng bắt buộc để một Backend Engineer có thể vận hành và tối ưu hóa ứng dụng trên môi trường thực tế.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Kernel là gì trong hệ điều hành Linux?</summary>
  
  **Trả lời:**
  Kernel là "trái tim" của hệ điều hành, đóng vai trò cầu nối giữa phần cứng và phần mềm. Nó quản lý bộ nhớ, CPU, và các thiết bị ngoại vi.
</details>

<details>
  <summary>Q2: Lệnh `ls`, `cd`, `pwd` dùng để làm gì?</summary>
  
  **Trả lời:**

- `ls`: Liệt kê danh sách file và thư mục.
- `cd`: Di chuyển giữa các thư mục.
- `pwd`: Hiển thị đường dẫn thư mục hiện tại.

</details>

<details>
  <summary>Q3: Phân biệt quyền `r`, `w`, `x` trong Linux.</summary>
  
  **Trả lời:**

- `r` (Read): Quyền đọc.
- `w` (Write): Quyền ghi/sửa.
- `x` (Execute): Quyền thực thi (chạy file).

</details>

<details>
  <summary>Q4: Lệnh `sudo` dùng để làm gì?</summary>
  
  **Trả lời:**
  "SuperUser DO". Cho phép người dùng bình thường thực thi các lệnh với quyền của quản trị viên (root).
</details>

<details>
  <summary>Q5: Ý nghĩa của lệnh `grep`?</summary>
  
  **Trả lời:**
  Dùng để tìm kiếm chuỗi ký tự bên trong các file hoặc kết quả của lệnh khác.
</details>

<details>
  <summary>Q6: Làm thế nào để xem dung lượng ổ cứng còn trống?</summary>
  
  **Trả lời:**
  Dùng lệnh `df -h`. (Flag `-h` để hiển thị định dạng dễ đọc như GB, MB).
</details>

<details>
  <summary>Q7: Làm thế nào để xóa một thư mục có chứa dữ liệu bên trong?</summary>
  
  **Trả lời:**
  Dùng lệnh `rm -rf <tên_thư_mục>`. Cẩn thận: lệnh này xóa vĩnh viễn và không thể khôi phục!
</details>

<details>
  <summary>Q8: Ý nghĩa của `~` và `.` trong đường dẫn?</summary>
  
  **Trả lời:**

- `~`: Thư mục Home của người dùng hiện tại.
- `.`: Thư mục hiện hành.

</details>

<details>
  <summary>Q9: Lệnh `top` dùng để làm gì?</summary>
  
  **Trả lời:**
  Hiển thị danh sách các tiến trình (processes) đang chạy và tài nguyên (CPU, RAM) mà chúng đang tiêu thụ theo thời gian thực.
</details>

<details>
  <summary>Q10: Làm thế nào để thay đổi quyền sở hữu file (Owner)?</summary>
  
  **Trả lời:**
  Dùng lệnh `chown <user>:<group> <file_name>`.
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Sự khác biệt giữa Hard Link và Soft Link (Symbolic Link).</summary>
  
  **Trả lời:**

- Soft Link: Giống shortcut bên Windows, trỏ tới đường dẫn file. Nếu file gốc bị xóa, link sẽ bị hỏng.
- Hard Link: Trỏ trực tiếp vào inode (dữ liệu thật trên đĩa). Nếu file gốc bị xóa, hard link vẫn truy cập được dữ liệu đó.

</details>

<details>
  <summary>Q2: Giải thích cấu trúc file `/etc/passwd` và `/etc/shadow`.</summary>
  
  **Trả lời:**

- `/etc/passwd`: Lưu thông tin user (tên, UID, thư mục home, shell).
- `/etc/shadow`: Lưu mật khẩu đã được mã hóa và thông tin về thời hạn mật khẩu.

</details>

<details>
  <summary>Q3: Làm thế nào để tìm kiếm tất cả các file có đuôi `.log` được sửa đổi trong 7 ngày qua?</summary>
  
  **Trả lời:**
  Dùng lệnh: `find /var/log -name "*.log" -mtime -7`.
</details>

<details>
  <summary>Q4: Quy trình khởi động (Boot Process) của Linux diễn ra như thế nào?</summary>
  
  **Trả lời:**
  BIOS/UEFI -> Boot Loader (GRUB) -> Kernel -> Init System (Systemd).
</details>

<details>
  <summary>Q5: Giải thích các thông số trong kết quả lệnh `chmod 755`.</summary>
  
  **Trả lời:**
  Số 755 tương ứng với `rwxr-xr-x`:

- 7 (rwx): Owner có toàn quyền.
- 5 (r-x): Group có quyền đọc và chạy.
- 5 (r-x): Others có quyền đọc và chạy.

</details>

<details>
  <summary>Q6: "Standard Streams" trong Linux là gì (stdin, stdout, stderr)?</summary>
  
  **Trả lời:**

- stdin (0): Đầu vào chuẩn (bàn phím).
- stdout (1): Đầu ra chuẩn (màn hình).
- stderr (2): Đầu ra báo lỗi.
  Dùng `>` để redirect stdout và `2>` để redirect stderr.

</details>

<details>
  <summary>Q7: Cron Job là gì? Cấu trúc của một file crontab?</summary>
  
  **Trả lời:**
  Lịch trình chạy lệnh tự động. Cấu trúc 5 sao: `Phút Giờ Ngày Tháng Thứ_trong_tuần <lệnh>`.
</details>

<details>
  <summary>Q8: Làm thế nào để xem các cổng (ports) đang mở trên server?</summary>
  
  **Trả lời:**
  Dùng lệnh `netstat -tuln` hoặc `ss -tuln`.
</details>

<details>
  <summary>Q9: Ý nghĩa của lệnh `ps aux`?</summary>
  
  **Trả lời:**
  Liệt kê mọi tiến trình đang chạy trong hệ thống kèm thông tin chi tiết về user, CPU, RAM và trạng thái.
</details>

<details>
  <summary>Q10: "Package Manager" là gì? (apt, yum, pacman).</summary>
  
  **Trả lời:**
  Công cụ giúp cài đặt, cập nhật và gỡ bỏ phần mềm trên Linux (ví dụ Ubuntu dùng `apt`, CentOS dùng `yum`).
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Inode là gì? Chuyện gì xảy ra nếu hệ thống hết Inode dù ổ cứng vẫn còn trống?</summary>
  
  **Trả lời:**
  Inode là cấu trúc dữ liệu lưu thông tin về file (trừ tên file và dữ liệu thật). Nếu hết Inode, bạn không thể tạo thêm file mới dù ổ cứng còn hàng TB trống.
</details>

<details>
  <summary>Q2: Giải thích cơ chế "Swap Memory". Khi nào nó gây hại cho hiệu năng?</summary>
  
  **Trả lời:**
  Dùng một phần ổ cứng làm RAM giả. Nếu RAM thật hết, Linux đẩy dữ liệu sang Swap. Gây hại khi "Swap Thrashing" xảy ra: hệ thống liên tục đọc/ghi Swap làm CPU chờ đợi I/O, khiến server cực chậm.
</details>

<details>
  <summary>Q3: Phân biệt các loại tín hiệu (Signals): SIGTERM, SIGKILL, SIGHUP.</summary>
  
  **Trả lời:**

- SIGTERM (15): Yêu cầu tiến trình dừng một cách lịch sự (có thời gian dọn dẹp).
- SIGKILL (9): Ép tiến trình dừng ngay lập tức (không thể bỏ qua).
- SIGHUP (1): Yêu cầu tiến trình nạp lại cấu hình (reload).

</details>

<details>
  <summary>Q4: Làm thế nào để debug một tiến trình bị treo mà không có log (strace)?</summary>
  
  **Trả lời:**
  Dùng `strace -p <PID>`. Nó sẽ hiển thị các system calls mà tiến trình đang thực hiện, giúp bạn biết nó đang bị kẹt ở đâu (ví dụ: đang đợi kết nối mạng hoặc đọc file).
</details>

<details>
  <summary>Q5: Ý nghĩa của "Load Average" trong lệnh `uptime`?</summary>
  
  **Trả lời:**
  Là số lượng tiến trình trung bình đang đợi CPU hoặc I/O trong 1, 5, và 15 phút. Nếu Load Average > số nhân CPU, hệ thống đang bị quá tải.
</details>

<details>
  <summary>Q6: Giải thích về "Environment Variables" và file `.bashrc`, `.profile`.</summary>
  
  **Trả lời:**
  Biến môi trường lưu cấu hình cho shell và ứng dụng. `.bashrc` chạy mỗi khi mở terminal mới (non-login shell), `.profile` chạy khi user mới login.
</details>

<details>
  <summary>Q7: Làm thế nào để thực hiện "SSH Key-based Authentication" và tại sao nó an toàn hơn mật khẩu?</summary>
  
  **Trả lời:**
  Tạo cặp khóa Public/Private. Copy Public Key lên server. An toàn vì khóa có độ dài lớn, không thể brute-force như mật khẩu và yêu cầu phải có file khóa vật lý mới vào được.
</details>

<details>
  <summary>Q8: Cách tối ưu hóa Kernel thông qua `/proc/sys` (sysctl).</summary>
  
  **Trả lời:**
  Cho phép chỉnh sửa các thông số mạng (số lượng kết nối đồng thời), bộ nhớ đệm, giới hạn file mở... mà không cần restart máy.
</details>

<details>
  <summary>Q9: Giải thích về "File Descriptors" và lỗi "Too many open files".</summary>
  
  **Trả lời:**
  Mọi thứ trong Linux đều là file. File descriptor là một số nguyên đại diện cho một file/socket đang mở. Lỗi xảy ra khi ứng dụng mở quá nhiều file/kết nối mà vượt ngưỡng cho phép của hệ thống (`ulimit`).
</details>

<details>
  <summary>Q10: "Zombie Process" là gì và làm thế nào để dọn dẹp chúng?</summary>
  
  **Trả lời:**
  Tiến trình con đã kết thúc nhưng chưa được tiến trình cha đọc trạng thái thoát. Zombie không tốn tài nguyên trừ 1 slot trong bảng process. Để dọn dẹp, phải gửi tín hiệu cho tiến trình cha hoặc restart tiến trình cha.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Thiết kế hệ thống High Availability (HA) ở mức Network layer dùng Keepalived/VRRP.</summary>
  
  **Trả lời:**
  Dùng 2 server cùng sở hữu một **Virtual IP (VIP)**. Một con là Master, con kia là Backup. Nếu Master sập, VIP tự động nhảy sang Backup qua giao thức VRRP, đảm bảo kết nối người dùng không bị đứt.
</details>

<details>
  <summary>Q2: Phân tích sự đánh đổi giữa các loại File System: Ext4 vs XFS vs Btrfs.</summary>
  
  **Trả lời:**

- Ext4: Ổn định nhất, phổ biến nhất.
- XFS: Tốt cho file lớn và đa luồng (multi-threaded I/O).
- Btrfs: Hiện đại, hỗ trợ Snapshot, RAID mềm, tự phục hồi lỗi bit nhưng tiêu tốn tài nguyên CPU/RAM hơn.

</details>

<details>
  <summary>Q3: Làm thế nào để bảo mật cứng (Hardening) một server Linux trên Internet?</summary>
  
  **Xử lý:** 1. Tắt SSH Password Auth (chỉ dùng Key). 2. Thay đổi cổng SSH mặc định. 3. Cài đặt Firewall (UFW/IPTables). 4. Cài đặt Fail2Ban. 5. Tắt các dịch vụ không dùng. 6. Cập nhật kernel/phần mềm thường xuyên.
</details>

<details>
  <summary>Q4: Tầm nhìn: Tại sao Container (Docker) lại sử dụng các tính năng Linux Namespaces và Cgroups?</summary>
  
  **Trả lời:**

- Namespaces: Cô lập tài nguyên (Process, Network, User) để các container không thấy nhau.
- Cgroups: Giới hạn tài nguyên (CPU, RAM) để 1 container không làm sập cả máy host. Đây là nền tảng của ảo hóa mức hệ điều hành.

</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Server bỗng dưng không cho tạo file mới dù lệnh `df` báo còn 50% dung lượng. Bạn kiểm tra gì?</summary>
  
  **Xử lý:** Kiểm tra Inodes bằng lệnh `df -i`. Thường do ứng dụng tạo quá nhiều file rác nhỏ (session, cache) làm cạn kiệt bảng Inode.
</details>

<details>
  <summary>S2: Bạn cần theo dõi log của ứng dụng theo thời gian thực và lọc ra các dòng có chứa chữ "ERROR". Lệnh nào?</summary>
  
  **Xử lý:** `tail -f /path/to/app.log | grep --line-buffered "ERROR"`.
</details>

## Nên biết

- Quyền hạn file (chmod, chown).
- Quản lý tiến trình (top, ps, kill).
- Thao tác file cơ bản (find, grep, cat, tail).

## Lưu ý

- Chạy lệnh `rm -rf /` (mất sạch hệ thống).
- Chỉnh sửa file cấu hình mà không backup file cũ.
- Để server Production chạy bằng user `root`.

## Mẹo và thủ thuật

- Dùng phím `Tab` để tự động hoàn thành lệnh/đường dẫn.
- Sử dụng `alias` để tạo các lệnh ngắn gọn cho những tổ hợp lệnh dài hay dùng.
