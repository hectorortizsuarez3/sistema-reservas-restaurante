@extends('layout')

@section('content')
<div style="display:flex; gap:1rem; align-items:center; flex-wrap:wrap;">
    <h1>Reservas (gerencia)</h1>

    {{-- Turnos --}}
    <div>
        <a href="{{ route('gerencia.reservas.index', ['day' => $dayOffset, 'shift' => 'mediodia']) }}"
           style="padding:0.4rem 0.8rem; border:1px solid #ccc; border-radius:6px; text-decoration:none; {{ $shiftKey==='mediodia' ? 'background:#eee;' : '' }}">
           Mediodía (M)
        </a>
        <a href="{{ route('gerencia.reservas.index', ['day' => $dayOffset, 'shift' => 'noche']) }}"
           style="padding:0.4rem 0.8rem; border:1px solid #ccc; border-radius:6px; text-decoration:none; {{ $shiftKey==='noche' ? 'background:#eee;' : '' }}">
           Noche (N)
        </a>
    </div>

    {{-- Días: hoy + 10 --}}
    <div style="display:flex; gap:0.4rem; flex-wrap:wrap;">
        @foreach ($dias as $d)
            <a href="{{ route('gerencia.reservas.index', ['day' => $d['offset'], 'shift' => $shiftKey]) }}"
               title="{{ $d['full'] }}"
               style="padding:0.3rem 0.6rem; border:1px solid #ccc; border-radius:6px; text-decoration:none; font-size:0.95rem; {{ $d['offset']===$dayOffset ? 'background:#ddd; font-weight:bold;' : '' }}">
               {{ $d['label'] }}
            </a>
        @endforeach
    </div>
</div>

<hr style="margin:1rem 0;">

{{-- Resumen del turno seleccionado --}}
<p style="margin:0.5rem 0;">
    <strong>Día:</strong> {{ $targetDate->isoFormat('dddd D [de] MMMM') }} |
    <strong>Turno:</strong> {{ ucfirst($shiftKey) }} |
    <strong>Capacidad turno:</strong> {{ $capacity }} personas |
    <strong>Reservadas:</strong> {{ $totalPersonas }} ({{ $ocupacionPct }}%)
</p>

<div style="display:flex; gap:2rem; flex-wrap:wrap; align-items:flex-start;">
    <div style="min-width:260px;">
        <div style="padding:0.8rem; border:1px solid #ddd; border-radius:8px;">
            <h3 style="margin-top:0;">Resumen</h3>
            <p style="margin:0.2rem 0;"><strong>Total reservas:</strong> {{ $totalReservas }}</p>
            <p style="margin:0.2rem 0;"><strong>Total personas:</strong> {{ $totalPersonas }}</p>
        </div>

        {{-- Atajos --}}
        <div style="margin-top:0.8rem; font-size:0.9rem; color:#666;">
            Atajos: ← día anterior · → día siguiente · M mediodía · N noche
        </div>
    </div>

    <div style="flex:1;">
        <h3 style="margin-top:0;">Ocupación por slot</h3>

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
                        <div style="margin-top:0.4rem;">
                            @foreach ($slot['reservas'] as $r)
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

{{-- JS: atajos de teclado para cambiar día/turno sin ratón --}}
<script>
document.addEventListener('keydown', function(e) {
    const params = new URLSearchParams(window.location.search);
    let day = parseInt(params.get('day') || '0', 10);
    let shift = params.get('shift') || '{{ $shiftKey }}';

    if (e.key === 'ArrowRight') {
        day = Math.min(day + 1, {{ config('reservas.days_ahead', 10) }});
        window.location = `{{ route('gerencia.reservas.index') }}?day=${day}&shift=${shift}`;
    }
    if (e.key === 'ArrowLeft') {
        day = Math.max(day - 1, 0);
        window.location = `{{ route('gerencia.reservas.index') }}?day=${day}&shift=${shift}`;
    }
    if (e.key.toLowerCase() === 'm') {
        shift = 'mediodia';
        window.location = `{{ route('gerencia.reservas.index') }}?day=${day}&shift=${shift}`;
    }
    if (e.key.toLowerCase() === 'n') {
        shift = 'noche';
        window.location = `{{ route('gerencia.reservas.index') }}?day=${day}&shift=${shift}`;
    }
});
</script>
@endsection
