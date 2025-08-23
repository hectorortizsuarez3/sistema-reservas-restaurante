<?php

return [
    // Declaro variable para calcular % de ocupación en el controller
    'capacity_per_shift' => 20,

    // Declaro variable para agrupar y mostrar reservas por hora
    'slots' => [
        'mediodia' => ['13:00','13:30','14:00','14:30'],
        'noche'    => ['21:00','21:30','22:00'],
    ],
];
