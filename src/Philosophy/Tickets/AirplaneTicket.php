<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 20:51
 */

namespace Philosophy\Tickets;


/**
 * Class AirplaneTicket
 * @package Philosophy\Tickets
 */
class AirplaneTicket extends AbstractTicket
{
    /**
     * @var string
     */
    protected static $preset = 'From {{DEPARTURE_POINT}}, take flight {{FLIGHT_NUMBER}} to {{DESTINATION_POINT}}. Gate {{GATE_NUMBER}}. Seat {{SEAT_NUMBER}}.';

    public function __construct(array $ticketInfo = []) {
        parent::__construct($ticketInfo);
        assert(isset($ticketInfo['FLIGHT_NUMBER']));
        assert(isset($ticketInfo['GATE_NUMBER']));
        assert(isset($ticketInfo['SEAT_NUMBER']));
    }

    /**
     * @return string
     */
    public function render(): string
    {

        $string =  parent::render();

        $baggageInfo = $this->ticketInfo['BAGGAGE'] ?? false;
        if ($baggageInfo){
            $string = $string . " Baggage drop at ticket counter {$baggageInfo}.";
        }else{
            $string = $string . " Baggage will be automatically transferred from your last leg.";
        }
        return $string;
    }
}