<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <title>Restaurante Laravel</title>
</head>
<body>

    <nav>
        <ul>
            <li><a href="{{ route('inicio') }}">Inicio</a></li>
            <li><a href="{{ route('menu') }}">Menú</a></li>
            <li><a href="{{ route('reservas') }}">Reservas</a></li>
            <li><a href="{{ route('contacto') }}">Contacto</a></li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
