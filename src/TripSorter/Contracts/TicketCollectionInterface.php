<?php

namespace TripSorter\Contracts;


interface TicketCollectionInterface extends \IteratorAggregate
{

    public function toArray(): array;

    public function orderedByPath(): TicketCollectionInterface;

    public function findStartTicket(): TicketInterface;

    public function withDestination(string $destinationPoint) : TicketCollectionInterface;

    public function withDeparture(string $departurePoint) : TicketCollectionInterface;

    public function without(TicketInterface $exceptTicket) : TicketCollectionInterface;

    public function count() : int;

    public function first();

    public function render(): array;

}
