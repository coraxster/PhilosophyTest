<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 8:51
 */

namespace Philosophy;


use Philosophy\Contracts\TicketCollectionInterface;
use Philosophy\Contracts\TicketInterface;

/**
 * Class TicketCollection
 * @package Philosophy
 */
class TicketCollection implements TicketCollectionInterface
{
    /**
     * @var array
     */
    protected $tickets;
    /**
     * @var int
     */
    protected $position = 0;

    /**
     * TicketCollection constructor.
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
     * @return TicketCollectionInterface
     */
    public function orderByPath(): TicketCollectionInterface
    {
        $ticket = $this->getStartPointTicket();
        $tickets = [$ticket];
        while($ticket = $this->withDeparture( $ticket->getDestinationPoint() )->first()){
            $tickets[] = $ticket;
        }
        return new self($tickets);
    }

    /**
     * @return TicketInterface
     * @throws \Exception
     */
    public function getStartPointTicket() : TicketInterface
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
     * @return array
     */
    public function toArray(): array
    {
        return $this->tickets;
    }

    /**
     * @return int
     */
    public function count(): int {
        return count($this->tickets);
    }

    /**
     * @return bool
     */
    public function first() {
        return array_values($this->tickets)[0] ?? false;
    }

    /**
     * @return array
     */
    public function renderToStrings(){
        $strings = [];
        foreach ($this->tickets as $ticket){
            $strings[] = $ticket->render();
        }
        return $strings;
    }


}