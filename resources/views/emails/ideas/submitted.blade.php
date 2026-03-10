<x-mail::message>
# 🎯 Ting tinh! Ý tưởng xịn xò của bạn đã tới tay chúng mình rồi nè!

Chào **{{ $idea->user_name ?: 'người bạn bí ẩn' }}**,

Wow! Cảm ơn bạn đã tin tưởng gửi gắm ý tưởng cho **{{ config('app.name') }}**. Chúng mình đã "bắt" được nó và đang cất giữ cẩn thận trong danh sách chờ rồi đây.

<x-mail::panel>
**Ý tưởng của bạn:**
{{ $idea->name }}
</x-mail::panel>

### 🕒 Điều gì sẽ xảy ra tiếp theo?
1. **Xét duyệt:** Chúng mình sẽ xem xét nội dung và tính khả thi của ý tưởng.
2. **Bình chọn:** Cộng đồng có thể tham gia bình chọn để giúp ý tưởng của bạn được ưu tiên viết bài sớm hơn.
3. **Thông báo:** Khi bài viết chính thức được xuất bản, bạn sẽ nhận được một email thông báo kèm đường dẫn trực tiếp.

Bạn có thể theo dõi tiến độ và xem các ý tưởng khác tại đây:

<x-mail::button :url="route('ideas.index')" color="primary">
Xem danh sách ý tưởng
</x-mail::button>

Cảm ơn bạn đã đồng hành cùng chúng mình trong việc xây dựng kho tàng kiến thức hữu ích!

Trân trọng,<br>
**{{ config('app.name') }} Team**
</x-mail::message>
