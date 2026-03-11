<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLinkRequest;
use App\Models\Link;
use App\Services\LinkService;
use App\Support\PrezetHelper;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class LinkController extends Controller
{
    public function __construct(
        protected LinkService $linkService
    ) {}

    /**
     * Display a listing of the resource.
     */
    public function index(): View
    {
        return view('links.index', array_merge([
            'links' => $this->linkService->getPaginatedLinks(),
            'seo' => PrezetHelper::getSeoData('Tài nguyên Lập trình & Liên kết Hữu ích', 'Tổng hợp các công cụ, thư viện và tài nguyên học tập lập trình web tốt nhất được tuantq.online tuyển chọn.', null, config('prezet.seo.links_image')),
        ], PrezetHelper::getCommonData()));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLinkRequest $request): RedirectResponse
    {
        $this->linkService->createLink($request->validated());

        return back()->with('success', 'Đã lưu liên kết thành công!');
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StoreLinkRequest $request, Link $link): RedirectResponse
    {
        $this->linkService->updateLink($link, $request->validated());

        return back()->with('success', 'Đã cập nhật liên kết thành công!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Link $link): RedirectResponse
    {
        $this->linkService->deleteLink($link);

        return back()->with('success', 'Đã xóa liên kết thành công!');
    }
}
