<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 20:51
 */

namespace Philosophy\Tickets;


class AirportBusTicket extends AbstractTicket
{
    /**
     * @var string
     */
    protected static $preset = 'Take the airport bus from {{DEPARTURE_POINT}} to {{DESTINATION_POINT}}.';


    /**
     * @return string
     */
    public function render(): string
    {

        $string = parent::render();

        $seatNumber = $this->ticketInfo['SEAT'] ?? false;
        if ($seatNumber){
            $string = $string . " Seat {$seatNumber}.";
        }else{
            $string = $string . ' No seat assignment.';
        }
        return $string;
    }
}