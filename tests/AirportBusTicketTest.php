<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 22:59
 */



class AirportBusTicketTest extends \PHPUnit\Framework\TestCase
{



    public function testRenderWithSeat()
    {
        $tickerData = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
            'TRAIN_NUMBER' => '123abc',
            'SEAT' => '3c'
         ];

        $expects =
            'Take the airport bus from MOSCOW to SPB. Seat 3c.';

        $ticket = new \Philosophy\Tickets\AirportBusTicket($tickerData);
        $this->assertEquals($expects, $ticket->render());
    }


    public function testRenderWithoutSeat()
    {
        $tickerData = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
            'TRAIN_NUMBER' => '123abc',
        ];

        $expects =
            'Take the airport bus from MOSCOW to SPB. No seat assignment.';

        $ticket = new \Philosophy\Tickets\AirportBusTicket($tickerData);
        $this->assertEquals($expects, $ticket->render());
    }
}