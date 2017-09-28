<?php
/**
 * Created by PhpStorm.
 * User: rockwith
 * Date: 27.09.17
 * Time: 8:45
 */

namespace Philosophy\Tickets;


use Philosophy\Contracts\TicketInterface;

/**
 * Class AbstractTicket
 * @package Philosophy\Tickets
 */
abstract class AbstractTicket implements TicketInterface
{
    /**
     * @var string
     */
    protected static $preset = 'From {{DEPARTURE_POINT}} to {{DESTINATION_POINT}}';
    /**
     * @var array
     */
    protected $ticketInfo;

    /**
     * AbstractTicket constructor.
     * @param array $ticketInfo
     */
    public function __construct
    (
        array $ticketInfo = []
    ) {
        assert(isset($ticketInfo['DEPARTURE_POINT']), 'DEPARTURE_POINT is using as point key');
        assert(isset($ticketInfo['DESTINATION_POINT']), 'DESTINATION_POINT is using as point key');
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