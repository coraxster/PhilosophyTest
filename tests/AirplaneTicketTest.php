<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 22:59
 */



class AirplaneTicketTest extends \PHPUnit\Framework\TestCase
{


    public function testRenderWithBaggageInfo()
    {
        $tickerData = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
            'GATE_NUMBER' => '0a',
            'FLIGHT_NUMBER' => '1a',
            'BAGGAGE' => '2b',
            'SEAT_NUMBER' => '3c'
         ];

        $expects =
            'From MOSCOW, take flight 1a to SPB. Gate 0a. Seat 3c. Baggage drop at ticket counter 2b.';

        $ticket = new \Philosophy\Tickets\AirplaneTicket($tickerData);
        $this->assertEquals($expects, $ticket->render());
    }


    public function testRenderWithoutBaggageInfo()
    {
        $tickerData = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
            'GATE_NUMBER' => '0a',
            'FLIGHT_NUMBER' => '1a',
            'SEAT_NUMBER' => '3c'
         ];

        $expects =
            'From MOSCOW, take flight 1a to SPB. Gate 0a. Seat 3c. Baggage will be automatically transferred from your last leg.';

        $ticket = new \Philosophy\Tickets\AirplaneTicket($tickerData);
        $this->assertEquals($expects, $ticket->render());
    }
}