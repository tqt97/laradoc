<?php

namespace App\Enums;

enum FileUploadStatus: int
{
    case UPLOADING = 0;
    case PROCESSING = 1;
    case READY = 2;

    public function label(): string
    {
        return match ($this) {
            self::UPLOADING => 'Đang tải lên',
            self::PROCESSING => 'Đang xử lý',
            self::READY => 'Sẵn sàng',
        };
    }
}
