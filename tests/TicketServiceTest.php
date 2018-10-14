<?php

class TicketServiceTest extends \PHPUnit\Framework\TestCase
{

    protected $ticketsData = [
        [
            'TYPE' => 'TRAIN',
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
            'TRAIN_NUMBER' => '123abc',
            'SEAT' => '3c'
        ],
        [
            'TYPE' => 'AIRPORT_BUS',
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
            'SEAT' => '3c'
        ],
        [
            'TYPE' => 'AIRPLANE',
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
            'GATE_NUMBER' => '0a',
            'FLIGHT_NUMBER' => '1a',
            'BAGGAGE' => '2b',
            'SEAT_NUMBER' => '3c'
        ]
    ];

    public function testBuild()
    {
        $service = new \TripSorter\TicketService();
        $collection = $service->buildTickets($this->ticketsData);
        $this->assertEquals($collection->count(), count($this->ticketsData));
    }

    public function testBuildWithoutTicketType()
    {
        $service = new \TripSorter\TicketService();

        $ticketsData = $this->ticketsData;
        unset($ticketsData[0]['TYPE']);

        $this->expectException(\Exception::class);
        $service->buildTickets($ticketsData);
    }

    public function testBuildWithWrongTicketType()
    {
        $service = new \TripSorter\TicketService();

        $ticketsData = $this->ticketsData;
        $ticketsData[0]['TYPE'] = 'WRONG_TYPE';

        $this->expectException(\Exception::class);
        $service->buildTickets($ticketsData);
    }


}