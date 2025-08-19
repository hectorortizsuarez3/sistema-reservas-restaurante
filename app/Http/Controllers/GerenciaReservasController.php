<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GerenciaReservasController extends Controller
{
    public function index(Request $request)
    {
        // --- 1) Leer configuración ---
        $daysAhead = (int) config('reservas.days_ahead', 10);
        $slotsCfg  = config('reservas.slots');
        $capacity  = (int) config('reservas.capacity_per_shift', 20);

        // --- 2) Parámetros de UI ---
        $dayOffset = (int) $request->query('day', 0);       // 0 = hoy
        $shiftKey  = $request->query('shift', 'mediodia');  // 'mediodia' | 'noche'

        // Saneamos
        $dayOffset = max(0, min($daysAhead, $dayOffset));
        if (! array_key_exists($shiftKey, $slotsCfg)) {
            $shiftKey = 'mediodia';
        }

        // --- 3) Fecha objetivo y slots del turno seleccionado ---
        $today      = Carbon::today();                 // respeta timezone de config/app.php
        $targetDate = $today->clone()->addDays($dayOffset);
        $slots      = $slotsCfg[$shiftKey];            // p.ej. ['13:00','13:30','14:00','14:30']

        // --- 4) Traer reservas del día para esos slots (y solo esos) ---
        $reservas = Reserva::query()
            ->whereDate('fecha', $targetDate->toDateString())
            ->whereIn('hora', $slots)
            ->orderBy('hora')
            ->get();

        // --- 5) Totales del turno ---
        $totalPersonas = (int) $reservas->sum('personas');
        $totalReservas = (int) $reservas->count();
        $ocupacionPct  = $capacity > 0 ? round(($totalPersonas / $capacity) * 100) : 0;

        // --- 6) Estructura por slot (incluye slots sin reservas) ---
        $porSlot = collect($slots)->mapWithKeys(function ($hhmm) use ($reservas) {
            $lista = $reservas->where('hora', $hhmm);
            return [
                $hhmm => [
                    'hora'         => $hhmm,
                    'reservas'     => $lista->values(),
                    'personas_sum' => (int) $lista->sum('personas'),
                    'count'        => (int) $lista->count(),
                ],
            ];
        });

        // --- 7) Lista de días (0..daysAhead) para pintar botones ---
        $dias = collect(range(0, $daysAhead))->map(function ($offset) use ($today) {
            $d = $today->clone()->addDays($offset);
            return [
                'offset' => $offset,
                'iso'    => $d->toDateString(),                 // 2025-08-18
                'label'  => $d->isoFormat('ddd D/M'),           // lun 18/8
                'full'   => $d->isoFormat('dddd D [de] MMMM'),  // lunes 18 de agosto
            ];
        });

        return view('gerencia.reservas.index', [
            'dias'          => $dias,
            'shiftKey'      => $shiftKey,
            'dayOffset'     => $dayOffset,
            'porSlot'       => $porSlot,        // mapa con TODOS los slots del turno
            'totalPersonas' => $totalPersonas,
            'totalReservas' => $totalReservas,
            'capacity'      => $capacity,
            'ocupacionPct'  => $ocupacionPct,
            'targetDate'    => $targetDate,
        ]);
    }
}
