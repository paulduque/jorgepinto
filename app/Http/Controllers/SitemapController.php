<?php

namespace App\Http\Controllers;

use App\Models\Event;
use App\Models\News;
use App\Models\SiteSetting;
use App\Models\Theme;
use Carbon\Carbon;
use Illuminate\Http\Response;

class SitemapController extends Controller
{
    /**
     * Genera el sitemap XML dinámico del sitio público.
     *
     * Incluye:
     * - Home
     * - Noticias (listado + individuales)
     * - Temas (listado + individuales)
     * - Agenda (listado + eventos públicos) — solo si agenda_link_visible
     * - Perfil, Contacto, Política de privacidad
     */
    public function index(): Response
    {
        $settings = SiteSetting::current();
        $baseUrl = rtrim(config('app.url', 'https://jorgepinto.ec'), '/');

        $urls = [];

        // ─── Home ───
        $urls[] = $this->buildUrl($baseUrl . '/', null, 'daily', '1.0');

        // ─── Noticias (listado) ───
        $latestNewsUpdate = News::where('is_published', true)->max('updated_at');
        $urls[] = $this->buildUrl(
            $baseUrl . '/noticias',
            $latestNewsUpdate ? Carbon::parse($latestNewsUpdate) : now(),
            'daily',
            '0.9'
        );

        // ─── Noticias (individuales) ───
        News::where('is_published', true)
            ->orderByDesc('published_at')
            ->get()
            ->each(function (News $news) use (&$urls, $baseUrl) {
                $urls[] = $this->buildUrl(
                    $baseUrl . '/noticias/' . $news->slug,
                    $news->updated_at,
                    'weekly',
                    '0.8'
                );
            });

        // ─── Temas (listado) ───
        $urls[] = $this->buildUrl($baseUrl . '/temas', null, 'weekly', '0.7');

        // ─── Temas (individuales) ───
        Theme::where('is_active', true)
            ->orderBy('sort_order')
            ->get()
            ->each(function (Theme $theme) use (&$urls, $baseUrl) {
                $urls[] = $this->buildUrl(
                    $baseUrl . '/temas/' . $theme->slug,
                    $theme->updated_at,
                    'monthly',
                    '0.6'
                );
            });

        // ─── Agenda (solo si está visible) ───
        if ($settings?->agenda_link_visible) {
            $urls[] = $this->buildUrl($baseUrl . '/agenda', null, 'daily', '0.7');

            Event::where('is_public', true)
                ->orderByDesc('start_at')
                ->get()
                ->each(function (Event $event) use (&$urls, $baseUrl) {
                    $urls[] = $this->buildUrl(
                        $baseUrl . '/agenda/' . $event->slug,
                        $event->updated_at,
                        'weekly',
                        '0.6'
                    );
                });
        }

        // ─── Páginas estáticas ───
        $urls[] = $this->buildUrl($baseUrl . '/perfil', null, 'monthly', '0.7');
        $urls[] = $this->buildUrl($baseUrl . '/contacto', null, 'monthly', '0.6');
        $urls[] = $this->buildUrl($baseUrl . '/politica-privacidad', null, 'yearly', '0.3');

        return response()
            ->view('sitemap', compact('urls'))
            ->header('Content-Type', 'application/xml');
    }

    /**
     * Construye el array de una URL para el sitemap.
     */
    private function buildUrl(string $loc, ?Carbon $lastmod, string $changefreq, string $priority): array
    {
        return [
            'loc' => $loc,
            'lastmod' => ($lastmod ?? now())->toAtomString(),
            'changefreq' => $changefreq,
            'priority' => $priority,
        ];
    }
}
