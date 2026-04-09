<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <style>
        .button {
            background-color: #f97316;
            border: none;
            color: white;
            padding: 12px 24px;
            text-align: center;
            text-decoration: none;
            display: inline-block;
            font-size: 16px;
            margin: 4px 2px;
            cursor: pointer;
            border-radius: 12px;
            font-weight: bold;
        }
        .container {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            max-width: 600px;
            margin: 0 auto;
            padding: 20px;
            border: 1px solid #e5e7eb;
            border-radius: 24px;
            background-color: #ffffff;
        }
        .header {
            background: linear-gradient(135deg, #f97316 0%, #ea580c 100%);
            padding: 30px;
            border-radius: 20px 20px 0 0;
            color: white;
            text-align: center;
        }
        .content {
            padding: 30px;
            color: #374151;
            line-height: 1.6;
        }
        .footer {
            padding: 20px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
        }
        .badge {
            background-color: #ffedd5;
            color: #9a3412;
            padding: 4px 12px;
            border-radius: 9999px;
            font-size: 12px;
            font-weight: bold;
            text-transform: uppercase;
        }
    </style>
</head>
<body style="background-color: #f9fafb; padding: 40px 0;">
    <div class="container">
        <div class="header">
            <h1 style="margin: 0; font-size: 24px;">Yêu cầu Phê duyệt Tệp</h1>
        </div>
        <div class="content">
            <p>Xin chào Admin,</p>
            <p>Một tệp mới đã được tải lên bởi khách và đang chờ bạn phê duyệt để được hiển thị công khai.</p>
            
            <div style="background-color: #f3f4f6; padding: 20px; border-radius: 16px; margin: 20px 0;">
                <p style="margin: 5px 0;"><strong>Tên tệp:</strong> {{ $file->name }}</p>
                <p style="margin: 5px 0;"><strong>Người gửi:</strong> <span class="badge">{{ $file->uploader_name }}</span></p>
                <p style="margin: 5px 0;"><strong>Kích thước:</strong> {{ number_format($file->size / 1024, 1) }} KB</p>
                <p style="margin: 5px 0;"><strong>Định dạng:</strong> {{ strtoupper(explode('/', $file->mime_type)[1] ?? 'FILE') }}</p>
            </div>

            <div style="text-align: center; margin-top: 30px;">
                <a href="{{ route('files.review') }}" class="button" style="color: #ffffff;">Truy cập Danh sách Chờ duyệt</a>
            </div>
            
            <p style="margin-top: 30px; font-size: 14px; color: #6b7280;">
                Nếu nút trên không hoạt động, bạn có thể copy link sau: <br>
                <a href="{{ route('files.review') }}" style="color: #f97316;">{{ route('files.review') }}</a>
            </p>
        </div>
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. Tất cả các quyền được bảo lưu.
        </div>
    </div>
</body>
</html>
