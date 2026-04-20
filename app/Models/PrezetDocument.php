<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Prezet\Prezet\Models\Document;
use Prezet\Prezet\Models\Tag;

class PrezetDocument extends Document
{
    /**
     * The table associated with the model.
     *
     * @var string
     */
    protected $table = 'documents';

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'document_tags', 'document_id', 'tag_id');
    }

    /**
     * Scope a query to only include published documents.
     */
    public function scopeActive(Builder $query): Builder
    {
        return $query->where('draft', false);
    }

    /**
     * Scope a query to include documents from a specific path.
     */
    public function scopeInPath(Builder $query, string $path): Builder
    {
        return $query->where('filepath', 'like', "content/{$path}%");
    }

    /**
     * Scope a query to only include blog posts.
     */
    public function scopeBlogs(Builder $query): Builder
    {
        return $query->where('content_type', 'article')
            ->where('filepath', 'like', 'content/blogs%');
    }

    /**
     * Scope a query to only include series posts.
     */
    public function scopeSeries(Builder $query): Builder
    {
        return $query->where('filepath', 'like', 'content/series/%');
    }

    /**
     * Scope a query to only include snippets.
     */
    public function scopeSnippets(Builder $query): Builder
    {
        return $query->where('filepath', 'like', 'content/snippets%');
    }

    /**
     * Scope a query to only include stories.
     */
    public function scopeStories(Builder $query): Builder
    {
        return $query->where('filepath', 'like', 'content/stories%');
    }

    /**
     * Scope a query to search by title or content.
     */
    public function scopeSearch(Builder $query, ?string $term): Builder
    {
        if (empty($term)) {
            return $query;
        }

        return $query->where(function ($q) use ($term) {
            $q->where('frontmatter->title', 'like', "%{$term}%")
                ->orWhere('content', 'like', "%{$term}%");
        });
    }
}
