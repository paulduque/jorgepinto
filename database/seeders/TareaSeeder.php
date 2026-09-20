<?php

namespace Database\Seeders;

use App\Models\SemanaPlan;
use App\Models\Tarea;
use Illuminate\Database\Seeder;

class TareaSeeder extends Seeder
{
    /**
     * Tareas iniciales del plan de choque (S1).
     * Se irán agregando más por semana.
     */
    public function run(): void
    {
        $s1 = SemanaPlan::where('codigo', 'S1')->first();

        if (! $s1) {
            $this->command->warn('No se encontró la semana S1. Corre primero SemanaPlanSeeder.');
            return;
        }

        $tareas = [
            'Línea base de reconocimiento por zona (encuesta rápida vía campo)',
            'Elegir 3 zonas prioritarias',
            'Definir mensaje único y llamado a la acción',
            'Lanzar serie fija (historia personal del candidato)',
            'Crear Business Manager y activar las 3 fanpages',
            'Abrir Canal de WhatsApp + grupos por cantón + QR',
            'Sumar 10 primeros validadores',
            'Definir 5 KPIs y armar tablero',
            'Acordar agenda de 4 semanas con campo',
        ];

        foreach ($tareas as $orden => $titulo) {
            Tarea::create([
                'titulo' => $titulo,
                'fase' => 'S1',
                'semana_id' => $s1->id,
                'estado' => 'pendiente',
                'prioridad' => 'alta',
                'orden' => $orden,
            ]);
        }
    }
}
