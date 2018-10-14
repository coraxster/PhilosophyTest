<?php

include '../vendor/autoload.php';

$ticketsData = [
    [
        'TYPE' => 'TRAIN',
        'DEPARTURE_POINT' => 'Madrid',
        'DESTINATION_POINT' => 'Barcelona',
        'TRAIN_NUMBER' => '78A',
        'SEAT' => '45B'
    ],
    [
        'TYPE' => 'AIRPORT_BUS',
        'DEPARTURE_POINT' => 'Barcelona',
        'DESTINATION_POINT' => 'Gerona Airport',
    ],
    [
        'TYPE' => 'AIRPLANE',
        'DEPARTURE_POINT' => 'Gerona Airport',
        'DESTINATION_POINT' => 'Stockholm',
        'GATE_NUMBER' => '45B',
        'FLIGHT_NUMBER' => 'SK455',
        'BAGGAGE' => '344',
        'SEAT_NUMBER' => '3A'
    ],
    [
        'TYPE' => 'AIRPLANE',
        'DEPARTURE_POINT' => 'Stockholm',
        'DESTINATION_POINT' => 'New York JFK',
        'GATE_NUMBER' => '22',
        'FLIGHT_NUMBER' => 'SK22',
        'SEAT_NUMBER' => 'B'
    ]
];

$service = new \TripSorter\TicketService();

$tickets = $service->buildTickets($ticketsData);
foreach ($tickets->toArray() as $ticket){
    echo '<li>' . $ticket->render() . '</li>';
}