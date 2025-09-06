@extends('layout')

@section('content')
        <section>
        <h1>Bienvenido a Cuatro Caminos</h1>
        <p>Sabores mediterráneos con productos frescos de temporada.</p>
        <img src="{{ asset('storage/portada/entrada_restaurante.jpeg') }}" alt="Foto de la entrada"><br>
        <p>En pleno centro de Madrid.</p>
        <img src="{{ asset('storage/portada/interior_restaurante.jpg') }}" alt="Foto del interior">
    </section>

    <section>
        <p>
            Cuatro Caminos nació como un proyecto familiar movido por la idea de recuperar el sabor de las recetas de siempre y compartirlo en un ambiente cercano. Con el tiempo se ha convertido en un punto de encuentro del barrio: un lugar donde celebrar, charlar y comer bien sin prisas. Hemos crecido, pero seguimos cocinando con el mismo cariño y con el compromiso de trabajar cada temporada con los mejores productos.
        </p>
        <p>
            Nuestro restaurante es un espacio luminoso y acogedor, pensado para que te sientas como en casa desde que entras por la puerta. Cuidamos los detalles: una sala cómoda, un servicio cercano y una carta breve pero bien afinada, que cambia cuando el mercado lo pide. Ideal para comidas entre semana, cenas en pareja o reuniones con amigos.
        </p>
        <p>
            La cocina de Cuatro Caminos es mediterránea y de mercado: platos sencillos, bien hechos y con producto fresco. Encontrarás entrantes tradicionales para compartir, principales que combinan mar y tierra, y postres caseros. Entre nuestros imprescindibles están el gazpacho andaluz, la paella mixta y la tarta de queso; además, ofrecemos opciones ligeras y vegetarianas para que todos disfruten.
        </p>
    </section>

    <section>
        <p>
            <a href="{{ route('reservas') }}">Reserva tu mesa ahora</a>
        </p>
        <p><a href="{{ route('menu') }}">Ver menú completo</a></p>
    </section>

    <section>
        <h2>Horario</h2>
        <p>
            Abierto todos los días:<br>
            13:00 – 16:00 | 20:00 – 23:30
        </p>
        <h2>Dirección</h2>
        <p>📍 Calle Ejemplo, 123 – Madrid</p>
    </section>
@endsection



