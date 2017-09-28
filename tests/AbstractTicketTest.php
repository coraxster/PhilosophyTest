<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 22:59
 */



class AbstractTicketTest extends \PHPUnit\Framework\TestCase
{


    public function testPointsValues()
    {
        $tickerData = [
            'DEPARTURE_POINT' => 'DATA1',
            'DESTINATION_POINT' => 'DATA2',
            'SOME_KEY' => 'SOME_DATA',
        ];
        $ticket = $this->getMockForAbstractClass('\Philosophy\Tickets\AbstractTicket', [$tickerData]);
        $this->assertEquals($tickerData['DEPARTURE_POINT'], $ticket->getDeparturePoint());
        $this->assertEquals($tickerData['DESTINATION_POINT'], $ticket->getDestinationPoint());
    }


    public function testRender()
    {
        $tickerData = [
            'DEPARTURE_POINT' => 'MOSCOW',
            'DESTINATION_POINT' => 'SPB',
        ];
        $ticket = $this->getMockForAbstractClass('\Philosophy\Tickets\AbstractTicket', [$tickerData]);
        $this->assertEquals('From MOSCOW to SPB', $ticket->render());
    }
}