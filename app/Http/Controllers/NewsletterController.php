<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterRequest;
use App\Models\Subscriber;
use Illuminate\Http\RedirectResponse;

class NewsletterController extends Controller
{
    public function subscribe(StoreNewsletterRequest $request): RedirectResponse
    {
        Subscriber::create($request->validated());

        return back()->with('success', 'Đã đăng ký bản tin thành công!');
    }
}
