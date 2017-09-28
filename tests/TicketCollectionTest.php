<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 22:59
 */



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

        $ticket1 = new \Philosophy\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \Philosophy\Tickets\AirportBusTicket($ticker2Data);
        $ticketCollection = new \Philosophy\TicketCollection([$ticket1, $ticket2]);
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

        $ticket1 = new \Philosophy\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \Philosophy\Tickets\AirportBusTicket($ticker2Data);
        $ticketCollection = new \Philosophy\TicketCollection([$ticket1, $ticket2]);
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
        $ticket1 = new \Philosophy\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \Philosophy\Tickets\AirportBusTicket($ticker2Data);
        $ticketCollection = new \Philosophy\TicketCollection([$ticket2, $ticket1]);
        $found = $ticketCollection->getStartPointTicket();
        $this->assertEquals($found, $ticket1);
    }

    public function testOrdering()
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
        $ticket1 = new \Philosophy\Tickets\AirportBusTicket($ticker1Data);
        $ticket2 = new \Philosophy\Tickets\AirportBusTicket($ticker2Data);
        $expectOrdered = [$ticket1, $ticket2];

        $ticketCollection = new \Philosophy\TicketCollection([$ticket2, $ticket1]);
        $orderedArray = $ticketCollection->orderByPath()->toArray();
        $this->assertEquals($orderedArray, $expectOrdered);
    }



}