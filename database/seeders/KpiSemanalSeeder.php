<?php

namespace Database\Seeders;

use App\Models\KpiSemanal;
use App\Models\SemanaPlan;
use Illuminate\Database\Seeder;

class KpiSemanalSeeder extends Seeder
{
    /**
     * KPIs base del plan de campaña.
     *
     * FUENTES:
     * - Padrón electoral Pichincha: https://rpubs.com/p_diazjurado/1244706
     * - Resultados CNE 2021 (1ra y 2da vuelta, Asambleístas provinciales)
     *
     * CÁLCULO DE LA META FINAL:
     * - Padrón Pichincha 2026 estimado: ~2.500.000 electores
     * - Abstención esperada: ~18% → votos válidos: ~2.050.000
     * - Votos necesarios para ganar (28% escenario fragmentado): ~574.000
     */
    public function run(): void
    {
        $semanas = SemanaPlan::all()->keyBy('codigo');

        // Progresión de metas por semana (exponencial)
        $progresion = [
            'S1' => ['contactos' => 500,   'validadores' => 10, 'suscriptores' => 1000,  'alcance' => 250000,  'eventos' => 5],
            'S2' => ['contactos' => 1500,  'validadores' => 15, 'suscriptores' => 3000,  'alcance' => 500000,  'eventos' => 5],
            'S3' => ['contactos' => 3500,  'validadores' => 22, 'suscriptores' => 7000,  'alcance' => 800000,  'eventos' => 5],
            'S4' => ['contactos' => 7000,  'validadores' => 30, 'suscriptores' => 14000, 'alcance' => 1200000, 'eventos' => 5],
            'S5' => ['contactos' => 11500, 'validadores' => 38, 'suscriptores' => 23000, 'alcance' => 1800000, 'eventos' => 5],
            'S6' => ['contactos' => 18000, 'validadores' => 47, 'suscriptores' => 36000, 'alcance' => 2500000, 'eventos' => 5],
            'S7' => ['contactos' => 28700, 'validadores' => 57, 'suscriptores' => 57400, 'alcance' => 3500000, 'eventos' => 5],
        ];

        // Justificación por KPI (fuente confiable para el equipo)
        $justificaciones = [
            'contactos' => 'FUENTE: Proyección CNE 2021 + padrón Pichincha 2026 (RPubs). CÁLCULO: 5% de los 574.000 votos necesarios para ganar (28% de votos válidos en escenario fragmentado de 10 candidatos). REFERENCIA: resultados Asambleístas Pichincha 2021.',
            'validadores' => 'FUENTE: Benchmark de campañas provinciales Ecuador 2023. CÁLCULO: 1 validador por cada 500 contactos captados. Los validadores son multiplicadores locales (presidentes de juntas parroquiales, dirigentes barriales, transportistas).',
            'suscriptores' => 'FUENTE: Benchmark de campañas digitales LATAM 2023. CÁLCULO: 10% de los votos necesarios (574.000). Meta: 57.400 suscriptores al Canal de WhatsApp. El canal es la herramienta clave para movilización final (GOTV).',
            'alcance' => 'FUENTE: Benchmark Meta Ads Ecuador 2023. CÁLCULO: 10x los votos necesarios durante campaña oficial (12-26 nov). Meta final: 5.740.000 impresiones únicas al mes en toda la provincia.',
            'eventos' => 'FUENTE: Agenda interna con coordinación de campo. CÁLCULO: 5 eventos por semana durante S1-S7 (35 eventos totales) + 15 en campaña oficial = 50 eventos base. Cada evento captura en promedio 100-150 contactos.',
        ];

        $fuentes = [
            'padron' => 'https://rpubs.com/p_diazjurado/1244706',
            'cne2021' => 'PDF CNE Resultados Electorales 2021',
        ];

        foreach ($progresion as $codigo => $metas) {
            $semana = $semanas->get($codigo);
            if (! $semana) {
                $this->command->warn("Semana {$codigo} no encontrada. Corre primero SemanaPlanSeeder.");
                continue;
            }

            foreach ($metas as $kpi => $meta) {
                KpiSemanal::create([
                    'semana_id' => $semana->id,
                    'kpi' => $kpi,
                    'valor' => 0,
                    'meta' => $meta,
                    'notas' => $justificaciones[$kpi] ?? null,
                ]);
            }
        }

        $this->command->info('✅ 35 KPIs cargados con metas y justificaciones.');
        $this->command->info('   Fuentes: ' . $fuentes['padron'] . ' + ' . $fuentes['cne2021']);
    }
}
