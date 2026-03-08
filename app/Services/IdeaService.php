<?php

namespace App\Services;

use App\Models\Idea;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;

class IdeaService
{
    /**
     * Get paginated ideas.
     */
    public function getPaginatedIdeas(int $perPage = 10): LengthAwarePaginator
    {
        return Idea::orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Get unique categories from ideas.
     */
    public function getUniqueCategories(): Collection
    {
        return Idea::whereNotNull('category')
            ->get(['category'])
            ->flatMap(fn ($idea) => explode(',', $idea->category))
            ->map(fn ($cat) => trim($cat))
            ->filter()
            ->unique()
            ->values();
    }

    /**
     * Store a new idea.
     */
    public function createIdea(array $data): Idea
    {
        return Idea::create([
            'user_name' => $data['user_name'] ?? null,
            'name' => $data['name'],
            'category' => $data['category'] ?? null,
            'reference' => $data['reference'] ?? null,
            'status' => 'submitted',
        ]);
    }
}
