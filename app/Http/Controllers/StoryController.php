<?php

namespace App\Http\Controllers;

use App\Services\StoryService;
use App\Support\PrezetHelper;
use Illuminate\Contracts\View\View;
use Illuminate\Http\Request;
use Prezet\Prezet\Prezet;

class StoryController extends Controller
{
    public function __construct(
        protected StoryService $storyService
    ) {}

    public function index(Request $request): View
    {
        $search = $request->input('q');
        $tag = $request->input('tag');
        $data = $this->storyService->getPaginatedStories($search, $tag);

        $title = $tag ? "Thẻ: {$tag}" : 'Nhật ký & Những câu chuyện';

        return view('stories.index', array_merge([
            'stories' => $data['stories'],
            'paginator' => $data['paginator'],
            'search' => $search,
            'currentTag' => $tag,
            'seo' => PrezetHelper::getSeoData($title, 'Nơi ghi lại những câu chuyện, hành trình và trải nghiệm cá nhân của tôi qua từng ngày.', null, config('prezet.seo.default_image')),
        ], PrezetHelper::getCommonData()));
    }

    public function show($slug): View
    {
        $story = $this->storyService->getStoryBySlug($slug);
        $md = Prezet::getMarkdown($story->filepath);
        $html = Prezet::parseMarkdown($md)->getContent();

        return view('stories.show', array_merge([
            'story' => $story,
            'body' => $html,
            'slug' => $slug,
            'headings' => Prezet::getHeadings($html),
            'relatedStories' => $this->storyService->getRelatedStories($story),
            'previousStory' => $this->storyService->getPreviousStory($story),
            'nextStory' => $this->storyService->getNextStory($story),
            'seo' => PrezetHelper::getSeoData(
                $story->frontmatter->title,
                $story->frontmatter->excerpt,
                null,
                $story->frontmatter->image ? url($story->frontmatter->image) : null,
                [
                    'type' => 'article',
                    'published_time' => $story->createdAt?->toIso8601String(),
                    'section' => 'Stories',
                    'tags' => $story->frontmatter->tags ?? [],
                    'author' => config('prezet.seo.author'),
                ]
            ),
        ], PrezetHelper::getCommonData()));
    }
}
