<?php

return [
    // Capacidad total del turno (suma de todos los slots de ese turno)
    'capacity_per_shift' => 20,

    // Slots permitidos (coinciden con tu controlador de store)
    'slots' => [
        'mediodia' => ['13:00','13:30','14:00','14:30'],
        'noche'    => ['21:00','21:30','22:00'],
    ],
];
