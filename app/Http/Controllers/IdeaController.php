<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreIdeaRequest;
use App\Services\IdeaService;
use App\Support\PrezetHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\JsonResponse;

class IdeaController extends Controller
{
    public function __construct(
        protected IdeaService $ideaService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('ideas.index', [
            'ideas' => $this->ideaService->getPaginatedIdeas(),
            'categories' => $this->ideaService->getUniqueCategories(),
            'seo' => PrezetHelper::getSeoData('Đề xuất ý tưởng'),
        ]);
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
     * Get the partial list of ideas for AJAX updates.
     */
    public function list(): View
    {
        return view('ideas.partials.list', [
            'ideas' => $this->ideaService->getPaginatedIdeas(),
        ]);
    }
}
