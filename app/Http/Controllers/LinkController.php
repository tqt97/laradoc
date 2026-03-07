<?php

namespace App\Http\Controllers;

use App\Models\Link;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class LinkController extends Controller
{
    public function index(): View
    {
        $links = Link::latest()->paginate(15);

        return view('links.index', compact('links'));
    }

    public function store(Request $request): RedirectResponse
    {
        $request->validate([
            'url' => 'required|url',
            'title' => 'nullable|string|max:255',
        ]);

        $metadata = $this->extractMetadata($request->url, $request->title);

        Link::create([
            'url' => $request->url,
            'title' => $metadata['title'],
            'og_image' => $metadata['og_image'],
        ]);

        return back()->with('success', 'Đã lưu liên kết thành công!');
    }

    public function update(Request $request, Link $link): RedirectResponse
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'url' => 'required|url',
        ]);

        $link->update($request->only('title', 'url'));

        return back()->with('success', 'Đã cập nhật liên kết thành công!');
    }

    public function destroy(Link $link): RedirectResponse
    {
        $link->delete();

        return back()->with('success', 'Đã xóa liên kết thành công!');
    }

    /**
     * Extract metadata (title and OG image) from a URL.
     */
    private function extractMetadata(string $url, ?string $providedTitle): array
    {
        $title = $providedTitle;
        $ogImage = null;

        try {
            $response = Http::withHeaders([
                'User-Agent' => 'Mozilla/5.0',
                'Accept' => 'text/html,application/xhtml+xml',
            ])
                ->timeout(10)
                ->connectTimeout(5)
                ->retry(2, 200)
                ->get($url);

            if (! $response->successful()) {
                return [
                    'title' => $title ?: $url,
                    'og_image' => null,
                ];
            }

            $contentType = $response->header('Content-Type', '');

            // CASE 1: URL là ảnh trực tiếp
            if (str_contains($contentType, 'image/')) {
                return [
                    'title' => $title ?: basename(parse_url($url, PHP_URL_PATH)),
                    'og_image' => $url,
                ];
            }

            $html = $response->body();

            libxml_use_internal_errors(true);

            // FIX lỗi encoding UTF-8
            $dom = new \DOMDocument('1.0', 'UTF-8');

            $html = mb_convert_encoding($html, 'HTML-ENTITIES', 'UTF-8');

            $dom->loadHTML($html);

            $xpath = new \DOMXPath($dom);

            // TITLE
            if (! $title) {

                $node = $xpath->query('//meta[@property="og:title"]')->item(0);

                if ($node instanceof \DOMElement) {
                    $title = $node->getAttribute('content');
                }

                if (! $title) {
                    $node = $xpath->query('//title')->item(0);

                    if ($node instanceof \DOMElement) {
                        $title = trim($node->textContent);
                    }
                }
            }

            // OG IMAGE
            $imageNode = $xpath->query('//meta[@property="og:image"]')->item(0);

            if (! $imageNode) {
                $imageNode = $xpath->query('//meta[@name="twitter:image"]')->item(0);
            }

            if ($imageNode instanceof \DOMElement) {
                $ogImage = $imageNode->getAttribute('content');
            }

            // Resolve relative URL
            if ($ogImage && ! str_starts_with($ogImage, 'http')) {
                $ogImage = $this->resolveAbsoluteUrl($url, $ogImage);
            }

        } catch (\Throwable $e) {

            Log::warning('Metadata extraction failed', [
                'url' => $url,
                'error' => $e->getMessage(),
            ]);
        }

        return [
            'title' => html_entity_decode($title ?: $url),
            'og_image' => $ogImage,
        ];
    }

    /**
     * Resolve a relative URL into an absolute one.
     */
    private function resolveAbsoluteUrl(string $baseUrl, string $relativeUrl): string
    {
        $parsed = parse_url($baseUrl);

        $scheme = $parsed['scheme'] ?? 'https';
        $host = $parsed['host'] ?? '';

        $domain = $scheme.'://'.$host;

        if (str_starts_with($relativeUrl, '//')) {
            return $scheme.':'.$relativeUrl;
        }

        if (str_starts_with($relativeUrl, '/')) {
            return $domain.$relativeUrl;
        }

        return $domain.'/'.ltrim($relativeUrl, '/');
    }
}
