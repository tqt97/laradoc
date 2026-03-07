<?php

use App\Http\Controllers\LinkController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\Prezet\ImageController;
use App\Http\Controllers\Prezet\IndexController;
use App\Http\Controllers\Prezet\OgimageController;
use App\Http\Controllers\Prezet\SearchController;
use App\Http\Controllers\Prezet\ShowController;
use App\Http\Controllers\SnippetController;
use Illuminate\Foundation\Http\Middleware\VerifyCsrfToken;
use Illuminate\Session\Middleware\StartSession;
use Illuminate\Support\Facades\Route;
use Illuminate\View\Middleware\ShareErrorsFromSession;

Route::middleware([
    StartSession::class,
    ShareErrorsFromSession::class,
    VerifyCsrfToken::class,
])->group(function () {
    Route::post('newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

    // Links feature
    Route::get('links', [LinkController::class, 'index'])->name('links.index');
    Route::post('links', [LinkController::class, 'store'])->name('links.store');
    Route::put('links/{link}', [LinkController::class, 'update'])->name('links.update');
    Route::delete('links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');

    // Snippets feature
    Route::get('snippets', [SnippetController::class, 'index'])->name('snippets.index');
    Route::get('snippets/create', [SnippetController::class, 'create'])->name('snippets.create');
    Route::post('snippets', [SnippetController::class, 'store'])->name('snippets.store');
    Route::get('snippets/{slug}', [SnippetController::class, 'show'])->name('snippets.show');
    Route::get('snippets/{slug}/edit', [SnippetController::class, 'edit'])->name('snippets.edit');
    Route::put('snippets/{slug}', [SnippetController::class, 'update'])->name('snippets.update');
});

Route::withoutMiddleware([
    VerifyCsrfToken::class,
])
    ->group(function () {
        Route::get('search', SearchController::class)->name('prezet.search');

        Route::get('prezet/img/{path}', ImageController::class)
            ->name('prezet.image')
            ->where('path', '.*');

        Route::get('/prezet/ogimage/{slug}', OgimageController::class)
            ->name('prezet.ogimage')
            ->where('slug', '.*');

        Route::get('/', IndexController::class)
            ->name('prezet.index');

        Route::get('{slug}', ShowController::class)
            ->name('prezet.show')
            ->where('slug', '.*'); // https://laravel.com/docs/11.x/routing#parameters-encoded-forward-slashes
    });
