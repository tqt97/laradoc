<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Idea extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_name',
        'email',
        'name',
        'category',
        'status',
        'reference',
        'votes_count',
    ];

    /**
     * Get the votes for the idea.
     */
    public function votes(): HasMany
    {
        return $this->hasMany(IdeaVote::class);
    }
}
