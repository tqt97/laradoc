<?php

namespace App\Http\Controllers;

use App\Models\PrezetDocument;
use App\Support\PrezetHelper;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ImageGalleryController extends Controller
{
    /**
     * Display a listing of the images by category.
     */
    public function index(Request $request): View
    {
        $documents = PrezetDocument::active()
            ->orderBy('created_at', 'desc')
            ->get();

        $images = $documents->map(function ($doc) {
            $slug = str_replace(['content/', '.md', '/'], ['', '', '-'], $doc->filepath);
            $ogImageRelativePath = "ogimages/{$slug}.webp";

            // Check existence in prezet/images/
            $fullPath = base_path("prezet/images/{$ogImageRelativePath}");

            if (! file_exists($fullPath)) {
                return null;
            }

            return (object) [
                'title' => $doc->frontmatter->title ?? 'Untitled',
                'category' => $doc->frontmatter->category ?? 'Uncategorized',
                'url' => route('prezet.image', ['path' => $ogImageRelativePath]),
                'link' => route('prezet.show', $doc->slug),
                'date' => $doc->created_at,
                'excerpt' => $doc->frontmatter->excerpt ?? '',
            ];
        })->filter()->groupBy('category');

        return view('gallery.index', array_merge([
            'categories' => $images,
            'seo' => PrezetHelper::getSeoData(
                'Thư viện Hình ảnh & Portfolio',
                'Khám phá bộ sưu tập hình ảnh và các bài viết qua góc nhìn nghệ thuật.',
                null,
                route('prezet.image', ['path' => 'ogimages/blogs-index.webp'])
            ),
        ], PrezetHelper::getCommonData()));
    }
}
