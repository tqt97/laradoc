<?php

namespace App\Services;

use App\Enums\FileModerationStatus;
use App\Enums\FileUploadStatus;
use App\Models\File;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileService
{
    /**
     * Get paginated and filtered library items.
     */
    public function getLibraryItems(Request $request, int $perPage = 12): LengthAwarePaginator
    {
        $query = File::query();

        // Sorting
        $sort = $request->get('sort', 'latest');
        if ($sort === 'oldest') {
            $query->oldest();
        } else {
            $query->latest();
        }

        // Filter by moderation status for non-admins/super-admins
        if (! Auth::check() || ! Auth::user()->hasAnyRole(['admin', 'super-admin'])) {
            $query->where('status_moderation', FileModerationStatus::APPROVED);
            if (Auth::check()) {
                $query->orWhere('user_id', Auth::id());
            }
        }

        // Search logic
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('uploader_name', 'like', "%{$search}%");
            });
        }

        // Date filter
        if ($request->filled('date')) {
            $query->whereDate('created_at', $request->date);
        }

        return $query->paginate($perPage)->withQueryString();
    }

    /**
     * Get pending items for admin review.
     */
    public function getPendingItems(int $perPage = 10): LengthAwarePaginator
    {
        return File::where('status_moderation', FileModerationStatus::PENDING)
            ->latest()
            ->paginate($perPage);
    }

    /**
     * Create a virtual placeholder for a new book/file.
     */
    public function createVirtualItem(array $data): File
    {
        return File::create([
            'name' => $data['name'],
            'path' => 'pending/'.Str::random(40),
            'mime_type' => $data['mime_type'],
            'size' => $data['size'],
            'disk' => 'public',
            'status_upload' => FileUploadStatus::UPLOADING,
            'user_id' => Auth::id(),
            'uploader_name' => Auth::check() ? Auth::user()->name : ($data['uploader_name'] ?? 'Ẩn danh'),
            'status_moderation' => Auth::check() ? FileModerationStatus::APPROVED : FileModerationStatus::PENDING,
            'share_token' => (string) Str::uuid(),
        ]);
    }

    /**
     * Store a chunk of a file.
     */
    public function storeChunk($file, string $tempId, int $index): string
    {
        return Storage::disk('local')->putFileAs(
            "chunks/{$tempId}",
            $file,
            $index
        );
    }

    /**
     * Update share settings.
     */
    public function updateShareSettings(File $file, array $data): array
    {
        $file->update([
            'is_public' => $data['is_public'] ?? false,
            'password' => $data['password'] ?: null,
        ]);

        return [
            'share_url' => route('files.shared', $file->share_token),
        ];
    }

    /**
     * Get file icon based on mime type.
     */
    public function getIconForMime(string $mime): string
    {
        return match ($mime) {
            'application/pdf' => 'book',
            'text/markdown', 'text/x-markdown' => 'markdown',
            default => 'document',
        };
    }
}
