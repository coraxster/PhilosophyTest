<?php

class AbstractTicketTest extends \PHPUnit\Framework\TestCase
{

    public function testConstruct()
    {
        $ticketData = [
            'DEPARTURE_POINT' => 'DATA1',
            'DESTINATION_POINT' => 'DATA2',
            'SOME_KEY' => 'SOME_DATA',
        ];
        $ticket = $this->getMockForAbstractClass('\TripSorter\Tickets\AbstractTicket', [$ticketData]);
        $this->assertEquals($ticketData['DEPARTURE_POINT'], $ticket->getDeparturePoint());
        $this->assertEquals($ticketData['DESTINATION_POINT'], $ticket->getDestinationPoint());
    }

    public function testConstructWithoutRequiredInfo()
    {
        $ticketData = [
            'DEPARTURE_POINT' => 'DATA1',
            'SOME_KEY' => 'SOME_DATA',
        ];
        $this->expectException(\Exception::class);
        $this->getMockForAbstractClass('\TripSorter\Tickets\AbstractTicket', [$ticketData]);
    }

    public function testRender()
    {
        $ticketData = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
        ];
        $ticket = $this->getMockForAbstractClass('TripSorter\Tickets\AbstractTicket', [$ticketData]);
        $this->assertEquals('From MOSCOW to SPB', $ticket->render());
    }

}