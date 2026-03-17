<?php

use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ImageGalleryController;
use App\Http\Controllers\LinkController;
use App\Http\Controllers\NewsletterController;
use App\Http\Controllers\PermissionController;
use App\Http\Controllers\PortfolioController;
use App\Http\Controllers\Prezet\ArticleController;
use App\Http\Controllers\Prezet\ImageController;
use App\Http\Controllers\Prezet\IndexController;
use App\Http\Controllers\Prezet\OgimageController;
use App\Http\Controllers\Prezet\SearchController;
use App\Http\Controllers\Prezet\ShowController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\SeriesController;
use App\Http\Controllers\SnippetController;
use Illuminate\Support\Facades\Route;

// Roles and Permissions management
Route::middleware(['auth', 'role:super-admin'])->group(function () {
    Route::get('roles', [RoleController::class, 'index'])->name('roles.index');
    Route::post('roles', [RoleController::class, 'store'])->name('roles.store');
    Route::put('roles/{role}', [RoleController::class, 'update'])->name('roles.update');
    Route::delete('roles/{role}', [RoleController::class, 'destroy'])->name('roles.destroy');
    Route::post('roles/users/{user}', [RoleController::class, 'assignUserRole'])->name('roles.assign');

    Route::post('permissions', [PermissionController::class, 'store'])->name('permissions.store');
    Route::delete('permissions/{permission}', [PermissionController::class, 'destroy'])->name('permissions.destroy');
});

// Breeze Auth Routes (must be before Prezet wildcard)
require __DIR__.'/auth.php';

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

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

// Ideas feature
Route::get('ideas', [IdeaController::class, 'index'])->name('ideas.index');
Route::post('ideas', [IdeaController::class, 'store'])->name('ideas.store');
Route::get('ideas/list', [IdeaController::class, 'list'])->name('ideas.list');
Route::post('ideas/{idea}/vote', [IdeaController::class, 'toggleVote'])->name('ideas.toggle-vote')->middleware('throttle:30,1');
Route::put('ideas/{idea}', [IdeaController::class, 'update'])->name('ideas.update')->middleware('auth');
Route::delete('ideas/{idea}', [IdeaController::class, 'destroy'])->name('ideas.destroy')->middleware('auth');

// Image Gallery
Route::get('gallery', [ImageGalleryController::class, 'index'])->name('gallery.index');
Route::get('portfolio', [PortfolioController::class, 'index'])->name('portfolio.index');

// Prezet search route
Route::get('search', SearchController::class)->name('prezet.search');

Route::get('prezet/img/{path}', ImageController::class)
    ->name('prezet.image')
    ->where('path', '.*');

Route::get('/prezet/ogimage/{slug}', OgimageController::class)
    ->name('prezet.ogimage')
    ->where('slug', '.*');

Route::get('/', IndexController::class)
    ->name('prezet.index');

Route::get('/articles', ArticleController::class)
    ->name('prezet.articles');

Route::get('/series', [SeriesController::class, 'index'])
    ->name('prezet.series.index');

Route::get('/series/{slug}', [SeriesController::class, 'show'])
    ->name('prezet.series.show')
    ->where('slug', '.*');

// Feature specific routes
Route::middleware(['auth', 'feature:dashboard_analytics'])->group(function () {
    Route::get('/dashboard/analytics', function () {
        // This route is only accessible if 'dashboard_analytics' feature is enabled for the user's role.
        return response()->json(['message' => 'Welcome to the analytics dashboard!']);
    })->name('analytics'); // Note: Changed route name to 'analytics' to match navigation example
});

Route::middleware(['auth', 'feature:library'])->group(function () {
    Route::get('/library', function () {
        return response()->json(['message' => 'Welcome to the library!']);
    })->name('library.index');
});

Route::middleware(['auth', 'feature:portfolio'])->group(function () {
    Route::get('/portfolio/management', function () {
        return response()->json(['message' => 'Welcome to the portfolio management!']);
    })->name('portfolio.management');
});

Route::middleware(['auth', 'feature:public_feature'])->group(function () {
    Route::get('/public-feature', function () {
        return response()->json(['message' => 'This is a public feature!']);
    })->name('public_feature.index');
});

Route::get('{slug}', ShowController::class)
    ->name('prezet.show')
    ->where('slug', '.*'); // https://laravel.com/docs/11.x/routing#parameters-encoded-forward-slashes
