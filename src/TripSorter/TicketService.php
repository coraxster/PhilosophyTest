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

    public function orderByPath(TicketCollectionInterface $tickets): TicketCollection
    {
        $this->validateTrip($tickets);
        $ticket = $tickets->findStartTickets()->first();
        $newTickets = [$ticket];
        while($ticket = $tickets->withDeparture( $ticket->getDestinationPoint() )->first()){
            $newTickets[] = $ticket;
            $tickets = $tickets->without($ticket);
        }
        return new TicketCollection($newTickets);
    }

    public function validateTrip(TicketCollectionInterface $tickets)
    {
        $starts = $tickets->findStartTickets();
        if ($starts->count() === 0 ) {
            throw new \Exception('There is no start point in tickets set.');
        }

        if ($starts->count() > 1 ) {
            throw new \Exception('There are few start points in tickets set.');
        }

        $deps = $dests = [];
        foreach ($tickets as $ticket) {
            $deps[] = $ticket->getDeparturePoint();
            $dests[] = $ticket->getDestinationPoint();
        }

        if (count(array_unique($deps)) !== count($deps)) {
            throw new \Exception('There are few tickets with the same departure point.');
        }
        if (count(array_unique($dests)) !== count($dests)) {
            throw new \Exception('There are few tickets with the same destination point.');
        }
    }

}
