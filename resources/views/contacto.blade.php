@extends('layout')

@section('content')
<h1>Contacto</h1>
<p>¿Tienes dudas?<br>
    Puede escribirnos a <b>info@cuatrocaminos.com.</b> <br>
    También puede llamarnos por teléfono al <b>91 654 456</b>.<br>
    O escribirnos su consulta desde este formulario:
    </p>



{{-- Errores de validación de campos --}}
@if ($errors->any())
    <div class="alert alert-danger" role="alert">
        <ul style="margin:0; padding-left:1.2rem;">
            @foreach ($errors->all() as $error)
                {{-- Evita duplicar el error "general" si ya lo mostramos arriba --}}
                @if ($error !== $errors->first('general'))
                    <li>{{ $error }}</li>
                @endif
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('contacto.enviar') }}" id="contactForm">
    @csrf

    {{-- Nombre: requerido, mínimo 2 caracteres, máximo 100 --}}
    <div style="margin-bottom: 1rem;">
        <label for="nombre">Nombre</label><br>
        <input
            id="nombre"
            name="nombre"
            type="text"
            value="{{ old('nombre') }}"
            required
            minlength="2"
            maxlength="100"
            autocomplete="name"
        >
        @error('nombre') <br><small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Teléfono: opcional; patrón general internacional (opcional + y 7–15 dígitos) --}}
    <div style="margin-bottom: 1rem;">
        <label for="telefono">Teléfono (opcional)</label><br>
        <input
            id="telefono"
            name="telefono"
            type="tel"
            value="{{ old('telefono') }}"
            pattern="^\+?\d{7,15}$"
            inputmode="tel"
            autocomplete="tel"
            placeholder="+34600111222"
        >
        <br><small>Formato: 7–15 dígitos, puede empezar por “+”.</small>
        @error('telefono') <br><small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Email: requerido y con formato válido --}}
    <div style="margin-bottom: 1rem;">
        <label for="email">Email</label><br>
        <input
            id="email"
            name="email"
            type="email"
            value="{{ old('email') }}"
            required
            maxlength="255"
            autocomplete="email"
            placeholder="tucorreo@ejemplo.com"
        >
        @error('email') <br><small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Mensaje: requerido, 8–500 caracteres, con contador en cliente --}}
    <div style="margin-bottom: 1rem;">
        <label for="mensaje">Mensaje</label><br>
        <textarea
            id="mensaje"
            name="mensaje"
            rows="6"
            required
            minlength="8"
            maxlength="500"
            placeholder="Cuéntanos en qué podemos ayudarte (máx. 500 caracteres)"
        >{{ old('mensaje') }}</textarea>
        <div><small>Caracteres restantes: <span id="contador">500</span></small></div>
        @error('mensaje') <br><small class="text-danger">{{ $message }}</small> @enderror
    </div>

    {{-- Honeypot anti-spam: debe existir en el DOM pero oculto por CSS --}}
    <div style="display:none;">
        <label for="website">Website</label>
        <input id="website" name="website" type="text" autocomplete="off" tabindex="-1">
    </div>

    <button type="submit" id="enviarBtn">Enviar</button>
</form>

{{-- JS: contador de caracteres y evitar doble envío cuando el form es válido --}}
<script>
document.addEventListener('DOMContentLoaded', function () {
    const mensaje = document.getElementById('mensaje');
    const contador = document.getElementById('contador');
    const form = document.getElementById('contactForm');
    const enviarBtn = document.getElementById('enviarBtn');
    const MAX = 500;

    const actualizarContador = () => {
        const restante = Math.max(0, MAX - (mensaje.value?.length || 0));
        contador.textContent = restante;
    };

    actualizarContador();
    mensaje.addEventListener('input', actualizarContador);

    form.addEventListener('submit', function (e) {
        // Deja que la validación nativa del navegador actúe
        if (!form.checkValidity()) return;
        // Si todo es válido, desactiva el botón para evitar duplicados
        enviarBtn.disabled = true;
        enviarBtn.textContent = 'Enviando...';
    });
});
</script>
<br>
{{-- Mensaje de éxito al enviar --}}
@if (session('status'))
    <div class="alert alert-success" role="alert">
        {{ session('status') }}
    </div>
@endif

{{-- Error general (por ejemplo, si falló el envío del correo) --}}
@error('general')
    <div class="alert alert-danger" role="alert">{{ $message }}</div>
@enderror

@endsection