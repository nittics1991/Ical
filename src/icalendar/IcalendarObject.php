<?php

/**
*   IcalendarObject
*
*   @version 200711
*/

declare(strict_types=1);

namespace Icalendar;

use IteratorAggregate;
use Icalendar\IcalendarEvent;

class IcalendarObject implements IteratorAggregate
{
    /**
    *   events
    *
    *   @var array
    */
    protected array $events = [];
    
    /**
    *   add
    *
    *   @param IcalendarEvent $event
    *   @return $this
    */
    public function add(IcalendarEvent $event): IcalendarObject
    {
        $this->events[] = $event;
        return $this;
    }
    
    /**
    *   {inherit}
    *
    */
    public function getIterator()
    {
        foreach ($this->events as $event) {
            yield $event;
        }
    }
}
