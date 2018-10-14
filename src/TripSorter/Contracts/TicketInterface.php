<?php

namespace TripSorter\Contracts;


interface TicketInterface
{

    public function getDeparturePoint() : string ;

    public function getDestinationPoint() : string;

    public function render() : string;

}