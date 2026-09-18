<?php

namespace App\Rules;

use Closure;
use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Support\Facades\Http;

class Recaptcha implements ValidationRule
{
    public function validate(string $attribute, mixed $value, Closure $fail): void
    {
        // Si no hay token, falla
        if (empty($value)) {
            $fail('La verificación de seguridad es obligatoria.');
            return;
        }

        // Llamar a la API de Google para verificar el token
        $response = Http::asForm()->post('https://www.google.com/recaptcha/api/siteverify', [
            'secret' => config('services.recaptcha.secret_key'),
            'response' => $value,
            'remoteip' => request()->ip(),
        ]);

        $data = $response->json();

        // Verificar si la validación fue exitosa
        if (! ($data['success'] ?? false)) {
            $fail('La verificación de seguridad falló. Intenta de nuevo.');
            return;
        }

        // Verificar el score (solo para v3)
        $threshold = config('services.recaptcha.score_threshold', 0.5);
        $score = $data['score'] ?? 0;

        if ($score < $threshold) {
            $fail('Nuestra verificación de seguridad detectó actividad sospechosa. Intenta de nuevo.');
        }
    }
}
