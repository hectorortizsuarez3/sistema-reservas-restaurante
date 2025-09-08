<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <!-- link bootstrap desactivado: <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet"> -->
    <title>Restaurante Laravel</title>
    <meta name="viewport" content="width=devide-width, initial-scale=1">

    <!--Damos la instrucción a laravel para que cargue todos los archivos app.js (app.css aún no)
    en todas las vistas que extiendan de layout-->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body>

    <nav>
        <ul>
            <li><a href="{{ route('inicio') }}"
                class="{{ request()->routeIs('inicio') ? 'active' : '' }}"
                @if(request()->routeIs('inicio')) aria-current="page" @endif>
                Inicio</a>
            </li>

            <li><a href="{{ route('menu') }}"
                class="{{ request()->routeIs('menu') ? 'active' : '' }}"
                @if(request()->routeIs('menu')) aria-current="page" @endif>
                Menú</a>
            </li>

            <li><a href="{{ route('reservas') }}"
                class="{{ request()->routeIs('reservas*') ? 'active' : '' }}"
                @if(request()->routeIs('reservas*')) aria-current="page" @endif>
                Reservas</a>
            </li>

            <li><a href="{{ route('contacto') }}"
                class="{{ request()->routeIs('contacto*') ? 'active' : '' }}"
                 @if(request()->routeIs('contacto*')) aria-current="page" @endif>
                Contacto</a>
            </li>
        </ul>
    </nav>

    <main>
        @yield('content')
    </main>

</body>
</html>
