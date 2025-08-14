<h2>Nuevo mensaje de contacto</h2>

<p><strong>Nombre:</strong> {{ $nombre }}</p>
<p><strong>Teléfono:</strong> {{ $telefono ?: 'No proporcionado' }}</p>
<p><strong>Email:</strong> {{ $email }}</p>

<p><strong>Mensaje:</strong></p>
<p style="white-space: pre-wrap;">{{ $mensaje }}</p>

<hr>
<p style="font-size: 12px; color: #666;">
    Enviado desde el formulario de contacto de la web.
</p>
