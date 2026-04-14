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
    public function getPaginatedKnowledge(?string $search = null, int $perPage = 10): array
    {
        $query = PrezetDocument::active()->inPath('knowledge/vi');

        if ($search) {
            $query->search($search);
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
}
