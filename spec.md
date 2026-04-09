<?php

/**
 * =====================================================
 * Laravel File Storage + Preview + Sharing System
 * (Lightweight + Flexible + Production Mindset)
 * =====================================================
 *
 * Features:
 * - Upload: TXT, MD, PDF
 * - Preview online
 * - Share file via link
 * - Public / Private / Password protected
 * - Track & document all actions
 */

/**
 * 1. Migration: files
 */
Schema::create('files', function (Blueprint $table) {
    $table->id();
    $table->string('name');
    $table->string('path');
    $table->string('mime_type');
    $table->unsignedBigInteger('size');
    $table->string('disk')->default('public');

    // sharing
    $table->boolean('is_public')->default(false);
    $table->string('share_token')->nullable()->unique();
    $table->string('password')->nullable();

    $table->timestamps();
});

/**
 * 2. Model
 */
class File extends Model
{
    protected $fillable = [
        'name', 'path', 'mime_type', 'size', 'disk',
        'is_public', 'share_token', 'password'
    ];

    protected $hidden = ['password'];

    public function isPasswordProtected(): bool
    {
        return !empty($this->password);
    }
}

/**
 * 3. Upload + Share Controller
 */
class FileController extends Controller
{
    public function upload(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:txt,md,pdf|max:10240'
        ]);

        $file = $request->file('file');

        $path = Storage::disk('public')->putFile('uploads', $file);

        $record = File::create([
            'name' => $file->getClientOriginalName(),
            'path' => $path,
            'mime_type' => $file->getMimeType(),
            'size' => $file->getSize(),
            'disk' => 'public',
            'share_token' => Str::uuid(),
        ]);

        $this->log('upload', $record);

        return redirect()->route('files.show', $record);
    }

    public function show(File $file)
    {
        $this->authorizeAccess($file);

        $this->log('preview', $file);

        return app(FilePreviewService::class)->render($file);
    }

    public function share(File $file, Request $request)
    {
        $file->update([
            'is_public' => $request->boolean('is_public'),
            'password' => $request->password ? bcrypt($request->password) : null,
        ]);

        $this->log('share_update', $file);

        return response()->json([
            'share_url' => route('files.shared', $file->share_token)
        ]);
    }

    public function shared($token, Request $request)
    {
        $file = File::where('share_token', $token)->firstOrFail();

        if (!$file->is_public) {
            abort(403);
        }

        if ($file->isPasswordProtected()) {
            if (!Hash::check($request->input('password'), $file->password)) {
                return response('Password required or incorrect', 401);
            }
        }

        $this->log('shared_preview', $file);

        return app(FilePreviewService::class)->render($file);
    }

    private function authorizeAccess(File $file)
    {
        // extend with policy later
        return true;
    }

    private function log(string $action, File $file)
    {
        activity()->log("{$action} file_id={$file->id}");
    }
}

/**
 * 4. Preview Service
 */
use League\CommonMark\CommonMarkConverter;

class FilePreviewService
{
    public function render(File $file)
    {
        return match ($file->mime_type) {
            'text/plain' => $this->txt($file),
            'text/markdown', 'text/x-markdown' => $this->md($file),
            'application/pdf' => $this->pdf($file),
            default => abort(415),
        };
    }

    private function txt(File $file)
    {
        $content = Storage::disk($file->disk)->get($file->path);
        return response("<pre>" . e($content) . "</pre>");
    }

    private function md(File $file)
    {
        $content = Storage::disk($file->disk)->get($file->path);

        $converter = new CommonMarkConverter();
        $html = $converter->convert($content);

        return response("<div class='markdown-body'>{$html}</div>");
    }

    private function pdf(File $file)
    {
        $url = Storage::disk($file->disk)->url($file->path);
        return response("<iframe src='{$url}' width='100%' height='800px'></iframe>");
    }
}

/**
 * 5. Routes
 */
Route::post('/upload', [FileController::class, 'upload'])->name('files.upload');
Route::get('/files/{file}', [FileController::class, 'show'])->name('files.show');
Route::post('/files/{file}/share', [FileController::class, 'share'])->name('files.share');
Route::get('/s/{token}', [FileController::class, 'shared'])->name('files.shared');

/**
 * 6. Install packages
 */
// composer require league/commonmark
// composer require spatie/laravel-activitylog

/**
 * 7. Best Practices
 * ---------------------------------
 * - Use share_token instead of exposing ID
 * - Password must be hashed
 * - Do NOT expose private files directly
 * - Use activity log for tracking
 * - Keep preview logic isolated
 * - Validate mime strictly
 */

/**
 * 8. Optional Enhancements
 * ---------------------------------
 * - Temporary signed URL (S3)
 * - Expired share link
 * - View count / analytics
 * - Cache preview
 */

/**
 * =====================================================
 * FINAL PROMPT (COPY THIS)
 * =====================================================
 *
 * "Build a lightweight, flexible, and production-ready Laravel file storage system that supports uploading and previewing TXT, Markdown (MD), and PDF files. Files must be stored using Laravel Storage (local or S3), while only metadata is stored in the database. Implement a preview system using a service layer that renders content based on MIME type: plain text for TXT, CommonMark for Markdown, and iframe embed for PDF.
 *
 * Additionally, implement a robust file sharing system with the following capabilities:
 * - Generate secure shareable links using a unique token (not file ID)
 * - Support public sharing, private access, and password-protected access
 * - Ensure passwords are hashed and validated securely
 * - Prevent unauthorized access to private files
 *
 * The system must follow SOLID principles (especially SRP and Open/Closed), ensure XSS safety, and be easily extensible for new file types.
 *
 * IMPORTANT: Every feature, change, or action (upload, preview, share, access) must be logged and documented (e.g., activity log or audit trail) so that the system remains traceable, debuggable, and maintainable in production environments."
 */
