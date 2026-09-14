<?php

namespace Database\Seeders;

use App\Models\Hero;
use App\Models\News;
use App\Models\Profile;
use App\Models\SiteSetting;
use App\Models\Theme;
use Illuminate\Database\Seeder;

class SiteDataSeeder extends Seeder
{
    public function run(): void
    {
        // ─────────────────────────────────────────────────────────
        // SITE SETTINGS
        // ─────────────────────────────────────────────────────────
        SiteSetting::firstOrCreate(
            ['id' => 1],
            [
                'site_name' => 'Sitio Oficial',
                'person_name' => 'JORGE PINTO',
                'site_description' => 'Comprometido con la democracia, apasionado por lo social y firme en mis valores. Mi familia y la protección de la infancia son mi prioridad.',
                'logo' => 'site/01M240X4M0KK3WMPRDX22GVA8R.jpg',
                'favicon' => 'settings/favicon/01M26NJHD1833GH9S7FNQHBDCM.png',
                'agenda_image' => 'site/agenda/01M2EEA34XQDEZBS7G6YBABKCP.jpg',
                'phone' => '099 999 9999',
                'email' => 'info@jorgepinto.com',
                'whatsapp' => '099 999 9999',
                'address' => 'Quito',
                'contact_description' => 'Estamos disponibles para escuchar tus inquietudes, propuestas y comentarios. Puedes comunicarte con nosotros a través de nuestros canales oficiales.',
                'registration_enabled' => true,
                'default_role' => 'colaborador',
                'agenda_link_visible' => true,
                'agenda_link_public_only' => true,
            ]
        );

        // ─────────────────────────────────────────────────────────
        // HEROES
        // ─────────────────────────────────────────────────────────
        $heroes = [
            [
                'title' => 'Buenas noticias para Pichincha',
                'description' => '"Conoce nuestras propuestas, prioridades y el trabajo que estamos construyendo para el futuro."',
                'image' => 'heroes/01M241M4NBRRC4D0ZENQDC711N.jpg',
                'primary_button_text' => 'Conoce más',
                'primary_button_url' => '/noticias',
                'is_active' => true,
                'number' => '3',
                'number_color' => '#f0be5d',
            ],
            [
                'title' => 'Conoce mi historia',
                'description' => '"Antes de la política, hay una historia. Te cuento qué me impulsó a trabajar por un futuro distinto para nuestras comunidades."',
                'image' => 'heroes/01M2DJREYQYTDMEM01DB7QJEJ9.jpg',
                'primary_button_text' => 'Ir a historia',
                'primary_button_url' => '/perfil',
                'is_active' => true,
            ],
            [
                'title' => 'Millones de razones para el cambio',
                'description' => '"Esto no se trata de un candidato. Se trata de todos los que creemos que Pichincha merece algo mejor."',
                'image' => 'heroes/01M2DKP8STNZ4ZSGTHJYQWQPZV.jpg',
                'primary_button_text' => 'Ir a la propuesta',
                'primary_button_url' => '/noticias/fomento_productivo_para_Pichincha',
                'is_active' => true,
                'number' => '3',
                'number_color' => '#fadb0f',
            ],
        ];

        foreach ($heroes as $hero) {
            Hero::firstOrCreate(['title' => $hero['title']], $hero);
        }

        // ─────────────────────────────────────────────────────────
        // NEWS
        // ─────────────────────────────────────────────────────────
        $news = [
            [
                'title' => 'Un nuevo camino para nuestro país',
                'slug' => 'un-nuevo-camino-para-nuestro-pais',
                'excerpt' => 'Jorge Pinto presenta una visión de futuro basada en oportunidades, trabajo y mejores servicios para todos.',
                'content' => '<p>Pueblo es pueblo.</p>',
                'image' => 'news/01M243213195Y837YXK7VEC2H8.jpg',
                'category' => 'Propuestas',
                'published_at' => '2026-09-11 02:59:27',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Jorge Pinto plantea tres alternativas para mejorar la conexión entre Quito y el Valle de Los Chillos',
                'slug' => 'Jorge_Pinto_tres_alternativas_mejorar_conexión_Quito_Valle_de_Los_Chillos',
                'excerpt' => 'El candidato a la Prefectura de Pichincha presentó tres alternativas para enfrentar los problemas de movilidad.',
                'content' => '<p>Jorge Pinto planteó tres alternativas para atender los problemas de movilidad que afectan a miles de personas.</p><p>Entre las opciones están el paso inferior P2–P3, el Túnel Itchimbía y un tren de conexión entre el Valle y el Metro de Quito.</p>',
                'image' => 'news/01M260FBWM0DYM7NSDPY155NJ8.jpg',
                'category' => 'Pichincha',
                'published_at' => '2026-09-10 20:51:01',
                'is_published' => true,
                'is_featured' => true,
            ],
            [
                'title' => 'Jorge Pinto pone el fomento productivo en el centro de su propuesta para Pichincha',
                'slug' => 'fomento_productivo_para_Pichincha',
                'excerpt' => 'Jorge Pinto sostiene que el fomento productivo es clave para enfrentar la pobreza y generar oportunidades.',
                'content' => '<p>El candidato a la Prefectura de Pichincha plantea fortalecer el fomento productivo como herramienta para mejorar la economía.</p><p>La propuesta apunta a utilizar las competencias de la Prefectura para impulsar actividades productivas y apoyar a emprendedores.</p>',
                'image' => 'news/01M260KE75ZWW9Q31JQGKVT7B8.jpg',
                'category' => 'Economía y Desarrollo',
                'published_at' => '2026-09-10 20:55:32',
                'is_published' => true,
                'is_featured' => false,
            ],
            [
                'title' => 'Jorge Pinto participa en diálogo con el sector productivo',
                'slug' => 'Jorge_Pinto_diálogo_con_sector_productivo',
                'excerpt' => 'Jorge Pinto participó en un encuentro con representantes del sector productivo.',
                'content' => '<p>Jorge Pinto participó en un diálogo con representantes del sector productivo, invitado por la Cámara de Industrias y Producción.</p><p>El candidato destacó la importancia de estos espacios para conocer propuestas relacionadas con el desarrollo de la provincia.</p>',
                'image' => 'news/01M260QCS3YRKQ91VAZWA9HV5A.jpg',
                'category' => 'Actualidad',
                'published_at' => '2026-09-10 20:57:31',
                'is_published' => true,
                'is_featured' => false,
            ],
        ];

        foreach ($news as $item) {
            News::firstOrCreate(['slug' => $item['slug']], $item);
        }

        // ─────────────────────────────────────────────────────────
        // THEMES
        // ─────────────────────────────────────────────────────────
        $themes = [
            [
                'title' => 'Economía',
                'description' => 'Crear oportunidades y fortalecer nuestra economía.',
                'image' => 'themes/01M25TKFTAYG8M1BB959XFV0YK.jpg',
                'slug' => 'economia',
                'sort_order' => 1,
                'is_active' => true,
            ],
            [
                'title' => 'Seguridad',
                'description' => 'Seguridad para todos',
                'image' => 'themes/01M25TMXH94FA5F8H2BVPXVNMZ.jpg',
                'slug' => 'seguridad',
                'sort_order' => 2,
                'is_active' => true,
            ],
            [
                'title' => 'Educación',
                'description' => 'Educación para todos',
                'image' => 'themes/01M242B06JAP1KG22ECWZM61M5.jpg',
                'slug' => 'educacion',
                'sort_order' => 3,
                'is_active' => true,
            ],
            [
                'title' => 'Salud',
                'description' => 'Salud para todos',
                'image' => 'themes/01M242ECFRD3Z4BGGZZW0DTMY3.jpg',
                'slug' => 'salud',
                'sort_order' => 4,
                'is_active' => true,
            ],
        ];

        foreach ($themes as $theme) {
            Theme::firstOrCreate(['slug' => $theme['slug']], $theme);
        }

        // ─────────────────────────────────────────────────────────
        // PROFILES
        // ─────────────────────────────────────────────────────────
        Profile::firstOrCreate(
            ['id' => 1],
            [
                'name' => 'Jorge Pinto',
                'position' => 'Líder y servidor público',
                'intro' => 'Una visión de futuro construida con trabajo, diálogo y oportunidades para todos.',
                'biography' => '<p>Jorge Pinto ha desarrollado su trayectoria con una visión centrada en las personas y en la construcción de oportunidades.</p>',
                'photo' => 'profile/01M2493XW793DBQAW4331QNJN3.jpg',
                'secondary_photo' => 'profile/01M2493XWF1QSMKEQW2PS5SVCZ.jpg',
                'quote' => 'El futuro se construye escuchando, trabajando y cumpliendo.',
                'is_active' => true,
            ]
        );

        $this->command->info('✅ Datos del sitio migrados correctamente.');
    }
}
