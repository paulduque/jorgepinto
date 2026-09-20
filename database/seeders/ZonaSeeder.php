<?php

namespace Database\Seeders;

use App\Models\Zona;
use Illuminate\Database\Seeder;

class ZonaSeeder extends Seeder
{
    /**
     * Zonas iniciales de Pichincha.
     * La prioridad se ajustará después de la línea base de S1.
     */
    public function run(): void
    {
        $zonas = [
            // Quito (dividido por zonas)
            ['canton' => 'Quito', 'parroquia' => 'Centro Histórico', 'prioridad' => 'media'],
            ['canton' => 'Quito', 'parroquia' => 'Norte', 'prioridad' => 'media'],
            ['canton' => 'Quito', 'parroquia' => 'Sur', 'prioridad' => 'media'],
            ['canton' => 'Quito', 'parroquia' => 'Valles (Cumbayá, Tumbaco)', 'prioridad' => 'media'],

            // Cantones de Pichincha
            ['canton' => 'Cayambe', 'parroquia' => null, 'prioridad' => 'media'],
            ['canton' => 'Mejía', 'parroquia' => null, 'prioridad' => 'media'],
            ['canton' => 'Rumiñahui', 'parroquia' => null, 'prioridad' => 'media'],
            ['canton' => 'Pedro Moncayo', 'parroquia' => null, 'prioridad' => 'media'],
            ['canton' => 'Puerto Quito', 'parroquia' => null, 'prioridad' => 'media'],
            ['canton' => 'San Miguel de los Bancos', 'parroquia' => null, 'prioridad' => 'media'],
            ['canton' => 'Pedro Vicente Maldonado', 'parroquia' => null, 'prioridad' => 'media'],
        ];

        foreach ($zonas as $zona) {
            Zona::create($zona);
        }
    }
}
