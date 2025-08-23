@extends('layout')

@section('content')
<div style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
    <h1>Reservas (gerencia)</h1>

    <!---Enlaces para cambiar entre turnos manteniendo la fecha actual--->
    <div>
        <a href="{{ route('reservas.index', ['date' => $targetDate->toDateString(), 'shift' => 'mediodia']) }}"
           style="padding:0.4rem 0.8rem; border:1px solid #ccc; border-radius:6px; text-decoration:none; {{ $shiftKey==='mediodia' ? 'background:#eee;' : '' }}">
           Mediodía (M)
        </a>
        <a href="{{ route('reservas.index', ['date' => $targetDate->toDateString(), 'shift' => 'noche']) }}"
           style="padding:0.4rem 0.8rem; border:1px solid #ccc; border-radius:6px; text-decoration:none; {{ $shiftKey==='noche' ? 'background:#eee;' : '' }}">
           Noche (N)
        </a>
    </div>

    <!-- Calendario para elegir fecha -->
    <form method="GET" action="{{ route('reservas.index') }}" style="display:flex; align-items:center; gap:0.6rem;">
        <input type="hidden" name="shift" value="{{ $shiftKey }}">
        <label for="date" style="font-weight:600;">Fecha:</label>
        <input
            id="date"
            type="date"
            name="date"
            value="{{ $targetDate->toDateString() }}"
            style="padding:0.35rem; border:1px solid #ccc; border-radius:6px;"
            onchange="this.form.submit()"
        >
        <noscript><button type="submit">Ver</button></noscript>
    </form>
</div>

<hr style="margin:1rem 0;">

<!-- Resumen del turno seleccionado -->
<p style="margin:0.5rem 0;">
    <strong>Día:</strong> {{ $targetDate->isoFormat('dddd D [de] MMMM') }} |
    <strong>Turno:</strong> {{ ucfirst($shiftKey) }} |
    <strong>Capacidad turno:</strong> {{ $capacity }} personas |
    <strong>Reservadas:</strong> {{ $totalPersonas }} ({{ $ocupacionPct }}%)
</p>

<!--Tarjeta lateral con resumen del nº de reservas-->
<div style="display:flex; gap:2rem; flex-wrap:wrap; align-items:flex-start;">
    <div style="min-width:260px;">
        <div style="padding:0.8rem; border:1px solid #ddd; border-radius:8px;">
            <h3 style="margin-top:0;">Resumen</h3>
            <p style="margin:0.2rem 0;"><strong>Total reservas:</strong> {{ $totalReservas }}</p>
            <p style="margin:0.2rem 0;"><strong>Total personas:</strong> {{ $totalPersonas }}</p>
        </div>

        <!-- Texto informativo -->
        <div style="margin-top:0.8rem; font-size:0.9rem; color:#666;">
            Atajos: ← día anterior · → día siguiente · M mediodía · N noche
        </div>
    </div>

    <div style="flex:1;">
        <h3 style="margin-top:0;">Reservas por hora</h3>

        <ul style="list-style:none; padding-left:0;">
            @foreach ($porSlot as $slot)
                <li style="padding:0.6rem 0; border-bottom:1px solid #eee;">
                    <div style="display:flex; justify-content:space-between; align-items:center;">
                        <strong style="font-size:1.05rem;">{{ $slot['hora'] }}</strong>
                        <span style="font-size:0.95rem;">
                            {{ $slot['count'] }} reserva(s) · {{ $slot['personas_sum'] }} persona(s)
                        </span>
                    </div>

                    @if ($slot['count'] > 0)
                        <div style="margin-top:0.4rem; display:flex; flex-direction:column; gap:0.3rem;">
                            @foreach ($slot['reservas'] as $r)
                                <div style="padding:0.4rem 0.6rem; border:1px solid #eee; border-radius:6px;">
                                    <div style="display:flex; gap:0.8rem; align-items:center; font-size:0.95rem;">
                                        <span>#{{ $r->id }}</span>
                                        <span>🧑 {{ $r->personas }}</span>
                                        @if (!empty($r->nombre))
                                            <span>· {{ $r->nombre }}</span>
                                        @endif
                                        @if (!empty($r->telefono))
                                            <span>· 📞 {{ $r->telefono }}</span>
                                        @endif
                                        @if (!empty($r->email))
                                            <span>· ✉️ {{ $r->email }}</span>
                                        @endif
                                    </div>
                                    @if (!empty($r->mensaje))
                                        <div style="margin-top:0.35rem; font-size:0.92rem; color:#444;">
                                            <span style="opacity:0.8;">📝 Mensaje:</span>
                                            <div>{!! nl2br(e($r->mensaje)) !!}</div>
                                        </div>
                                    @endif
                                </div>
                            @endforeach
                        </div>
                    @else
                        <div style="margin-top:0.4rem; color:#777; font-size:0.95rem;">
                            — sin reservas —
                        </div>
                    @endif
                </li>
            @endforeach
        </ul>
    </div>
</div>

<!-- JS: atajos de teclado para navegar fechas y turnos -->
<script>
    window.shiftKeyBlade = "{{ $shiftKey }}";
    window.routeReservas = "{{ route('reservas.index') }}";
</script>
@endsection

