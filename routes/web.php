<?php

use App\Models\Hero;
use App\Models\News;
use App\Models\SiteSetting;
use App\Models\Theme;
use App\Models\Profile;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $settings = SiteSetting::current();

    $hero = Hero::where('is_active', true)->first();

    $themes = Theme::where('is_active', true)
        ->orderBy('sort_order')
        ->get();

    $news = News::where('is_published', true)
        ->orderByDesc('published_at')
        ->take(3)
        ->get();

    $profile = Profile::where('is_active', true)->first();

    return view('home', compact(
        'settings',
        'hero',
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
    $settings = SiteSetting::current();

    return view('contact.show', compact('settings'));
});
