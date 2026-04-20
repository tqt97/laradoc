<?php

namespace App\Services;

use App\Models\PrezetDocument;
use App\Support\PrezetHelper;
use Illuminate\Support\Str;
use Prezet\Prezet\Data\DocumentData;

class StoryService
{
    /**
     * Get paginated stories.
     */
    public function getPaginatedStories(?string $search = null, ?string $tag = null, int $perPage = 10): array
    {
        $query = PrezetDocument::active()->stories();

        if ($search) {
            $query->search($search);
        }

        if ($tag) {
            $query->whereHas('tags', fn ($q) => $q->where('name', $tag));
        }

        $paginator = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $stories = $paginator->getCollection()->map(function ($doc) {
            $docData = app(DocumentData::class)::fromModel($doc);
            $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

            return $docData;
        });

        return [
            'stories' => $stories,
            'paginator' => $paginator,
        ];
    }

    /**
     * Get a specific story by slug.
     */
    public function getStoryBySlug(string $slug): object
    {
        $doc = PrezetDocument::active()
            ->stories()
            ->where('slug', 'stories/'.$slug)
            ->firstOrFail();

        $docData = app(DocumentData::class)::fromModel($doc);
        $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

        // Add raw created_at and slug for easier navigation
        $docData->rawCreatedAt = $doc->created_at;
        $docData->relativeSlug = $slug;

        return $docData;
    }

    /**
     * Get the previous story based on creation date.
     */
    public function getPreviousStory(object $story): ?object
    {
        $date = $story->rawCreatedAt ?? $story->createdAt;

        $doc = PrezetDocument::active()
            ->stories()
            ->where('created_at', '<', $date)
            ->orderBy('created_at', 'desc')
            ->first();

        if (! $doc) {
            return null;
        }

        $docData = app(DocumentData::class)::fromModel($doc);
        $docData->relativeSlug = Str::after($doc->slug, 'stories/');

        return $docData;
    }

    /**
     * Get the next story based on creation date.
     */
    public function getNextStory(object $story): ?object
    {
        $date = $story->rawCreatedAt ?? $story->createdAt;

        $doc = PrezetDocument::active()
            ->stories()
            ->where('created_at', '>', $date)
            ->orderBy('created_at', 'asc')
            ->first();

        if (! $doc) {
            return null;
        }

        $docData = app(DocumentData::class)::fromModel($doc);
        $docData->relativeSlug = Str::after($doc->slug, 'stories/');

        return $docData;
    }

    /**
     * Get related stories.
     */
    public function getRelatedStories(object $story, int $limit = 3)
    {
        $tags = $story->frontmatter->tags ?? [];

        $query = PrezetDocument::active()
            ->stories()
            ->where('slug', '!=', 'stories/'.$story->slug);

        if (! empty($tags)) {
            $query->where(function ($q) use ($tags) {
                foreach ($tags as $tag) {
                    $q->orWhere('frontmatter->tags', 'like', "%{$tag}%");
                }
            });
        }

        return $query->inRandomOrder()
            ->limit($limit)
            ->get()
            ->map(function ($doc) {
                $docData = app(DocumentData::class)::fromModel($doc);
                $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

                return $docData;
            });
    }
}
