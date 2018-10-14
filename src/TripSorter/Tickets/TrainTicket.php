<?php

namespace TripSorter\Tickets;


class TrainTicket extends AbstractTicket
{

    protected static $preset = 'Take train {{TRAIN_NUMBER}} from {{DEPARTURE_POINT}} to {{DESTINATION_POINT}}.';

    protected static $requiredInfo = [
        'DEPARTURE_POINT',
        'DESTINATION_POINT',
        'TRAIN_NUMBER'
    ];

    /**
     * @return string
     */
    public function render(): string
    {
        $string = parent::render();

        $seatNumber = $this->ticketInfo['SEAT'] ?? null;
        if (is_null($seatNumber)){
            $string .= ' No seat assignment.';
        }else{
            $string .= " Seat {$seatNumber}.";
        }
        return $string;
    }
}