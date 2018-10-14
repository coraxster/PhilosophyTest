<?php

namespace TripSorter\Tickets;


use TripSorter\Contracts\TicketInterface;

/**
 * Class AbstractTicket
 */
abstract class AbstractTicket implements TicketInterface
{

    protected static $preset = 'From {{DEPARTURE_POINT}} to {{DESTINATION_POINT}}';

    protected static $requiredInfo = [
        'DEPARTURE_POINT',
        'DESTINATION_POINT'
    ];

    /**
     * Map with ticket data.
     *
     * @var array
     */
    protected $ticketInfo;

    /**
     * AbstractTicket constructor.
     * Validates input data for required attributes. (throwing Exception)
     *
     * @param array $ticketInfo
     * @throws \Exception
     */
    public function __construct(array $ticketInfo)
    {
        $requiredKeys = array_unique(array_merge(self::$requiredInfo, static::$requiredInfo));
        $missingKeys = array_diff($requiredKeys, array_keys($ticketInfo));
        if (count($missingKeys)) {
            $msg = sprintf('Next info is required(Class: %s): %s.', get_class($this), implode(', ', $missingKeys));
            throw new \Exception($msg);
        }

        $this->ticketInfo = $ticketInfo;
    }

    /**
     * @return string
     */
    public function getDeparturePoint() : string
    {
        return $this->ticketInfo['DEPARTURE_POINT'];
    }

    /**
     * @return string
     */
    public function getDestinationPoint() : string
    {
        return $this->ticketInfo['DESTINATION_POINT'];
    }

    /**
     * @return string
     */
    public function render() : string
    {
        $placeholders = [];
        foreach ($this->ticketInfo as $key=>$value){
            $placeholders['{{'.$key.'}}'] = $value;
        }
        return strtr(static::$preset, $placeholders);
    }


}