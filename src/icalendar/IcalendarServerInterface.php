<?php

/**
*   IcalendarServerInterface
*
*   @version 200711
*/

namespace Concerto\icalendar;

interface IcalendarServerInterface
{
    /**
    *   send
    *
    *   @param mixed $icalendar
    */
    public function send($icalendar);
}
