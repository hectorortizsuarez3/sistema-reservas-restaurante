<?php

namespace App\Http\Controllers;

use App\Models\Reserva;
use Carbon\Carbon;
use Illuminate\Http\Request;

class GerenciaReservasController extends Controller
{
    public function index(Request $request)
    {
        // --- 1) Configuración ---
        $slotsCfg  = config('reservas.slots');
        $capacity  = (int) config('reservas.capacity_per_shift', 20);

        // --- 2) Parámetros de UI ---
        // Turno: 'mediodia' | 'noche'
        $shiftKey = $request->query('shift', 'mediodia');
        if (! array_key_exists($shiftKey, $slotsCfg)) {
            $shiftKey = 'mediodia';
        }

        // Fecha: 'YYYY-MM-DD'. Si no viene o es inválida, usamos HOY.
        $today = Carbon::today();
        $dateStr = $request->query('date');
        try {
            $targetDate = $dateStr ? Carbon::parse($dateStr)->startOfDay() : $today->clone();
        } catch (\Exception $e) {
            $targetDate = $today->clone();
        }

        // --- 3) Slots del turno seleccionado ---
        $slots = $slotsCfg[$shiftKey];          // p.ej. ['13:00','13:30','14:00','14:30']
        $start = reset($slots);                 // '13:00'
        $end   = end($slots);                   // '14:30' (o último de la lista)

        // --- 4) Traer reservas del día por RANGO de hora ---
        $reservas = Reserva::query()
            ->whereDate('fecha', $targetDate->toDateString())
            ->whereTime('hora', '>=', $start)
            ->whereTime('hora', '<=', $end)
            ->orderBy('hora')
            ->get();

        // --- 5) Totales del turno ---
        $totalPersonas = (int) $reservas->sum('personas');
        $totalReservas = (int) $reservas->count();
        $ocupacionPct  = $capacity > 0 ? round(($totalPersonas / $capacity) * 100) : 0;

        // --- 6) Estructura por slot (incluye slots sin reservas; normalizamos a HH:MM) ---
        $porSlot = collect($slots)->mapWithKeys(function ($hhmm) use ($reservas) {
            $lista = $reservas->filter(function ($r) use ($hhmm) {
                $h = substr((string) $r->hora, 0, 5); // '13:00:00' -> '13:00'
                return $h === $hhmm;
            });

            return [
                $hhmm => [
                    'hora'         => $hhmm,
                    'reservas'     => $lista->values(),
                    'personas_sum' => (int) $lista->sum('personas'),
                    'count'        => (int) $lista->count(),
                ],
            ];
        });

        return view('gerencia.reservas.index', [
            'shiftKey'      => $shiftKey,
            'porSlot'       => $porSlot,
            'totalPersonas' => $totalPersonas,
            'totalReservas' => $totalReservas,
            'capacity'      => $capacity,
            'ocupacionPct'  => $ocupacionPct,
            'targetDate'    => $targetDate,
        ]);
    }
}

