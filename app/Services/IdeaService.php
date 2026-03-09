<?php

namespace App\Services;

use App\Mail\IdeaSubmitted;
use App\Models\Idea;
use App\Models\IdeaVote;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Mail;

class IdeaService
{
    /**
     * Get paginated ideas with filters and search.
     */
    public function getPaginatedIdeas(Request $request, int $perPage = 10): LengthAwarePaginator
    {
        $query = Idea::query();

        // Search by name or user_name
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('user_name', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%");
            });
        }

        // Filter by status
        if ($request->filled('status') && $request->status !== 'all') {
            $query->where('status', $request->status);
        }

        // Filter by category
        if ($request->filled('category') && $request->category !== 'all') {
            $query->where('category', 'like', "%{$request->category}%");
        }

        // Sorting
        $sort = $request->get('sort', 'latest');
        switch ($sort) {
            case 'oldest':
                $query->orderBy('created_at', 'asc');
                break;
            case 'top':
                $query->orderBy('votes_count', 'desc')->orderBy('created_at', 'desc');
                break;
            case 'latest':
            default:
                $query->orderBy('created_at', 'desc');
                break;
        }

        $ideas = $query->paginate($perPage)->withQueryString();

        // Attach voted status for current IP
        $ip = $request->ip();
        $votedIdeaIds = IdeaVote::where('ip_address', $ip)
            ->whereIn('idea_id', $ideas->pluck('id'))
            ->pluck('idea_id')
            ->toArray();

        foreach ($ideas as $idea) {
            $idea->is_voted = in_array($idea->id, $votedIdeaIds);
        }

        return $ideas;
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
        $idea = Idea::create([
            'user_name' => $data['user_name'] ?? null,
            'email' => $data['email'] ?? null,
            'name' => $data['name'],
            'category' => $data['category'] ?? null,
            'reference' => $data['reference'] ?? null,
            'status' => 'submitted',
        ]);

        if ($idea->email) {
            Mail::to($idea->email)->send(new IdeaSubmitted($idea));
        }

        return $idea;
    }

    /**
     * Toggle vote for an idea.
     * Returns true if voted, false if unvoted.
     */
    public function toggleVote(Idea $idea, Request $request): bool
    {
        $ip = $request->ip();

        $vote = IdeaVote::where('idea_id', $idea->id)
            ->where('ip_address', $ip)
            ->first();

        if ($vote) {
            $vote->delete();
            $idea->decrement('votes_count');

            return false;
        }

        IdeaVote::create([
            'idea_id' => $idea->id,
            'ip_address' => $ip,
            'user_agent' => $request->userAgent(),
        ]);

        $idea->increment('votes_count');

        return true;
    }
}
