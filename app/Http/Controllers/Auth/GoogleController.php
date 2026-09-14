<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\SiteSetting;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Laravel\Socialite\Facades\Socialite;

class GoogleController extends Controller
{
    /**
     * Redirige al usuario a Google para autenticarse.
     */
    public function redirect()
    {
        return Socialite::driver('google')->redirect();
    }

    /**
     * Maneja el callback de Google.
     */
    public function callback()
    {
        try {
            $googleUser = Socialite::driver('google')->user();
        } catch (\Exception $e) {
            return redirect()->route('filament.admin.auth.login')
                ->with('error', 'Error al iniciar sesión con Google: ' . $e->getMessage());
        }

        // Buscar usuario por google_id o email
        $user = User::where('google_id', $googleUser->getId())
            ->orWhere('email', $googleUser->getEmail())
            ->first();

        if ($user) {
            // Si el usuario existe pero no tenía google_id, lo actualizamos
            if (! $user->google_id) {
                $user->update(['google_id' => $googleUser->getId()]);
            }
        } else {
            // Crear usuario nuevo
            $settings = SiteSetting::current();

            $user = User::create([
                'name' => $googleUser->getName(),
                'email' => $googleUser->getEmail(),
                'google_id' => $googleUser->getId(),
                'password' => bcrypt(str()->random(32)), // Password aleatorio
                'is_active' => true,
            ]);

            // Asignar rol por defecto desde SiteSetting
            if ($settings?->default_role) {
                $user->assignRole($settings->default_role);
            }
        }

        // Iniciar sesión
        Auth::login($user);

        // Redirigir al dashboard del panel
        return redirect()->intended(route('filament.admin.pages.dashboard'));
    }
}
