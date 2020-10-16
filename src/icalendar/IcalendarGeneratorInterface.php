<?php

/**
*   IcalendarGeneratorInterface
*
*   @version 200711
*/

declare(strict_types=1);

namespace Icalendar;

interface IcalendarGeneratorInterface
{
    /**
    *   generate
    *
    *   @param mixed $icalendar
    */
    public function generate($icalendar);
}
