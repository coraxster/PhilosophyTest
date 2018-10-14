<?php

class AirportBusTicketTest extends \PHPUnit\Framework\TestCase
{

    protected $ticketData = [
        'DEPARTURE_POINT' => 'MOSCOW',
        'DESTINATION_POINT' => 'SPB',
        'SEAT' => '3c'
    ];

    public function testRenderWithSeat()
    {
        $ticketData = $this->ticketData;

        $expects =
            'Take the airport bus from MOSCOW to SPB. Seat 3c.';

        $ticket = new \TripSorter\Tickets\AirportBusTicket($ticketData);
        $this->assertEquals($expects, $ticket->render());
    }


    public function testRenderWithoutSeat()
    {
        $ticketData = $this->ticketData;
        unset($ticketData['SEAT']);

        $expects =
            'Take the airport bus from MOSCOW to SPB. No seat assignment.';

        $ticket = new \TripSorter\Tickets\AirportBusTicket($ticketData);
        $this->assertEquals($expects, $ticket->render());
    }
}