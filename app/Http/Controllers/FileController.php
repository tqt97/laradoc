<?php

namespace App\Http\Controllers;

use App\Jobs\ProcessFileUpload;
use App\Models\File;
use App\Services\FilePreviewService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class FileController extends Controller
{
    public function __construct(
        protected FilePreviewService $previewService
    ) {}

    public function index()
    {
        $files = File::latest()->get();

        return view('files.index', compact('files'));
    }

    public function upload(Request $request)
    {
        // Keep as fallback for small files if needed, but we'll use chunked for all.
        $request->validate([
            'file' => 'required|file|mimes:txt,md,pdf|max:30720',
        ]);

        $file = $request->file('file');
        $path = Storage::disk('public')->putFile('uploads', $file);

        $record = File::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'disk' => 'public',
            'share_token' => (string) Str::uuid(),
        ]);

        $this->logAction('upload', $record);

        return response()->json(['success' => true]);
    }

    public function uploadChunk(Request $request)
    {
        $request->validate([
            'file' => 'required|file',
            'chunk_index' => 'required|integer',
            'temp_id' => 'required|string',
        ]);

        $file = $request->file('file');
        $tempId = $request->temp_id;
        $index = $request->chunk_index;

        $path = Storage::disk('local')->putFileAs(
            "chunks/{$tempId}",
            $file,
            $index
        );

        return response()->json(['success' => true]);
    }

    public function completeUpload(Request $request)
    {
        $request->validate([
            'temp_id' => 'required|string',
            'file_name' => 'required|string',
            'total_chunks' => 'required|integer',
            'mime_type' => 'required|string',
            'total_size' => 'required|integer',
        ]);

        ProcessFileUpload::dispatch(
            $request->file_name,
            $request->temp_id,
            $request->total_chunks,
            $request->mime_type,
            $request->total_size
        );

        return response()->json(['success' => true]);
    }

    public function show(File $file)
    {
        $this->authorizeAccess($file);

        $this->logAction('preview', $file);

        $content = $this->previewService->render($file);

        return view('files.show', compact('file', 'content'));
    }

    public function share(File $file, Request $request)
    {
        $file->update([
            'is_public' => $request->boolean('is_public'),
            'password' => $request->password ?: null,
        ]);

        $this->logAction('share_update', $file);

        return response()->json([
            'share_url' => route('files.shared', $file->share_token),
        ]);
    }

    public function shared($token, Request $request)
    {
        $file = File::where('share_token', $token)->firstOrFail();

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
        // extend with policy later
        return true;
    }

    private function logAction(string $action, File $file)
    {
        activity()
            ->performedOn($file)
            ->log("{$action} file_id={$file->id}");
    }
}
