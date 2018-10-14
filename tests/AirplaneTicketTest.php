<?php

class AirplaneTicketTest extends \PHPUnit\Framework\TestCase
{

    protected $ticketData = [
        'DEPARTURE_POINT' => 'MOSCOW',
        'DESTINATION_POINT' => 'SPB',
        'GATE_NUMBER' => '0a',
        'FLIGHT_NUMBER' => '1a',
        'BAGGAGE' => '2b',
        'SEAT_NUMBER' => '3c'
    ];

    public function testConstructWithoutRequiredInfo()
    {
        $ticketData = $this->ticketData;
        unset($ticketData['FLIGHT_NUMBER']);

        $this->expectException(\Exception::class);
        new \TripSorter\Tickets\AirplaneTicket($ticketData);
    }

    public function testRenderWithBaggageInfo()
    {
        $ticketData = $this->ticketData;

        $expects =
            'From MOSCOW, take flight 1a to SPB. Gate 0a. Seat 3c. Baggage drop at ticket counter 2b.';

        $ticket = new \TripSorter\Tickets\AirplaneTicket($ticketData);
        $this->assertEquals($expects, $ticket->render());
    }


    public function testRenderWithoutBaggageInfo()
    {
        $ticketData = $this->ticketData;
        unset($ticketData['BAGGAGE']);

        $expects =
            'From MOSCOW, take flight 1a to SPB. Gate 0a. Seat 3c. Baggage will be automatically transferred from your last leg.';

        $ticket = new \TripSorter\Tickets\AirplaneTicket($ticketData);
        $this->assertEquals($expects, $ticket->render());
    }

}