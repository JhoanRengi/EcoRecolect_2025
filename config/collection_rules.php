<?php

return [
    'organic_days' => [
        'Antonio Nariño' => 1,
        'Barrios Unidos' => 2,
        'Bosa' => 3,
        'Chapinero' => 4,
        'Ciudad Bolívar' => 5,
        'Candelaria' => 6,
        'Engativá' => 7,
        'Fontibón' => 1,
        'Kennedy' => 2,
        'La Candelaria' => 3,
        'Los Mártires' => 4,
        'Puente Aranda' => 5,
        'Rafael Uribe Uribe' => 6,
        'San Cristóbal' => 7,
        'Santa Fe' => 1,
        'Sumapaz' => 2,
        'Suba' => 3,
        'Teusaquillo' => 4,
        'Tunjuelito' => 5,
        'Usaquén' => 6,
    ],
    'day_labels' => [
        1 => 'Lunes',
        2 => 'Martes',
        3 => 'Miércoles',
        4 => 'Jueves',
        5 => 'Viernes',
        6 => 'Sábado',
        7 => 'Domingo',
    ],
    'limits' => [
        'organic_per_week' => 1,
        'inorganic_per_week' => 2,
        'hazardous_per_month' => 1,
    ],
    'points' => [
        'min_award' => 10,
        'per_kg' => [
            \App\Models\CollectionSchedule::TYPE_INORGANIC => 2,
            \App\Models\CollectionSchedule::TYPE_ORGANIC => 3,
            \App\Models\CollectionSchedule::TYPE_HAZARDOUS => 5,
        ],
        'separation_bonus' => [
            \App\Models\CollectionSchedule::TYPE_INORGANIC => 20,
            \App\Models\CollectionSchedule::TYPE_ORGANIC => 30,
            \App\Models\CollectionSchedule::TYPE_HAZARDOUS => 40,
        ],
    ],
];
