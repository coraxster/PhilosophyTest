<?php

namespace TripSorter;

use TripSorter\Contracts\TicketCollectionInterface;
use TripSorter\Tickets\AirplaneTicket;
use TripSorter\Tickets\TrainTicket;
use TripSorter\Tickets\AirportBusTicket;

/**
 * Class TicketService
 */
class TicketService
{

    /**
     * Map with available Ticket classes.
     * @var array
     */
    protected static $ticketTypes = [
        'AIRPORT_BUS' => AirportBusTicket::class,
        'AIRPLANE' => AirplaneTicket::class,
        'TRAIN' => TrainTicket::class,
    ];

    /**
     * $ticketsData['TYPE'] required, one of TicketService::$ticketTypes
     * $ticketsData['DEPARTURE_POINT'] required for all types of ticket
     * $ticketsData['DESTINATION_POINT'] required for all types of ticket
     * @param array $ticketsData
     * @return TicketCollectionInterface
     * @throws \Exception
     */
    public function buildTickets(array $ticketsData) : TicketCollectionInterface
    {
        $tickets = [];
        foreach ($ticketsData as $tData){
            if (! isset($tData['TYPE'])) {
                throw new \Exception('No ticket type.');
            }
            $ticketClass = self::$ticketTypes[$tData['TYPE']] ?? null;
            if (is_null($ticketClass)) {
                throw new \Exception('Unknown ticket type: ' . $tData['TYPE'] . '.');
            }
            $tickets[] = new $ticketClass($tData);
        }
        return new TicketCollection($tickets);
    }



}