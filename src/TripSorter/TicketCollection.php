<?php

namespace TripSorter;

use TripSorter\Contracts\TicketCollectionInterface;
use TripSorter\Contracts\TicketInterface;

/**
 * Class TicketCollection
 */
class TicketCollection implements TicketCollectionInterface
{
    /**
     * Ticket storage
     * @var array
     */
    protected $tickets;

    /**
     * TicketCollection constructor.
     *
     * todo: maybe we need validation mechanism here... as example in case we get 2 separate stacks in array or loops
     *
     * @param array $tickets
     */
    public function __construct(array $tickets)
    {
        foreach ($tickets as $ticket){
            assert($ticket instanceof TicketInterface, 'TicketCollection expects Tickets :)');
        }
        $this->tickets = $tickets;
    }

    /**
     * @return \Traversable
     */
    public function getIterator(): \Traversable
    {
        return new \ArrayIterator($this->tickets);
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return $this->tickets;
    }

    /**
     * @return TicketCollectionInterface
     * @throws \Exception
     */
    public function orderedByPath(): TicketCollectionInterface
    {
        $ticket = $this->findStartTicket();
        $tickets = [$ticket];
        $ticketsCol = $this;
        while($ticket = $ticketsCol->withDeparture( $ticket->getDestinationPoint() )->first()){
            $tickets[] = $ticket;
            $ticketsCol = $ticketsCol->without($ticket);
        }
        return new self($tickets);
    }

    /**
     * @return TicketInterface
     * @throws \Exception
     */
    public function findStartTicket() : TicketInterface
    {
        foreach ($this->tickets as $ticket){
            $departurePoint = $ticket->getDeparturePoint();
            if ($this->withDestination($departurePoint)->count() === 0){
                return $ticket;
            }
        }
        throw new \Exception('There is no start point in tickets set.');
    }

    /**
     * @param string $departurePoint
     * @return TicketCollectionInterface
     */
    public function withDeparture(string $departurePoint): TicketCollectionInterface
    {
        $foundTickets = [];
        foreach ($this->tickets as $ticket){
            if ($ticket->getDeparturePoint() === $departurePoint){
                $foundTickets[] = $ticket;
            }
        }
        return new self($foundTickets);
    }

    /**
     * @param string $destinationPoint
     * @return TicketCollectionInterface
     */
    public function withDestination(string $destinationPoint): TicketCollectionInterface
    {
        $foundTickets = [];
        foreach ($this->tickets as $ticket){
            if ($ticket->getDestinationPoint() === $destinationPoint){
                $foundTickets[] = $ticket;
            }
        }
        return new self($foundTickets);
    }

    /**
     * @param TicketInterface $exceptTicket
     * @return TicketCollection
     */
    public function without(TicketInterface $exceptTicket): TicketCollectionInterface
    {
        $newTickets = $this->tickets;
        foreach ($newTickets as $key=>$ticket){
            if ($ticket === $exceptTicket){
                unset($newTickets[$key]);
            }
        }
        return new self($newTickets);
    }

    /**
     * @return int
     */
    public function count(): int
    {
        return count($this->tickets);
    }

    /**
     * @return TicketInterface|null
     */
    public function first()
    {
        return array_values($this->tickets)[0] ?? null;
    }

    /**
     * @return array
     */
    public function render(): array
    {
        $strings = [];
        foreach ($this->tickets as $ticket){
            $strings[] = $ticket->render();
        }
        return $strings;
    }

}
