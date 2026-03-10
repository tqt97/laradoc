<x-mail::message>
# 🎊 Bùm chíu! Ý tưởng của bạn đã chính thức "lên sàn" rồi nè!

Chào **{{ $idea->user_name ?: 'người bạn tuyệt vời' }}**,

Tin cực nóng đây! Ý tưởng "triệu đô" mà bạn đã gợi ý cho **{{ config('app.name') }}** cuối cùng đã được chúng mình "phù phép" thành một bài viết cực kỳ xịn xò rồi đó.

<x-mail::panel>
**Chủ đề:**
# {{ $document->frontmatter->title }}
</x-mail::panel>

Ý tưởng ban đầu của bạn: *{{ Str::limit($idea->name, 100) }}*

Đây là thành quả từ sự gợi ý tuyệt vời của bạn và sự quan tâm từ cộng đồng thông qua các lượt bình chọn. Hy vọng bài viết này sẽ mang lại nhiều giá trị cho bạn và những người đọc khác.

<x-mail::button :url="route('prezet.show', $document->slug)" color="success">
📖 Đọc bài viết ngay
</x-mail::button>

Một lần nữa, cảm ơn bạn đã đóng góp ý tưởng giúp nội dung trên **{{ config('app.name') }}** ngày càng phong phú và hữu ích hơn. Nếu bạn có thêm những ý tưởng mới, đừng ngần ngại chia sẻ với chúng mình nhé!

Chúc bạn một ngày làm việc hiệu quả và tràn đầy cảm hứng!

Trân trọng,<br>
**{{ config('app.name') }} Team**
</x-mail::message>
