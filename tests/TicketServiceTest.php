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

    public function testValidateTrip()
    {
        $service = new \TripSorter\TicketService();

        $ticker1Data = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
        ];
        $ticker2Data = [
            'DEPARTURE_POINT' => $ticker1Data['DESTINATION_POINT'],
            'DESTINATION_POINT' => 'KAZAN',
        ];
        $ticket1 = new \TripSorter\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \TripSorter\Tickets\AirportBusTicket($ticker2Data);
        $ticketCollection = new \TripSorter\TicketCollection([$ticket2, $ticket1]);
        $service->validateTrip($ticketCollection); // no exception
    }

    public function testValidateTripEmptyCollection()
    {
        $service = new \TripSorter\TicketService();

        $ticketCollection = new \TripSorter\TicketCollection([]);

        $this->expectException(\Exception::class);
        $service->validateTrip($ticketCollection);
    }

    public function testValidateTripFewStarts()
    {
        $service = new \TripSorter\TicketService();

        $ticker1Data = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
        ];
        $ticker2Data = [
            'DEPARTURE_POINT' => 'LIVNY',
            'DESTINATION_POINT' => 'KAZAN',
        ];
        $ticket1 = new \TripSorter\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \TripSorter\Tickets\AirportBusTicket($ticker2Data);
        $ticketCollection = new \TripSorter\TicketCollection([$ticket1, $ticket2]);

        $this->expectException(\Exception::class);
        $service->validateTrip($ticketCollection);
    }

    public function testValidateTripWithLoop()
    {
        $service = new \TripSorter\TicketService();

        $ticker1Data = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
        ];
        $ticker2Data = [
            'DEPARTURE_POINT' => 'LIVNY',
            'DESTINATION_POINT' => 'SPB',
        ];
        $ticket1 = new \TripSorter\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \TripSorter\Tickets\AirportBusTicket($ticker2Data);
        $ticketCollection = new \TripSorter\TicketCollection([$ticket1, $ticket2]);

        $this->expectException(\Exception::class);
        $service->validateTrip($ticketCollection);
    }

    public function testValidateTripWithCrossPoint()
    {
        $service = new \TripSorter\TicketService();

        $ticker1Data = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
        ];
        $ticker2Data = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'LIVNY',
        ];
        $ticket1 = new \TripSorter\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \TripSorter\Tickets\AirportBusTicket($ticker2Data);
        $ticketCollection = new \TripSorter\TicketCollection([$ticket1, $ticket2]);

        $this->expectException(\Exception::class);
        $service->validateTrip($ticketCollection);
    }

    public function testOrdering()
    {
        $service = new \TripSorter\TicketService();

        $ticker1Data = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
        ];
        $ticker2Data = [
            'DEPARTURE_POINT' => $ticker1Data['DESTINATION_POINT'],
            'DESTINATION_POINT' => 'KAZAN',
        ];
        $ticket1 = new \TripSorter\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \TripSorter\Tickets\AirportBusTicket($ticker2Data);
        $expectingOrdered = [$ticket1, $ticket2];

        $ticketCollection = new \TripSorter\TicketCollection([$ticket2, $ticket1]);
        $orderedArray = $service->orderByPath($ticketCollection)->toArray();
        $this->assertEquals($orderedArray, $expectingOrdered);
    }

}