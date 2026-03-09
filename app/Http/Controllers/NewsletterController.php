<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreNewsletterRequest;
use App\Models\Subscriber;
use Illuminate\Http\JsonResponse;

class NewsletterController extends Controller
{
    public function subscribe(StoreNewsletterRequest $request): JsonResponse
    {
        Subscriber::create($request->validated());

        return response()->json([
            'message' => 'Cảm ơn bạn đã đăng ký bản tin!',
        ]);
    }
}
