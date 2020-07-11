<?php

/**
*   IcalendarServerInterface
*
*   @version 200711
*/
declare(strict_types=1);

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
