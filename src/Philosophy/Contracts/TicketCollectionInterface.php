<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 8:31
 */

namespace Philosophy\Contracts;


interface TicketCollectionInterface
{

    public function orderByPath() : TicketCollectionInterface;

    public function toArray(): array;

    public function count() : int ;

    public function first();

    public function withDestination(string $destinationPoint) : TicketCollectionInterface;

    public function withDeparture(string $departurePoint) : TicketCollectionInterface;

    public function getStartPointTicket() : TicketInterface;

}