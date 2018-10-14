<?php

class TrainTicketTest extends \PHPUnit\Framework\TestCase
{

    protected $ticketData = [
        'DEPARTURE_POINT' => 'MOSCOW',
        'DESTINATION_POINT' => 'SPB',
        'TRAIN_NUMBER' => '123abc',
        'SEAT' => '3c'
    ];

    public function testConstructWithoutRequiredInfo()
    {
        $ticketData = $this->ticketData;
        unset($ticketData['TRAIN_NUMBER']);

        $this->expectException(\Exception::class);
        new \TripSorter\Tickets\TrainTicket($ticketData);
    }

    public function testRenderWithSeat()
    {
        $ticketData = $this->ticketData;

        $expects =
            'Take train 123abc from MOSCOW to SPB. Seat 3c.';

        $ticket = new \TripSorter\Tickets\TrainTicket($ticketData);
        $this->assertEquals($expects, $ticket->render());
    }


    public function testRenderWithoutSeat()
    {
        $ticketData = $this->ticketData;
        unset($ticketData['SEAT']);

        $expects =
            'Take train 123abc from MOSCOW to SPB. No seat assignment.';

        $ticket = new \TripSorter\Tickets\TrainTicket($ticketData);
        $this->assertEquals($expects, $ticket->render());
    }
}