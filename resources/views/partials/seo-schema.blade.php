@php
    $settings = \App\Models\SiteSetting::current();
    $personName = trim($settings?->person_name ?? 'Jorge Pinto');
    $siteName = $settings?->site_name ?? 'Sitio Oficial';
    $siteDescription = $settings?->site_description ?? 'Sitio oficial de campaña';
    $siteUrl = config('app.url', 'https://jorgepinto.ec');

    // Construir sameAs limpiamente
    $sameAs = array_filter([
        $settings?->facebook,
        $settings?->twitter,
        $settings?->instagram,
        $settings?->youtube,
        $settings?->tiktok,
    ]);

    // ─── Schema Person ───
    $personSchema = [
        '@type' => 'Person',
        '@id' => $siteUrl . '/#person',
        'name' => $personName,
        'url' => $siteUrl,
        'description' => $siteDescription,
        'jobTitle' => 'Candidato',
        'address' => [
            '@type' => 'PostalAddress',
            'addressLocality' => 'Quito',
            'addressRegion' => 'Pichincha',
            'addressCountry' => 'EC',
        ],
    ];

    if ($settings?->logo) {
        $personSchema['image'] = asset('storage/' . $settings->logo);
    }

    if (!empty($sameAs)) {
        $personSchema['sameAs'] = array_values($sameAs);
    }

    if ($settings?->email) {
        $personSchema['email'] = $settings->email;
    }

    if ($settings?->phone) {
        $personSchema['telephone'] = $settings->phone;
    }

    $personSchema['affiliation'] = [
        '@type' => 'Organization',
        'name' => 'Campaña ' . $personName,
    ];

    // ─── Schema WebSite ───
    $websiteSchema = [
        '@type' => 'WebSite',
        '@id' => $siteUrl . '/#website',
        'url' => $siteUrl,
        'name' => $personName . ' — ' . $siteName,
        'description' => $siteDescription,
        'publisher' => [
            '@id' => $siteUrl . '/#person',
        ],
        'inLanguage' => 'es-EC',
    ];

    // ─── Graph base ───
    $graph = [$personSchema, $websiteSchema];

    // ─── Esquemas adicionales inyectados por la vista ───
    // Cada vista puede definir $extraSchema (array o colección de arrays)
    if (!empty($extraSchema)) {
        $graph = array_merge($graph, (array) $extraSchema);
    }

    // ─── Schema completo ───
    $schema = [
        '@context' => 'https://schema.org',
        '@graph' => $graph,
    ];
@endphp

<script type="application/ld+json">
{!! json_encode($schema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT) !!}
</script>
