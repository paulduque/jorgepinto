<?php

namespace Database\Seeders;

use App\Models\DocumentoCampana;
use Illuminate\Database\Seeder;

class DocumentoCampanaSeeder extends Seeder
{
    /**
     * Carga el documento maestro de estrategias de campaña.
     * El contenido está en formato markdown.
     */
    public function run(): void
    {
        $contenido = file_get_contents(base_path('ESTRATEGIAS_CAMPANA.md'));

        if (! $contenido) {
            $this->command->warn('No se encontró ESTRATEGIAS_CAMPANA.md');
            return;
        }

        DocumentoCampana::updateOrCreate(
            ['id' => 1],
            [
                'titulo' => 'Estrategias de Campaña - Jorge Pinto Pichincha 2026',
                'contenido' => $contenido,
                'version' => 1,
                'updated_by' => 1,
            ]
        );

        $this->command->info('✅ Documento maestro de estrategias cargado.');
    }
}
