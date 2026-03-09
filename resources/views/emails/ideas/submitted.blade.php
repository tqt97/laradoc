<x-mail::message>
# Cảm ơn bạn đã đóng góp ý tưởng!

Chào {{ $idea->user_name ?: 'bạn' }},

Chúng mình đã nhận được ý tưởng của bạn:

**{{ $idea->name }}**

Ý tưởng của bạn hiện đang ở trạng thái **Đang chờ**. Chúng mình sẽ xem xét và phản hồi sớm nhất có thể.

Bạn có thể theo dõi danh sách ý tưởng và bình chọn tại đây:

<x-mail::button :url="route('ideas.index')">
Xem danh sách ý tưởng
</x-mail::button>

Cảm ơn bạn đã đồng hành cùng {{ config('app.name') }}!

Trân trọng,<br>
{{ config('app.name') }}
</x-mail::message>
