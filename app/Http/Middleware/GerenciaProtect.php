<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;

class GerenciaProtect
{
    public function handle(Request $request, Closure $next)
    {
        // Si ya está validada la sesión, pasa
        if ($request->session()->get('gerencia_ok') === true) {
            return $next($request);
        }

        // Permitir acceso a la pantalla de acceso y su POST
        if ($request->routeIs('gerencia.acceso.show') || $request->routeIs('gerencia.acceso.check')) {
            return $next($request);
        }

        // Si no, redirigir a pedir PIN
        return redirect()->route('gerencia.acceso.show')
            ->with('redirect_to', $request->fullUrl());
    }
}

