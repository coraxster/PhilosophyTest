<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 8:31
 */

namespace Philosophy\Contracts;


interface TicketInterface
{

    public function getDeparturePoint() : string ;

    public function getDestinationPoint() : string;

    public function render() : string;

}