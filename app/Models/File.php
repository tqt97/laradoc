<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'path', 'mime_type', 'size', 'disk',
        'is_public', 'share_token', 'password',
    ];

    protected $hidden = ['password'];

    protected $casts = [
        'is_public' => 'boolean',
        'password' => 'hashed',
    ];

    public function isPasswordProtected(): bool
    {
        return ! empty($this->password);
    }
}
