<?php

namespace App\Services;

use App\Models\PrezetDocument;
use App\Support\PrezetHelper;
use Prezet\Prezet\Data\DocumentData;

class KnowledgeService
{
    /**
     * Get paginated knowledge reviews.
     */
    public function getPaginatedKnowledge(?string $search = null, ?string $tag = null, int $perPage = 10): array
    {
        $query = PrezetDocument::active()->inPath('knowledge');

        if ($search) {
            $query->search($search);
        }

        if ($tag) {
            $query->whereHas('tags', fn ($q) => $q->where('name', $tag));
        }

        $paginator = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $knowledge = $paginator->getCollection()->map(function ($doc) {
            $docData = app(DocumentData::class)::fromModel($doc);
            $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

            return $docData;
        });

        return [
            'knowledge' => $knowledge,
            'paginator' => $paginator,
        ];
    }

    /**
     * Get a specific knowledge review by slug.
     */
    public function getKnowledgeBySlug(string $slug): object
    {
        $doc = PrezetDocument::active()
            ->inPath('knowledge')
            ->where('slug', 'knowledge/'.$slug)
            ->firstOrFail();

        $docData = app(DocumentData::class)::fromModel($doc);
        $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

        return $docData;
    }

    /**
     * Get related knowledge reviews.
     */
    public function getRelatedKnowledge(object $knowledge, int $limit = 3)
    {
        $tags = $knowledge->frontmatter->tags ?? [];

        $query = PrezetDocument::active()
            ->inPath('knowledge')
            ->where('slug', '!=', 'knowledge/'.$knowledge->slug);

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
