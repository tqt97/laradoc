<?php

namespace App\Services;

use App\Models\PrezetDocument;
use App\Support\PrezetCache;
use App\Support\PrezetHelper;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Cache;
use Prezet\Prezet\Data\DocumentData;
use Prezet\Prezet\Prezet;

class ArticleService
{
    /**
     * Get the latest blog articles.
     */
    public function getLatestArticles(int $limit = 6): Collection
    {
        return PrezetDocument::active()
            ->blogs()
            ->orderBy('created_at', 'desc')
            ->limit($limit)
            ->get()
            ->map(fn ($doc) => $this->mapToArticleData($doc));
    }

    /**
     * Get paginated articles with optional filtering.
     */
    public function getPaginatedArticles(?string $category = null, ?string $tag = null, int $perPage = 10): LengthAwarePaginator
    {
        $query = PrezetDocument::active()->blogs();

        if ($category) {
            $query->whereRaw('LOWER(category) = ?', [strtolower($category)]);
        } elseif ($tag) {
            $query->whereHas('tags', fn ($q) => $q->where('name', $tag));
        }

        $paginator = $query->orderBy('created_at', 'desc')->paginate($perPage);

        $paginator->setCollection(
            $paginator->getCollection()->map(fn ($doc) => $this->mapToArticleData($doc))
        );

        return $paginator;
    }

    /**
     * Get articles grouped by category.
     */
    public function getArticlesByCategory(int $limitPerCategory = 4): Collection
    {
        return PrezetDocument::active()
            ->blogs()
            ->whereNotNull('category')
            ->orderBy('created_at', 'desc')
            ->get()
            ->groupBy('category')
            ->map(function ($articles) use ($limitPerCategory) {
                return $articles->take($limitPerCategory)->map(fn ($doc) => $this->mapToArticleData($doc));
            });
    }

    /**
     * Map a Document model to a structured article object.
     */
    public function mapToArticleData(object $doc): object
    {
        $docData = app(DocumentData::class)::fromModel($doc);

        // Cache reading time to avoid N+1 markdown parsing
        $version = PrezetCache::version();
        $cacheKey = "reading_time_{$version}_".md5($doc->filepath);

        $readingTime = Cache::remember($cacheKey, 86400, function () use ($doc) {
            $md = Prezet::getMarkdown($doc->filepath);

            return PrezetHelper::calculateReadingTime(Prezet::parseMarkdown($md)->getContent());
        });

        // Check image
        $docData->frontmatter->image = PrezetHelper::checkImageExists($docData->frontmatter->image);

        return (object) [
            'data' => $docData,
            'readingTime' => $readingTime,
        ];
    }
}
