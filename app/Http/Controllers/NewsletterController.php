<?php

namespace App\Http\Controllers;

use App\Models\Subscriber;
use Illuminate\Http\Request;

class NewsletterController extends Controller
{
    public function subscribe(Request $request)
    {
        $request->validate([
            'email' => 'required|email|unique:subscribers,email',
        ]);

        Subscriber::create([
            'email' => $request->email,
        ]);

        if ($request->header('HX-Request')) {
            session()->flash('success', 'Đã đăng ký bản tin thành công!');

            return view('components.prezet.newsletter');
        }

        return back()->with('success', 'Đã đăng ký bản tin thành công!');
    }
}
