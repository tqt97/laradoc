<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Models\Idea;
use App\Services\IdeaService;
use App\Support\PrezetHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;

class IdeaController extends Controller
{
    public function __construct(
        protected IdeaService $ideaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request): View
    {
        return view('ideas.index', array_merge([
            'ideas' => $this->ideaService->getPaginatedIdeas($request),
            'categories' => $this->ideaService->getUniqueCategories(),
            'seo' => PrezetHelper::getSeoData('Gợi ý Bài viết & Ý tưởng Phát triển', 'Hãy gửi các yêu cầu về chủ đề bài viết hoặc ý tưởng kỹ thuật mà bạn muốn tuantq.online chia sẻ.'),
        ], PrezetHelper::getCommonData()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreIdeaRequest $request): JsonResponse
    {
        $this->ideaService->createIdea($request->validated());

        return response()->json([
            'message' => 'Cảm ơn bạn đã đóng góp ý tưởng!',
        ]);
    }

    /**
     * Toggle vote for an idea.
     */
    public function toggleVote(Request $request, Idea $idea): JsonResponse
    {
        $isVoted = $this->ideaService->toggleVote($idea, $request);

        return response()->json([
            'message' => $isVoted ? 'Cảm ơn bạn đã bình chọn!' : 'Đã bỏ bình chọn.',
            'votes_count' => $idea->fresh()->votes_count,
            'is_voted' => $isVoted,
        ]);
    }

    /**
     * Get the partial list of ideas for AJAX updates.
     */
    public function list(Request $request): View
    {
        return view('ideas.partials.list', [
            'ideas' => $this->ideaService->getPaginatedIdeas($request),
        ]);
    }

    /**
     * Update an idea (for admin).
     */
    public function update(Request $request, Idea $idea): JsonResponse
    {
        $this->authorize('manage-ideas');

        $request->validate([
            'status' => 'required|in:submitted,published',
            'post_slug' => 'nullable|string',
        ]);

        $idea->update($request->only('status', 'post_slug'));

        return response()->json([
            'message' => 'Cập nhật ý tưởng thành công!',
            'idea' => $idea,
        ]);
    }

    /**
     * Remove an idea (for admin).
     */
    public function destroy(Idea $idea): JsonResponse
    {
        $this->authorize('manage-ideas');

        $idea->delete();

        return response()->json([
            'message' => 'Xóa ý tưởng thành công!',
        ]);
    }
}
