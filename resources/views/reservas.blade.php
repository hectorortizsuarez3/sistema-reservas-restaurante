@extends('layout')

@section('content')
    <h1>Reservar mesa</h1>

    {{-- Bloque global de errores --}}
    @if ($errors->any())
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    @endif

    {{-- Mensaje de éxito --}}
    @if(session('success'))
        <p>{!! session('success') !!}</p>
    @endif

    <form action="{{ route('reservas.enviar') }}" method="POST">
        @csrf

        <label for="nombre">Nombre:</label><br>
        <input type="text" name="nombre" id="nombre" required><br><br>

        <label for="telefono">Teléfono:</label><br>
        <input type="tel" name="telefono" id="telefono" required><br><br>

        <label for="email">Email:</label><br>
        <input type="email" name="email" id="email" required><br><br>

        <label for="fecha">Fecha:</label><br>
        <input type="date" name="fecha" id="fecha" required><br><br>

        <label for="personas">Personas:</label><br>
        <select name="personas" id="personas" required>
            @for($i = 1; $i <= 6; $i++)
                <option value="{{ $i }}">{{ $i }} persona{{ $i > 1 ? 's' : '' }}</option>
            @endfor
        </select><br><br>

        <label for="hora">Hora:</label><br>
        <select name="hora" id="hora" required>
            <option value="">Seleccione</option>
            <option value="13:00">13:00</option>
            <option value="13:30">13:30</option>
            <option value="14:00">14:00</option>
            <option value="14:30">14:30</option>
            <option value="21:00">21:00</option>
            <option value="21:30">21:30</option>
            <option value="22:00">22:00</option>
        </select><br><br>

        <label for="mensaje">Mensaje:</label><br>
        <textarea name="mensaje" id="mensaje"></textarea><br><br>

        <button type="submit">Reservar</button>
    </form>
@endsection
