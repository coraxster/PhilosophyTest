<?php

class TicketCollectionTest extends \PHPUnit\Framework\TestCase
{

    public function testFilter1()
    {
        $depPoint1 = 'MOSCOW';
        $ticker1Data = [
            'DEPARTURE_POINT' => $depPoint1,
            'DESTINATION_POINT' => 'SPB',
        ];
        $ticker2Data = [
            'DEPARTURE_POINT' => 'SPB',
            'DESTINATION_POINT' => 'KAZAN',
        ];

        $ticket1 = new \TripSorter\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \TripSorter\Tickets\AirportBusTicket($ticker2Data);
        $ticketCollection = new \TripSorter\TicketCollection([$ticket1, $ticket2]);
        $filteredCollection = $ticketCollection->withDeparture($depPoint1);
        $this->assertEquals($filteredCollection->count(), 1);
        $this->assertEquals($filteredCollection->first(), $ticket1);
    }

    public function testFilter2()
    {
        $destPoint1 = 'SPB';
        $ticker1Data = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
        ];
        $ticker2Data = [
            'DEPARTURE_POINT' => 'SPB',
            'DESTINATION_POINT' => 'KAZAN',
        ];

        $ticket1 = new \TripSorter\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \TripSorter\Tickets\AirportBusTicket($ticker2Data);
        $ticketCollection = new \TripSorter\TicketCollection([$ticket1, $ticket2]);
        $filteredCollection = $ticketCollection->withDestination($destPoint1);
        $this->assertEquals($filteredCollection->count(), 1);
        $this->assertEquals($filteredCollection->first(), $ticket1);
    }

    public function testFindStartTicket()
    {
        $depPoint1 = 'MOSCOW';
        $destPoint1 = 'SPB';
        $depPoint2 = $destPoint1;
        $destPoint2 = 'KAZAN';

        $ticker1Data = [
            'DEPARTURE_POINT' => $depPoint1,
            'DESTINATION_POINT' => $destPoint1,
        ];
        $ticker2Data = [
            'DEPARTURE_POINT' => $depPoint2,
            'DESTINATION_POINT' => $destPoint2,
        ];
        $ticket1 = new \TripSorter\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \TripSorter\Tickets\AirportBusTicket($ticker2Data);
        $ticketCollection = new \TripSorter\TicketCollection([$ticket2, $ticket1]);
        $found = $ticketCollection->findStartTickets();
        $this->assertEquals($found->first(), $ticket1);
        $this->assertEquals($found->count(), 1);
    }

}