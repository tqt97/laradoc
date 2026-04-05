<?php

namespace App\Models;

use App\Enums\FileModerationStatus;
use App\Enums\FileUploadStatus;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'slug', 'path', 'mime_type', 'size', 'disk',
        'status_upload', 'status_moderation',
        'is_public', 'share_token', 'password', 'user_id',
        'uploader_name',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_public' => 'boolean',
        'password' => 'hashed',
        'status_upload' => FileUploadStatus::class,
        'status_moderation' => FileModerationStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($file) {
            if (empty($file->slug)) {
                $file->slug = Str::slug($file->name).'-'.Str::random(5);
            }
        });
    }

    public function getRouteKeyName()
    {
        return 'slug';
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function isPasswordProtected(): bool
    {
        return ! empty($this->password);
    }

    public function isApproved(): bool
    {
        return $this->status_moderation === FileModerationStatus::APPROVED;
    }

    public function isPending(): bool
    {
        return $this->status_moderation === FileModerationStatus::PENDING;
    }
}
