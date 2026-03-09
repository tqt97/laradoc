<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class IdeaVote extends Model
{
    protected $fillable = [
        'idea_id',
        'ip_address',
        'user_agent',
    ];

    /**
     * Get the idea that was voted for.
     */
    public function idea(): BelongsTo
    {
        return $this->belongsTo(Idea::class);
    }
}
