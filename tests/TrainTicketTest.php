<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 22:59
 */



class TrainTicketTest extends \PHPUnit\Framework\TestCase
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
            'Take train 123abc from MOSCOW to SPB. Seat 3c.';

        $ticket = new \Philosophy\Tickets\TrainTicket($tickerData);
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
            'Take train 123abc from MOSCOW to SPB. No seat assignment.';

        $ticket = new \Philosophy\Tickets\TrainTicket($tickerData);
        $this->assertEquals($expects, $ticket->render());
    }
}