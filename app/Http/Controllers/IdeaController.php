<?php

namespace App\Http\Controllers;

use App\Models\Idea;
use App\Support\PrezetHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Prezet\Prezet\Models\Document;

class IdeaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        $ideas = Idea::latest()->paginate(20);

        // Get categories from Ideas table
        $ideaCategories = Idea::whereNotNull('category')->distinct()->pluck('category');

        // Get categories from Prezet blog posts
        $blogCategories = app(Document::class)::query()
            ->where('content_type', 'article')
            ->where('draft', false)
            ->whereNotNull('category')
            ->distinct()
            ->pluck('category');

        // Merge and unique categories
        $categories = $ideaCategories->concat($blogCategories)->unique()->sort();

        return view('ideas.index', array_merge([
            'ideas' => $ideas,
            'categories' => $categories,
            'seo' => PrezetHelper::getSeoData('Ý tưởng nội dung', 'Đề xuất ý tưởng nội dung cho website.'),
        ], PrezetHelper::getCommonData()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'nullable|string|max:255',
            'reference' => 'nullable|url|max:255',
        ]);

        Idea::create([
            'name' => $request->name,
            'category' => $request->category,
            'reference' => $request->reference,
            'status' => 'submitted',
        ]);

        return back()->with('success', 'Cảm ơn bạn đã đóng góp ý tưởng!');
    }
}
