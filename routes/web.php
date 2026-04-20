<?php

use App\Http\Controllers\Admin\FeatureController as AdminFeatureController;
use App\Http\Controllers\IdeaController;
use App\Http\Controllers\ImageGalleryController;
use App\Http\Controllers\KnowledgeController;
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
use App\Http\Controllers\StoryController;
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

    Route::resource('features', AdminFeatureController::class, ['as' => 'admin']);
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

// Knowledge Review feature
Route::get('knowledge', [KnowledgeController::class, 'index'])->name('knowledge.index');
Route::get('knowledge/{slug}', [KnowledgeController::class, 'show'])->name('knowledge.show');

// Stories feature
Route::get('stories', [StoryController::class, 'index'])->name('stories.index');
Route::get('stories/{slug}', [StoryController::class, 'show'])->name('stories.show');

// Newsletter
Route::post('newsletter/subscribe', [NewsletterController::class, 'subscribe'])->name('newsletter.subscribe');

// Links feature
Route::middleware('feature:links')->group(function () {
    Route::get('links', [LinkController::class, 'index'])->name('links.index');
    Route::post('links', [LinkController::class, 'store'])->name('links.store');
    Route::put('links/{link}', [LinkController::class, 'update'])->name('links.update');
    Route::delete('links/{link}', [LinkController::class, 'destroy'])->name('links.destroy');
});

// Snippets feature
Route::middleware('feature:snippets')->group(function () {
    Route::get('snippets', [SnippetController::class, 'index'])->name('snippets.index');
    Route::get('snippets/create', [SnippetController::class, 'create'])->name('snippets.create');
    Route::post('snippets', [SnippetController::class, 'store'])->name('snippets.store');
    Route::get('snippets/{slug}', [SnippetController::class, 'show'])->name('snippets.show');
    Route::get('snippets/{slug}/edit', [SnippetController::class, 'edit'])->name('snippets.edit');
    Route::put('snippets/{slug}', [SnippetController::class, 'update'])->name('snippets.update');
});

// Ideas feature
Route::middleware('feature:ideas')->group(function () {
    Route::get('ideas', [IdeaController::class, 'index'])->name('ideas.index');
    Route::post('ideas', [IdeaController::class, 'store'])->name('ideas.store');
    Route::get('ideas/list', [IdeaController::class, 'list'])->name('ideas.list');
    Route::post('ideas/{idea}/vote', [IdeaController::class, 'toggleVote'])->name('ideas.toggle-vote')->middleware('throttle:30,1');
    Route::put('ideas/{idea}', [IdeaController::class, 'update'])->name('ideas.update')->middleware('auth');
    Route::delete('ideas/{idea}', [IdeaController::class, 'destroy'])->name('ideas.destroy')->middleware('auth');
});

// Image Gallery
Route::get('gallery', [ImageGalleryController::class, 'index'])->name('gallery.index')->middleware('feature:gallery');

// Portfolio
Route::get('portfolio', [PortfolioController::class, 'index'])->name('portfolio.index')->middleware('feature:portfolio');

// Articles
Route::get('/articles', ArticleController::class)->name('prezet.articles')->middleware('feature:articles');

// Series
Route::middleware('feature:series')->group(function () {
    Route::get('/series', [SeriesController::class, 'index'])
        ->name('prezet.series.index');

    Route::get('/series/{slug}', [SeriesController::class, 'show'])
        ->name('prezet.series.show')
        ->where('slug', '.*');
});

// Prezet search route
Route::get('search', SearchController::class)->name('prezet.search');

Route::get('prezet/img/{path}', ImageController::class)
    ->name('prezet.image')
    ->where('path', '.*');

Route::get('/prezet/ogimage/{slug}', OgimageController::class)
    ->name('prezet.ogimage')
    ->where('slug', '.*');

Route::get('/', IndexController::class)->name('prezet.index');

Route::get('{slug}', ShowController::class)
    ->name('prezet.show')
    ->where('slug', '.*');
