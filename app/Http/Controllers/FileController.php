<?php

namespace App\Http\Controllers;

use App\Enums\FileModerationStatus;
use App\Enums\FileUploadStatus;
use App\Http\Requests\CompleteUploadRequest;
use App\Http\Requests\CreateVirtualFileRequest;
use App\Http\Requests\ShareFileRequest;
use App\Jobs\ProcessFileUpload;
use App\Models\File;
use App\Services\FilePreviewService;
use App\Services\FileService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class FileController extends Controller
{
    public function __construct(
        protected FilePreviewService $previewService,
        protected FileService $fileService
    ) {}

    /**
     * Display the library index.
     */
    public function index(Request $request)
    {
        $files = $this->fileService->getLibraryItems($request);

        return view('files.index', compact('files'));
    }

    /**
     * Display the review list for admins.
     */
    public function review()
    {
        $files = $this->fileService->getPendingItems();

        return view('files.review', compact('files'));
    }

    /**
     * Create a virtual placeholder for a new file.
     */
    public function createVirtual(CreateVirtualFileRequest $request)
    {
        $file = $this->fileService->createVirtualItem($request->validated());

        return response()->json(['file' => $file]);
    }

    /**
     * Upload a chunk of a file.
     */
    public function uploadChunk(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'chunk_index' => 'required|integer',
            'temp_id' => 'required|string',
        ]);

        $this->fileService->storeChunk(
            $request->file('file'),
            $request->temp_id,
            $request->chunk_index
        );

        return response()->json(['success' => true]);
    }

    /**
     * Complete the upload and dispatch merging job.
     */
    public function completeUpload(CompleteUploadRequest $request)
    {
        $file = File::findOrFail($request->file_id);
        $file->update(['status_upload' => FileUploadStatus::PROCESSING]);

        ProcessFileUpload::dispatch(
            $file,
            $request->temp_id,
            $request->total_chunks
        );

        return response()->json(['success' => true, 'file' => $file]);
    }

    /**
     * Show a specific book/file preview.
     */
    public function show(File $file)
    {
        $this->authorizeAccess($file);

        $this->logAction('preview', $file);

        $content = $this->previewService->render($file);

        return view('files.show', compact('file', 'content'));
    }

    /**
     * Approve a pending file.
     */
    public function approve(File $file)
    {
        $file->update(['status_moderation' => FileModerationStatus::APPROVED]);

        return back()->with('success', 'Đã phê duyệt tài liệu.');
    }

    /**
     * Reject a pending file.
     */
    public function reject(File $file)
    {
        $file->update(['status_moderation' => FileModerationStatus::REJECTED]);

        return back()->with('success', 'Đã từ chối tài liệu.');
    }

    /**
     * Update share settings.
     */
    public function share(File $file, ShareFileRequest $request)
    {
        $result = $this->fileService->updateShareSettings($file, $request->validated());

        $this->logAction('share_update', $file);

        return response()->json($result);
    }

    /**
     * View shared content.
     */
    public function shared($token, Request $request)
    {
        $file = File::where('share_token', $token)->firstOrFail();

        if (! $file->isApproved()) {
            abort(403, 'Tài liệu này đang chờ phê duyệt.');
        }

        if (! $file->is_public) {
            abort(403);
        }

        if ($file->isPasswordProtected()) {
            if (! Hash::check($request->input('password'), $file->password)) {
                return response('Password required or incorrect', 401);
            }
        }

        $this->logAction('shared_preview', $file);

        $content = $this->previewService->render($file);

        return view('files.show', compact('file', 'content'));
    }

    private function authorizeAccess(File $file)
    {
        if (Auth::check() && Auth::user()->hasAnyRole(['admin', 'super-admin'])) {
            return true;
        }

        if (! $file->isApproved() && $file->user_id !== Auth::id()) {
            abort(403, 'Tài liệu này chưa được phê duyệt.');
        }

        return true;
    }

    private function logAction(string $action, File $file)
    {
        activity()
            ->performedOn($file)
            ->log("{$action} file_id={$file->id}");
    }
}
