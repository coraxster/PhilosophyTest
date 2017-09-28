<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 20:47
 */

namespace Philosophy;


use Philosophy\Contracts\TicketCollectionInterface;
use Philosophy\Tickets\AirplaneTicket;
use Philosophy\Tickets\TrainTicket;
use Philosophy\Tickets\AirportBusTicket;

/**
 * Class TicketService
 * @package Philosophy
 */
class TicketService
{

    /**
     * $ticketsData['TYPE'] required, one of 'TRAIN', 'AIRPLANE', 'AIRPORT_BUS'
     * $ticketsData['DEPARTURE_POINT'] required
     * $ticketsData['DESTINATION_POINT'] required
     *
     * @param array $ticketsData
     * @return TicketCollectionInterface
     */
    public function buildTickets(array $ticketsData) : TicketCollectionInterface
    {
        $tickets = [];
        foreach ($ticketsData as $tData){
            switch ($tData['TYPE']){
                case 'TRAIN':
                    $ticket = new TrainTicket($tData);
                    break;
                case 'AIRPLANE':
                    $ticket = new AirplaneTicket($tData);
                    break;
                case 'AIRPORT_BUS':
                    $ticket = new AirportBusTicket($tData);
                    break;
                default:
                    $ticket = false;
            }
            if ($ticket){
                $tickets[] = $ticket;
            }
        }
        return new TicketCollection($tickets);
    }

}