<?php

namespace App\Services;

use App\Models\Link;
use App\Support\PrezetHelper;
use Illuminate\Pagination\LengthAwarePaginator;

class LinkService
{
    /**
     * Get paginated links.
     */
    public function getPaginatedLinks(int $perPage = 12): LengthAwarePaginator
    {
        return Link::orderBy('created_at', 'desc')->paginate($perPage);
    }

    /**
     * Store a new link.
     */
    public function createLink(array $data): Link
    {
        $metadata = PrezetHelper::extractMetadata($data['url'], $data['title']);

        return Link::create([
            'url' => $data['url'],
            'title' => $metadata['title'],
            'og_image' => $metadata['og_image'],
        ]);
    }

    /**
     * Update an existing link.
     */
    public function updateLink(Link $link, array $data): bool
    {
        return $link->update($data);
    }

    /**
     * Delete a link.
     */
    public function deleteLink(Link $link): bool
    {
        return $link->delete();
    }
}
