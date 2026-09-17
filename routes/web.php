<?php

use App\Models\Hero;
use App\Models\News;
use App\Models\SiteSetting;
use App\Models\Theme;
use App\Models\Profile;
use App\Http\Controllers\PublicAgendaController;
use App\Http\Controllers\Auth\GoogleController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {

    $heroes = Hero::where('is_active', true)->orderBy('id')->get();

    $themes = Theme::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    $news = News::where('is_published', true)
        ->orderByDesc('published_at')
        ->take(6)
        ->get();

    $profile = Profile::where('is_active', true)->first();

    return view('home', compact(
        'heroes',
        'themes',
        'news',
        'profile'
    ));
});

Route::get('/buscar', function () {
    $query = trim(request('q', ''));

    $news = collect();
    $themes = collect();

    if ($query !== '') {
        $news = News::where('is_published', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('excerpt', 'like', "%{$query}%")
                    ->orWhere('content', 'like', "%{$query}%")
                    ->orWhere('category', 'like', "%{$query}%");
            })
            ->orderByDesc('published_at')
            ->get();

        $themes = Theme::where('is_active', true)
            ->where(function ($q) use ($query) {
                $q->where('title', 'like', "%{$query}%")
                    ->orWhere('description', 'like', "%{$query}%");
            })
            ->orderBy('sort_order')
            ->get();
    }

    return view('search', compact('query', 'news', 'themes'));
});

Route::get('/noticias', function () {
    $perPage = 3;

    $news = News::where('is_published', true)
        ->orderByDesc('published_at')
        ->take($perPage)
        ->get();

    $totalNews = News::where('is_published', true)->count();

    return view('news.index', compact('news', 'perPage', 'totalNews'));
});

Route::get('/noticias/cargar-mas', function () {
    $perPage = 3;
    $offset = (int) request('offset', 0);

    $news = News::where('is_published', true)
        ->orderByDesc('published_at')
        ->skip($offset)
        ->take($perPage)
        ->get();

    $totalNews = News::where('is_published', true)->count();
    $hasMore = ($offset + $news->count()) < $totalNews;

    return response()->json([
        'html' => view('news._card_list', compact('news'))->render(),
        'hasMore' => $hasMore,
    ]);
});

Route::get('/noticias/{slug}', function (string $slug) {
    $news = News::where('slug', $slug)
        ->where('is_published', true)
        ->firstOrFail();

    return view('news.show', compact('news'));
});

Route::get('/temas', function () {
    $themes = Theme::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    return view('themes.index', compact('themes'));
});

Route::get('/temas/{slug}', function (string $slug) {
    $theme = Theme::where('slug', $slug)
        ->where('is_active', true)
        ->firstOrFail();

    return view('themes.show', compact('theme'));
});

Route::get('/perfil', function () {
    $profile = Profile::where('is_active', true)->first();

    return view('profile.show', compact('profile'));
});

Route::get('/contacto', function () {

    return view('contact.show');
});

// Agenda pública (solo usuarios logueados con rol permitido)
Route::middleware(['agenda.access'])->group(function () {
    Route::get('/agenda', [PublicAgendaController::class, 'index'])->name('agenda.index');
    Route::get('/agenda/{event:slug}', [PublicAgendaController::class, 'show'])->name('agenda.show');
});

// Google OAuth
Route::get('/auth/google/redirect', [GoogleController::class, 'redirect'])->name('auth.google.redirect');
Route::get('/auth/google/callback', [GoogleController::class, 'callback'])->name('auth.google.callback');
