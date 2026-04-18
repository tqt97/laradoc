---
title: "Cấu trúc dữ liệu & Thuật toán trong PHP: Tư duy Giải thuật"
description: Hệ thống hơn 50 câu hỏi về Big-O, Sorting, Searching, Tree, Graph và tối ưu thuật toán trong PHP.
date: 2026-03-23
tags: [algorithm, data-structures, php, big-o, logic]
image: /prezet/img/ogimages/knowledge-vi-data-structures-algorithms-php.webp
---

> Thuật toán là nền tảng của mọi chương trình máy tính. Hiểu về DSA giúp bạn viết code không chỉ chạy đúng mà còn chạy nhanh và tiết kiệm tài nguyên.

## Người mới bắt đầu (Beginner)

<details>
  <summary>Q1: Thuật toán (Algorithm) là gì?</summary>
  
  **Trả lời:**
  Là một tập hợp các hướng dẫn từng bước để giải quyết một vấn đề cụ thể hoặc thực hiện một nhiệm vụ.
</details>

<details>
  <summary>Q2: Cấu trúc dữ liệu (Data Structure) là gì?</summary>
  
  **Trả lời:**
  Là một cách chuyên biệt để tổ chức, quản lý và lưu trữ dữ liệu trong máy tính để có thể truy cập và sửa đổi hiệu quả.
</details>

<details>
  <summary>Q3: Big-O notation dùng để làm gì?</summary>
  
  **Trả lời:**
  Dùng để đo lường độ phức tạp về thời gian (Time Complexity) và không gian (Space Complexity) của một thuật toán khi kích thước dữ liệu đầu vào (n) tăng lên.
</details>

<details>
  <summary>Q4: Mảng (Array) trong DSA khác gì mảng trong PHP?</summary>
  
  **Trả lời:**
  Trong DSA, mảng thường là tập hợp các phần tử có cùng kiểu dữ liệu nằm ở các vùng nhớ liên tiếp. Mảng PHP thực chất là một Ordered Hash Map phức tạp.
</details>

<details>
  <summary>Q5: Ngăn xếp (Stack) hoạt động theo nguyên tắc nào?</summary>
  
  **Trả lời:**
  LIFO (Last-In-First-Out) - Vào sau ra trước. Giống như một chồng đĩa, cái đặt vào cuối cùng sẽ được lấy ra đầu tiên.
</details>

<details>
  <summary>Q6: Hàng đợi (Queue) hoạt động theo nguyên tắc nào?</summary>
  
  **Trả lời:**
  FIFO (First-In-First-Out) - Vào trước ra trước. Giống như xếp hàng mua vé.
</details>

<details>
  <summary>Q7: Tìm kiếm tuần tự (Linear Search) hoạt động như thế nào?</summary>
  
  **Trả lời:**
  Kiểm tra từng phần tử của mảng từ đầu đến cuối cho đến khi tìm thấy giá trị mong muốn. Độ phức tạp O(n).
</details>

<details>
  <summary>Q8: Danh sách liên kết (Linked List) là gì?</summary>
  
  **Trả lời:**
  Là tập hợp các Node, mỗi Node chứa dữ liệu và một tham chiếu (con trỏ) tới Node tiếp theo.
</details>

<details>
  <summary>Q9: Thuật toán sắp xếp nổi bọt (Bubble Sort) ý tưởng chính là gì?</summary>
  
  **Trả lời:**
  Liên tục so sánh 2 phần tử kề nhau và hoán đổi nếu chúng sai thứ tự, làm cho phần tử lớn nhất "nổi" lên cuối mảng sau mỗi vòng lặp.
</details>

<details>
  <summary>Q10: Độ phức tạp O(1) nghĩa là gì?</summary>
  
  **Trả lời:**
  Thời gian thực thi không đổi, bất kể dữ liệu đầu vào lớn bao nhiêu (ví dụ: truy cập phần tử mảng qua index).
</details>

## Trung cấp (Intermediate)

<details>
  <summary>Q1: Tìm kiếm nhị phân (Binary Search) yêu cầu điều kiện gì của mảng?</summary>
  
  **Trả lời:**
  Mảng phải được **sắp xếp**. Nó liên tục chia đôi mảng để tìm, độ phức tạp cực nhanh O(log n).
</details>

<details>
  <summary>Q2: Hash Table (Bảng băm) giải quyết vấn đề gì?</summary>
  
  **Trả lời:**
  Giúp tìm kiếm, thêm, xóa dữ liệu với độ phức tạp trung bình O(1) bằng cách sử dụng hàm băm (Hash function) để biến Key thành chỉ số mảng.
</details>

<details>
  <summary>Q3: Đệ quy (Recursion) là gì? Cần lưu ý gì để tránh treo máy?</summary>
  
  **Trả lời:**
  Hàm tự gọi lại chính nó. Cần phải có **điểm dừng (base case)** để tránh vòng lặp vô tận gây lỗi Stack Overflow.
</details>

<details>
  <summary>Q4: Sự khác biệt giữa Set và Array?</summary>
  
  **Trả lời:**
  Set chỉ chứa các phần tử **duy nhất** (không trùng lặp) và thường không đảm bảo thứ tự. Array cho phép trùng lặp và có thứ tự.
</details>

<details>
  <summary>Q5: Phân biệt Tree và Graph.</summary>
  
  **Trả lời:**
  Tree là một dạng đặc biệt của Graph: không có chu trình (cycle) và các node kết nối phân cấp. Graph có thể kết nối tùy ý và có chu trình.
</details>

<details>
  <summary>Q6: Tại sao Quicksort lại nhanh hơn Bubble Sort?</summary>
  
  **Trả lời:**
  Quicksort dùng chiến thuật "Chia để trị" (Divide and Conquer), độ phức tạp trung bình O(n log n), trong khi Bubble Sort là O(n²).
</details>

<details>
  <summary>Q7: Binary Search Tree (BST) là gì?</summary>
  
  **Trả lời:**
  Cây nhị phân mà node bên trái luôn nhỏ hơn node cha, node bên phải luôn lớn hơn node cha.
</details>

<details>
  <summary>Q8: "Collision" trong Hash Table là gì? Cách xử lý cơ bản?</summary>
  
  **Trả lời:**
  Khi 2 Key khác nhau qua hàm băm cho ra cùng 1 chỉ số. Cách xử lý: Chaining (dùng Linked List tại chỉ số đó) hoặc Open Addressing.
</details>

<details>
  <summary>Q9: Giải thích độ phức tạp O(n log n).</summary>
  
  **Trả lời:**
  Thường xuất hiện trong các thuật toán chia để trị hiệu quả (Merge Sort, Heap Sort). Tốc độ tăng trưởng nhanh hơn O(n) nhưng chậm hơn nhiều so với O(n²).
</details>

<details>
  <summary>Q10: Priority Queue (Hàng đợi ưu tiên) là gì?</summary>
  
  **Trả lời:**
  Giống Queue nhưng mỗi phần tử có một độ ưu tiên. Phần tử có ưu tiên cao hơn sẽ được lấy ra trước.
</details>

## Nâng cao (Advanced)

<details>
  <summary>Q1: Giải thích thuật toán Sắp xếp nhanh (Quick Sort) và cách chọn Pivot.</summary>
  
  **Trả lời:**
  Chọn 1 phần tử làm Pivot -> Phân đoạn mảng thành 2 phần (nhỏ hơn Pivot và lớn hơn Pivot) -> Đệ quy cho từng phần. Việc chọn Pivot (đầu, cuối, giữa, hoặc ngẫu nhiên) ảnh hưởng lớn đến việc tránh trường hợp xấu nhất O(n²).
</details>

<details>
  <summary>Q2: Duyệt cây (Tree Traversal): Phân biệt In-order, Pre-order và Post-order.</summary>
  
  **Trả lời:**

- Pre-order: Gốc -> Trái -> Phải.
- In-order: Trái -> Gốc -> Phải (Duyệt BST sẽ ra mảng tăng dần).
- Post-order: Trái -> Phải -> Gốc.

</details>

<details>
  <summary>Q3: Thuật toán tìm đường đi ngắn nhất Dijkstra hoạt động như thế nào?</summary>
  
  **Trả lời:**
  Dùng để tìm đường đi ngắn nhất từ 1 đỉnh đến tất cả các đỉnh còn lại trong đồ thị có trọng số không âm. Dùng chiến thuật tham lam (Greedy) và Priority Queue.
</details>

<details>
  <summary>Q4: Quy hoạch động (Dynamic Programming) khác gì đệ quy thông thường?</summary>
  
  **Trả lời:**
  DP giải quyết các bài toán con chồng chéo và lưu lại kết quả (Memoization) để không phải tính lại, biến O(2ⁿ) thành O(n).
</details>

<details>
  <summary>Q5: Giải thích về Cân bằng cây (AVL Tree, Red-Black Tree).</summary>
  
  **Trả lời:**
  Các loại cây tự cân bằng để đảm bảo chiều cao luôn là log n, giúp các thao tác tìm kiếm/thêm/xóa luôn duy trì được tốc độ O(log n) ngay cả trong trường hợp xấu nhất.
</details>

<details>
  <summary>Q6: BFS (Breadth-First Search) và DFS (Depth-First Search) trên Đồ thị.</summary>
  
  **Trả lời:**
  BFS dùng Queue (duyệt theo tầng). DFS dùng Stack/Đệ quy (đi sâu nhất có thể trước khi quay lại).
</details>

<details>
  <summary>Q7: Giải thích độ phức tạp O(2ⁿ) và O(n!).</summary>
  
  **Trả lời:**
  Độ phức tạp lũy thừa và giai thừa. Cực kỳ chậm, chỉ xử lý được n rất nhỏ (ví dụ: bài toán người giao hàng, tìm tập con).
</details>

<details>
  <summary>Q8: Thuật toán KMP (Knuth-Morris-Pratt) dùng để làm gì?</summary>
  
  **Trả lời:**
  Tìm kiếm chuỗi con trong chuỗi mẹ một cách hiệu quả O(n+m) bằng cách sử dụng mảng tiền tố để không phải quay lại vị trí cũ khi so khớp lỗi.
</details>

<details>
  <summary>Q9: Giải thích khái niệm "Trie" (Prefix Tree).</summary>
  
  **Trả lời:**
  Cấu trúc cây dùng để lưu trữ các chuỗi ký tự, cực kỳ hiệu quả cho tính năng Auto-complete hoặc kiểm tra từ điển.
</details>

<details>
  <summary>Q10: Sự đánh đổi giữa Time Complexity và Space Complexity.</summary>
  
  **Trả lời:**
  Đôi khi chúng ta dùng thêm bộ nhớ (Space) để giảm thời gian tính toán (Time). Ví dụ: Caching, Hash Table, Memoization.
</details>

## Kiến trúc sư (Architect)

<details>
  <summary>Q1: Phân tích cấu trúc dữ liệu của một Search Engine lớn.</summary>
  
  **Trả lời:**
  Sử dụng **Inverted Index** (Bản mục lục đảo ngược). Key là các từ khóa, Value là danh sách các Document ID chứa từ đó. Kết hợp với Trie để tìm kiếm nhanh và Ranking Algorithm (như PageRank).
</details>

<details>
  <summary>Q2: Làm thế nào để lưu trữ và truy vấn "Bạn của bạn" trong mạng xã hội có tỷ người dùng?</summary>
  
  **Trả lời:**
  Sử dụng **Graph Database** (như Neo4j). Biểu diễn User là Node, quan hệ "Friend" là Edge. Truy vấn dùng BFS với giới hạn độ sâu (Depth limit).
</details>

<details>
  <summary>Q3: Thiết kế cấu trúc dữ liệu cho hệ thống tính toán tọa độ (Uber/Grab).</summary>
  
  **Trả lời:**
  Sử dụng **Quadtree** hoặc **Geohash**. Chia bản đồ thành các vùng không gian để thu hẹp phạm vi tìm kiếm tài xế gần nhất thay vì so sánh với tất cả tài xế.
</details>

<details>
  <summary>Q4: Phân tích thuật toán đồng thuận (Consensus Algorithms) như Raft hoặc Paxos.</summary>
  
  **Trả lời:**
  Dùng trong hệ thống phân tán để các node thống nhất về một giá trị duy nhất (ví dụ: chọn Leader, commit transaction) ngay cả khi có node sập hoặc mạng lỗi.
</details>

<details>
  <summary>Q5: Thiết kế hệ thống Rate Limiting ở quy mô khổng lồ.</summary>
  
  **Trả lời:**
  Dùng thuật toán **Token Bucket** lưu trong Redis. Sử dụng Lua Script để đảm bảo tính nguyên tử (Atomicity) khi trừ token và kiểm tra thời gian.
</details>

<details>
  <summary>Q6: Làm thế nào để tìm Top 100 từ khóa xu hướng trong stream dữ liệu khổng lồ (realtime)?</summary>
  
  **Trả lời:**
  Sử dụng thuật toán **Count-Min Sketch** (cấu trúc dữ liệu xác suất) để đếm tần suất xấp xỉ mà không tốn nhiều bộ nhớ, kết hợp với Min-Heap để giữ Top K.
</details>

<details>
  <summary>Q7: Phân tích kiến trúc của mảng PHP (Zend HashTable) dưới góc độ DSA.</summary>
  
  **Trả lời:**
  Mảng PHP là sự kết hợp của: 1. Hash Table (truy cập key O(1)). 2. Doubly Linked List (duy trì thứ tự thêm vào). Nó cực kỳ linh hoạt nhưng tốn bộ nhớ gấp nhiều lần so với mảng thuần của C/Java.
</details>

<details>
  <summary>Q8: Thiết kế hệ thống Undo/Redo cho một trình soạn thảo văn bản.</summary>
  
  **Trả lời:**
  Sử dụng 2 Stack: `undoStack` và `redoStack`. Khi có thao tác mới -> đẩy vào undoStack. Khi Undo -> lấy từ undoStack đẩy sang redoStack. Dùng Command Pattern để đóng gói các thao tác.
</details>

<details>
  <summary>Q9: Khi nào bạn nên dùng mảng thường (SplFixedArray) thay vì mảng PHP mặc định?</summary>
  
  **Trả lời:**
  Khi xử lý tập dữ liệu cực lớn (hàng triệu phần tử) và biết trước kích thước. `SplFixedArray` tiết kiệm bộ nhớ hơn và nhanh hơn vì nó là mảng thực sự trong bộ nhớ, không có overhead của Hash Map.
</details>

<details>
  <summary>Q10: Giải thích bài toán P vs NP (tầm nhìn Architect).</summary>
  
  **Trả lời:**
  P là những bài toán giải được nhanh. NP là những bài toán mà nếu có đáp án, ta kiểm tra lại rất nhanh nhưng chưa tìm được cách giải nhanh. Hầu hết các bài toán tối ưu thực tế (như sắp xếp lịch trình) là NP-Hard. Kỹ sư phải dùng thuật toán xấp xỉ (Heuristic) thay vì tìm đáp án tuyệt đối.
</details>

## Tình huống thực tế (Practical Scenarios)

<details>
  <summary>S1: Bạn cần kiểm tra xem 1 email đã tồn tại trong danh sách 100 triệu email chưa. Dùng gì?</summary>
  
  **Xử lý:** Dùng **Bloom Filter**. Nó cho phép kiểm tra cực nhanh và tốn rất ít RAM. Nếu nó bảo "Chưa có" thì chắc chắn chưa có. Nếu bảo "Có rồi" thì có thể sai số nhỏ (cần check lại trong DB).
</details>

<details>
  <summary>S2: Sắp xếp 1 file dữ liệu 10GB trên máy tính chỉ có 2GB RAM. Cách làm?</summary>
  
  **Xử lý:** Dùng **External Merge Sort**. Chia file thành nhiều mảnh nhỏ 1GB -> Sắp xếp từng mảnh -> Gộp (Merge) các mảnh đã sắp xếp lại với nhau.
</details>

## Nên biết

- Hiểu bản chất của Big-O.
- Biết khi nào dùng Array vs Hash Map.
- Thuật toán Tìm kiếm nhị phân.

## Lưu ý

- Sử dụng đệ quy quá sâu mà không có đuôi (Tail call optimization không được hỗ trợ tốt trong PHP cũ).
- Dùng mảng PHP làm Stack/Queue cho dữ liệu khổng lồ (tốn RAM không cần thiết).
- Quên rằng `in_array()` là O(n), trong khi `isset($map[$key])` là O(1).

## Mẹo và thủ thuật

- Luôn ưu tiên dùng các hàm có sẵn của PHP (đã được tối ưu bằng C) thay vì tự viết lại thuật toán bằng PHP.
- Dùng thư viện `Spl` (Standard PHP Library) khi cần các cấu trúc dữ liệu chuẩn như `SplStack`, `SplQueue`, `SplPriorityQueue`.
