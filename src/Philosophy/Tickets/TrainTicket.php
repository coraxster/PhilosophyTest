<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 20:51
 */

namespace Philosophy\Tickets;


class TrainTicket extends AbstractTicket
{
    /**
     * @var string
     */
    protected static $preset = 'Take train {{TRAIN_NUMBER}} from {{DEPARTURE_POINT}} to {{DESTINATION_POINT}}.';

    public function __construct(array $ticketInfo = []) {
        parent::__construct($ticketInfo);
        assert(isset($ticketInfo['TRAIN_NUMBER']));
    }


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