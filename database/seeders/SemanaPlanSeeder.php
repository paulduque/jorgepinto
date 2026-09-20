<?php

namespace Database\Seeders;

use App\Models\SemanaPlan;
use Illuminate\Database\Seeder;

class SemanaPlanSeeder extends Seeder
{
    /**
     * Semanas del plan de campaña.
     */
    public function run(): void
    {
        $semanas = [
            [
                'codigo' => 'S1',
                'fecha_inicio' => '2026-09-21',
                'fecha_fin' => '2026-09-27',
                'fase' => 'Diagnóstico + arranque',
                'objetivo' => 'Línea base, zonas prioritarias, mensaje único, primeras 10 validaciones.',
            ],
            [
                'codigo' => 'S2',
                'fecha_inicio' => '2026-09-28',
                'fecha_fin' => '2026-10-04',
                'fase' => 'Reconocimiento',
                'objetivo' => '1 pieza diaria, cobertura de eventos, primeros reportes de KPIs.',
            ],
            [
                'codigo' => 'S3',
                'fecha_inicio' => '2026-10-05',
                'fecha_fin' => '2026-10-11',
                'fase' => 'Reconocimiento + base',
                'objetivo' => 'Sumar testimonios, iniciar preparación del debate.',
            ],
            [
                'codigo' => 'S4',
                'fecha_inicio' => '2026-10-12',
                'fecha_fin' => '2026-10-18',
                'fase' => 'Escalar validadores',
                'objetivo' => 'Llegar a 20-25 validadores activos, contenido por cantón.',
            ],
            [
                'codigo' => 'S5',
                'fecha_inicio' => '2026-10-19',
                'fecha_fin' => '2026-10-25',
                'fase' => 'Escalar + voto útil',
                'objetivo' => 'Simulacros de debate, siembra de voto útil con pruebas.',
            ],
            [
                'codigo' => 'S6',
                'fecha_inicio' => '2026-10-26',
                'fecha_fin' => '2026-11-01',
                'fase' => 'Consolidar + producir oficial',
                'objetivo' => 'Producir todo el material para campaña oficial.',
            ],
            [
                'codigo' => 'S7',
                'fecha_inicio' => '2026-11-02',
                'fecha_fin' => '2026-11-08',
                'fase' => 'Producir/programar oficial + debate',
                'objetivo' => 'Llegar a 30-50 validadores, simulacros semanales.',
            ],
            [
                'codigo' => 'Cierre',
                'fecha_inicio' => '2026-11-09',
                'fecha_fin' => '2026-11-11',
                'fase' => 'Confirmar lista, lanzamiento',
                'objetivo' => 'Confirmar lista CNE (9 nov), piezas de lanzamiento listas.',
            ],
            [
                'codigo' => 'Oficial',
                'fecha_inicio' => '2026-11-12',
                'fecha_fin' => '2026-11-26',
                'fase' => 'Campaña oficial',
                'objetivo' => 'Ritmo alto: propuestas, testimonios, debate, pauta permitida.',
            ],
            [
                'codigo' => 'Silencio',
                'fecha_inicio' => '2026-11-27',
                'fecha_fin' => '2026-11-29',
                'fase' => 'Silencio electoral',
                'objetivo' => 'Sin propaganda. Solo logística legal.',
            ],
        ];

        foreach ($semanas as $semana) {
            SemanaPlan::create($semana);
        }
    }
}
