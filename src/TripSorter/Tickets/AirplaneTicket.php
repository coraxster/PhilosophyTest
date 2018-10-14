<?php

namespace TripSorter\Tickets;


/**
 * Class AirplaneTicket
 */
class AirplaneTicket extends AbstractTicket
{

    protected static $preset = 'From {{DEPARTURE_POINT}}, take flight {{FLIGHT_NUMBER}} to {{DESTINATION_POINT}}. Gate {{GATE_NUMBER}}. Seat {{SEAT_NUMBER}}.';

    protected static $requiredInfo = [
        'DEPARTURE_POINT',
        'DESTINATION_POINT',
        'FLIGHT_NUMBER',
        'GATE_NUMBER',
        'SEAT_NUMBER'
    ];

    /**
     * @return string
     */
    public function render(): string
    {
        $string =  parent::render();

        $baggageInfo = $this->ticketInfo['BAGGAGE'] ?? null;
        if (is_null($baggageInfo)){
            $string .= " Baggage will be automatically transferred from your last leg.";
        }else{
            $string .= " Baggage drop at ticket counter {$baggageInfo}.";
        }
        return $string;
    }
}