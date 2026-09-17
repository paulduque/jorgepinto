<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class EnsureAgendaAccess
{
    public function handle(Request $request, Closure $next): Response
    {
        // 1. Verificar que esté logueado
        if (! Auth::check()) {
            return redirect('/admin/login');
        }

        // 2. Recargar el usuario desde la BD (para asegurar que tiene HasRoles)
        $user = \App\Models\User::find(Auth::id());

        if (! $user) {
            return redirect('/admin/login');
        }

        // 3. Verificar que tenga el rol permitido
        if (! $user->hasAnyRole(['super_admin', 'coordinador'])) {
            abort(403, 'No tienes permiso para acceder a esta sección.');
        }

        return $next($request);
    }
}
